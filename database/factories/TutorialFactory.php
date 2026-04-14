<?php

namespace Database\Factories;

use App\Enums\ContentAccess;
use App\Enums\ContentStatus;
use App\Models\Category;
use App\Models\Tutorial;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tutorial>
 */
class TutorialFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title).'-'.Str::random(6),
            'excerpt' => fake()->sentence(15),
            'body' => '<p>'.implode('</p><p>', fake()->paragraphs(8)).'</p>',
            'access' => ContentAccess::Free,
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

    public function pro(): static
    {
        return $this->state(fn () => ['access' => ContentAccess::Pro]);
    }
}
