@php
    $user = auth()->user();
    $hasAccess = $user && $user->isPro();
@endphp

<x-layouts::front>
    @push('meta')
        <meta name="description" content="{{ $course->description }}">
        <link rel="canonical" href="{{ route('front.courses.show', $course) }}">
    @endpush

    <div class="mx-auto max-w-3xl py-6">
        <flux:badge color="amber">Pro</flux:badge>
        <flux:heading size="xl" class="mt-2 !text-4xl">{{ $course->title }}</flux:heading>
        <flux:text class="mt-3 text-lg">{{ $course->description }}</flux:text>

        @if ($course->github_url)
            <div class="mt-4">
                <flux:button :href="$course->github_url" target="_blank" icon="code-bracket" variant="ghost" size="sm">Repositorio del curso</flux:button>
            </div>
        @endif

        <section class="mt-10">
            <flux:heading size="lg">Lecciones</flux:heading>
            <div class="mt-4 space-y-2">
                @forelse ($course->lessons as $lesson)
                    <div class="flex items-center justify-between rounded-lg border border-zinc-200 px-4 py-3 dark:border-zinc-800">
                        <div>
                            <flux:text class="text-xs text-zinc-500">Lección {{ $lesson->order }}</flux:text>
                            <flux:heading size="sm" class="mt-1">{{ $lesson->title }}</flux:heading>
                        </div>
                        @if ($hasAccess)
                            <flux:button :href="route('front.courses.lesson', [$course, $lesson])" size="sm" wire:navigate>Leer</flux:button>
                        @else
                            <flux:icon.lock-closed class="size-5 text-zinc-400" />
                        @endif
                    </div>
                @empty
                    <flux:text class="text-zinc-500">Este curso aún no tiene lecciones publicadas.</flux:text>
                @endforelse
            </div>
        </section>

        @unless ($hasAccess)
            <x-paywall-gate message="Suscríbete para acceder a todas las lecciones del curso." />
        @endunless
    </div>
</x-layouts::front>
