<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Theme
    |--------------------------------------------------------------------------
    |
    | This is the default theme that will be used when no theme is specified.
    |
    */

    'default' => env('THEME_DEFAULT', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Themes Path
    |--------------------------------------------------------------------------
    |
    | This is the base path where your themes are located. Each theme should
    | be in its own folder with a 'views' subdirectory containing the
    | Blade templates.
    |
    | Structure:
    | resources/themes/
    |   ├── theme1/
    |   │   └── views/
    |   │       └── welcome.blade.php
    |   └── theme2/
    |       └── views/
    |           └── welcome.blade.php
    |
    */

    'path' => resource_path('themes'),

];
