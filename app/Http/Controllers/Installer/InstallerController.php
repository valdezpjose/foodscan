<?php

namespace App\Http\Controllers\Installer;


use App\Http\Controllers\Controller;
use App\Services\InstallerPermissionCheckerService;
use App\Services\InstallerRequirementsCheckerService;
use App\Services\InstallerService;
use Dipokhalder\EnvEditor\EnvEditor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InstallerController extends Controller
{
    public InstallerService $installerService;
    protected InstallerRequirementsCheckerService $installerRequirementsCheckerService;
    protected InstallerPermissionCheckerService $installerPermissionCheckerService;

    public function __construct(InstallerService $installerService, InstallerRequirementsCheckerService $installerRequirementsCheckerService, InstallerPermissionCheckerService $installerPermissionCheckerService)
    {
        $this->installerService                    = $installerService;
        $this->installerRequirementsCheckerService = $installerRequirementsCheckerService;
        $this->installerPermissionCheckerService   = $installerPermissionCheckerService;

        if (file_exists(storage_path('installed'))) {
            Redirect::to(env('APP_URL'))->send();
        }
    }

    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('installer.welcome');
    }

    public function requirement(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $phpSupportInfo = $this->installerRequirementsCheckerService->checkPHPversion(config('installer.core.minPhpVersion'));
        $requirements   = $this->installerRequirementsCheckerService->check(config('installer.requirements'));
        return view('installer.requirement', compact('requirements', 'phpSupportInfo'));
    }

    public function permission(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $permissions = $this->installerPermissionCheckerService->check(config('installer.permissions'));
        return view('installer.permission', compact('permissions'));
    }

    public function license(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('installer.license');
    }

    public function licenseStore(Request $request)
{
    // 1) Validar formato (si quieres mantener esa validación)
    $rules     = config('installer.license.form.rules');
    $validator = Validator::make($request->all(), $rules);
    if ($validator->fails()) {
        return redirect(route('installer.license'))
            ->withErrors($validator)
            ->withInput();
    }

    // 2) Bypass total si lo declaramos en .env
    if (config('app.skip_license_check')) {
        // redirige al siguiente paso SIN tocar la clave ni el dominio
        return redirect(route('installer.site'));
    }

    // 3) Si no se salta, sigue el flujo normal
    try {
        $response = $this->installerService->licenseCodeChecker($request->all());
        if (isset($response->status) && $response->status) {
            $envService = new EnvEditor();
            $envService->addData([
                'MIX_API_KEY' => $request->license_key,
            ]);
            return redirect(route('installer.site'));
        } else {
            return redirect(route('installer.license'))
                ->withErrors(['global' => $response->message])
                ->withInput();
        }
    } catch (Exception $e) {
        return redirect(route('installer.license'))
            ->withErrors(['global' => $e->getMessage()])
            ->withInput();
    }
}


    public function site(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('installer.site');
    }

    public function siteStore(Request $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $rules     = config('installer.site.form.rules');
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect(route('installer.site'))->withErrors($validator)->withInput();
        }

        try {
            $this->installerService->siteSetup($request);
            return redirect(route('installer.database'));
        } catch (Exception $e) {
            return redirect(route('installer.site'))->withErrors($e->getMessage())->withInput();
        }
    }

    public function database(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('installer.database');
    }

   public function databaseStore(Request $request)
{

    // Usa las mismas claves que en tu formulario:
    $rules = [
      'db_host'     => 'required|string',
      'db_port'     => 'required|numeric',
      'db_name'     => 'required|string',
      'db_username' => 'required|string',
      'db_password' => 'nullable|string',
    ];

    try {
        // Llamada al servicio; si falla lanza excepción
        $this->installerService->databaseSetup($request);
        // Si llega aquí, ¡todo OK!
        
        
        return redirect(route('installer.final'));
    } catch (Exception $e) {

        // Atrapa la excepción y muestra su mensaje
        return redirect(route('installer.database'))
            ->withErrors(['global' => $e->getMessage()])
            ->withInput();
    }
}

    public function final(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('installer.final');
    }

    public function finalStore(): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        try {
            $this->installerService->finalSetup();
            return redirect(env('APP_URL'));
        } catch (Exception $e) {
            return redirect(route('installer.site'))->withErrors(['global' => $e->getMessage()]);
        }
    }

}
