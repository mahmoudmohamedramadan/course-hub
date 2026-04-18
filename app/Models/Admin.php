<?php

namespace App\Models;

use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthentication;

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

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
