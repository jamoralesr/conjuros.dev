@props([
    'title',
    'description',
    'eyebrow' => null,
])

<div class="flex w-full flex-col">
    <div class="label-mono text-zinc-500">
        {{ $eyebrow ?? 'Acceso' }}
    </div>
    <h1 class="mt-3 text-2xl font-bold tracking-tight text-zinc-900 md:text-3xl dark:text-zinc-100">
        {{ $title }}
    </h1>
    <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
        {{ $description }}
    </p>
</div>
