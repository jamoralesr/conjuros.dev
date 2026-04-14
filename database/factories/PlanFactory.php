<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Plan>
 */
class PlanFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'price_monthly' => fake()->randomFloat(2, 5, 20),
            'price_yearly' => fake()->randomFloat(2, 50, 200),
            'stripe_price_id_monthly' => 'price_'.Str::random(14),
            'stripe_price_id_yearly' => 'price_'.Str::random(14),
        ];
    }
}
