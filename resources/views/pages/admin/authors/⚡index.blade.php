<?php

use App\Enums\AuthorType;
use App\Models\Author;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.admin')] #[Title('Autores — Admin')] class extends Component {
    public ?int $editingId = null;

    public string $name = '';

    public string $slug = '';

    public string $bio = '';

    public string $type = 'human';

    public function edit(int $id): void
    {
        $author = Author::findOrFail($id);
        $this->editingId = $author->id;
        $this->name = $author->name;
        $this->slug = $author->slug;
        $this->bio = $author->bio ?? '';
        $this->type = $author->type->value;
    }

    public function cancel(): void
    {
        $this->reset(['editingId', 'name', 'slug', 'bio', 'type']);
        $this->type = 'human';
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash'],
            'bio' => ['nullable', 'string'],
            'type' => ['required', 'in:human,ai'],
        ]);

        $data = [
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'bio' => $validated['bio'] ?: null,
            'type' => AuthorType::from($validated['type']),
        ];

        if ($this->editingId) {
            Author::findOrFail($this->editingId)->update($data);
        } else {
            Author::create($data);
        }

        $this->cancel();
        Flux::toast(variant: 'success', text: 'Autor guardado.');
    }

    public function delete(int $id): void
    {
        Author::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Autor eliminado.');
    }

    public function updatedName(): void
    {
        if (! $this->editingId) {
            $this->slug = Str::slug($this->name);
        }
    }

    public function with(): array
    {
        return ['authors' => Author::orderBy('name')->get()];
    }
}; ?>

<div>
    <header class="border-b border-zinc-200 px-8 py-10 dark:border-zinc-800">
        <div class="label-mono text-zinc-500">AUT · Firmas</div>
        <h1 class="mt-3 text-3xl font-bold tracking-tight md:text-4xl">Autores</h1>
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Humanos y modelos de IA que firman el contenido.</p>
    </header>

    <div class="px-8 pb-10 pt-8">
        <div class="grid gap-6 lg:grid-cols-2">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Nombre</flux:table.column>
                <flux:table.column>Tipo</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @forelse ($authors as $author)
                    <flux:table.row :key="$author->id">
                        <flux:table.cell>{{ $author->name }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge :color="$author->type->value === 'ai' ? 'violet' : 'zinc'">{{ $author->type->label() }}</flux:badge>
                        </flux:table.cell>
                        <flux:table.cell>
                            <div class="flex gap-2">
                                <flux:button size="xs" wire:click="edit({{ $author->id }})">Editar</flux:button>
                                <flux:button size="xs" variant="danger" wire:click="delete({{ $author->id }})" wire:confirm="¿Eliminar?">Borrar</flux:button>
                            </div>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="3" class="text-center text-zinc-500">Sin autores.</flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>

        <flux:card>
            <flux:heading>{{ $editingId ? 'Editar autor' : 'Nuevo autor' }}</flux:heading>
            <form wire:submit="save" class="mt-4 space-y-4">
                <flux:input wire:model.live.debounce.500ms="name" label="Nombre" required />
                <flux:input wire:model="slug" label="Slug" required />
                <flux:textarea wire:model="bio" label="Bio" rows="3" />
                <flux:select wire:model="type" label="Tipo">
                    <flux:select.option value="human">Humano</flux:select.option>
                    <flux:select.option value="ai">IA</flux:select.option>
                </flux:select>
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
