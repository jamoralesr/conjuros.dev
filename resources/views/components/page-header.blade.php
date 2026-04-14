@props([
    'eyebrow' => null,
    'number' => null,
    'title',
    'subtitle' => null,
    'hero' => false,
])

<header {{ $attributes->class([
    'relative',
    'bg-dot-grid -mx-6 px-6 pb-16 pt-20 border-b border-zinc-200 dark:border-zinc-800' => $hero,
    'py-10 border-b border-zinc-200 dark:border-zinc-800' => ! $hero,
]) }}>
    <div @class(['mx-auto w-full', 'max-w-5xl' => $hero])>
        @if ($eyebrow || $number)
            <div class="flex items-center gap-3 label-mono text-zinc-500">
                @if ($number)
                    <span class="text-zinc-400 dark:text-zinc-600">{{ $number }}</span>
                @endif
                @if ($eyebrow)
                    <span class="text-zinc-900 dark:text-zinc-100">{{ $eyebrow }}</span>
                @endif
            </div>
        @endif

        <h1 @class([
            'mt-4 font-bold text-zinc-900 dark:text-zinc-100',
            'text-5xl md:text-7xl tracking-[-0.03em] leading-[0.95]' => $hero,
            'text-4xl md:text-5xl tracking-tight leading-[1.05]' => ! $hero,
        ])>
            {{ $title }}
        </h1>

        @if ($subtitle)
            <p @class([
                'mt-5 max-w-2xl text-zinc-600 dark:text-zinc-400 leading-relaxed',
                'text-lg md:text-xl' => $hero,
                'text-base' => ! $hero,
            ])>
                {{ $subtitle }}
            </p>
        @endif

        @isset ($actions)
            <div class="mt-8 flex flex-wrap items-center gap-3">
                {{ $actions }}
            </div>
        @endisset
    </div>
</header>
