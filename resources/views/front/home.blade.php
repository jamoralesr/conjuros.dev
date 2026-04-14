<x-layouts::front>
    <x-page-header
        hero
        number="Nº 001"
        eyebrow="Laboratorio · Español"
        title="Aprende a construir con IA, no a pesar de ella."
        subtitle="Tutoriales, cursos y recursos en español para desarrolladores y vibe coders. Cada laboratorio es un proyecto real en GitHub. Cada decisión documentada."
    >
        <x-slot:actions>
            <flux:button :href="route('front.tutorials.index')" variant="primary" wire:navigate>Explorar tutoriales</flux:button>
            <a href="{{ route('front.methodology') }}" wire:navigate class="label-mono text-zinc-600 underline decoration-zinc-400 underline-offset-4 hover:text-zinc-900 hover:decoration-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 dark:hover:decoration-zinc-100">
                Leer la metodología →
            </a>
        </x-slot:actions>
    </x-page-header>

    @if ($latestTutorials->isNotEmpty())
        <section class="py-16">
            <div class="mb-8 flex items-end justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
                <div>
                    <div class="label-mono text-zinc-500">01 — Tutoriales</div>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight md:text-3xl">Últimos tutoriales</h2>
                </div>
                <a href="{{ route('front.tutorials.index') }}" wire:navigate class="label-mono text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100">Ver todos →</a>
            </div>
            <div class="grid gap-0 md:grid-cols-3 md:[&>*]:border-l md:[&>*]:-ml-px md:[&>*:first-child]:ml-0">
                @foreach ($latestTutorials as $index => $tutorial)
                    <x-content-card
                        :href="route('front.tutorials.show', $tutorial)"
                        :id="'TUT-'.str_pad((string) $tutorial->id, 3, '0', STR_PAD_LEFT)"
                        :category="$tutorial->category?->name ?? 'Tutorial'"
                        :pro="$tutorial->access->value === 'pro'"
                        :title="$tutorial->title"
                        :excerpt="$tutorial->excerpt"
                        :meta="$tutorial->published_at?->format('d M Y')"
                    />
                @endforeach
            </div>
        </section>
    @endif

    @if ($latestArticles->isNotEmpty())
        <section class="border-t border-zinc-200 py-16 dark:border-zinc-800">
            <div class="mb-8 flex items-end justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
                <div>
                    <div class="label-mono text-zinc-500">02 — Artículos</div>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight md:text-3xl">Últimos artículos</h2>
                </div>
                <a href="{{ route('front.articles.index') }}" wire:navigate class="label-mono text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100">Ver todos →</a>
            </div>
            <div class="grid gap-0 md:grid-cols-3 md:[&>*]:border-l md:[&>*]:-ml-px md:[&>*:first-child]:ml-0">
                @foreach ($latestArticles as $article)
                    <x-content-card
                        :href="route('front.articles.show', $article)"
                        :id="'ART-'.str_pad((string) $article->id, 3, '0', STR_PAD_LEFT)"
                        :category="$article->category?->name ?? 'Artículo'"
                        :pro="$article->access->value === 'pro'"
                        :title="$article->title"
                        :excerpt="$article->excerpt"
                        :meta="$article->published_at?->format('d M Y')"
                    />
                @endforeach
            </div>
        </section>
    @endif

    @if ($latestCourses->isNotEmpty())
        <section class="border-t border-zinc-200 py-16 dark:border-zinc-800">
            <div class="mb-8 flex items-end justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
                <div>
                    <div class="label-mono text-zinc-500">03 — Cursos</div>
                    <h2 class="mt-2 text-2xl font-bold tracking-tight md:text-3xl">Cursos</h2>
                </div>
                <a href="{{ route('front.courses.index') }}" wire:navigate class="label-mono text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100">Ver todos →</a>
            </div>
            <div class="grid gap-0 md:grid-cols-3 md:[&>*]:border-l md:[&>*]:-ml-px md:[&>*:first-child]:ml-0">
                @foreach ($latestCourses as $course)
                    <x-content-card
                        :href="route('front.courses.show', $course)"
                        :id="'COU-'.str_pad((string) $course->id, 3, '0', STR_PAD_LEFT)"
                        :category="$course->category?->name ?? 'Curso'"
                        :pro="true"
                        :title="$course->title"
                        :excerpt="$course->description"
                    />
                @endforeach
            </div>
        </section>
    @endif

    <section class="-mx-6 mt-16 border-t border-zinc-200 bg-zinc-50 px-6 py-20 dark:border-zinc-800 dark:bg-zinc-900">
        <div class="mx-auto max-w-3xl">
            <div class="label-mono text-zinc-500">Manifiesto</div>
            <h2 class="mt-4 text-3xl font-bold leading-tight tracking-tight md:text-4xl">
                Un proyecto construido con IA, no a pesar de ella.
            </h2>
            <p class="mt-5 max-w-2xl text-base leading-relaxed text-zinc-600 dark:text-zinc-400">
                Todo el contenido de Conjuros.dev se produce en colaboración con Claude.
                No como autocomplete, sino como co-autor: propone estructura, critica decisiones,
                escribe código, hace preguntas incómodas.
            </p>
            <div class="mt-8">
                <flux:button :href="route('front.methodology')" variant="primary" wire:navigate>Conoce la metodología</flux:button>
            </div>
        </div>
    </section>
</x-layouts::front>
