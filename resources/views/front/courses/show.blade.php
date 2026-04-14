@php
    $user = auth()->user();
    $hasAccess = $user && $user->isPro();
    $courseId = 'COU-'.str_pad((string) $course->id, 3, '0', STR_PAD_LEFT);
@endphp

<x-layouts::front>
    @push('meta')
        <meta name="description" content="{{ $course->description }}">
        <link rel="canonical" href="{{ route('front.courses.show', $course) }}">
    @endpush

    <article class="mx-auto max-w-3xl py-12">
        <div class="label-mono flex items-center gap-3 text-zinc-500">
            <span>{{ $courseId }}</span>
            <span class="text-zinc-300 dark:text-zinc-700">·</span>
            <span class="text-zinc-900 dark:text-zinc-100">Curso</span>
            <span class="text-zinc-300 dark:text-zinc-700">·</span>
            <span class="flex items-center gap-1 text-amber-600 dark:text-amber-400">
                <span class="size-1 rounded-full bg-amber-500"></span> Pro
            </span>
        </div>

        <h1 class="mt-6 text-4xl font-bold leading-[1.05] tracking-tight text-zinc-900 md:text-5xl dark:text-zinc-100">
            {{ $course->title }}
        </h1>
        <p class="mt-5 text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $course->description }}</p>

        @if ($course->github_url)
            <div class="mt-6">
                <a href="{{ $course->github_url }}" target="_blank" class="label-mono text-zinc-600 underline decoration-zinc-400 underline-offset-4 hover:text-zinc-900 hover:decoration-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                    Repositorio del curso →
                </a>
            </div>
        @endif

        <section class="mt-12 border-t border-zinc-200 pt-10 dark:border-zinc-800">
            <div class="label-mono text-zinc-500">Índice</div>
            <h2 class="mt-2 text-2xl font-bold tracking-tight">Lecciones</h2>

            <div class="mt-6 divide-y divide-zinc-200 border-y border-zinc-200 dark:divide-zinc-800 dark:border-zinc-800">
                @forelse ($course->lessons as $lesson)
                    <div class="flex items-center justify-between gap-4 py-4">
                        <div class="flex items-start gap-5">
                            <span class="label-mono mt-1 text-zinc-400 dark:text-zinc-600">
                                {{ str_pad((string) $lesson->order, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <div>
                                <h3 class="text-base font-semibold tracking-tight text-zinc-900 dark:text-zinc-100">{{ $lesson->title }}</h3>
                            </div>
                        </div>
                        @if ($hasAccess)
                            <a href="{{ route('front.courses.lesson', [$course, $lesson]) }}" wire:navigate class="label-mono text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                                Leer →
                            </a>
                        @else
                            <flux:icon.lock-closed class="size-4 text-zinc-400" />
                        @endif
                    </div>
                @empty
                    <p class="py-6 label-mono text-zinc-500">Este curso aún no tiene lecciones publicadas.</p>
                @endforelse
            </div>
        </section>

        @unless ($hasAccess)
            <x-paywall-gate message="Suscríbete para acceder a todas las lecciones del curso." />
        @endunless
    </article>
</x-layouts::front>
