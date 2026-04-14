<?php

namespace Database\Factories;

use App\Enums\AuthorType;
use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.Str::random(4),
            'bio' => fake()->sentence(),
            'avatar' => null,
            'type' => AuthorType::Human,
            'user_id' => null,
        ];
    }

    public function ai(): static
    {
        return $this->state(fn () => [
            'type' => AuthorType::Ai,
            'user_id' => null,
        ]);
    }
}
