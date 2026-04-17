<?php

namespace App\Services;

use App\Enums\HttpStatusCode;
use App\Repositories\Lesson as LessonRepository;

class Lesson
{
    /**
     * Lesson repository.
     *
     * @var \App\Repositories\Lesson
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param  \App\Repositories\Lesson  $repository
     * @return void
     */
    public function __construct(LessonRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the previous lesson for a course.
     *
     * @param  \App\Models\Course  $course
     * @param  \App\Models\Lesson  $lesson
     * @return array|never
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function resolveAccessibleLessonNavigation($course, $lesson)
    {
        if (! $course->isPublished()) {
            abort(HttpStatusCode::NOT_FOUND->value);
        }

        if ($lesson->course_id !== $course->id) {
            abort(HttpStatusCode::NOT_FOUND->value);
        }

        if (! $lesson->isPublished()) {
            abort(HttpStatusCode::NOT_FOUND->value);
        }

        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        if (! $user->isEnrolledIn($course)) {
            abort(HttpStatusCode::NOT_FOUND->value);
        }

        $this->repository->loadCourseRelations($course);

        return $this->repository->getAdjacentPublishedLessons($course, $lesson);
    }
}
