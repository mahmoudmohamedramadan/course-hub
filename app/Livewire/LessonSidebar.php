<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LessonSidebar extends Component
{
    public Course $course;

    public Lesson $currentLesson;

    /**
     * @var array<string, string>
     */
    protected $listeners = ['lesson-progress-updated' => '$refresh'];

    public function render(): View
    {
        $lessonIds = $this->course->lessons->pluck('id');

        $completedIds = auth()->user()
            ->lessonProgress()
            ->whereIn('lesson_id', $lessonIds)
            ->whereNotNull('completed_at')
            ->pluck('lesson_id');

        return view('livewire.lesson-sidebar', [
            'completedIds' => $completedIds,
        ]);
    }
}
