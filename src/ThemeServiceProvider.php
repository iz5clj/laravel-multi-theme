<?php

namespace Michel\LaravelTheme;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Michel\LaravelTheme\Middleware\SetTheme;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/theme.php', 'theme');

        $this->app->singleton('theme', function ($app) {
            return new ThemeService(
                config('theme.default', 'default'),
                config('theme.path', resource_path('themes'))
            );
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
