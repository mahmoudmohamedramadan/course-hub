<?php

namespace App\Services;

use App\Enums\HttpStatusCode;
use App\Repositories\Course as CourseRepository;

class Course
{
    /**
     * Course repository.
     *
     * @var \App\Repositories\Course
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param  \App\Repositories\Course  $repository
     * @return void
     */
    public function __construct(CourseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get completed lesson IDs for a published course.
     *
     * @param  \App\Models\Course  $course
     * @return array
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function getPublishedCourseCompletedLessonIds($course)
    {
        if (! $course->isPublished()) {
            abort(HttpStatusCode::NOT_FOUND->value);
        }

        $this->repository->loadRelations($course);

        return $this->repository->getCompletedLessonIds($course);
    }
}
