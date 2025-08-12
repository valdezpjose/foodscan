<?php

namespace App\Services;


use App\Libraries\AppLibrary;
use Dipokhalder\EnvEditor\EnvEditor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PDOException;

class InstallerService
{
    public function siteSetup(Request $request): void
    {
        $envService = new EnvEditor();
        $envService->addData([
            'APP_NAME' => $request->app_name,
            'APP_URL'  => rtrim($request->app_url, '/') 
        ]);
        Artisan::call('optimize:clear');
    }

    public function databaseSetup(Request $request): bool
{
    // 1) Si hay error, checkDatabaseConnection() lanzará excepción.
    
    $this->checkDatabaseConnection($request);

    // 2) Si llegamos hasta aquí, la conexión fue OK: guardamos .env y corremos migraciones
    
    $envService = new EnvEditor();
    $envService->addData([
        'DB_HOST'     => $request->db_host,
        'DB_PORT'     => $request->db_port,
        'DB_DATABASE' => $request->db_name,
        'DB_USERNAME' => $request->db_username,
        'DB_PASSWORD' => $request->db_password,
    ]);

    Artisan::call('config:cache');
    Artisan::call('migrate:fresh', ['--force' => true]);
    Artisan::call('db:seed', ['--force' => true]);
    Artisan::call('optimize:clear');
    Artisan::call('config:clear');
    return true;
}

    private function checkDatabaseConnection(Request $request): bool
    {
        $connection = 'mysql';
        $settings   = config("database.connections.$connection");
        config([
            'database' => [
                'default'     => $connection,
                'connections' => [
                    $connection => array_merge($settings, [
                        'driver'   => $connection,
                        'host'     => $request->input('db_host'),
                        'port'     => $request->input('db_port'),
                        'database' => $request->input('db_name'),
                        'username' => $request->input('db_username'),
                        'password' => $request->input('db_password'),
                    ]),
                ],
            ],
        ]);

        DB::purge();

         try {
        DB::connection()->getPdo();
        return true;
    } catch (PDOException $e) {
        // Lanzamos una excepción con el mensaje original de MySQL/PDO
        throw new \Exception('Error de conexión a la base de datos: ' . $e->getMessage());
    }
    }

    public function licenseCodeChecker($array)
    {
        try {
            $payload = [
                'license_code' => $array['license_key'],
                'product_id'   => config('product.itemId'),
                'domain'       => AppLibrary::domain(url('')),
                'purpose'      => 'install',
                'version'      => config('product.version')
            ];
            if (isset($array['purpose'])) {
                $payload['purpose'] = $array['purpose'];
            }
            $apiUrl   = config('product.licenseCodeCheckerUrl');
            $response = Http::post($apiUrl . '/api/check-installer-license', $payload);
            return AppLibrary::licenseApiResponse($response);
        } catch (\Exception $exception) {
            return (object)[
                'status'  => false,
                'message' => $exception->getMessage()
            ];
        }
    }

    public function finalSetup(): void
    {
        $installedLogFile = storage_path('installed');
        $dateStamp        = date('Y-m-d h:i:s A');
        if (!file_exists($installedLogFile)) {
            $message = trans('installer.installed.success_log_message') . $dateStamp . "\n";
            file_put_contents($installedLogFile, $message);
        } else {
            $message = trans('installer.installed.update_log_message') . $dateStamp;
            file_put_contents($installedLogFile, $message . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        Artisan::call('storage:link', ['--force' => true]);
        $envService = new EnvEditor();
        $envService->addData([
            'APP_ENV'   => 'production',
            'APP_DEBUG' => 'false'
        ]);
        Artisan::call('optimize:clear');
    }
}

