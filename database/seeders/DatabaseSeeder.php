<?php

namespace Database\Seeders;

use App\Enums\AuthorType;
use App\Enums\UserRole;
use App\Models\Author;
use App\Models\Category;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'dumbo@sietepm.com'],
            [
                'name' => 'Dumbo',
                'password' => Hash::make('password'),
                'role' => UserRole::Admin,
                'email_verified_at' => now(),
            ],
        );

        Plan::firstOrCreate(
            ['slug' => 'standard'],
            [
                'name' => 'Estándar',
                'price_monthly' => 8.00,
                'price_yearly' => 80.00,
                'stripe_price_id_monthly' => config('services.stripe.prices.standard_monthly'),
                'stripe_price_id_yearly' => config('services.stripe.prices.standard_yearly'),
            ],
        );

        $categories = [
            'IA' => 'ia',
            'Laravel' => 'laravel',
            'Vibe coding' => 'vibe-coding',
            'Infraestructura' => 'infraestructura',
        ];

        foreach ($categories as $name => $slug) {
            Category::firstOrCreate(['slug' => $slug], ['name' => $name]);
        }

        Author::firstOrCreate(
            ['slug' => 'dumbo'],
            [
                'name' => 'Dumbo',
                'bio' => 'Fundador de Siete PM y Conjuros.dev.',
                'type' => AuthorType::Human,
                'user_id' => $admin->id,
            ],
        );

        Author::firstOrCreate(
            ['slug' => 'claude'],
            [
                'name' => 'Claude',
                'bio' => 'Co-autor de IA (Anthropic).',
                'type' => AuthorType::Ai,
                'user_id' => null,
            ],
        );
    }
}
