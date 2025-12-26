<?php

namespace iz5clj\MultiTheme\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetTheme
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $type = 'frontend'): Response
    {
        app('theme')->setType($type);
        
        // Share theme info with all views
        view()->share('themeType', $type);
        view()->share('themeName', app('theme')->getActive($type));
        
        return $next($request);
    }
}
