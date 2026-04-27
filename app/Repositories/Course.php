<?php

namespace App\Repositories;

use App\Models\Course as CourseModel;

class Course
{
    /**
     * Get completed lesson ids for a course.
     *
     * @param  \App\Models\Course  $course
     * @return array
     */
    public function getCourseProgress(CourseModel $course)
    {
        /** @var \App\Models\User $user */
        $user = auth('web')->user();

        $completedLessonIds = collect([]);

        $checkEnrollment = !empty($user) && $user->isEnrolledIn($course);

        if ($checkEnrollment) {
            $completedLessonIds = $user
                ->lessonProgress()
                ->whereIn('lesson_id', $course->lessons->pluck('id'))
                ->whereNotNull('completed_at')
                ->pluck('lesson_id');
        }

        return [
            'isEnrolled'         => $checkEnrollment,
            'completedLessonIds' => $completedLessonIds,
        ];
    }

    /**
     * Search for courses.
     *
     * @param string  $searchValue
     * @param string  $categoryValue
     * @param string  $levelId
     * @param string  $sort
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($searchValue, $categoryId, $levelId, $sort)
    {
        return CourseModel::published()
            ->select([
                'slug',
                'category_id',
                'level_id',
                'instructor_id',
                'thumbnail_url',
                'title',
                'short_description',
                'rating',
            ])
            ->with(['category:id,name', 'level:id,slug,name', 'instructor:id,name,avatar_url'])
            ->when(filled($searchValue), function ($q) use ($searchValue) {
                $q->where(function ($q) use ($searchValue) {
                    $q
                        ->where('title', 'LIKE', "%{$searchValue}%")
                        ->orWhere('short_description', 'LIKE', "%{$searchValue}%")
                        ->orWhere('description', 'LIKE', "%{$searchValue}%");
                });
            })
            ->when(filled($categoryId), fn($q)  => $q->where('category_id', $categoryId))
            ->when(filled($levelId),    fn($q)  => $q->where('level_id', $levelId))
            ->when($sort === 'newest',  fn($q)  => $q->latest())
            ->when($sort === 'rating',  fn($q)  => $q->orderByDesc('rating')->orderByDesc('id'))
            ->paginate(4);
    }
}
