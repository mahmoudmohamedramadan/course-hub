# Separate admin authentication (Filament)

## Why this exists

The app originally relied on a single `users` table for authentication. When wiring Filament, **installer-style flows and user-creation tooling** typically persist accounts using whatever Eloquent model your panel is configured to use. If that model is the same as your students (`User`), new “admins” land in `users` alongside normal accounts.

That coupling creates real problems:

- **Privilege overlap** — the same identity can satisfy both “logged-in student” and “Filament session” expectations unless you add strict, easy-to-miss guards everywhere.
- **Harder reasoning** — authorization and policies must constantly branch on “is this row an admin or a student?”.
- **Higher blast radius** — bugs in role checks or route middleware can expose admin capabilities to the wrong account class.

This project **splits authentication concerns**: students stay on the `web` guard and `users` table; Filament uses a dedicated **`admins` table** and **`admin` guard**.

---

## 1. Admin model and migration

Create the model and migration:

```bash
php artisan make:model Admin -m
```

Adjust the migration to match the columns you need (at minimum `name`, `email`, `password`).

---

## 2. Admin model

Implement Filament’s `FilamentUser` contract (and any optional MFA interfaces your panel uses). Use the same attribute style as `App\Models\User` for fillable / hidden fields:

```php
<?php

namespace App\Models;

use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthentication;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable([
    'name',
    'email',
    'password',
])]
#[Hidden([
    'password',
])]
class Admin extends Authenticatable implements FilamentUser, HasAppAuthentication
{
    use InteractsWithAppAuthentication;

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
```

Tighten `canAccessPanel()` in production (e.g. allow only specific emails, roles, or env-driven allow lists).

---

## 3. Dedicated guard and provider

In `config/auth.php`, register a session guard that points at an `admins` provider, and map that provider to `App\Models\Admin::class`:

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => env('AUTH_MODEL', App\Models\User::class),
    ],

    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
],
```

Keep `defaults` aimed at **`web`** for the public site; only the Filament panel should use the **`admin`** guard.

---

## 4. Filament panel configuration

Bind the panel to the admin guard so Filament sessions never authenticate against `User`:

```php
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        // ...
        ->authGuard('admin');
}
```

In this repository, see `app/Providers/Filament/AdminPanelProvider.php`.

---

## Result

- Admins live in **`admins`**, students in **`users`**.
- **Session isolation** — `auth('web')` and `auth('admin')` are distinct; the student app and Filament no longer share the same credential store.
- **Clearer security boundary** — you still need correct middleware and `canAccessPanel()` logic, but you are not storing two different actor types in one table by default.
