<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Helpers\CourseHelpers;
use App\Models\Relations\CourseRelations;
use App\Traits\Models\UpdatesNavigationBadgeCount;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
    'category_id',
    'level_id',
    'instructor_id',
    'title',
    'slug',
    'short_description',
    'description',
    'rating',
    'is_featured',
    'is_published',
    'target_audience',
    'thumbnail_url',
    'cover_image_url',
])]
class Course extends BaseModel
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory, CourseRelations, CourseHelpers, UpdatesNavigationBadgeCount;

    /**
     * The attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'rating'       => 'decimal:2',
            'is_featured'  => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($course) {
            if (empty($course->slug)) {
                $course->slug = Str::slug($course->title) . '-' . Str::lower(Str::random(6));
            }
        });
    }
}
