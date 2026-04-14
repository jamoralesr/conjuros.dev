<?php

use App\Models\Plan;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Layout('layouts.admin')] #[Title('Planes — Admin')] class extends Component {
    public ?int $editingId = null;

    public string $name = '';

    public string $slug = '';

    public float $price_monthly = 0;

    public float $price_yearly = 0;

    public string $stripe_price_id_monthly = '';

    public string $stripe_price_id_yearly = '';

    public function edit(int $id): void
    {
        $plan = Plan::findOrFail($id);
        $this->editingId = $plan->id;
        $this->name = $plan->name;
        $this->slug = $plan->slug;
        $this->price_monthly = (float) $plan->price_monthly;
        $this->price_yearly = (float) $plan->price_yearly;
        $this->stripe_price_id_monthly = $plan->stripe_price_id_monthly ?? '';
        $this->stripe_price_id_yearly = $plan->stripe_price_id_yearly ?? '';
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'alpha_dash'],
            'price_monthly' => ['required', 'numeric', 'min:0'],
            'price_yearly' => ['required', 'numeric', 'min:0'],
            'stripe_price_id_monthly' => ['nullable', 'string', 'max:255'],
            'stripe_price_id_yearly' => ['nullable', 'string', 'max:255'],
        ]);

        if ($this->editingId) {
            Plan::findOrFail($this->editingId)->update($validated);
        } else {
            Plan::create($validated);
        }

        $this->reset();
        Flux::toast(variant: 'success', text: 'Plan guardado.');
    }

    public function with(): array
    {
        return ['plans' => Plan::orderBy('price_monthly')->get()];
    }
}; ?>

<div>
    <header class="border-b border-zinc-200 px-8 py-10 dark:border-zinc-800">
        <div class="label-mono text-zinc-500">PLN · Negocio</div>
        <h1 class="mt-3 text-3xl font-bold tracking-tight md:text-4xl">Planes</h1>
        <p class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">Precios en USD. Los IDs de Stripe se inyectan desde <code class="font-mono text-xs">.env</code> por defecto.</p>
    </header>

    <div class="px-8 pb-10 pt-8">
        <flux:table>
        <flux:table.columns>
            <flux:table.column>Nombre</flux:table.column>
            <flux:table.column>Mensual</flux:table.column>
            <flux:table.column>Anual</flux:table.column>
            <flux:table.column>Stripe mensual</flux:table.column>
            <flux:table.column>Stripe anual</flux:table.column>
            <flux:table.column></flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse ($plans as $plan)
                <flux:table.row :key="$plan->id">
                    <flux:table.cell>{{ $plan->name }}</flux:table.cell>
                    <flux:table.cell>USD {{ number_format($plan->price_monthly, 2) }}</flux:table.cell>
                    <flux:table.cell>USD {{ number_format($plan->price_yearly, 2) }}</flux:table.cell>
                    <flux:table.cell class="font-mono text-xs">{{ $plan->stripe_price_id_monthly ?? '—' }}</flux:table.cell>
                    <flux:table.cell class="font-mono text-xs">{{ $plan->stripe_price_id_yearly ?? '—' }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:button size="xs" wire:click="edit({{ $plan->id }})">Editar</flux:button>
                    </flux:table.cell>
                </flux:table.row>
            @empty
                <flux:table.row>
                    <flux:table.cell colspan="6" class="text-center text-zinc-500">Sin planes.</flux:table.cell>
                </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>

        <flux:card class="mt-6 max-w-2xl">
        <flux:heading>{{ $editingId ? 'Editar plan' : 'Nuevo plan' }}</flux:heading>
        <form wire:submit="save" class="mt-4 space-y-4">
            <flux:input wire:model="name" label="Nombre" required />
            <flux:input wire:model="slug" label="Slug" required />
            <div class="grid gap-4 md:grid-cols-2">
                <flux:input wire:model.number="price_monthly" type="number" step="0.01" label="Precio mensual (USD)" required />
                <flux:input wire:model.number="price_yearly" type="number" step="0.01" label="Precio anual (USD)" required />
            </div>
            <flux:input wire:model="stripe_price_id_monthly" label="Stripe price ID mensual" placeholder="price_…" />
            <flux:input wire:model="stripe_price_id_yearly" label="Stripe price ID anual" placeholder="price_…" />
            <flux:button type="submit" variant="primary" size="sm">Guardar</flux:button>
        </form>
        </flux:card>
    </div>
</div>
