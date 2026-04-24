<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
    'name',
    'slug'
])]
class Level extends BaseModel
{
    /** @use HasFactory<LevelFactory> */
    use HasFactory;

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
