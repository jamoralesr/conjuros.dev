@props(['message' => null])

<div class="relative mt-10">
    <div class="pointer-events-none absolute inset-x-0 -top-40 h-40 bg-gradient-to-t from-white to-transparent dark:from-zinc-950"></div>

    <div class="mx-auto max-w-2xl border border-zinc-200 bg-white p-10 text-center dark:border-zinc-800 dark:bg-zinc-950">
        <div class="label-mono text-amber-600 dark:text-amber-400">Contenido Pro</div>
        <h3 class="mt-4 text-2xl font-bold tracking-tight md:text-3xl">
            Este fragmento está reservado para suscriptores.
        </h3>
        <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
            {{ $message ?? 'Suscríbete para leer el resto. Acceso completo a tutoriales y cursos, USD 8 al mes.' }}
        </p>
        <div class="mt-6 flex justify-center gap-3">
            @auth
                <flux:button :href="route('billing.edit')" variant="primary" wire:navigate>Ver planes</flux:button>
            @else
                <flux:button :href="route('register')" variant="primary" wire:navigate>Crear cuenta</flux:button>
                <flux:button :href="route('login')" variant="ghost" wire:navigate>Ya tengo cuenta</flux:button>
            @endauth
        </div>
    </div>
</div>
