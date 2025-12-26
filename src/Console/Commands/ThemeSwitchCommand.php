<?php

namespace iz5clj\MultiTheme\Console\Commands;

use Illuminate\Console\Command;
use iz5clj\MultiTheme\Facades\Theme;

class ThemeSwitchCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'theme:switch 
                            {type : The theme type (frontend, admin, etc.)}
                            {theme : The theme name to switch to}';

    /**
     * The console command description.
     */
    protected $description = 'Switch the active theme for a given type';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $type = $this->argument('type');
        $theme = $this->argument('theme');

        if (!Theme::typeExists($type)) {
            $this->error("Theme type [{$type}] does not exist.");
            $this->info('Available types: ' . implode(', ', Theme::getTypes()));
            return self::FAILURE;
        }

        if (!Theme::themeExists($type, $theme)) {
            $this->error("Theme [{$theme}] does not exist for type [{$type}].");
            $availableThemes = array_keys(Theme::getAvailableThemes($type));
            $this->info('Available themes: ' . implode(', ', $availableThemes));
            return self::FAILURE;
        }

        // Update .env file
        $this->updateEnvFile($type, $theme);

        $this->info("Theme switched to [{$theme}] for type [{$type}]");
        $this->warn('Remember to run: php artisan config:clear');

        return self::SUCCESS;
    }

    /**
     * Update the .env file with new theme
     */
    protected function updateEnvFile(string $type, string $theme): void
    {
        $envFile = base_path('.env');
        $envKey = strtoupper($type) . '_THEME';

        if (!file_exists($envFile)) {
            return;
        }

        $content = file_get_contents($envFile);

        if (preg_match("/^{$envKey}=.*/m", $content)) {
            $content = preg_replace(
                "/^{$envKey}=.*/m",
                "{$envKey}={$theme}",
                $content
            );
        } else {
            $content .= "\n{$envKey}={$theme}";
        }

        file_put_contents($envFile, $content);
    }
}