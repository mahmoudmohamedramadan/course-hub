# Filament Separate Admin Authentication

## Why this exists

The app originally used a single users table for authentication. When setting up Filament, creating an admin also stored it in the same table.

This causes problems:

- **Privilege overlap** — admins and users share the same access
- **More complex logic** — you must constantly check roles
- **Security risk** — mistakes can expose admin features to users

---

## Solution

- Users → `users` table with `web` guard
- Admins → `admins` table with `admin` guard

---

## 1. Admin model and migration

Create the model and migration:

```bash
php artisan make:model Admin -m
```

Adjust the migration to match the columns you need (at minimum `name`, `email`, `password`).

---

## 2. Admin model

Implement Filament’s `FilamentUser` contract (and any optional MFA interfaces your panel uses). Use the same attribute style as `App\Models\User` for fillable / hidden fields.

> For official guidance on implementing **`FilamentUser`** and **`canAccessPanel()`** (who may access the panel), see Filament’s documentation: [Users — Authorizing access to the panel](https://filamentphp.com/docs/5.x/users/overview#authorizing-access-to-the-panel). That page uses `App\Models\User` as an example; apply the same ideas to your **`Admin`** model.

```php
<?php

namespace App\Models;

use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthentication;

class Admin extends BaseAuthModel implements FilamentUser, HasAppAuthentication
{
    use InteractsWithAppAuthentication;

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
        'driver'   => 'session',
        'provider' => 'users',
    ],

    'admin' => [
        'driver'   => 'session',
        'provider' => 'admins',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model'  => env('AUTH_MODEL', App\Models\User::class),
    ],

    'admins' => [
        'driver' => 'eloquent',
        'model'  => App\Models\Admin::class,
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
