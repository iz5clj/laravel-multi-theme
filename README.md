# Laravel Multi-Theme Package

A Laravel package for managing multiple themes in your application. Perfect for applications that need separate frontend and admin themes, or multiple theme variations.

## Features

- ✅ Multiple theme types (frontend, admin, custom)
- ✅ Easy theme switching via command or facade
- ✅ Automatic view resolution with fallback support
- ✅ Theme-specific components
- ✅ Middleware for route-based theme assignment
- ✅ Laravel 10, 11, 12 compatible

## Installation

Install via Composer:

```bash
composer require iz5clj/laravel-multi-theme
```

Publish the config file:

```bash
php artisan vendor:publish --tag=multi-theme-config
```

## Directory Structure

Create your themes directory:

```
resources/
└── themes/
    ├── frontend/
    │   ├── default/
    │   │   ├── views/
    │   │   ├── sass/
    │   │   └── js/
    │   └── modern/
    │       └── views/
    └── admin/
        ├── classic/
        │   └── views/
        └── dashboard/
            └── views/
```

## Configuration

Edit `config/multi-theme.php`:

```php
'types' => [
    'frontend' => [
        'active' => env('FRONTEND_THEME', 'default'),
        'path' => 'frontend',
        'themes' => [
            'default' => ['name' => 'Default Theme'],
            'modern' => ['name' => 'Modern Theme'],
        ],
    ],
    'admin' => [
        'active' => env('ADMIN_THEME', 'classic'),
        'path' => 'admin',
        'themes' => [
            'classic' => ['name' => 'Classic Admin'],
            'dashboard' => ['name' => 'Dashboard Theme'],
        ],
    ],
],
```

Add to your `.env`:

```env
FRONTEND_THEME=default
ADMIN_THEME=classic
```

## Usage

### Route Middleware

```php
// routes/web.php

// Frontend routes
Route::middleware(['theme:frontend'])->group(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/about', [HomeController::class, 'about']);
});

// Admin routes
Route::prefix('admin')
    ->middleware(['auth', 'theme:admin'])
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
    });
```

### Using the Facade

```php
use iz5clj\MultiTheme\Facades\Theme;

// Get current theme type
Theme::getType(); // 'frontend' or 'admin'

// Get active theme for a type
Theme::getActive('frontend'); // 'default'

// Get theme path
Theme::getPath('frontend'); // Full path to views

// Get theme asset path
Theme::asset('images/logo.png'); // 'themes/frontend/default/images/logo.png'

// Get available themes
Theme::getAvailableThemes('frontend');

// Check if theme exists
Theme::themeExists('frontend', 'modern');
```

### Controllers

Controllers work normally - Laravel automatically resolves views from the active theme:

```php
class HomeController extends Controller
{
    public function index()
    {
        // Looks in: resources/themes/frontend/{active}/views/pages/home.blade.php
        return view('pages.home');
    }
}
```

### Artisan Command

Switch themes via command line:

```bash
# Switch frontend theme to 'modern'
php artisan theme:switch frontend modern

# Switch admin theme to 'dashboard'
php artisan theme:switch admin dashboard

# Clear config cache
php artisan config:clear
```

### Helper Function (Optional)

Create a helper in your app:

```php
// app/helpers.php

if (!function_exists('theme_asset')) {
    function theme_asset(string $path): string
    {
        return app('theme')->asset($path);
    }
}
```

Use in views:

```blade
<img src="{{ theme_asset('images/logo.png') }}" alt="Logo">
```

## License

MIT License

## Contributing

Pull requests are welcome!

### 9. LICENSE

MIT License

Copyright (c) 2024 Your Name

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
