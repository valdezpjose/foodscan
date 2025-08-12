<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel server requirements, you can add as many
    | as your application require, we check if the extension is enabled
    | by looping through the array and run "extension_loaded" on it.
    |
    */
    'core'         => [
        'minPhpVersion' => '8.1.0',
    ],

    'requirements' => [
        'php'    => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL',
            'xml',
            'Ctype',
            'BCMath',
            'Zip',
            'Imagick',
            'Exif',
            'Fileinfo'
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel folders permissions, if your application
    | requires more permissions just add them to the array list bellow.
    |
    */
    'permissions'  => [
        'storage/framework/' => '775',
        'storage/logs/'      => '775',
        'bootstrap/cache/'   => '775',
    ],


    /*
    |--------------------------------------------------------------------------
    | License Validation Rules & Messages
    |--------------------------------------------------------------------------
    |
    | This are the default form field validation rules. Available Rules:
    | https://laravel.com/docs/5.4/validation#available-validation-rules
    |
    */
    'license'         => [
        'form' => [
            'rules' => [
                'license_key' => 'required|string|max:500',
            ],
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Environment Site Wizard Validation Rules & Messages
    |--------------------------------------------------------------------------
    |
    | This are the default form field validation rules. Available Rules:
    | https://laravel.com/docs/5.4/validation#available-validation-rules
    |
    */
    'site'         => [
        'form' => [
            'rules' => [
                'app_name' => 'required|string|max:50',
                'app_url'  => 'required|url',
            ],
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Environment Database Wizard Validation Rules & Messages
    |--------------------------------------------------------------------------
    |
    | This are the default form field validation rules. Available Rules:
    | https://laravel.com/docs/5.4/validation#available-validation-rules
    |
    */
    'database'     => [
        'form' => [
            'rules' => [
                'db_host'     => 'required',
                'db_port'     => 'required|numeric',
                'db_name'     => 'required',
                'db_username' => 'required',
                'db_password' => 'required',
            ],
        ],
    ],
    'buildPayload' => [
        'license_code' => env('MIX_API_KEY'),
        'product_id'   => '50038622',
        'purpose'      => 'update',
        'version'      => 1.3,
    ],

    'url'            => 'https://support.inilabs.net',
    'productlicence' => '/api/check-product-license',
];
