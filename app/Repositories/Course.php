<?php

namespace App\Repositories;

use App\Models\Course as CourseModel;

class Course
{
    /**
     * Load relations for a course.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function loadRelations($course)
    {
        $course->load([
            'lessons'    => fn($q) => $q
                ->select(['id', 'course_id', 'slug', 'title', 'video_duration_seconds', 'is_published', 'sort_order'])
                ->orderBy('sort_order'),
            'instructor' => fn($q) => $q->select(['id', 'name', 'title', 'avatar_url', 'bio', 'linkedin_url']),
            'category'   => fn($q) => $q->select(['id', 'name']),
            'level'      => fn($q) => $q->select(['id', 'slug', 'name']),
        ]);
    }

    /**
     * Get completed lesson ids for a course.
     *
     * @param  \App\Models\Course  $course
     * @return array
     */
    public function getCompletedLessonIds(CourseModel $course)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = auth('web')->user();

        $completedLessonIds = [];

        if (!empty($user) && $user->isEnrolledIn($course)) {
            $completedLessonIds = $user
                ->lessonProgress()
                ->whereIn('lesson_id', $course->lessons->pluck('id'))
                ->whereNotNull('completed_at')
                ->pluck('lesson_id')
                ->all();
        }

        return $completedLessonIds;
    }

    /**
     * Search for courses.
     *
     * @param string  $searchQuery
     * @param string  $categoryId
     * @param string  $levelId
     * @param string  $sort
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search($searchQuery, $categoryId, $levelId, $sort)
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
            ->when($searchQuery !== '', function ($q) use ($searchQuery) {
                $term = "%{$searchQuery}%";
                $q->where(function ($q) use ($term) {
                    $q
                        ->where('title', 'like', $term)
                        ->orWhere('short_description', 'like', $term)
                        ->orWhere('description', 'like', $term);
                });
            })
            ->when($categoryId !== '', fn($q) => $q->where('category_id', (int) $categoryId))
            ->when($levelId !== '',    fn($q) => $q->where('level_id', (int) $levelId))
            ->when($sort === 'newest', fn($q) => $q->latest())
            ->when($sort === 'rating', fn($q) => $q->orderByDesc('rating')->orderByDesc('id'))
            ->paginate(4);
    }
}
