<?php

use App\Models\Article;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] #[Title('Artículos — Admin')] class extends Component {
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Article::findOrFail($id)->delete();
        Flux::toast(variant: 'success', text: 'Artículo eliminado.');
    }

    public function with(): array
    {
        return [
            'articles' => Article::query()
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
            <flux:heading size="xl">Artículos</flux:heading>
            <flux:text class="mt-1">Contenido libre o pro, sin laboratorio asociado.</flux:text>
        </div>
        <flux:button :href="route('admin.articles.create')" icon="plus" variant="primary" wire:navigate>Nuevo</flux:button>
    </div>

    <div class="mt-6 max-w-sm">
        <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar por título…" icon="magnifying-glass" />
    </div>

    <flux:table :paginate="$articles" class="mt-6">
        <flux:table.columns>
            <flux:table.column>Título</flux:table.column>
            <flux:table.column>Categoría</flux:table.column>
            <flux:table.column>Acceso</flux:table.column>
            <flux:table.column>Estado</flux:table.column>
            <flux:table.column>Publicado</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @forelse ($articles as $article)
                <flux:table.row :key="$article->id">
                    <flux:table.cell>{{ $article->title }}</flux:table.cell>
                    <flux:table.cell>{{ $article->category?->name ?? '—' }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$article->access->value === 'pro' ? 'amber' : 'zinc'">
                            {{ $article->access->label() }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$article->status->value === 'published' ? 'lime' : 'zinc'">
                            {{ $article->status->label() }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>{{ $article->published_at?->format('d/m/Y') ?? '—' }}</flux:table.cell>
                    <flux:table.cell>
                        <div class="flex gap-2">
                            <flux:button size="xs" :href="route('admin.articles.edit', $article)" wire:navigate>Editar</flux:button>
                            <flux:button size="xs" variant="danger" wire:click="delete({{ $article->id }})" wire:confirm="¿Eliminar este artículo?">Borrar</flux:button>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="6" class="text-center text-zinc-500">Sin artículos todavía.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</div>
