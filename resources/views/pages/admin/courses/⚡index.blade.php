<?php

use App\Models\Course;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] #[Title('Cursos — Admin')] class extends Component {
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Course::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Curso eliminado.');
    }

    public function with(): array
    {
        return [
            'courses' => Course::query()
                ->when($this->search, fn ($q) => $q->where('title', 'ilike', "%{$this->search}%"))
                ->with(['category', 'lessons'])
                ->withCount('lessons')
                ->latest()
                ->paginate(15),
        ];
    }
}; ?>

<div class="px-6 py-10">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Cursos</flux:heading>
            <flux:text class="mt-1">Siempre pro. Lecciones encadenadas con hilo conductor.</flux:text>
        </div>
        <flux:button :href="route('admin.courses.create')" icon="plus" variant="primary" wire:navigate>Nuevo</flux:button>
    </div>

    <div class="mt-6 max-w-sm">
        <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar…" icon="magnifying-glass" />
    </div>

    <flux:table :paginate="$courses" class="mt-6">
        <flux:table.columns>
            <flux:table.column>Título</flux:table.column>
            <flux:table.column>Categoría</flux:table.column>
            <flux:table.column>Lecciones</flux:table.column>
            <flux:table.column>Estado</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($courses as $course)
                <flux:table.row :key="$course->id">
                    <flux:table.cell>{{ $course->title }}</flux:table.cell>
                    <flux:table.cell>{{ $course->category?->name ?? '—' }}</flux:table.cell>
                    <flux:table.cell>{{ $course->lessons_count }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$course->status->value === 'published' ? 'lime' : 'zinc'">{{ $course->status->label() }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="flex gap-2">
                            <flux:button size="xs" :href="route('admin.lessons.index', $course)" wire:navigate>Lecciones</flux:button>
                            <flux:button size="xs" :href="route('admin.courses.edit', $course)" wire:navigate>Editar</flux:button>
                            <flux:button size="xs" variant="danger" wire:click="delete({{ $course->id }})" wire:confirm="¿Eliminar curso y todas sus lecciones?">Borrar</flux:button>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center text-zinc-500">Sin cursos todavía.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>
