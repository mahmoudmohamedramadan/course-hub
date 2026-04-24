<?php

namespace App\Models;

use App\Traits\Models\UpdatesNavigationBadgeCount;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[Fillable([
    'name',
    'email',
    'password'
])]
#[Hidden([
    'password',
    'remember_token'
])]
class BaseAuthModel extends Authenticatable
{
    use UpdatesNavigationBadgeCount;
}
