@props(['message' => null])

<div class="relative mt-8">
    <div class="pointer-events-none absolute inset-x-0 -top-40 h-40 bg-gradient-to-t from-white to-transparent dark:from-zinc-950"></div>

    <flux:card class="mx-auto max-w-2xl text-center">
        <flux:icon.lock-closed class="mx-auto size-10 text-amber-500" />
        <flux:heading size="lg" class="mt-3">Contenido Pro</flux:heading>
        <flux:text class="mt-2">
            {{ $message ?? 'Suscríbete para leer el resto. Acceso completo a tutoriales y cursos, USD 8 al mes.' }}
        </flux:text>
        <div class="mt-5 flex justify-center gap-2">
            @auth
                <flux:button :href="route('billing.edit')" variant="primary" wire:navigate>Ver planes</flux:button>
            @else
                <flux:button :href="route('register')" variant="primary" wire:navigate>Crear cuenta</flux:button>
                <flux:button :href="route('login')" variant="ghost" wire:navigate>Ya tengo cuenta</flux:button>
            @endauth
        </div>
    </flux:card>
</div>
