<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Lesson;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class LessonSidebar extends Component
{
    public Course $course;

    public Lesson $currentLesson;

    protected $listeners = ['lesson-progress-updated' => '$refresh'];

    public function render(): View
    {
        $lessonIds = $this->course->lessons->pluck('id');

        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        /** \App\Models\User */
        $completedIds = $user
            ->lessonProgress()
            ->whereIn('lesson_id', $lessonIds)
            ->whereNotNull('completed_at')
            ->pluck('lesson_id');

        return view('livewire.lesson-sidebar', [
            'completedIds' => $completedIds,
        ]);
    }
}
