<x-layouts::front>
    @push('meta')
        <meta name="description" content="{{ $resource->description }}">
        <link rel="canonical" href="{{ route('front.resources.show', $resource) }}">
    @endpush

    <article class="mx-auto max-w-3xl py-6">
        <flux:text class="text-xs uppercase text-zinc-500">{{ $resource->type->label() }}</flux:text>
        <flux:heading size="xl" class="mt-2 !text-3xl">{{ $resource->title }}</flux:heading>

        @if ($resource->description)
            <flux:text class="mt-3 text-lg">{{ $resource->description }}</flux:text>
        @endif

        @if ($resource->model)
            <div class="mt-2"><flux:badge color="violet">{{ $resource->model }}</flux:badge></div>
        @endif

        @if ($resource->body)
            <div class="mt-8">
                <flux:heading size="sm">Contenido</flux:heading>
                <pre class="mt-2 overflow-x-auto rounded-lg border border-zinc-200 bg-zinc-50 p-4 font-mono text-sm dark:border-zinc-800 dark:bg-zinc-900">{{ $resource->body }}</pre>
            </div>
        @endif

        @if ($resource->url)
            <div class="mt-6">
                <flux:button :href="$resource->url" target="_blank" icon="arrow-top-right-on-square" variant="primary">
                    Ir al recurso
                </flux:button>
            </div>
        @endif
    </article>
</x-layouts::front>
