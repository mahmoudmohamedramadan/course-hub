<?php

namespace App\Livewire;

use App\Models\Course;
use App\Models\Lesson;
use Livewire\Component;
use Livewire\Attributes\Computed;

class LessonProgressControls extends Component
{
    public Course $course;

    public Lesson $lesson;

    public bool $isCompleted = false;

    public int $completedCount = 0;

    public int $totalLessons = 0;

    protected $user;

    public function mount()
    {
        $this->refreshStats();
    }

    public function boot()
    {
        /** @var \App\Models\User $user */
        $this->user = auth('web')->user();
    }

    public function markComplete()
    {
        $this->user->lessonProgress()->updateOrCreate(
            ['lesson_id' => $this->lesson->id],
            ['completed_at' => now()]
        );

        $this->refreshStats();
        $this->dispatch('lesson-progress-updated');
    }

    #[Computed(true)]
    protected function publishedLessonIds()
    {
        return $this->course->lessons()
            ->published()
            ->pluck('id');
    }

    private function refreshStats()
    {
        $publishedLessonIds = $this->publishedLessonIds;

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

    public function render()
    {
        return view('livewire.lesson-progress-controls');
    }
}
