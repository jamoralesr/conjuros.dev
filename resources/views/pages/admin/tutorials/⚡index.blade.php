<?php

use App\Models\Tutorial;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] #[Title('Tutoriales — Admin')] class extends Component {
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Tutorial::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Tutorial eliminado.');
    }

    public function with(): array
    {
        return [
            'tutorials' => Tutorial::query()
                ->when($this->search, fn ($q) => $q->where('title', 'ilike', "%{$this->search}%"))
                ->with('category')
                ->latest()
                ->paginate(15),
        ];
    }
}; ?>

<div>
    <header class="flex items-end justify-between gap-6 border-b border-zinc-200 px-8 py-10 dark:border-zinc-800">
        <div>
            <div class="label-mono text-zinc-500">TUT · Laboratorios</div>
            <h1 class="mt-3 text-3xl font-bold tracking-tight md:text-4xl">Tutoriales</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Pieza única con laboratorio y repositorio GitHub.</p>
        </div>
        <flux:button :href="route('admin.tutorials.create')" icon="plus" variant="primary" wire:navigate>Nuevo</flux:button>
    </header>

    <div class="px-8 pb-10 pt-8">
        <div class="max-w-sm">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar…" icon="magnifying-glass" />
        </div>

        <flux:table :paginate="$tutorials" class="mt-6">
        <flux:table.columns>
            <flux:table.column>Título</flux:table.column>
            <flux:table.column>Categoría</flux:table.column>
            <flux:table.column>Acceso</flux:table.column>
            <flux:table.column>Estado</flux:table.column>
            <flux:table.column>GitHub</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($tutorials as $tutorial)
                <flux:table.row :key="$tutorial->id">
                    <flux:table.cell>{{ $tutorial->title }}</flux:table.cell>
                    <flux:table.cell>{{ $tutorial->category?->name ?? '—' }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$tutorial->access->value === 'pro' ? 'amber' : 'zinc'">{{ $tutorial->access->label() }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$tutorial->status->value === 'published' ? 'lime' : 'zinc'">{{ $tutorial->status->label() }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell class="text-xs text-zinc-500">{{ $tutorial->github_url ? '✓' : '—' }}</flux:table.cell>
                    <flux:table.cell>
                        <div class="flex gap-2">
                            <flux:button size="xs" :href="route('admin.tutorials.edit', $tutorial)" wire:navigate>Editar</flux:button>
                            <flux:button size="xs" variant="danger" wire:click="delete({{ $tutorial->id }})" wire:confirm="¿Eliminar?">Borrar</flux:button>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="6" class="text-center text-zinc-500">Sin tutoriales todavía.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
    </div>
</div>
