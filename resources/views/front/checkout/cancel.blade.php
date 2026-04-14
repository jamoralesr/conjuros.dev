<x-layouts::front>
    <div class="mx-auto max-w-xl py-20 text-center">
        <flux:heading size="xl" class="!text-3xl">Suscripción cancelada</flux:heading>
        <flux:text class="mt-3">No hicimos ningún cargo. Cuando quieras, puedes volver a intentarlo.</flux:text>
        <div class="mt-8">
            <flux:button :href="route('front.plans')" variant="primary" wire:navigate>Ver planes</flux:button>
        </div>
    </div>
</x-layouts::front>
