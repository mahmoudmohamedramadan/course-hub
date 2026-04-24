<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\UpdatesNavigationBadgeCount;

class BaseModel extends Model
{
    use UpdatesNavigationBadgeCount;
}
