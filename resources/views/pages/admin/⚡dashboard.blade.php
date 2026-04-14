<?php

use App\Models\Article;
use App\Models\Course;
use App\Models\Resource;
use App\Models\Tutorial;
use App\Models\User;
use Laravel\Cashier\Subscription;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.admin')] #[Title('Dashboard — Admin')] class extends Component {
    public function with(): array
    {
        return [
            'counts' => [
                'articles' => Article::count(),
                'tutorials' => Tutorial::count(),
                'courses' => Course::count(),
                'resources' => Resource::count(),
                'users' => User::count(),
                'activeSubscribers' => Subscription::where('stripe_status', 'active')->count(),
            ],
        ];
    }
}; ?>

<div class="px-6 py-10">
    <flux:heading size="xl">Panel de administración</flux:heading>
    <flux:text class="mt-1">Conjuros.dev · contenido y membresías</flux:text>

    <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <flux:card>
            <flux:heading>Artículos</flux:heading>
            <div class="mt-2 text-3xl font-bold">{{ $counts['articles'] }}</div>
        </flux:card>
        <flux:card>
            <flux:heading>Tutoriales</flux:heading>
            <div class="mt-2 text-3xl font-bold">{{ $counts['tutorials'] }}</div>
        </flux:card>
        <flux:card>
            <flux:heading>Cursos</flux:heading>
            <div class="mt-2 text-3xl font-bold">{{ $counts['courses'] }}</div>
        </flux:card>
        <flux:card>
            <flux:heading>Recursos</flux:heading>
            <div class="mt-2 text-3xl font-bold">{{ $counts['resources'] }}</div>
        </flux:card>
        <flux:card>
            <flux:heading>Usuarios</flux:heading>
            <div class="mt-2 text-3xl font-bold">{{ $counts['users'] }}</div>
        </flux:card>
        <flux:card>
            <flux:heading>Suscriptores activos</flux:heading>
            <div class="mt-2 text-3xl font-bold text-primary-500">{{ $counts['activeSubscribers'] }}</div>
        </flux:card>
    </div>
</div>
