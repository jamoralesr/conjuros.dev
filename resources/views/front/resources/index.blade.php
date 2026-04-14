<x-layouts::front>
    <x-page-header
        number="Sección 04"
        eyebrow="Biblioteca"
        title="Recursos"
        subtitle="Prompts, skills, comandos, agentes, snippets, enlaces curados."
    />

    <section class="py-10">
        <div class="mb-8 flex flex-wrap items-center gap-2 border-b border-zinc-200 pb-6 dark:border-zinc-800">
            <span class="label-mono mr-2 text-zinc-500">Filtrar</span>
            <a href="{{ route('front.resources.index') }}" wire:navigate
               @class([
                   'label-mono border px-3 py-1.5 transition',
                   'border-zinc-900 bg-zinc-900 text-white dark:border-zinc-100 dark:bg-zinc-100 dark:text-zinc-900' => $currentType === '',
                   'border-zinc-200 text-zinc-600 hover:border-zinc-900 hover:text-zinc-900 dark:border-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-100 dark:hover:text-zinc-100' => $currentType !== '',
               ])>
                Todos
            </a>
            @foreach ($types as $type)
                <a href="{{ route('front.resources.index', ['type' => $type->value]) }}" wire:navigate
                   @class([
                       'label-mono border px-3 py-1.5 transition',
                       'border-zinc-900 bg-zinc-900 text-white dark:border-zinc-100 dark:bg-zinc-100 dark:text-zinc-900' => $currentType === $type->value,
                       'border-zinc-200 text-zinc-600 hover:border-zinc-900 hover:text-zinc-900 dark:border-zinc-800 dark:text-zinc-400 dark:hover:border-zinc-100 dark:hover:text-zinc-100' => $currentType !== $type->value,
                   ])>
                    {{ $type->label() }}
                </a>
            @endforeach
        </div>

        <div class="grid gap-0 md:grid-cols-2 lg:grid-cols-3 md:[&>*]:border-l md:[&>*]:-ml-px md:[&>*:first-child]:ml-0 lg:[&>*:nth-child(3n+1)]:ml-0 md:[&>*]:border-t md:[&>*:first-child]:border-t md:[&>*]:-mt-px">
            @forelse ($resources as $resource)
                <x-content-card
                    :href="route('front.resources.show', $resource)"
                    :id="'RES-'.str_pad((string) $resource->id, 3, '0', STR_PAD_LEFT)"
                    :category="$resource->type->label()"
                    :title="$resource->title"
                    :excerpt="$resource->description"
                />
            @empty
                <p class="col-span-full border border-dashed border-zinc-200 p-10 text-center label-mono text-zinc-500 dark:border-zinc-800">
                    Aún no hay recursos en esta categoría.
                </p>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $resources->links() }}
        </div>
    </section>
</x-layouts::front>
