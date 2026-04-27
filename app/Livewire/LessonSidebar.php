<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Lesson;
use Livewire\Component;
use App\Repositories\Course as CourseRepository;

class LessonSidebar extends Component
{
    public Course $course;

    public Lesson $currentLesson;

    protected $listeners = ['lesson-progress-updated' => '$refresh'];

    /**
     * Course repository.
     *
     * @var \App\Repositories\Course
     */
    protected $repository;

    public function boot()
    {
        $this->repository = new CourseRepository;
    }

    public function render()
    {
        $completedIds = $this->repository->getCourseProgress($this->course)['completedLessonIds'];

        return view('livewire.lesson-sidebar', [
            'completedIds' => $completedIds,
        ]);
    }
}
