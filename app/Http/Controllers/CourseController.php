<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\Course as CourseService;

class CourseController
{
    /**
     * Course service.
     *
     * @var \App\Services\Course
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\Course  $service
     * @return void
     */
    public function __construct(CourseService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Contracts\View\View|never
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function show(Course $course)
    {
        $completedLessonIds = $this->service->getPublishedCourseCompletedLessonIds($course);

        return view('courses.show', [
            'course'             => $course,
            'completedLessonIds' => $completedLessonIds,
        ]);
    }
}
