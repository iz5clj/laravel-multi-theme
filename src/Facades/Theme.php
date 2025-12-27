<?php

namespace Michel\LaravelTheme\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Michel\LaravelTheme\ThemeService set(string $theme)
 * @method static string get()
 * @method static string getThemePath(string $theme = null)
 * @method static string getBasePath()
 * @method static \Michel\LaravelTheme\ThemeService setBasePath(string $path)
 * @method static string asset(string $path)
 * @method static bool exists(string $theme)
 * @method static array all()
 *
 * @see \Michel\LaravelTheme\ThemeService
 */
class Theme extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'theme';
    }
}
