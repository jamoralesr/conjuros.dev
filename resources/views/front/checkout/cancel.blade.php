<x-layouts::front>
    <section class="bg-dot-grid -mx-6 border-b border-zinc-200 px-6 py-24 dark:border-zinc-800">
        <div class="mx-auto max-w-2xl">
            <div class="flex items-center gap-3 label-mono text-zinc-500">
                <span class="size-1.5 rounded-full bg-zinc-400"></span>
                <span>SUB-NAK · Proceso cancelado</span>
            </div>
            <h1 class="mt-6 text-4xl font-bold leading-[1.05] tracking-tight text-zinc-900 md:text-6xl dark:text-zinc-100">
                Suscripción<br>
                <span class="text-zinc-500">cancelada.</span>
            </h1>
            <p class="mt-6 max-w-xl text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">
                No hicimos ningún cargo. Cuando quieras, puedes volver a intentarlo —
                el plan sigue ahí esperándote.
            </p>
            <div class="mt-10 flex flex-wrap items-center gap-4">
                <flux:button :href="route('front.plans')" variant="primary" wire:navigate>Ver planes</flux:button>
                <a href="{{ route('home') }}" wire:navigate class="label-mono text-zinc-600 underline decoration-zinc-400 underline-offset-4 hover:text-zinc-900 hover:decoration-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                    Volver al inicio →
                </a>
            </div>
        </div>
    </section>
</x-layouts::front>
