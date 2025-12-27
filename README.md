# Laravel Theme

A Laravel package for multi-theme support with dynamic view path switching.

## Installation

### Via Composer (from Packagist after publishing)

```bash
composer require iz5clj/laravel-theme
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=theme-config
```

This will create a `config/theme.php` file where you can set:

- `default` - The default theme name
- `path` - The base path where themes are located

## Theme Structure

Create your themes in the configured path (default: `resources/themes`):

```
resources/themes/
├── my-theme/
│   └── views/
│       ├── welcome.blade.php
│       └── layouts/
│           └── app.blade.php
└── another-theme/
    └── views/
        └── welcome.blade.php
```

## Usage

### Via Middleware (Recommended)

Apply the `theme` middleware to routes or route groups:

```php
// Single route
Route::get('/', function () {
    return view('welcome');
})->middleware('theme:my-theme');

// Route group
Route::middleware(['theme:my-theme'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::get('/about', function () {
        return view('about');
    });
});
```

### Via Facade

```php
use Michel\LaravelTheme\Facades\Theme;

// Set the theme
Theme::set('my-theme');

// Get current theme name
$currentTheme = Theme::get();

// Get theme asset URL
$cssUrl = Theme::asset('css/app.css');
// Returns: /themes/my-theme/css/app.css

// Check if a theme exists
if (Theme::exists('my-theme')) {
    // ...
}

// Get all available themes
$themes = Theme::all();
```

### In Blade Templates

The current theme name is shared with all views as `$currentTheme`:

```blade
<link href="{{ asset('themes/' . $currentTheme . '/css/app.css') }}" rel="stylesheet">

{{-- Or using the Theme facade --}}
<link href="{{ Theme::asset('css/app.css') }}" rel="stylesheet">
```

### Theme Assets

Place your theme assets in the public directory:

```
public/themes/
├── my-theme/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── images/
│       └── logo.png
└── another-theme/
    └── css/
        └── app.css
```

## API Reference

### ThemeService Methods

| Method | Description |
|--------|-------------|
| `set(string $theme)` | Set the active theme |
| `get()` | Get the current theme name |
| `asset(string $path)` | Generate URL for theme asset |
| `exists(string $theme)` | Check if a theme exists |
| `all()` | Get all available themes |
| `getThemePath(string $theme = null)` | Get the full path to a theme's views |
| `getBasePath()` | Get the base themes path |
| `setBasePath(string $path)` | Set the base themes path |

## Environment Variables

| Variable | Description | Default |
|----------|-------------|---------|
| `THEME_DEFAULT` | The default theme name | `default` |

## License

MIT License
