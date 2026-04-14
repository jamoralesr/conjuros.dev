<?php

namespace Database\Factories;

use App\Enums\ContentAccess;
use App\Enums\ResourceType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);
        $type = fake()->randomElement(ResourceType::cases());

        return [
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title).'-'.Str::random(6),
            'type' => $type,
            'body' => $type->hasBody() ? fake()->paragraph() : null,
            'url' => $type->hasUrl() ? fake()->url() : null,
            'description' => fake()->sentence(),
            'model' => $type->supportsModel() ? 'claude-sonnet-4-5' : null,
            'access' => ContentAccess::Free,
        ];
    }
}
