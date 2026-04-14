<?php

use App\Enums\ContentAccess;
use App\Enums\ContentStatus;
use App\Models\Author;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Tutorial;
use Flux\Flux;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.admin')] #[Title('Tutorial — Admin')] class extends Component {
    public ?Tutorial $tutorial = null;

    public string $title = '';

    public string $slug = '';

    public string $excerpt = '';

    public string $body = '';

    public string $github_url = '';

    public string $access = 'free';

    public string $status = 'draft';

    public ?int $category_id = null;

    public array $selectedTags = [];

    public array $selectedAuthors = [];

    public bool $publishNow = false;

    public function mount(?Tutorial $tutorial = null): void
    {
        if ($tutorial && $tutorial->exists) {
            $this->tutorial = $tutorial;
            $this->title = $tutorial->title;
            $this->slug = $tutorial->slug;
            $this->excerpt = $tutorial->excerpt ?? '';
            $this->body = $tutorial->body ?? '';
            $this->github_url = $tutorial->github_url ?? '';
            $this->access = $tutorial->access->value;
            $this->status = $tutorial->status->value;
            $this->category_id = $tutorial->category_id;
            $this->selectedTags = $tutorial->tags()->pluck('tags.id')->map(fn ($id) => (string) $id)->toArray();
            $this->selectedAuthors = $tutorial->authors()->pluck('authors.id')->map(fn ($id) => (string) $id)->toArray();
        }
    }

    public function updatedTitle(): void
    {
        if (! $this->tutorial) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function save(): RedirectResponse
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'github_url' => ['nullable', 'url'],
            'access' => ['required', 'in:free,pro'],
            'status' => ['required', 'in:draft,published'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'excerpt' => $validated['excerpt'] ?: null,
            'body' => $validated['body'] ?: null,
            'github_url' => $validated['github_url'] ?: null,
            'access' => ContentAccess::from($validated['access']),
            'status' => $this->publishNow ? ContentStatus::Published : ContentStatus::from($validated['status']),
            'category_id' => $validated['category_id'],
            'published_at' => $this->publishNow || $validated['status'] === 'published'
                ? ($this->tutorial?->published_at ?? now())
                : null,
        ];

        if ($this->tutorial) {
            $this->tutorial->update($data);
        } else {
            $this->tutorial = Tutorial::create($data);
        }

        $this->tutorial->tags()->sync(array_map('intval', $this->selectedTags));
        $this->tutorial->authors()->sync(array_map('intval', $this->selectedAuthors));

        Flux::toast(variant: 'success', text: 'Tutorial guardado.');

        return redirect()->route('admin.tutorials.edit', $this->tutorial);
    }

    public function with(): array
    {
        return [
            'categories' => Category::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'authors' => Author::orderBy('name')->get(),
        ];
    }
}; ?>

<div class="px-6 py-10">
    <flux:heading size="xl">{{ $tutorial ? 'Editar tutorial' : 'Nuevo tutorial' }}</flux:heading>

    <form wire:submit="save" class="mt-6 max-w-3xl space-y-6">
        <flux:input wire:model.live.debounce.500ms="title" label="Título" required />
        <flux:input wire:model="slug" label="Slug" required />
        <flux:input wire:model="github_url" label="Repositorio GitHub" type="url" placeholder="https://github.com/..." />
        <flux:textarea wire:model="excerpt" label="Resumen" rows="3" />

        <flux:editor wire:model="body" label="Cuerpo" description="Escribe el tutorial paso a paso." />

        <div class="grid gap-4 md:grid-cols-2">
            <flux:select wire:model="access" label="Acceso">
                <flux:select.option value="free">Libre</flux:select.option>
                <flux:select.option value="pro">Pro</flux:select.option>
            </flux:select>
            <flux:select wire:model="status" label="Estado">
                <flux:select.option value="draft">Borrador</flux:select.option>
                <flux:select.option value="published">Publicado</flux:select.option>
            </flux:select>
            <flux:select wire:model="category_id" label="Categoría">
                <flux:select.option value="">— Sin categoría —</flux:select.option>
                @foreach ($categories as $category)
                    <flux:select.option :value="$category->id">{{ $category->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="selectedTags" label="Tags" multiple>
                @foreach ($tags as $tag)
                    <flux:select.option :value="(string) $tag->id">{{ $tag->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="selectedAuthors" label="Autores" multiple>
                @foreach ($authors as $author)
                    <flux:select.option :value="(string) $author->id">{{ $author->name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:checkbox wire:model="publishNow" label="Publicar ahora" />
        </div>

        <div class="flex items-center gap-3">
            <flux:button type="submit" variant="primary">Guardar</flux:button>
            <flux:button :href="route('admin.tutorials.index')" variant="ghost" wire:navigate>Cancelar</flux:button>
        </div>
    </form>
</div>
