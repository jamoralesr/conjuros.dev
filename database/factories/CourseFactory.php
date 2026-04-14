<?php

namespace Database\Factories;

use App\Enums\ContentStatus;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title).'-'.Str::random(6),
            'description' => fake()->paragraph(),
            'status' => ContentStatus::Draft,
            'github_url' => fake()->url(),
            'category_id' => Category::factory(),
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => ContentStatus::Published,
            'published_at' => now()->subDay(),
        ]);
    }
}
