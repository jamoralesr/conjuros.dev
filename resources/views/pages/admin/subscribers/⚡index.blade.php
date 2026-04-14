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

<div class="px-6 py-10">
    <flux:heading size="xl">Suscriptores activos</flux:heading>
    <flux:text class="mt-1">Usuarios con suscripción activa en Stripe.</flux:text>

    <div class="mt-6 max-w-sm">
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
