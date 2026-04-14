<x-layouts::front>
    <div class="py-6">
        <flux:heading size="xl">Tutoriales</flux:heading>
        <flux:text class="mt-2">Un problema, una solución, un repositorio real en GitHub.</flux:text>
    </div>

    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse ($tutorials as $tutorial)
            <a href="{{ route('front.tutorials.show', $tutorial) }}" wire:navigate class="block">
                <flux:card class="h-full transition hover:border-primary-500">
                    <div class="flex items-center gap-2">
                        @if ($tutorial->access->value === 'pro')
                            <flux:badge color="amber" size="sm">Pro</flux:badge>
                        @endif
                        <flux:text class="text-xs uppercase text-zinc-500">{{ $tutorial->category?->name ?? 'Tutorial' }}</flux:text>
                    </div>
                    <flux:heading class="mt-2">{{ $tutorial->title }}</flux:heading>
                    <flux:text class="mt-2">{{ $tutorial->excerpt }}</flux:text>
                    <flux:text class="mt-3 text-xs text-zinc-500">{{ $tutorial->published_at?->format('d/m/Y') }}</flux:text>
                </flux:card>
            </a>
        @empty
            <flux:text class="col-span-full text-center text-zinc-500">Aún no hay tutoriales publicados.</flux:text>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $tutorials->links() }}
    </div>
</x-layouts::front>
