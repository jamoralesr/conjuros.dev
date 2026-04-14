@php
    use App\Support\ContentGate;
    $user = auth()->user();
    $isPro = $article->access->value === 'pro';
    $hasAccess = ! $isPro || ($user && $user->isPro());
    $body = $hasAccess ? $article->body : ContentGate::preview($article->body);
    $articleId = 'ART-'.str_pad((string) $article->id, 3, '0', STR_PAD_LEFT);
@endphp

<x-layouts::front>
    @push('meta')
        <meta name="description" content="{{ $article->excerpt }}">
        <link rel="canonical" href="{{ route('front.articles.show', $article) }}">
        <meta property="og:title" content="{{ $article->title }}">
        <meta property="og:description" content="{{ $article->excerpt }}">
        <meta property="og:type" content="article">
    @endpush

    <article class="mx-auto max-w-3xl py-12">
        <div class="label-mono flex items-center gap-3 text-zinc-500">
            <span>{{ $articleId }}</span>
            <span class="text-zinc-300 dark:text-zinc-700">·</span>
            <span class="text-zinc-900 dark:text-zinc-100">{{ $article->category?->name ?? 'Artículo' }}</span>
            @if ($isPro)
                <span class="text-zinc-300 dark:text-zinc-700">·</span>
                <span class="flex items-center gap-1 text-amber-600 dark:text-amber-400">
                    <span class="size-1 rounded-full bg-amber-500"></span> Pro
                </span>
            @endif
        </div>

        <h1 class="mt-6 text-4xl font-bold leading-[1.05] tracking-tight text-zinc-900 md:text-5xl dark:text-zinc-100">
            {{ $article->title }}
        </h1>

        @if ($article->excerpt)
            <p class="mt-5 text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $article->excerpt }}</p>
        @endif

        <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 label-mono text-zinc-500">
            <span>{{ $article->published_at?->locale('es')->translatedFormat('d · M · Y') }}</span>
            @if ($article->authors->isNotEmpty())
                <span class="text-zinc-300 dark:text-zinc-700">·</span>
                <span>{{ $article->authors->pluck('name')->join(', ') }}</span>
            @endif
        </div>

        <div class="mt-10 border-t border-zinc-200 pt-8 dark:border-zinc-800">
            <x-content-version-note :publishedAt="$article->published_at" />
        </div>

        <div class="prose prose-zinc mt-8 max-w-none dark:prose-invert">
            {!! $body !!}
        </div>

        @unless ($hasAccess)
            <x-paywall-gate />
        @endunless

        <div class="mt-16 border-t border-zinc-200 pt-6 label-mono text-zinc-500 dark:border-zinc-800">
            Escrito con Claude (Anthropic) · {{ $article->published_at?->locale('es')->translatedFormat('F Y') ?? now()->locale('es')->translatedFormat('F Y') }}
        </div>
    </article>
</x-layouts::front>
