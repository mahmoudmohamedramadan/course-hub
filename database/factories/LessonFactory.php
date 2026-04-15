<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Lesson::class;

    /**
     * The sample video URL.
     *
     * @var string
     */
    public const SAMPLE_VIDEO = 'https://youtu.be/tznw7lTblbY?si=QTewoxEnLPteAPId';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'title'                  => rtrim($title, '.'),
            'slug'                   => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 999999),
            'learnings'              => fake()->paragraph(),
            'video_duration_seconds' => fake()->numberBetween(120, 3600),
            'is_published'           => true,
            'video_url'              => self::SAMPLE_VIDEO,
            'sort_order'             => fake()->numberBetween(0, 50),
            'course_id'              => Course::factory(),
        ];
    }

    /**
     * Indicate that the lesson is unpublished.
     *
     * @return static
     */
    public function unpublished()
    {
        return $this->state(fn(array $attributes) => [
            'is_published' => false,
        ]);
    }
}
