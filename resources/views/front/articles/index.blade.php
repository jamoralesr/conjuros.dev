<x-layouts::front>
    <x-page-header
        number="Sección 01"
        eyebrow="Ensayos"
        title="Artículos"
        subtitle="Noticias, tips, reflexiones, opinión."
    />

    <section class="py-10">
        <div class="grid gap-0 md:grid-cols-2 lg:grid-cols-3 md:[&>*]:border-l md:[&>*]:-ml-px md:[&>*:first-child]:ml-0 lg:[&>*:nth-child(3n+1)]:ml-0 md:[&>*]:border-t md:[&>*:first-child]:border-t md:[&>*]:-mt-px">
            @forelse ($articles as $article)
                <x-content-card
                    :href="route('front.articles.show', $article)"
                    :id="'ART-'.str_pad((string) $article->id, 3, '0', STR_PAD_LEFT)"
                    :category="$article->category?->name ?? 'Artículo'"
                    :pro="$article->access->value === 'pro'"
                    :title="$article->title"
                    :excerpt="$article->excerpt"
                    :meta="$article->published_at?->format('d M Y')"
                />
            @empty
                <p class="col-span-full border border-dashed border-zinc-200 p-10 text-center label-mono text-zinc-500 dark:border-zinc-800">
                    Aún no hay artículos publicados.
                </p>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $articles->links() }}
        </div>
    </section>
</x-layouts::front>
