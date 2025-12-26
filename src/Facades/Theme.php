<?php

namespace iz5clj\MultiTheme\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \iz5clj\MultiTheme\Services\ThemeService setType(string $type)
 * @method static string|null getType()
 * @method static string getActive(string|null $type = null)
 * @method static bool setActive(string $type, string $theme)
 * @method static string getPath(string|null $type = null)
 * @method static string asset(string $path, string|null $type = null)
 * @method static array getAvailableThemes(string $type)
 * @method static array getTypes()
 * @method static bool typeExists(string $type)
 * @method static bool themeExists(string $type, string $theme)
 *
 * @see \iz5clj\MultiTheme\Services\ThemeService
 */
class Theme extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'theme';
    }
}
