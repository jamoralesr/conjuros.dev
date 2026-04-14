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

new #[Layout('layouts.admin')] #[Title('Dashboard — Admin')] class extends Component
{
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

<div>
    <header class="border-b border-zinc-200 px-8 py-10 dark:border-zinc-800">
        <div class="flex items-center gap-3 label-mono text-zinc-500">
            <span>Nº 001</span>
            <span class="text-zinc-900 dark:text-zinc-100">Panel de control</span>
        </div>
        <h1 class="mt-4 text-3xl font-bold tracking-tight md:text-4xl">Panel de administración</h1>
        <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-400">Conjuros.dev · contenido y membresías</p>
    </header>

    <div class="px-8 py-10">
        @php
            $cards = [
                ['key' => 'ART-001', 'label' => 'Artículos', 'value' => $counts['articles']],
                ['key' => 'TUT-001', 'label' => 'Tutoriales', 'value' => $counts['tutorials']],
                ['key' => 'COU-001', 'label' => 'Cursos', 'value' => $counts['courses']],
                ['key' => 'RES-001', 'label' => 'Recursos', 'value' => $counts['resources']],
                ['key' => 'USR-001', 'label' => 'Usuarios', 'value' => $counts['users']],
                ['key' => 'SUB-001', 'label' => 'Suscriptores activos', 'value' => $counts['activeSubscribers'], 'accent' => true],
            ];
        @endphp

        <div class="grid gap-0 border border-zinc-200 sm:grid-cols-2 lg:grid-cols-3 dark:border-zinc-800">
            @foreach ($cards as $index => $card)
                <div @class([
                    'group relative bg-white p-8 transition hover:bg-zinc-50 dark:bg-zinc-950 dark:hover:bg-zinc-900',
                    'sm:border-l sm:-ml-px' => $index % 2 === 1,
                    'lg:border-l lg:-ml-px' => $index % 3 !== 0,
                    'border-t -mt-px' => $index >= 2,
                    'sm:[&:nth-child(n+3)]:border-t lg:[&:nth-child(n+4)]:border-t lg:[&:nth-child(-n+3)]:border-t-0' => true,
                ])>
                    <div class="flex items-center justify-between label-mono text-zinc-400 dark:text-zinc-600">
                        <span>{{ $card['key'] }}</span>
                        <span>↗</span>
                    </div>
                    <div class="mt-8 text-5xl font-bold tracking-tight @if (! empty($card['accent'])) text-amber-600 dark:text-amber-400 @endif">
                        {{ $card['value'] }}
                    </div>
                    <div class="mt-3 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        {{ $card['label'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
