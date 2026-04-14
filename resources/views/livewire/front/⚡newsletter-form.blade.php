<?php

use App\Jobs\SyncSubscriberToButtondown;
use Livewire\Component;

new class extends Component {
    public string $email = '';

    public bool $submitted = false;

    public function subscribe(): void
    {
        $validated = $this->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        SyncSubscriberToButtondown::dispatch($validated['email'], [
            'source' => 'conjuros.dev:footer',
        ]);

        $this->submitted = true;
        $this->reset('email');
    }
}; ?>

<div>
    @if ($submitted)
        <flux:callout variant="success" icon="check">
            <flux:callout.text>Listo. Revisa tu correo para confirmar la suscripción.</flux:callout.text>
        </flux:callout>
    @else
        <form wire:submit="subscribe" class="flex gap-2">
            <flux:input wire:model="email" type="email" placeholder="tu@email.com" class="flex-1" />
            <flux:button type="submit" variant="primary">Suscribirme</flux:button>
        </form>
        @error('email')<flux:text class="mt-2 text-sm text-red-500">{{ $message }}</flux:text>@enderror
    @endif
</div>
