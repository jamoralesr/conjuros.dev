<?php

use App\Models\Plan;
use Flux\Flux;
use Illuminate\Http\RedirectResponse;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Membresía')] class extends Component {
    public ?Plan $plan = null;

    public function mount(): void
    {
        $this->plan = Plan::first();
    }

    public function redirectToCheckout(string $interval): RedirectResponse
    {
        return redirect()->route('checkout.start', [
            'plan' => $this->plan->slug,
            'interval' => $interval,
        ]);
    }

    public function redirectToPortal()
    {
        try {
            return auth()->user()->redirectToBillingPortal(route('billing.edit'));
        } catch (\Throwable $e) {
            Flux::toast(variant: 'danger', text: 'No se pudo abrir el portal: '.$e->getMessage());
        }
    }

    public function with(): array
    {
        $user = auth()->user();

        return [
            'isPro' => $user->isPro(),
            'subscription' => $user->subscription('default'),
        ];
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">Membresía</flux:heading>

    <x-pages::settings.layout heading="Membresía" subheading="Gestiona tu suscripción a Conjuros.dev Pro">
        @if ($isPro)
            <div class="mt-6 space-y-4">
                <flux:callout icon="check-badge" variant="success">
                    <flux:callout.heading>Tienes acceso Pro</flux:callout.heading>
                    <flux:callout.text>
                        Estado: {{ $subscription?->stripe_status ?? 'active' }}.
                        @if ($subscription?->ends_at)
                            Termina el {{ $subscription->ends_at->format('d/m/Y') }}.
                        @endif
                    </flux:callout.text>
                </flux:callout>

                <flux:button variant="primary" wire:click="redirectToPortal">
                    Gestionar suscripción
                </flux:button>
            </div>
        @else
            <div class="mt-6 space-y-4">
                <flux:text>
                    Suscríbete para acceder a todos los tutoriales y cursos pro.
                </flux:text>

                @if ($plan)
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                            <flux:heading size="lg">Mensual</flux:heading>
                            <div class="mt-2 text-3xl font-bold">USD {{ number_format($plan->price_monthly, 0) }}</div>
                            <flux:text class="mt-1">por mes</flux:text>
                            <flux:button variant="primary" class="mt-4 w-full" wire:click="redirectToCheckout('monthly')">
                                Suscribirme
                            </flux:button>
                        </div>
                        <div class="rounded-lg border border-primary-500 p-4">
                            <flux:heading size="lg">Anual</flux:heading>
                            <div class="mt-2 text-3xl font-bold">USD {{ number_format($plan->price_yearly, 0) }}</div>
                            <flux:text class="mt-1">al año (~2 meses gratis)</flux:text>
                            <flux:button variant="primary" class="mt-4 w-full" wire:click="redirectToCheckout('yearly')">
                                Suscribirme
                            </flux:button>
                        </div>
                    </div>
                @else
                    <flux:callout variant="warning">
                        <flux:callout.heading>Plan no configurado</flux:callout.heading>
                        <flux:callout.text>Ejecuta el seeder para crear el plan estándar.</flux:callout.text>
                    </flux:callout>
                @endif
            </div>
        @endif
    </x-pages::settings.layout>
</section>
