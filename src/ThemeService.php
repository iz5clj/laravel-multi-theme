<?php

namespace Iz5clj\LaravelMultiTheme;

use Illuminate\Support\Facades\View;
use Illuminate\View\FileViewFinder;

class ThemeService
{
    protected string $theme;
    protected string $basePath;

    public function __construct(string $defaultTheme = 'default', string $basePath = null)
    {
        $this->theme = $defaultTheme;
        $this->basePath = $basePath ?? resource_path('themes');
    }

    /**
     * Set the active theme.
     */
    public function set(string $theme): self
    {
        $this->theme = $theme;
        $themePath = $this->getThemePath($theme);

        if (is_dir($themePath)) {
            /** @var FileViewFinder $finder */
            $finder = View::getFinder();

            // Remove any existing theme paths and add the new one at the beginning
            $paths = array_filter(
                $finder->getPaths(),
                fn($p) => !str_starts_with($p, $this->basePath)
            );

            $finder->setPaths([$themePath, ...array_values($paths)]);
        }

        return $this;
    }

    /**
     * Get the current theme name.
     */
    public function get(): string
    {
        return $this->theme;
    }

    /**
     * Get the full path to a theme's views directory.
     */
    public function getThemePath(string $theme = null): string
    {
        $theme = $theme ?? $this->theme;
        return $this->basePath . '/' . $theme . '/views';
    }

    /**
     * Get the base themes path.
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * Set the base themes path.
     */
    public function setBasePath(string $path): self
    {
        $this->basePath = $path;
        return $this;
    }

    /**
     * Generate a URL for a theme asset.
     */
    public function asset(string $path): string
    {
        return asset("themes/{$this->theme}/{$path}");
    }

    /**
     * Check if a theme exists.
     */
    public function exists(string $theme): bool
    {
        return is_dir($this->getThemePath($theme));
    }

    /**
     * Get all available themes.
     */
    public function all(): array
    {
        $themes = [];
        
        if (is_dir($this->basePath)) {
            $directories = glob($this->basePath . '/*', GLOB_ONLYDIR);
            
            foreach ($directories as $dir) {
                $themeName = basename($dir);
                if (is_dir($dir . '/views')) {
                    $themes[] = $themeName;
                }
            }
        }

        return $themes;
    }
}
