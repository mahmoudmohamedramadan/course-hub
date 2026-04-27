<?php

namespace App\Repositories;

use App\Models\Lesson as LessonModel;

class Lesson
{
    /**
     * Get previous and next published lessons within a course.
     *
     * @param  \App\Models\Course  $course
     * @param  \App\Models\Lesson  $lesson
     * @return array
     */
    public function getAdjacentPublishedLessons($course, $lesson)
    {
        $sorted = $course->lessons;

        $currentIndex = $sorted->search(fn(LessonModel $l) => $l->is($lesson));

        $prevLesson = $currentIndex !== false && $currentIndex > 0
            ? $sorted->take($currentIndex)->reverse()->first(fn(LessonModel $l) => $l->is_published)
            : null;

        $nextLesson = $currentIndex !== false
            ? $sorted->skip($currentIndex + 1)->first(fn(LessonModel $l) => $l->is_published)
            : null;

        return compact('prevLesson', 'nextLesson');
    }
}
