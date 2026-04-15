<?php

namespace App\Models\Relations;

use App\Models\Course;
use App\Models\LessonProgress;

trait LessonRelations
{
    /**
     * Get the course that the lesson belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the progress records for the lesson.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function progressRecords()
    {
        return $this->hasMany(LessonProgress::class);
    }
}
