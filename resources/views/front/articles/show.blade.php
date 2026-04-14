@php
    use App\Support\ContentGate;
    $user = auth()->user();
    $isPro = $article->access->value === 'pro';
    $hasAccess = ! $isPro || ($user && $user->isPro());
    $body = $hasAccess ? $article->body : ContentGate::preview($article->body);
@endphp

<x-layouts::front>
    @push('meta')
        <meta name="description" content="{{ $article->excerpt }}">
        <link rel="canonical" href="{{ route('front.articles.show', $article) }}">
        <meta property="og:title" content="{{ $article->title }}">
        <meta property="og:description" content="{{ $article->excerpt }}">
        <meta property="og:type" content="article">
    @endpush

    <article class="mx-auto max-w-3xl py-6">
        <div class="mb-4 flex items-center gap-2">
            @if ($isPro)
                <flux:badge color="amber">Pro</flux:badge>
            @endif
            <flux:text class="text-xs uppercase text-zinc-500">{{ $article->category?->name ?? 'Artículo' }}</flux:text>
        </div>

        <flux:heading size="xl" class="!text-4xl">{{ $article->title }}</flux:heading>
        @if ($article->excerpt)
            <flux:text class="mt-3 text-lg">{{ $article->excerpt }}</flux:text>
        @endif

        <div class="mt-4 flex items-center gap-3 text-sm text-zinc-500">
            <span>{{ $article->published_at?->locale('es')->translatedFormat('d \d\e F \d\e Y') }}</span>
            @if ($article->authors->isNotEmpty())
                <span>·</span>
                <span>{{ $article->authors->pluck('name')->join(', ') }}</span>
            @endif
        </div>

        <div class="mt-10">
            <x-content-version-note :publishedAt="$article->published_at" />
        </div>

        <div class="prose prose-zinc mt-6 max-w-none dark:prose-invert">
            {!! $body !!}
        </div>

        @unless ($hasAccess)
            <x-paywall-gate />
        @endunless

        <div class="mt-12 border-t border-zinc-200 pt-6 text-sm text-zinc-500 dark:border-zinc-800">
            <em>Escrito con Claude (Anthropic) — {{ $article->published_at?->locale('es')->translatedFormat('F Y') ?? now()->locale('es')->translatedFormat('F Y') }}</em>
        </div>
    </article>
</x-layouts::front>
