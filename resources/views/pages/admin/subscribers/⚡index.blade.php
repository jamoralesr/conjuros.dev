<?php

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] #[Title('Suscriptores — Admin')] class extends Component {
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function with(): array
    {
        return [
            'subscribers' => User::query()
                ->whereHas('subscriptions', fn ($q) => $q->where('stripe_status', 'active'))
                ->when($this->search, fn ($q) => $q->where('email', 'ilike', "%{$this->search}%")->orWhere('name', 'ilike', "%{$this->search}%"))
                ->with('subscriptions')
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ];
    }
}; ?>

<div>
    <header class="border-b border-zinc-200 px-8 py-10 dark:border-zinc-800">
        <div class="label-mono text-zinc-500">SUB · Membresías</div>
        <h1 class="mt-3 text-3xl font-bold tracking-tight md:text-4xl">Suscriptores activos</h1>
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Usuarios con suscripción activa en Stripe.</p>
    </header>

    <div class="px-8 pb-10 pt-8">
        <div class="max-w-sm">
            <flux:input wire:model.live.debounce.300ms="search" placeholder="Buscar por email o nombre…" icon="magnifying-glass" />
        </div>

        <flux:table :paginate="$subscribers" class="mt-6">
        <flux:table.columns>
            <flux:table.column>Nombre</flux:table.column>
            <flux:table.column>Email</flux:table.column>
            <flux:table.column>Desde</flux:table.column>
            <flux:table.column>Estado Stripe</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($subscribers as $subscriber)
                <flux:table.row :key="$subscriber->id">
                    <flux:table.cell>{{ $subscriber->name }}</flux:table.cell>
                    <flux:table.cell>{{ $subscriber->email }}</flux:table.cell>
                    <flux:table.cell>{{ $subscriber->created_at->format('d/m/Y') }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge color="lime">{{ $subscriber->subscription('default')?->stripe_status ?? '—' }}</flux:badge>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="4" class="text-center text-zinc-500">Sin suscriptores activos todavía.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
    </div>
</div>
