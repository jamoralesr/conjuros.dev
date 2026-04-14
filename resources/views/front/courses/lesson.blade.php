@php
    use App\Support\ContentGate;
    $user = auth()->user();
    $hasAccess = $user && $user->isPro();
    $body = $hasAccess ? $lesson->body : ContentGate::preview($lesson->body, 800);
@endphp

<x-layouts::front>
    @push('meta')
        <link rel="canonical" href="{{ route('front.courses.lesson', [$course, $lesson]) }}">
    @endpush

    <div class="mx-auto max-w-3xl py-6">
        <a href="{{ route('front.courses.show', $course) }}" wire:navigate class="text-sm text-zinc-500 hover:underline">← {{ $course->title }}</a>

        <flux:text class="mt-6 text-xs uppercase text-zinc-500">Lección {{ $lesson->order }}</flux:text>
        <flux:heading size="xl" class="mt-1 !text-4xl">{{ $lesson->title }}</flux:heading>

        <div class="mt-8">
            <x-content-version-note :publishedAt="$lesson->published_at" />
        </div>

        <div class="prose prose-zinc mt-6 max-w-none dark:prose-invert">
            {!! $body !!}
        </div>

        @if ($hasAccess && $lesson->interactive_html_path)
            <div class="mt-10">
                <flux:heading size="lg">Recurso interactivo</flux:heading>
                <iframe src="{{ $lesson->interactive_html_path }}" class="mt-4 h-[600px] w-full rounded-lg border border-zinc-200 dark:border-zinc-800"></iframe>
            </div>
        @endif

        @unless ($hasAccess)
            <x-paywall-gate message="Suscríbete para leer esta lección completa." />
        @endunless

        <div class="mt-12 border-t border-zinc-200 pt-6 text-sm text-zinc-500 dark:border-zinc-800">
            <em>Escrito con Claude (Anthropic) — {{ $lesson->published_at?->locale('es')->translatedFormat('F Y') ?? now()->locale('es')->translatedFormat('F Y') }}</em>
        </div>
    </div>
</x-layouts::front>
