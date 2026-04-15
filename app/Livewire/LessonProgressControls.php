<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LessonProgressControls extends Component
{
    public Course $course;

    public Lesson $lesson;

    public bool $isCompleted = false;

    public int $completedCount = 0;

    public int $totalLessons = 0;

    protected $user;

    public function mount(): void
    {
        $this->refreshStats();
    }

    public function boot()
    {
        /** @var \App\Models\User $user */
        $this->user = auth('web')->user();
    }

    public function markComplete(): void
    {
        $this->user->lessonProgress()->updateOrCreate(
            ['lesson_id' => $this->lesson->id],
            ['completed_at' => now()]
        );

        $this->refreshStats();
        $this->dispatch('lesson-progress-updated');
    }

    private function refreshStats(): void
    {
        $publishedLessonIds = $this->course->lessons()
            ->where('is_published', true)
            ->pluck('id');

        $this->totalLessons = $publishedLessonIds->count();
        $this->completedCount = $this->user->lessonProgress()
            ->whereIn('lesson_id', $publishedLessonIds)
            ->whereNotNull('completed_at')
            ->count();
        $this->isCompleted = $this->user->lessonProgress()
            ->where('lesson_id', $this->lesson->id)
            ->whereNotNull('completed_at')
            ->exists();
    }

    public function render(): View
    {
        return view('livewire.lesson-progress-controls');
    }
}
