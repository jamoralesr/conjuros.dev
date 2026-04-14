@php
    $plan = \App\Models\Plan::first();
@endphp

<x-layouts::front>
    <x-page-header
        number="Nº 002"
        eyebrow="Suscripción"
        title="Un solo plan. Acceso completo."
        subtitle="Tutoriales pro, cursos, nuevas lecciones y recursos curados. Sin niveles, sin sorpresas."
    />

    @if ($plan)
        <section class="py-16">
            <div class="grid gap-0 md:grid-cols-2 md:[&>*]:border-l md:[&>*:first-child]:border-l-0 md:[&>*]:-ml-px">

                {{-- Mensual --}}
                <div class="border border-zinc-200 bg-white p-10 dark:border-zinc-800 dark:bg-zinc-950">
                    <div class="flex items-center justify-between label-mono text-zinc-500">
                        <span>Plan 01</span>
                        <span>Flexible</span>
                    </div>
                    <h2 class="mt-6 text-2xl font-bold tracking-tight">Mensual</h2>
                    <div class="mt-8 flex items-baseline gap-2">
                        <span class="text-5xl font-bold tracking-tight md:text-6xl">USD {{ number_format($plan->price_monthly, 0) }}</span>
                        <span class="label-mono text-zinc-500">/ mes</span>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                        Para quienes quieren probar antes de comprometerse al año completo.
                    </p>
                    <div class="mt-8">
                        @auth
                            <flux:button :href="route('checkout.start', ['plan' => $plan->slug, 'interval' => 'monthly'])" variant="primary" class="w-full">
                                Suscribirme
                            </flux:button>
                        @else
                            <flux:button :href="route('register')" variant="primary" class="w-full" wire:navigate>
                                Crear cuenta
                            </flux:button>
                        @endauth
                    </div>
                </div>

                {{-- Anual --}}
                <div class="relative border border-zinc-900 bg-zinc-900 p-10 text-zinc-100 dark:border-zinc-100 dark:bg-zinc-100 dark:text-zinc-900">
                    <div class="flex items-center justify-between label-mono text-zinc-400 dark:text-zinc-600">
                        <span>Plan 02</span>
                        <span>— Recomendado</span>
                    </div>
                    <h2 class="mt-6 text-2xl font-bold tracking-tight">Anual</h2>
                    <div class="mt-8 flex items-baseline gap-2">
                        <span class="text-5xl font-bold tracking-tight md:text-6xl">USD {{ number_format($plan->price_yearly, 0) }}</span>
                        <span class="label-mono text-zinc-400 dark:text-zinc-600">/ año</span>
                    </div>
                    <p class="mt-4 text-sm leading-relaxed text-zinc-300 dark:text-zinc-600">
                        Pagas doce y te llevas ~catorce meses. El plan de quien ya decidió.
                    </p>
                    <div class="mt-8">
                        @auth
                            <flux:button :href="route('checkout.start', ['plan' => $plan->slug, 'interval' => 'yearly'])" variant="primary" class="w-full">
                                Suscribirme
                            </flux:button>
                        @else
                            <flux:button :href="route('register')" variant="primary" class="w-full" wire:navigate>
                                Crear cuenta
                            </flux:button>
                        @endauth
                    </div>
                </div>

            </div>
        </section>
    @else
        <section class="py-16">
            <flux:callout variant="warning" class="mx-auto max-w-xl">
                <flux:callout.heading>Planes no configurados</flux:callout.heading>
            </flux:callout>
        </section>
    @endif

    <section class="border-t border-zinc-200 py-10 dark:border-zinc-800">
        <div class="mx-auto max-w-2xl text-center label-mono text-zinc-500">
            Factura: Siete PM SpA · Pagos procesados por Stripe
        </div>
    </section>
</x-layouts::front>
