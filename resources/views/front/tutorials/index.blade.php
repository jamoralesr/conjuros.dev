<x-layouts::front>
    <x-page-header
        number="Sección 02"
        eyebrow="Laboratorios"
        title="Tutoriales"
        subtitle="Un problema, una solución, un repositorio real en GitHub."
    />

    <section class="py-10">
        <div class="grid gap-0 md:grid-cols-2 lg:grid-cols-3 md:[&>*]:border-l md:[&>*]:-ml-px md:[&>*:first-child]:ml-0 lg:[&>*:nth-child(3n+1)]:ml-0 md:[&>*]:border-t md:[&>*:first-child]:border-t md:[&>*]:-mt-px">
            @forelse ($tutorials as $tutorial)
                <x-content-card
                    :href="route('front.tutorials.show', $tutorial)"
                    :id="'TUT-'.str_pad((string) $tutorial->id, 3, '0', STR_PAD_LEFT)"
                    :category="$tutorial->category?->name ?? 'Tutorial'"
                    :pro="$tutorial->access->value === 'pro'"
                    :title="$tutorial->title"
                    :excerpt="$tutorial->excerpt"
                    :meta="$tutorial->published_at?->format('d M Y')"
                />
            @empty
                <p class="col-span-full border border-dashed border-zinc-200 p-10 text-center label-mono text-zinc-500 dark:border-zinc-800">
                    Aún no hay tutoriales publicados.
                </p>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $tutorials->links() }}
        </div>
    </section>
</x-layouts::front>
