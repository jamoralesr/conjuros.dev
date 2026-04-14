@php
    $plan = \App\Models\Plan::first();
@endphp

<x-layouts::front>
    <div class="mx-auto max-w-3xl py-10 text-center">
        <flux:heading size="xl" class="!text-4xl">Un solo plan. Acceso completo.</flux:heading>
        <flux:text class="mt-3 text-lg">Tutoriales pro, cursos, nuevas lecciones y recursos curados.</flux:text>
    </div>

    @if ($plan)
        <div class="mx-auto mt-10 grid max-w-3xl gap-6 md:grid-cols-2">
            <flux:card>
                <flux:heading size="lg">Mensual</flux:heading>
                <div class="mt-4 text-5xl font-bold">USD {{ number_format($plan->price_monthly, 0) }}</div>
                <flux:text class="mt-1">por mes</flux:text>
                @auth
                    <flux:button :href="route('checkout.start', ['plan' => $plan->slug, 'interval' => 'monthly'])" variant="primary" class="mt-6 w-full">
                        Suscribirme
                    </flux:button>
                @else
                    <flux:button :href="route('register')" variant="primary" class="mt-6 w-full" wire:navigate>
                        Crear cuenta
                    </flux:button>
                @endauth
            </flux:card>

            <flux:card class="border-primary-500">
                <flux:heading size="lg">Anual</flux:heading>
                <div class="mt-4 text-5xl font-bold">USD {{ number_format($plan->price_yearly, 0) }}</div>
                <flux:text class="mt-1">al año <span class="text-primary-500">(~2 meses gratis)</span></flux:text>
                @auth
                    <flux:button :href="route('checkout.start', ['plan' => $plan->slug, 'interval' => 'yearly'])" variant="primary" class="mt-6 w-full">
                        Suscribirme
                    </flux:button>
                @else
                    <flux:button :href="route('register')" variant="primary" class="mt-6 w-full" wire:navigate>
                        Crear cuenta
                    </flux:button>
                @endauth
            </flux:card>
        </div>
    @else
        <flux:callout variant="warning" class="mx-auto max-w-xl">
            <flux:callout.heading>Planes no configurados</flux:callout.heading>
        </flux:callout>
    @endif

    <div class="mx-auto mt-12 max-w-2xl text-center text-sm text-zinc-500">
        Factura: Siete PM SpA · Pagos procesados por Stripe
    </div>
</x-layouts::front>
