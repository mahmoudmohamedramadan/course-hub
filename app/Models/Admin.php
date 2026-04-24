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
