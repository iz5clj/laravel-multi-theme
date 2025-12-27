<?php

namespace Iz5clj\LaravelMultiTheme\Middleware;

use Closure;
use Illuminate\Http\Request;
use Iz5clj\LaravelMultiTheme\ThemeService;
use Symfony\Component\HttpFoundation\Response;

class SetTheme
{
    public function __construct(
        protected ThemeService $themeService
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $theme = null): Response
    {
        $theme = $theme ?? config('theme.default', 'default');
        
        $this->themeService->set($theme);

        // Make theme available in all views
        view()->share('currentTheme', $theme);

        return $next($request);
    }
}
