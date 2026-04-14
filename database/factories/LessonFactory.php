<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);

        return [
            'course_id' => Course::factory(),
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title).'-'.Str::random(6),
            'body' => '<p>'.implode('</p><p>', fake()->paragraphs(6)).'</p>',
            'order' => fake()->numberBetween(1, 10),
            'interactive_html_path' => null,
            'published_at' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => ['published_at' => now()->subDay()]);
    }
}
