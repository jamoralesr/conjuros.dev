<x-layouts::front>
    <div class="py-6">
        <flux:heading size="xl">Recursos</flux:heading>
        <flux:text class="mt-2">Prompts, skills, comandos, agentes, snippets, enlaces curados.</flux:text>
    </div>

    <div class="mt-6 flex flex-wrap gap-2">
        <a href="{{ route('front.resources.index') }}" wire:navigate>
            <flux:badge :color="$currentType === '' ? 'primary' : 'zinc'">Todos</flux:badge>
        </a>
        @foreach ($types as $type)
            <a href="{{ route('front.resources.index', ['type' => $type->value]) }}" wire:navigate>
                <flux:badge :color="$currentType === $type->value ? 'primary' : 'zinc'">{{ $type->label() }}</flux:badge>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($resources as $resource)
            <a href="{{ route('front.resources.show', $resource) }}" wire:navigate class="block">
                <flux:card class="h-full transition hover:border-primary-500">
                    <flux:text class="text-xs uppercase text-zinc-500">{{ $resource->type->label() }}</flux:text>
                    <flux:heading class="mt-2">{{ $resource->title }}</flux:heading>
                    @if ($resource->description)
                        <flux:text class="mt-2">{{ $resource->description }}</flux:text>
                    @endif
                </flux:card>
            </a>
        @empty
            <flux:text class="col-span-full text-center text-zinc-500">Aún no hay recursos en esta categoría.</flux:text>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $resources->links() }}
    </div>
</x-layouts::front>
