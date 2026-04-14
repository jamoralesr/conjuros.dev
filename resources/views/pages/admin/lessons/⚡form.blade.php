<?php

use App\Models\Course;
use App\Models\Lesson;
use Flux\Flux;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.admin')] #[Title('Lección — Admin')] class extends Component {
    public Course $course;

    public ?Lesson $lesson = null;

    public string $title = '';

    public string $slug = '';

    public string $body = '';

    public int $order = 1;

    public string $interactive_html_path = '';

    public bool $publishNow = false;

    public function mount(Course $course, ?Lesson $lesson = null): void
    {
        $this->course = $course;

        if ($lesson && $lesson->exists) {
            $this->lesson = $lesson;
            $this->title = $lesson->title;
            $this->slug = $lesson->slug;
            $this->body = $lesson->body ?? '';
            $this->order = $lesson->order;
            $this->interactive_html_path = $lesson->interactive_html_path ?? '';
        } else {
            $this->order = $course->lessons()->max('order') + 1;
        }
    }

    public function updatedTitle(): void
    {
        if (! $this->lesson) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function save(): RedirectResponse
    {
        $validated = $this->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash'],
            'body' => ['nullable', 'string'],
            'order' => ['required', 'integer', 'min:0'],
            'interactive_html_path' => ['nullable', 'string', 'max:2048'],
        ]);

        $data = [
            'course_id' => $this->course->id,
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'body' => $validated['body'] ?: null,
            'order' => $validated['order'],
            'interactive_html_path' => $validated['interactive_html_path'] ?: null,
            'published_at' => $this->publishNow
                ? ($this->lesson?->published_at ?? now())
                : $this->lesson?->published_at,
        ];

        if ($this->lesson) {
            $this->lesson->update($data);
        } else {
            $this->lesson = Lesson::create($data);
        }

        Flux::toast(variant: 'success', text: 'Lección guardada.');

        return redirect()->route('admin.lessons.edit', [$this->course, $this->lesson]);
    }
}; ?>

<div>
    <header class="border-b border-zinc-200 px-8 py-10 dark:border-zinc-800">
        <div class="label-mono text-zinc-500">LES · {{ $lesson ? 'Editar' : 'Nueva' }}{{ $lesson ? ' · LES-'.str_pad((string) $lesson->id, 3, '0', STR_PAD_LEFT) : '' }} · Curso {{ $course->slug }}</div>
        <h1 class="mt-3 text-3xl font-bold tracking-tight md:text-4xl">{{ $lesson ? 'Editar lección' : 'Nueva lección' }}</h1>
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Curso: «{{ $course->title }}»</p>
    </header>

    <div class="px-8 pb-10 pt-8">
        <form wire:submit="save" class="max-w-3xl space-y-6">
        <flux:input wire:model.live.debounce.500ms="title" label="Título" required />
        <flux:input wire:model="slug" label="Slug" required />
        <flux:input wire:model.number="order" type="number" label="Orden" required />

        <x-content-editor wire:model="body" label="Cuerpo" description="Contenido de la lección. Incluye bloques de código." />

        <flux:input wire:model="interactive_html_path" label="URL de HTML interactivo (CDN)" placeholder="https://…" />

        <flux:checkbox wire:model="publishNow" label="Publicada" />

        <div class="flex items-center gap-3 border-t border-zinc-200 pt-6 dark:border-zinc-800">
            <flux:button type="submit" variant="primary">Guardar</flux:button>
            <flux:button :href="route('admin.lessons.index', $course)" variant="ghost" wire:navigate>Cancelar</flux:button>
        </div>
        </form>
    </div>
</div>
