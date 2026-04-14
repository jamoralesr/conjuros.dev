<x-layouts::front>
    <x-page-header
        number="Sección 03"
        eyebrow="Programas guiados"
        title="Cursos"
        subtitle="Lecciones encadenadas con hilo conductor. Siempre pro."
    />

    <section class="py-10">
        <div class="grid gap-0 md:grid-cols-2 lg:grid-cols-3 md:[&>*]:border-l md:[&>*]:-ml-px md:[&>*:first-child]:ml-0 lg:[&>*:nth-child(3n+1)]:ml-0 md:[&>*]:border-t md:[&>*:first-child]:border-t md:[&>*]:-mt-px">
            @forelse ($courses as $course)
                <x-content-card
                    :href="route('front.courses.show', $course)"
                    :id="'COU-'.str_pad((string) $course->id, 3, '0', STR_PAD_LEFT)"
                    :category="$course->category?->name ?? 'Curso'"
                    :pro="true"
                    :title="$course->title"
                    :excerpt="$course->description"
                    :meta="$course->lessons_count.' '.\Illuminate\Support\Str::plural('lección', $course->lessons_count)"
                />
            @empty
                <p class="col-span-full border border-dashed border-zinc-200 p-10 text-center label-mono text-zinc-500 dark:border-zinc-800">
                    Aún no hay cursos publicados.
                </p>
            @endforelse
        </div>

        <div class="mt-12">
            {{ $courses->links() }}
        </div>
    </section>
</x-layouts::front>
