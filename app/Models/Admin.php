<?php

namespace App\Models;

use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthentication;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;

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
