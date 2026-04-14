@php
    use App\Support\ContentGate;
    $user = auth()->user();
    $isPro = $tutorial->access->value === 'pro';
    $hasAccess = ! $isPro || ($user && $user->isPro());
    $body = $hasAccess ? $tutorial->body : ContentGate::preview($tutorial->body);
@endphp

<x-layouts::front>
    @push('meta')
        <meta name="description" content="{{ $tutorial->excerpt }}">
        <link rel="canonical" href="{{ route('front.tutorials.show', $tutorial) }}">
        <meta property="og:title" content="{{ $tutorial->title }}">
        <meta property="og:description" content="{{ $tutorial->excerpt }}">
        <meta property="og:type" content="article">
    @endpush

    <article class="mx-auto max-w-3xl py-6">
        <div class="mb-4 flex items-center gap-2">
            @if ($isPro)
                <flux:badge color="amber">Pro</flux:badge>
            @endif
            <flux:text class="text-xs uppercase text-zinc-500">{{ $tutorial->category?->name ?? 'Tutorial' }}</flux:text>
        </div>

        <flux:heading size="xl" class="!text-4xl">{{ $tutorial->title }}</flux:heading>
        @if ($tutorial->excerpt)
            <flux:text class="mt-3 text-lg">{{ $tutorial->excerpt }}</flux:text>
        @endif

        @if ($tutorial->github_url)
            <div class="mt-4">
                <flux:button :href="$tutorial->github_url" target="_blank" icon="code-bracket" variant="ghost" size="sm">
                    Ver repositorio en GitHub
                </flux:button>
            </div>
        @endif

        <div class="mt-8">
            <x-content-version-note :publishedAt="$tutorial->published_at" />
        </div>

        <div class="prose prose-zinc mt-6 max-w-none dark:prose-invert">
            {!! $body !!}
        </div>

        @unless ($hasAccess)
            <x-paywall-gate />
        @endunless

        <div class="mt-12 border-t border-zinc-200 pt-6 text-sm text-zinc-500 dark:border-zinc-800">
            <em>Escrito con Claude (Anthropic) — {{ $tutorial->published_at?->locale('es')->translatedFormat('F Y') ?? now()->locale('es')->translatedFormat('F Y') }}</em>
        </div>
    </article>
</x-layouts::front>
