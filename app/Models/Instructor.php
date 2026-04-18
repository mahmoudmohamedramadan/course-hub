<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\UpdatesNavigationBadgeCount;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
    'name',
    'title',
    'bio',
    'linkedin_url',
    'avatar_url'
])]
class Instructor extends Model
{
    /** @use HasFactory<InstructorFactory> */
    use HasFactory, UpdatesNavigationBadgeCount;

    /**
     * Get the courses for the instructor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
