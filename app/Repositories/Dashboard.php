<?php

namespace App\Repositories;

use App\Models\User;

class Dashboard
{
    /**
     * Get the courses the user is enrolled in.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Support\Collection<int, \App\Models\Course>
     */
    public function getEnrolledCourses(User $user)
    {
        return $user
            ->enrolledCourses()
            ->select(['courses.id', 'slug', 'title', 'short_description', 'thumbnail_url', 'rating', 'category_id', 'level_id'])
            ->with(['category:id,name', 'level:id,slug,name'])
            ->orderByDesc('course_user.created_at')
            ->get();
    }
}
