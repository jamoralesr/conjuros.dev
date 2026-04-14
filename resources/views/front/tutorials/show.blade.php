@php
    use App\Support\ContentGate;
    $user = auth()->user();
    $isPro = $tutorial->access->value === 'pro';
    $hasAccess = ! $isPro || ($user && $user->isPro());
    $body = $hasAccess ? $tutorial->body : ContentGate::preview($tutorial->body);
    $tutorialId = 'TUT-'.str_pad((string) $tutorial->id, 3, '0', STR_PAD_LEFT);
@endphp

<x-layouts::front>
    @push('meta')
        <meta name="description" content="{{ $tutorial->excerpt }}">
        <link rel="canonical" href="{{ route('front.tutorials.show', $tutorial) }}">
        <meta property="og:title" content="{{ $tutorial->title }}">
        <meta property="og:description" content="{{ $tutorial->excerpt }}">
        <meta property="og:type" content="article">
    @endpush

    <article class="mx-auto max-w-3xl py-12">
        <div class="label-mono flex items-center gap-3 text-zinc-500">
            <span>{{ $tutorialId }}</span>
            <span class="text-zinc-300 dark:text-zinc-700">·</span>
            <span class="text-zinc-900 dark:text-zinc-100">{{ $tutorial->category?->name ?? 'Tutorial' }}</span>
            @if ($isPro)
                <span class="text-zinc-300 dark:text-zinc-700">·</span>
                <span class="flex items-center gap-1 text-amber-600 dark:text-amber-400">
                    <span class="size-1 rounded-full bg-amber-500"></span> Pro
                </span>
            @endif
        </div>

        <h1 class="mt-6 text-4xl font-bold leading-[1.05] tracking-tight text-zinc-900 md:text-5xl dark:text-zinc-100">
            {{ $tutorial->title }}
        </h1>

        @if ($tutorial->excerpt)
            <p class="mt-5 text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $tutorial->excerpt }}</p>
        @endif

        <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 label-mono text-zinc-500">
            <span>{{ $tutorial->published_at?->locale('es')->translatedFormat('d · M · Y') }}</span>
            @if ($tutorial->github_url)
                <span class="text-zinc-300 dark:text-zinc-700">·</span>
                <a href="{{ $tutorial->github_url }}" target="_blank" class="underline decoration-zinc-400 underline-offset-4 hover:text-zinc-900 hover:decoration-zinc-900 dark:hover:text-zinc-100 dark:hover:decoration-zinc-100">
                    Repositorio en GitHub →
                </a>
            @endif
        </div>

        <div class="mt-10 border-t border-zinc-200 pt-8 dark:border-zinc-800">
            <x-content-version-note :publishedAt="$tutorial->published_at" />
        </div>

        <div class="prose prose-zinc mt-8 max-w-none dark:prose-invert">
            {!! $body !!}
        </div>

        @unless ($hasAccess)
            <x-paywall-gate />
        @endunless

        <div class="mt-16 border-t border-zinc-200 pt-6 label-mono text-zinc-500 dark:border-zinc-800">
            Escrito con Claude (Anthropic) · {{ $tutorial->published_at?->locale('es')->translatedFormat('F Y') ?? now()->locale('es')->translatedFormat('F Y') }}
        </div>
    </article>
</x-layouts::front>
