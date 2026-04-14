@props([
    'href',
    'id' => null,
    'category' => null,
    'pro' => false,
    'title',
    'excerpt' => null,
    'meta' => null,
])

<a href="{{ $href }}" wire:navigate {{ $attributes->class([
    'group relative block border border-zinc-200 bg-white p-6 transition',
    'hover:border-zinc-900 hover:-translate-y-0.5',
    'dark:border-zinc-800 dark:bg-zinc-950 dark:hover:border-zinc-100',
]) }}>
    <div class="flex items-center justify-between label-mono text-zinc-500">
        <span>
            {{ $category ?? 'Item' }}
            @if ($id)
                <span class="text-zinc-400 dark:text-zinc-600"> · {{ $id }}</span>
            @endif
        </span>
        @if ($pro)
            <span class="flex items-center gap-1 text-amber-600 dark:text-amber-400">
                <span class="size-1 rounded-full bg-amber-500"></span> Pro
            </span>
        @endif
    </div>

    <h3 class="mt-5 text-lg font-semibold leading-tight tracking-tight text-zinc-900 transition group-hover:text-zinc-600 dark:text-zinc-100 dark:group-hover:text-zinc-300">
        {{ $title }}
    </h3>

    @if ($excerpt)
        <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
            {{ $excerpt }}
        </p>
    @endif

    <div class="mt-5 flex items-center justify-between">
        @if ($meta)
            <div class="label-mono text-zinc-500">{{ $meta }}</div>
        @else
            <span></span>
        @endif
        <span class="label-mono text-zinc-400 transition group-hover:translate-x-0.5 group-hover:text-zinc-900 dark:text-zinc-600 dark:group-hover:text-zinc-100">
            Leer →
        </span>
    </div>
</a>
