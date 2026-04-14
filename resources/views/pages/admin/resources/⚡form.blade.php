<?php

use App\Enums\ContentAccess;
use App\Enums\ResourceType;
use App\Models\Resource;
use App\Models\Tag;
use Flux\Flux;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.admin')] #[Title('Recurso — Admin')] class extends Component {
    public ?Resource $resource = null;

    public string $title = '';

    public string $slug = '';

    public string $type = 'prompt';

    public string $body = '';

    public string $url = '';

    public string $description = '';

    public string $model = '';

    public string $access = 'free';

    public array $selectedTags = [];

    public function mount(?Resource $resource = null): void
    {
        if ($resource && $resource->exists) {
            $this->resource = $resource;
            $this->title = $resource->title;
            $this->slug = $resource->slug;
            $this->type = $resource->type->value;
            $this->body = $resource->body ?? '';
            $this->url = $resource->url ?? '';
            $this->description = $resource->description ?? '';
            $this->model = $resource->model ?? '';
            $this->access = $resource->access->value;
            $this->selectedTags = $resource->tags()->pluck('tags.id')->map(fn ($id) => (string) $id)->toArray();
        }
    }

    public function updatedTitle(): void
    {
        if (! $this->resource) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function save(): RedirectResponse
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash'],
            'type' => ['required', 'in:prompt,skill,command,hook,agent,snippet,link,tool,doc'],
            'body' => ['nullable', 'string'],
            'url' => ['nullable', 'url'],
            'description' => ['nullable', 'string'],
            'model' => ['nullable', 'string', 'max:100'],
            'access' => ['required', 'in:free,pro'],
        ]);

        $data = [
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'type' => ResourceType::from($validated['type']),
            'body' => $validated['body'] ?: null,
            'url' => $validated['url'] ?: null,
            'description' => $validated['description'] ?: null,
            'model' => $validated['model'] ?: null,
            'access' => ContentAccess::from($validated['access']),
        ];

        if ($this->resource) {
            $this->resource->update($data);
        } else {
            $this->resource = Resource::create($data);
        }

        $this->resource->tags()->sync(array_map('intval', $this->selectedTags));

        Flux::toast(variant: 'success', text: 'Recurso guardado.');

        return redirect()->route('admin.resources.edit', $this->resource);
    }

    public function with(): array
    {
        return [
            'types' => ResourceType::cases(),
            'tags' => Tag::orderBy('name')->get(),
        ];
    }
}; ?>

<div>
    <header class="border-b border-zinc-200 px-8 py-10 dark:border-zinc-800">
        <div class="label-mono text-zinc-500">RES · {{ $resource ? 'Editar' : 'Nuevo' }}{{ $resource ? ' · RES-'.str_pad((string) $resource->id, 3, '0', STR_PAD_LEFT) : '' }}</div>
        <h1 class="mt-3 text-3xl font-bold tracking-tight md:text-4xl">{{ $resource ? 'Editar recurso' : 'Nuevo recurso' }}</h1>
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Prompts, skills, commands, hooks, agents, snippets, links, tools, docs.</p>
    </header>

    <div class="px-8 pb-10 pt-8">
        <form wire:submit="save" class="max-w-3xl space-y-6">
        <flux:input wire:model.live.debounce.500ms="title" label="Título" required />
        <flux:input wire:model="slug" label="Slug" required />

        <flux:select wire:model.live="type" label="Tipo" required>
            @foreach ($types as $t)
                <flux:select.option :value="$t->value">{{ $t->label() }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:textarea wire:model="description" label="Descripción" rows="3" />

        @if (in_array($type, ['prompt','skill','command','hook','agent','snippet']))
            <div>
                <flux:label>Cuerpo</flux:label>
                <flux:textarea wire:model="body" rows="15" class="font-mono text-sm" />
            </div>
        @endif

        @if (in_array($type, ['link','tool','doc']))
            <flux:input wire:model="url" label="URL" type="url" required />
        @endif

        @if (in_array($type, ['prompt','skill','agent']))
            <flux:input wire:model="model" label="Modelo de IA" placeholder="claude-sonnet-4-5" />
        @endif

        <div class="grid gap-4 md:grid-cols-2">
            <flux:select wire:model="access" label="Acceso">
                <flux:select.option value="free">Libre</flux:select.option>
                <flux:select.option value="pro">Pro</flux:select.option>
            </flux:select>
            <flux:select wire:model="selectedTags" label="Tags" multiple>
                @foreach ($tags as $tag)
                    <flux:select.option :value="(string) $tag->id">{{ $tag->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <div class="flex items-center gap-3 border-t border-zinc-200 pt-6 dark:border-zinc-800">
            <flux:button type="submit" variant="primary">Guardar</flux:button>
            <flux:button :href="route('admin.resources.index')" variant="ghost" wire:navigate>Cancelar</flux:button>
        </div>
        </form>
    </div>
</div>
