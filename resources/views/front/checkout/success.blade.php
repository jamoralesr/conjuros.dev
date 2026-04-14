<x-layouts::front>
    <section class="bg-dot-grid -mx-6 border-b border-zinc-200 px-6 py-24 dark:border-zinc-800">
        <div class="mx-auto max-w-2xl">
            <div class="flex items-center gap-3 label-mono text-lime-600 dark:text-lime-400">
                <span class="size-1.5 rounded-full bg-lime-500"></span>
                <span>SUB-ACK · Suscripción activa</span>
            </div>
            <h1 class="mt-6 text-4xl font-bold leading-[1.05] tracking-tight text-zinc-900 md:text-6xl dark:text-zinc-100">
                Bienvenido a<br>
                <span class="text-zinc-500">Conjuros Pro.</span>
            </h1>
            <p class="mt-6 max-w-xl text-lg leading-relaxed text-zinc-600 dark:text-zinc-400">
                Tu suscripción está activa. Ya puedes acceder a todos los tutoriales pro,
                cursos y recursos curados. Gracias por apoyar el proyecto.
            </p>
            <div class="mt-10 flex flex-wrap items-center gap-4">
                <flux:button :href="route('front.tutorials.index')" variant="primary" wire:navigate>Ver tutoriales</flux:button>
                <a href="{{ route('billing.edit') }}" wire:navigate class="label-mono text-zinc-600 underline decoration-zinc-400 underline-offset-4 hover:text-zinc-900 hover:decoration-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                    Mi membresía →
                </a>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-2xl border border-zinc-200 p-8 dark:border-zinc-800">
            <div class="label-mono text-zinc-500">Próximos pasos</div>
            <ol class="mt-6 space-y-5">
                <li class="flex items-start gap-5">
                    <span class="label-mono mt-1 text-zinc-400 dark:text-zinc-600">01</span>
                    <div>
                        <div class="font-semibold text-zinc-900 dark:text-zinc-100">Explora los cursos</div>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Lecciones encadenadas con hilo conductor, laboratorios en GitHub.</p>
                    </div>
                </li>
                <li class="flex items-start gap-5">
                    <span class="label-mono mt-1 text-zinc-400 dark:text-zinc-600">02</span>
                    <div>
                        <div class="font-semibold text-zinc-900 dark:text-zinc-100">Lee la metodología</div>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Cómo producimos el contenido en colaboración con Claude.</p>
                    </div>
                </li>
                <li class="flex items-start gap-5">
                    <span class="label-mono mt-1 text-zinc-400 dark:text-zinc-600">03</span>
                    <div>
                        <div class="font-semibold text-zinc-900 dark:text-zinc-100">Recibe el newsletter</div>
                        <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">Un correo cada dos semanas con el contenido nuevo. Sin ruido.</p>
                    </div>
                </li>
            </ol>
        </div>
    </section>
</x-layouts::front>
