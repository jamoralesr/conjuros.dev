<?php

use App\Enums\ContentStatus;
use App\Models\Author;
use App\Models\Category;
use App\Models\Course;
use App\Models\Tag;
use Flux\Flux;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.admin')] #[Title('Curso — Admin')] class extends Component {
    public ?Course $course = null;

    public string $title = '';

    public string $slug = '';

    public string $description = '';

    public string $github_url = '';

    public string $status = 'draft';

    public ?int $category_id = null;

    public array $selectedTags = [];

    public array $selectedAuthors = [];

    public bool $publishNow = false;

    public function mount(?Course $course = null): void
    {
        if ($course && $course->exists) {
            $this->course = $course;
            $this->title = $course->title;
            $this->slug = $course->slug;
            $this->description = $course->description ?? '';
            $this->github_url = $course->github_url ?? '';
            $this->status = $course->status->value;
            $this->category_id = $course->category_id;
            $this->selectedTags = $course->tags()->pluck('tags.id')->map(fn ($id) => (string) $id)->toArray();
            $this->selectedAuthors = $course->authors()->pluck('authors.id')->map(fn ($id) => (string) $id)->toArray();
        }
    }

    public function updatedTitle(): void
    {
        if (! $this->course) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function save(): RedirectResponse
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash'],
            'description' => ['nullable', 'string'],
            'github_url' => ['nullable', 'url'],
            'status' => ['required', 'in:draft,published'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?: null,
            'github_url' => $validated['github_url'] ?: null,
            'status' => $this->publishNow ? ContentStatus::Published : ContentStatus::from($validated['status']),
            'category_id' => $validated['category_id'],
            'published_at' => $this->publishNow || $validated['status'] === 'published'
                ? ($this->course?->published_at ?? now())
                : null,
        ];

        if ($this->course) {
            $this->course->update($data);
        } else {
            $this->course = Course::create($data);
        }

        $this->course->tags()->sync(array_map('intval', $this->selectedTags));
        $this->course->authors()->sync(array_map('intval', $this->selectedAuthors));

        Flux::toast(variant: 'success', text: 'Curso guardado.');

        return redirect()->route('admin.courses.edit', $this->course);
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
    <flux:heading size="xl">{{ $course ? 'Editar curso' : 'Nuevo curso' }}</flux:heading>

    <form wire:submit="save" class="mt-6 max-w-3xl space-y-6">
        <flux:input wire:model.live.debounce.500ms="title" label="Título" required />
        <flux:input wire:model="slug" label="Slug" required />
        <flux:input wire:model="github_url" label="Repositorio GitHub" type="url" />
        <flux:textarea wire:model="description" label="Descripción" rows="5" />

        <div class="grid gap-4 md:grid-cols-2">
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
            <flux:button :href="route('admin.courses.index')" variant="ghost" wire:navigate>Cancelar</flux:button>
        </div>
    </form>
</div>
