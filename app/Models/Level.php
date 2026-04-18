<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\UpdatesNavigationBadgeCount;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
    'name',
    'slug'
])]
class Level extends Model
{
    /** @use HasFactory<LevelFactory> */
    use HasFactory, UpdatesNavigationBadgeCount;

    /**
     * Get the courses for the level.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
