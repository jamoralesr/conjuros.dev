<x-layouts::front>
    <div class="py-6">
        <flux:heading size="xl">Cursos</flux:heading>
        <flux:text class="mt-2">Lecciones encadenadas con hilo conductor. Siempre pro.</flux:text>
    </div>

    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($courses as $course)
            <a href="{{ route('front.courses.show', $course) }}" wire:navigate class="block">
                <flux:card class="h-full transition hover:border-primary-500">
                    <div class="flex items-center gap-2">
                        <flux:badge color="amber" size="sm">Pro</flux:badge>
                        <flux:text class="text-xs uppercase text-zinc-500">{{ $course->category?->name ?? 'Curso' }}</flux:text>
                    </div>
                    <flux:heading class="mt-2">{{ $course->title }}</flux:heading>
                    <flux:text class="mt-2">{{ $course->description }}</flux:text>
                    <flux:text class="mt-3 text-xs text-zinc-500">{{ $course->lessons_count }} {{ \Illuminate\Support\Str::plural('lección', $course->lessons_count) }}</flux:text>
                </flux:card>
            </a>
        @empty
            <flux:text class="col-span-full text-center text-zinc-500">Aún no hay cursos publicados.</flux:text>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $courses->links() }}
    </div>
</x-layouts::front>
