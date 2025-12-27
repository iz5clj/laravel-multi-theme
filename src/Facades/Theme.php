<?php

namespace Iz5clj\LaravelMultiTheme\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Iz5clj\LaravelMultiTheme\ThemeService set(string $theme)
 * @method static string get()
 * @method static string getThemePath(string $theme = null)
 * @method static string getBasePath()
 * @method static \Iz5clj\LaravelMultiTheme\ThemeService setBasePath(string $path)
 * @method static string asset(string $path)
 * @method static bool exists(string $theme)
 * @method static array all()
 *
 * @see \Iz5clj\LaravelMultiTheme\ThemeService
 */
class Theme extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'theme';
    }
}
