<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Helpers\LessonHelpers;
use App\Models\Relations\LessonRelations;
use App\Traits\Models\UpdatesNavigationBadgeCount;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable([
    'course_id',
    'title',
    'slug',
    'learnings',
    'video_duration_seconds',
    'is_published',
    'video_url',
    'sort_order',
])]
class Lesson extends BaseModel
{
    /** @use HasFactory<LessonFactory> */
    use HasFactory, LessonRelations, LessonHelpers, UpdatesNavigationBadgeCount;

    /**
     * The attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
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

        static::creating(function ($lesson) {
            if (empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title);
            }
        });
    }
}
