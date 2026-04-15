<?php

namespace App\Models\Helpers;

trait LessonHelpers
{
    /**
     * Get the formatted duration of the lesson.
     *
     * @return string
     */
    public function formattedDuration()
    {
        $seconds = $this->video_duration_seconds;
        $m       = intdiv($seconds, 60);
        $s       = $seconds % 60;

        return sprintf('%d:%02d', $m, $s);
    }
}
