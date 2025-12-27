<?php

namespace Iz5clj\LaravelMultiTheme;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Iz5clj\LaravelMultiTheme\Middleware\SetTheme;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/theme.php', 'theme');

        $this->app->singleton('theme', function ($app) {
            /** @var string $default */
            $default = config('theme.default', 'default') ?? 'default';
            /** @var string $path */
            $path = config('theme.path', resource_path('themes')) ?? resource_path('themes');
            
            return new ThemeService($default, $path);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Publish config file
        $this->publishes([
            __DIR__ . '/../config/theme.php' => config_path('theme.php'),
        ], 'theme-config');

        // Register middleware alias
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('theme', SetTheme::class);
    }
}
