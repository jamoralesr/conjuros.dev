<?php

use App\Models\Resource;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] #[Title('Recursos — Admin')] class extends Component {
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'type')]
    public string $typeFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedTypeFilter(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Resource::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Recurso eliminado.');
    }

    public function with(): array
    {
        return [
            'resources' => Resource::query()
                ->when($this->search, fn ($q) => $q->where('title', 'ilike', "%{$this->search}%"))
                ->when($this->typeFilter, fn ($q) => $q->where('type', $this->typeFilter))
                ->latest()
                ->paginate(15),
            'types' => \App\Enums\ResourceType::cases(),
        ];
    }
}; ?>

<div>
    <header class="flex items-end justify-between gap-6 border-b border-zinc-200 px-8 py-10 dark:border-zinc-800">
        <div>
            <div class="label-mono text-zinc-500">RES · Biblioteca</div>
            <h1 class="mt-3 text-3xl font-bold tracking-tight md:text-4xl">Recursos</h1>
            <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Prompts, skills, commands, hooks, agents, snippets, links, tools, docs.</p>
        </div>
        <flux:button :href="route('admin.resources.create')" icon="plus" variant="primary" wire:navigate>Nuevo</flux:button>
    </header>

    <div class="px-8 pb-10 pt-8">
        <div class="flex gap-3">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar…" icon="magnifying-glass" class="max-w-sm" />
            <flux:select wire:model.live="typeFilter" class="max-w-xs">
                <flux:select.option value="">Todos los tipos</flux:select.option>
                @foreach ($types as $type)
                    <flux:select.option :value="$type->value">{{ $type->label() }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <flux:table :paginate="$resources" class="mt-6">
        <flux:table.columns>
            <flux:table.column>Título</flux:table.column>
            <flux:table.column>Tipo</flux:table.column>
            <flux:table.column>Modelo</flux:table.column>
            <flux:table.column>Acceso</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($resources as $resource)
                <flux:table.row :key="$resource->id">
                    <flux:table.cell>{{ $resource->title }}</flux:table.cell>
                    <flux:table.cell>{{ $resource->type->label() }}</flux:table.cell>
                    <flux:table.cell>{{ $resource->model ?? '—' }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$resource->access->value === 'pro' ? 'amber' : 'zinc'">{{ $resource->access->label() }}</flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="flex gap-2">
                            <flux:button size="xs" :href="route('admin.resources.edit', $resource)" wire:navigate>Editar</flux:button>
                            <flux:button size="xs" variant="danger" wire:click="delete({{ $resource->id }})" wire:confirm="¿Eliminar?">Borrar</flux:button>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center text-zinc-500">Sin recursos todavía.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
    </div>
</div>
