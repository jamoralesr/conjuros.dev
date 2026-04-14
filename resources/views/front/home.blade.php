<x-layouts::front>
    <section class="py-10 text-center">
        <flux:heading size="xl" class="!text-4xl md:!text-6xl">Aprende a construir con IA, no a pesar de ella.</flux:heading>
        <flux:text class="mx-auto mt-6 max-w-2xl text-lg">
            Tutoriales, cursos y recursos en español para desarrolladores y vibe coders.
            Cada laboratorio es un proyecto real en GitHub. Cada decisión documentada.
        </flux:text>
        <div class="mt-8 flex justify-center gap-3">
            <flux:button :href="route('front.tutorials.index')" variant="primary" wire:navigate>Explorar tutoriales</flux:button>
            <flux:button :href="route('front.methodology')" variant="ghost" wire:navigate>Leer la metodología</flux:button>
        </div>
    </section>

    @if ($latestTutorials->isNotEmpty())
        <section class="mt-16">
            <div class="flex items-end justify-between">
                <flux:heading size="lg">Últimos tutoriales</flux:heading>
                <a href="{{ route('front.tutorials.index') }}" wire:navigate class="text-sm text-zinc-500 hover:underline">Ver todos →</a>
            </div>
            <div class="mt-6 grid gap-6 md:grid-cols-3">
                @foreach ($latestTutorials as $tutorial)
                    <a href="{{ route('front.tutorials.show', $tutorial) }}" wire:navigate class="block">
                        <flux:card class="h-full transition hover:border-primary-500">
                            <div class="flex items-center gap-2">
                                @if ($tutorial->access->value === 'pro')
                                    <flux:badge color="amber" size="sm">Pro</flux:badge>
                                @endif
                                <flux:text class="text-xs uppercase text-zinc-500">{{ $tutorial->category?->name ?? 'Tutorial' }}</flux:text>
                            </div>
                            <flux:heading class="mt-2">{{ $tutorial->title }}</flux:heading>
                            <flux:text class="mt-2">{{ $tutorial->excerpt }}</flux:text>
                        </flux:card>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    @if ($latestArticles->isNotEmpty())
        <section class="mt-16">
            <div class="flex items-end justify-between">
                <flux:heading size="lg">Últimos artículos</flux:heading>
                <a href="{{ route('front.articles.index') }}" wire:navigate class="text-sm text-zinc-500 hover:underline">Ver todos →</a>
            </div>
            <div class="mt-6 grid gap-6 md:grid-cols-3">
                @foreach ($latestArticles as $article)
                    <a href="{{ route('front.articles.show', $article) }}" wire:navigate class="block">
                        <flux:card class="h-full transition hover:border-primary-500">
                            <flux:text class="text-xs uppercase text-zinc-500">{{ $article->category?->name ?? 'Artículo' }}</flux:text>
                            <flux:heading class="mt-2">{{ $article->title }}</flux:heading>
                            <flux:text class="mt-2">{{ $article->excerpt }}</flux:text>
                        </flux:card>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    @if ($latestCourses->isNotEmpty())
        <section class="mt-16">
            <div class="flex items-end justify-between">
                <flux:heading size="lg">Cursos</flux:heading>
                <a href="{{ route('front.courses.index') }}" wire:navigate class="text-sm text-zinc-500 hover:underline">Ver todos →</a>
            </div>
            <div class="mt-6 grid gap-6 md:grid-cols-3">
                @foreach ($latestCourses as $course)
                    <a href="{{ route('front.courses.show', $course) }}" wire:navigate class="block">
                        <flux:card class="h-full transition hover:border-primary-500">
                            <flux:badge color="amber" size="sm">Pro</flux:badge>
                            <flux:heading class="mt-2">{{ $course->title }}</flux:heading>
                            <flux:text class="mt-2">{{ $course->description }}</flux:text>
                        </flux:card>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <section class="mt-20 rounded-2xl border border-zinc-200 bg-zinc-50 p-10 text-center dark:border-zinc-800 dark:bg-zinc-900">
        <flux:heading size="lg">Un proyecto construido con IA, no a pesar de ella.</flux:heading>
        <flux:text class="mx-auto mt-3 max-w-xl">
            Todo el contenido de Conjuros.dev se produce en colaboración con Claude.
            No como autocomplete, sino como co-autor.
        </flux:text>
        <flux:button :href="route('front.methodology')" variant="primary" class="mt-6" wire:navigate>Conoce la metodología</flux:button>
    </section>
</x-layouts::front>
