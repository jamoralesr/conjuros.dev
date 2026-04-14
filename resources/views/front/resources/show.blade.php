@php
    $resourceId = 'RES-'.str_pad((string) $resource->id, 3, '0', STR_PAD_LEFT);
@endphp

<x-layouts::front>
    @push('meta')
        <meta name="description" content="{{ $resource->description }}">
        <link rel="canonical" href="{{ route('front.resources.show', $resource) }}">
    @endpush

    <article class="mx-auto max-w-3xl py-12">
        <div class="label-mono flex items-center gap-3 text-zinc-500">
            <span>{{ $resourceId }}</span>
            <span class="text-zinc-300 dark:text-zinc-700">·</span>
            <span class="text-zinc-900 dark:text-zinc-100">{{ $resource->type->label() }}</span>
            @if ($resource->model)
                <span class="text-zinc-300 dark:text-zinc-700">·</span>
                <span>{{ $resource->model }}</span>
            @endif
        </div>

        <h1 class="mt-6 text-3xl font-bold leading-[1.1] tracking-tight text-zinc-900 md:text-4xl dark:text-zinc-100">
            {{ $resource->title }}
        </h1>

        @if ($resource->description)
            <p class="mt-5 text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $resource->description }}</p>
        @endif

        @if ($resource->body)
            <div class="mt-10 border-t border-zinc-200 pt-8 dark:border-zinc-800">
                <div class="label-mono text-zinc-500">Contenido</div>
                <pre class="mt-3 overflow-x-auto border border-zinc-200 bg-zinc-50 p-5 font-mono text-sm leading-relaxed text-zinc-800 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-200">{{ $resource->body }}</pre>
            </div>
        @endif

        @if ($resource->url)
            <div class="mt-8">
                <flux:button :href="$resource->url" target="_blank" icon="arrow-top-right-on-square" variant="primary">
                    Ir al recurso
                </flux:button>
            </div>
        @endif
    </article>
</x-layouts::front>
