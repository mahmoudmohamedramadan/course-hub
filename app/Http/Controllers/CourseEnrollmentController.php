<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\CourseEnrollment as CourseEnrollmentService;

class CourseEnrollmentController
{
    /**
     * CourseEnrollment service.
     *
     * @var \App\Services\CourseEnrollment
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\CourseEnrollment  $service
     * @return void
     */
    public function __construct(CourseEnrollmentService $service)
    {
        $this->service = $service;
    }

    /**
     * Enroll user in a course.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function store(Course $course)
    {
        $this->service->enrollUserInCourse($course);

        return redirect()
            ->route('courses.show', $course)
            ->with('status', __('You are now enrolled in this course.'));
    }
}
