<?php

namespace App\Models\Helpers;

trait CourseHelpers
{
    /**
     * Get the number of published lessons for the course.
     *
     * @return int
     */
    public function publishedLessonsCount()
    {
        return $this->lessons()->published()->count();
    }

    /**
     * Get the total duration of the course in seconds.
     *
     * @return int
     */
    public function totalDurationSeconds()
    {
        return (int) $this->lessons()->sum('video_duration_seconds');
    }

    /**
     * Get the total duration of the course in a formatted string.
     *
     * @return string
     */
    public function formattedTotalDuration()
    {
        $seconds = $this->totalDurationSeconds();
        $hours   = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);

        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }

        return "{$minutes} min";
    }
}
