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

<div class="px-6 py-10">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Tutoriales</flux:heading>
            <flux:text class="mt-1">Pieza única con laboratorio y repositorio GitHub.</flux:text>
        </div>
        <flux:button :href="route('admin.tutorials.create')" icon="plus" variant="primary" wire:navigate>Nuevo</flux:button>
    </div>

    <div class="mt-6 max-w-sm">
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
