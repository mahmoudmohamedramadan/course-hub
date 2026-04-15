<?php

namespace App\Repositories;

use App\Models\Lesson as LessonModel;

class Lesson
{
    /**
     * Load course relations.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function loadCourseRelations($course)
    {
        $course->load([
            'lessons' => fn($q) => $q
                ->select(['id', 'course_id', 'slug', 'title', 'video_duration_seconds', 'is_published', 'sort_order'])
                ->orderBy('sort_order'),
            'instructor' => fn($q) => $q->select(['id', 'name']),
            'category'   => fn($q) => $q->select(['id', 'name']),
            'level'      => fn($q) => $q->select(['id', 'slug', 'name']),
        ]);
    }

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
