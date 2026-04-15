<?php

namespace Database\Factories;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Instructor>
 */
class InstructorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = Instructor::class;

        /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();

        return [
            'name'         => $name,
            'title'        => fake()->jobTitle(),
            'bio'          => fake()->paragraphs(2, true),
            'linkedin_url' => 'https://linkedin.com/in/' . fake()->userName(),
            'avatar_url'   => "https://placehold.co/200x200?text={$name}",
        ];
    }
}
