<?php

namespace App\Models\Helpers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Str;

trait UserHelpers
{
    /**
     * Get the user's initials
     *
     * @return string
     */
    public function initials()
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /**
     * Check if the user has completed a lesson.
     *
     * @param \App\Models\Lesson $lesson
     * @return bool
     */
    public function hasCompletedLesson(Lesson $lesson)
    {
        return $this->lessonProgress()
            ->where('lesson_id', $lesson->id)
            ->whereNotNull('completed_at')
            ->exists();
    }

    /**
     * Check if the user is enrolled in a course.
     *
     * @param \App\Models\Course $course
     * @return bool
     */
    public function isEnrolledIn(Course $course)
    {
        return $this->enrolledCourses()->whereKey($course->id)->exists();
    }
}
