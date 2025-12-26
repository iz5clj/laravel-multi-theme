<?php

namespace iz5clj\MultiTheme;

use Illuminate\Support\ServiceProvider;
use iz5clj\MultiTheme\Services\ThemeService;
use iz5clj\MultiTheme\Console\Commands\ThemeSwitchCommand;
use iz5clj\MultiTheme\Http\Middleware\SetTheme;

class MultiThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../config/multi-theme.php', 'multi-theme'
        );

        // Register theme service as singleton
        $this->app->singleton('theme', function ($app) {
            return new ThemeService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/multi-theme.php' => config_path('multi-theme.php'),
        ], 'multi-theme-config');

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands([
                ThemeSwitchCommand::class,
            ]);
        }

        // Register middleware
        $router = $this->app['router'];
        $router->aliasMiddleware('theme', SetTheme::class);
    }
}
