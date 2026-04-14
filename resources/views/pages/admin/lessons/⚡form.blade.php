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

<div class="px-6 py-10">
    <flux:heading size="xl">{{ $lesson ? 'Editar lección' : 'Nueva lección' }}</flux:heading>
    <flux:text class="mt-1">Curso: {{ $course->title }}</flux:text>

    <form wire:submit="save" class="mt-6 max-w-3xl space-y-6">
        <flux:input wire:model.live.debounce.500ms="title" label="Título" required />
        <flux:input wire:model="slug" label="Slug" required />
        <flux:input wire:model.number="order" type="number" label="Orden" required />

        <flux:editor wire:model="body" label="Cuerpo" description="Contenido de la lección." />

        <flux:input wire:model="interactive_html_path" label="URL de HTML interactivo (CDN)" placeholder="https://…" />

        <flux:checkbox wire:model="publishNow" label="Publicada" />

        <div class="flex items-center gap-3">
            <flux:button type="submit" variant="primary">Guardar</flux:button>
            <flux:button :href="route('admin.lessons.index', $course)" variant="ghost" wire:navigate>Cancelar</flux:button>
        </div>
    </form>
</div>
