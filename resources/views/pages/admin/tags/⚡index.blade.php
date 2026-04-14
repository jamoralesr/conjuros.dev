<?php

use App\Models\Tag;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.admin')] #[Title('Tags — Admin')] class extends Component {
    public ?int $editingId = null;

    public string $name = '';

    public string $slug = '';

    public function edit(int $id): void
    {
        $tag = Tag::findOrFail($id);
        $this->editingId = $tag->id;
        $this->name = $tag->name;
        $this->slug = $tag->slug;
    }

    public function cancel(): void
    {
        $this->reset(['editingId', 'name', 'slug']);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash'],
        ]);

        if ($this->editingId) {
            Tag::findOrFail($this->editingId)->update($validated);
        } else {
            Tag::create($validated);
        }

        $this->reset(['editingId', 'name', 'slug']);
        Flux::toast(variant: 'success', text: 'Tag guardado.');
    }

    public function delete(int $id): void
    {
        Tag::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Tag eliminado.');
    }

    public function updatedName(): void
    {
        if (! $this->editingId) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function with(): array
    {
        return ['tags' => Tag::orderBy('name')->get()];
    }
}; ?>

<div>
    <header class="border-b border-zinc-200 px-8 py-10 dark:border-zinc-800">
        <div class="label-mono text-zinc-500">TAG · Taxonomía</div>
        <h1 class="mt-3 text-3xl font-bold tracking-tight md:text-4xl">Tags</h1>
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Etiquetas libres para cruzar contenido sin jerarquía.</p>
    </header>

    <div class="px-8 pb-10 pt-8">
        <div class="grid gap-6 lg:grid-cols-2">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Nombre</flux:table.column>
                <flux:table.column>Slug</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @forelse ($tags as $tag)
                    <flux:table.row :key="$tag->id">
                        <flux:table.cell>{{ $tag->name }}</flux:table.cell>
                        <flux:table.cell class="font-mono text-xs">{{ $tag->slug }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:button size="xs" wire:click="edit({{ $tag->id }})">Editar</flux:button>
                                <flux:button size="xs" variant="danger" wire:click="delete({{ $tag->id }})" wire:confirm="¿Eliminar?">Borrar</flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="3" class="text-center text-zinc-500">Sin tags.</flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        <flux:card>
            <flux:heading>{{ $editingId ? 'Editar tag' : 'Nuevo tag' }}</flux:heading>
            <form wire:submit="save" class="mt-4 space-y-4">
                <flux:input wire:model.live.debounce.500ms="name" label="Nombre" required />
                <flux:input wire:model="slug" label="Slug" required />
                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary" size="sm">Guardar</flux:button>
                    @if ($editingId)
                        <flux:button wire:click="cancel" variant="ghost" size="sm">Cancelar</flux:button>
                    @endif
                </div>
            </form>
        </flux:card>
        </div>
    </div>
</div>
