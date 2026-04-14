@props(['publishedAt' => null, 'stack' => 'Laravel 13 / Claude Sonnet 4.6'])

@php
    $formatted = $publishedAt
        ? \Carbon\Carbon::parse($publishedAt)->locale('es')->translatedFormat('F Y')
        : now()->locale('es')->translatedFormat('F Y');
@endphp

<div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900 dark:border-amber-900 dark:bg-amber-950/50 dark:text-amber-200">
    <em>Escrito con {{ $stack }} — {{ $formatted }}. Puede haber cambios en versiones posteriores.</em>
</div>
