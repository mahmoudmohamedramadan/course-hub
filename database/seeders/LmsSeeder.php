<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Level;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Category;
use App\Models\Instructor;
use Illuminate\Support\Str;
use App\Models\LessonProgress;
use Illuminate\Database\Seeder;
use Database\Factories\LessonFactory;

class LmsSeeder extends Seeder
{
    public function run(): void
    {
        $levelDefs = [
            ['name' => 'Beginner',     'slug' => 'beginner'],
            ['name' => 'Intermediate', 'slug' => 'intermediate'],
            ['name' => 'Advanced',     'slug' => 'advanced'],
            ['name' => 'Expert',       'slug' => 'expert'],
        ];

        $levels = collect($levelDefs)->map(fn(array $row) => Level::firstOrCreate(
            ['slug' => $row['slug']],
            ['name' => $row['name']]
        ));

        $categoryNames = [
            'Web Development',
            'Data Science',
            'DevOps',
            'Mobile',
            'UI/UX',
            'Security',
            'Cloud',
            'Databases',
            'AI/ML',
            'Soft Skills',
        ];

        $categories = collect($categoryNames)->map(fn(string $name) => Category::firstOrCreate(
            ['slug' => Str::slug($name)],
            ['name' => $name]
        ));

        $instructors = Instructor::factory()->count(6)->create();

        $courses = collect();
        for ($i = 0; $i < 8; $i++) {
            $courses->push(Course::factory()->create([
                'category_id'   => $categories->random()->id,
                'level_id'      => $levels->random()->id,
                'instructor_id' => $instructors->random()->id,
                'is_published'  => true,
            ]));
        }

        foreach ($courses as $course) {
            $lessonCount = random_int(5, 12);
            for ($j = 0; $j < $lessonCount; $j++) {
                Lesson::factory()->create([
                    'course_id'    => $course->id,
                    'sort_order'   => $j,
                    'is_published' => $j < $lessonCount - 1 || random_int(0, 1) === 1,
                    'video_url'    => LessonFactory::SAMPLE_VIDEO,
                ]);
            }
        }

        $student = User::firstOrCreate(['email' => 'student@lms.test'], [
            'name'              => 'Test Student',
            'password'          => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        foreach ($courses->take(3) as $course) {
            $student->enrolledCourses()->syncWithoutDetaching([$course->id]);

            $lessons = $course->lessons()
                ->published()
                ->orderBy('sort_order')
                ->take(2)
                ->get();

            foreach ($lessons as $lesson) {
                LessonProgress::updateOrCreate(
                    ['user_id' => $student->id, 'lesson_id' => $lesson->id],
                    ['completed_at' => now()->subDay()]
                );
            }
        }
    }
}
