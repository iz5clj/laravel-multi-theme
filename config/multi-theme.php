<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Theme Types
    |--------------------------------------------------------------------------
    |
    | Define your theme types (frontend, admin, etc.) and their settings.
    | Each theme type can have multiple themes to choose from.
    |
    */

    'types' => [
        'frontend' => [
            'active' => env('FRONTEND_THEME', 'default'),
            'path' => 'frontend',
            'themes' => [
                'default' => [
                    'name' => 'Default Theme',
                    'description' => 'Default frontend theme',
                ],
                'modern' => [
                    'name' => 'Modern Theme',
                    'description' => 'Modern frontend theme',
                ],
            ],
        ],
        
        'admin' => [
            'active' => env('ADMIN_THEME', 'classic'),
            'path' => 'admin',
            'themes' => [
                'classic' => [
                    'name' => 'Classic Admin',
                    'description' => 'Classic admin theme',
                ],
                'dashboard' => [
                    'name' => 'Dashboard Admin',
                    'description' => 'Modern dashboard theme',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Theme Base Path
    |--------------------------------------------------------------------------
    |
    | The base directory where all themes are stored.
    | Default: resources/themes
    |
    */

    'base_path' => resource_path('themes'),
];
