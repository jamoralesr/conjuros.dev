<x-layouts::front>
    <div class="mx-auto max-w-xl py-20 text-center">
        <flux:icon.check-badge class="mx-auto size-16 text-lime-500" />
        <flux:heading size="xl" class="mt-4 !text-3xl">¡Bienvenido a Conjuros Pro!</flux:heading>
        <flux:text class="mt-3">Tu suscripción está activa. Ya puedes acceder a todos los tutoriales y cursos.</flux:text>
        <div class="mt-8 flex justify-center gap-3">
            <flux:button :href="route('front.tutorials.index')" variant="primary" wire:navigate>Ver tutoriales</flux:button>
            <flux:button :href="route('billing.edit')" variant="ghost" wire:navigate>Mi membresía</flux:button>
        </div>
    </div>
</x-layouts::front>
