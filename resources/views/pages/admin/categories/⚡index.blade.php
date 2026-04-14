<?php

use App\Models\Category;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.admin')] #[Title('Categorías — Admin')] class extends Component {
    public ?int $editingId = null;

    public string $name = '';

    public string $slug = '';

    public function edit(int $id): void
    {
        $cat = Category::findOrFail($id);
        $this->editingId = $cat->id;
        $this->name = $cat->name;
        $this->slug = $cat->slug;
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
            $cat = Category::findOrFail($this->editingId);
            $cat->update($validated);
        } else {
            Category::create($validated);
        }

        $this->reset(['editingId', 'name', 'slug']);
        Flux::toast(variant: 'success', text: 'Categoría guardada.');
    }

    public function delete(int $id): void
    {
        Category::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Categoría eliminada.');
    }

    public function updatedName(): void
    {
        if (! $this->editingId) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function with(): array
    {
        return [
            'categories' => Category::withCount(['articles', 'tutorials', 'courses'])->orderBy('name')->get(),
        ];
    }
}; ?>

<div class="px-6 py-10">
    <flux:heading size="xl">Categorías</flux:heading>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div>
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Nombre</flux:table.column>
                    <flux:table.column>Slug</flux:table.column>
                    <flux:table.column>Uso</flux:table.column>
                    <flux:table.column></flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @forelse ($categories as $cat)
                        <flux:table.row :key="$cat->id">
                            <flux:table.cell>{{ $cat->name }}</flux:table.cell>
                            <flux:table.cell class="font-mono text-xs">{{ $cat->slug }}</flux:table.cell>
                            <flux:table.cell class="text-xs text-zinc-500">{{ $cat->articles_count + $cat->tutorials_count + $cat->courses_count }}</flux:table.cell>
                            <flux:table.cell>
                                <div class="flex gap-2">
                                    <flux:button size="xs" wire:click="edit({{ $cat->id }})">Editar</flux:button>
                                    <flux:button size="xs" variant="danger" wire:click="delete({{ $cat->id }})" wire:confirm="¿Eliminar?">Borrar</flux:button>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="4" class="text-center text-zinc-500">Sin categorías.</flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>

        <div>
            <flux:card>
                <flux:heading>{{ $editingId ? 'Editar categoría' : 'Nueva categoría' }}</flux:heading>
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
