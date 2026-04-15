<?php

namespace App\Services;

use App\Enums\HttpStatusCode;

class CourseEnrollment
{
    /**
     * Enroll user in a course.
     *
     * @param  \App\Models\Course  $course
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function enrollUserInCourse($course)
    {
        if (! $course->isPublished()) {
            abort(HttpStatusCode::NOT_FOUND->value);
        }

        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        if (! $user->isEnrolledIn($course)) {
            $user->enrolledCourses()->attach($course->id);
        }
    }
}
