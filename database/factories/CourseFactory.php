<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Level;
use App\Models\Category;
use App\Models\Instructor;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'title'             => rtrim($title, '.'),
            'slug'              => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 999999),
            'short_description' => fake()->text(160),
            'description'       => fake()->paragraphs(4, true),
            'rating'            => fake()->randomFloat(2, 3, 5),
            'is_featured'       => fake()->boolean(30),
            'is_published'      => true,
            'target_audience'   => fake()->randomElement(['Developers', 'Designers', 'Managers', 'Students', 'Hobbyists']),
            'thumbnail_url'     => "https://placehold.co/600x400?text={$title}",
            'cover_image_url'   => "https://placehold.co/1200x400?text={$title}",
            'category_id'       => Category::factory(),
            'level_id'          => Level::factory(),
            'instructor_id'     => Instructor::factory(),
        ];
    }

    /**
     * Indicate that the course is unpublished.
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
