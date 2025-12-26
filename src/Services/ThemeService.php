<?php

namespace iz5clj\MultiTheme\Services;

use Illuminate\Support\Facades\View;
use InvalidArgumentException;

class ThemeService
{
    protected ?string $currentType = null;
    protected bool $viewsRegistered = false;

    /**
     * Set the current theme type
     */
    public function setType(string $type): self
    {
        if (!$this->typeExists($type)) {
            throw new InvalidArgumentException("Theme type [{$type}] is not defined in config.");
        }

        $this->currentType = $type;
        $this->registerViews();

        return $this;
    }

    /**
     * Get the current theme type
     */
    public function getType(): ?string
    {
        return $this->currentType;
    }

    /**
     * Get the active theme name for a type
     */
    public function getActive(?string $type = null): string
    {
        $type = $type ?? $this->currentType ?? 'frontend';
        
        return config("multi-theme.types.{$type}.active", 'default');
    }

    /**
     * Set the active theme for a type
     */
    public function setActive(string $type, string $theme): bool
    {
        if (!$this->themeExists($type, $theme)) {
            return false;
        }

        config(["multi-theme.types.{$type}.active" => $theme]);
        
        return true;
    }

    /**
     * Get the full path to the theme views directory
     */
    public function getPath(?string $type = null): string
    {
        $type = $type ?? $this->currentType ?? 'frontend';
        $themePath = config("multi-theme.types.{$type}.path");
        $activeTheme = $this->getActive($type);
        $basePath = config('multi-theme.base_path', resource_path('themes'));
        
        return "{$basePath}/{$themePath}/{$activeTheme}/views";
    }

    /**
     * Get theme asset path
     */
    public function asset(string $path, ?string $type = null): string
    {
        $type = $type ?? $this->currentType ?? 'frontend';
        $themePath = config("multi-theme.types.{$type}.path");
        $activeTheme = $this->getActive($type);
        
        return "themes/{$themePath}/{$activeTheme}/{$path}";
    }

    /**
     * Get all available themes for a type
     */
    public function getAvailableThemes(string $type): array
    {
        return config("multi-theme.types.{$type}.themes", []);
    }

    /**
     * Get all theme types
     */
    public function getTypes(): array
    {
        return array_keys(config('multi-theme.types', []));
    }

    /**
     * Check if a theme type exists
     */
    public function typeExists(string $type): bool
    {
        return config("multi-theme.types.{$type}") !== null;
    }

    /**
     * Check if a specific theme exists for a type
     */
    public function themeExists(string $type, string $theme): bool
    {
        return isset(config("multi-theme.types.{$type}.themes")[$theme]);
    }

    /**
     * Register theme views path
     */
    protected function registerViews(): void
    {
        if (!$this->viewsRegistered && $this->currentType) {
            $themePath = $this->getPath();

            if (is_dir($themePath)) {
                View::addLocation($themePath);
            }
            
            $this->viewsRegistered = true;
        }
    }
}
