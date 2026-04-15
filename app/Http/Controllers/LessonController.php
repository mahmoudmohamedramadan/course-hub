<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Services\Lesson as LessonService;

class LessonController
{
    /**
     * Lesson service.
     *
     * @var \App\Services\Lesson
     */
    protected $service;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Services\Lesson  $service
     * @return void
     */
    public function __construct(LessonService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Contracts\View\View|never
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function show(Course $course, Lesson $lesson)
    {
        $lessonNavigation = $this->service->resolveAccessibleLessonNavigation($course, $lesson);

        $prevLesson = $lessonNavigation['prevLesson'];
        $nextLesson = $lessonNavigation['nextLesson'];

        return view('courses.lesson', [
            'course'     => $course,
            'lesson'     => $lesson,
            'prevLesson' => $prevLesson,
            'nextLesson' => $nextLesson,
        ]);
    }
}
