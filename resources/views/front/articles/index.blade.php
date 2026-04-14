<x-layouts::front>
    <div class="py-6">
        <flux:heading size="xl">Artículos</flux:heading>
        <flux:text class="mt-2">Noticias, tips, reflexiones, opinión.</flux:text>
    </div>

    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($articles as $article)
            <a href="{{ route('front.articles.show', $article) }}" wire:navigate class="block">
                <flux:card class="h-full transition hover:border-primary-500">
                    <div class="flex items-center gap-2">
                        @if ($article->access->value === 'pro')
                            <flux:badge color="amber" size="sm">Pro</flux:badge>
                        @endif
                        <flux:text class="text-xs uppercase text-zinc-500">{{ $article->category?->name ?? 'Artículo' }}</flux:text>
                    </div>
                    <flux:heading class="mt-2">{{ $article->title }}</flux:heading>
                    <flux:text class="mt-2">{{ $article->excerpt }}</flux:text>
                    <flux:text class="mt-3 text-xs text-zinc-500">{{ $article->published_at?->format('d/m/Y') }}</flux:text>
                </flux:card>
            </a>
        @empty
            <flux:text class="col-span-full text-center text-zinc-500">Aún no hay artículos publicados.</flux:text>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $articles->links() }}
    </div>
</x-layouts::front>
