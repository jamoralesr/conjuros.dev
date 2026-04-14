<?php

use App\Models\Course;
use App\Models\Lesson;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.admin')] #[Title('Lecciones — Admin')] class extends Component {
    public Course $course;

    public function mount(Course $course): void
    {
        $this->course = $course;
    }

    public function delete(int $id): void
    {
        Lesson::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Lección eliminada.');
    }

    public function with(): array
    {
        return [
            'lessons' => $this->course->lessons()->orderBy('order')->get(),
        ];
    }
}; ?>

<div>
    <header class="flex items-end justify-between gap-6 border-b border-zinc-200 px-8 py-10 dark:border-zinc-800">
        <div>
            <div class="label-mono text-zinc-500">LES · Curso {{ $course->slug }}</div>
            <h1 class="mt-3 text-3xl font-bold tracking-tight md:text-4xl">Lecciones de «{{ $course->title }}»</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Ordenadas por posición en el curso.</p>
        </div>
        <div class="flex gap-2">
            <flux:button :href="route('admin.courses.edit', $course)" variant="ghost" wire:navigate>Volver al curso</flux:button>
            <flux:button :href="route('admin.lessons.create', $course)" icon="plus" variant="primary" wire:navigate>Nueva lección</flux:button>
        </div>
    </header>

    <div class="px-8 pb-10 pt-8">
        <flux:table>
        <flux:table.columns>
            <flux:table.column>#</flux:table.column>
            <flux:table.column>Título</flux:table.column>
            <flux:table.column>Publicada</flux:table.column>
            <flux:table.column>HTML interactivo</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($lessons as $lesson)
                <flux:table.row :key="$lesson->id">
                    <flux:table.cell>{{ $lesson->order }}</flux:table.cell>
                    <flux:table.cell>{{ $lesson->title }}</flux:table.cell>
                    <flux:table.cell>{{ $lesson->published_at?->format('d/m/Y') ?? '—' }}</flux:table.cell>
                    <flux:table.cell class="text-xs text-zinc-500">{{ $lesson->interactive_html_path ? '✓' : '—' }}</flux:table.cell>
                    <flux:table.cell>
                        <div class="flex gap-2">
                            <flux:button size="xs" :href="route('admin.lessons.edit', [$course, $lesson])" wire:navigate>Editar</flux:button>
                            <flux:button size="xs" variant="danger" wire:click="delete({{ $lesson->id }})" wire:confirm="¿Eliminar lección?">Borrar</flux:button>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center text-zinc-500">Sin lecciones todavía.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
    </div>
</div>
