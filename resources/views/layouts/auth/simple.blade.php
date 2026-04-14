<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100">
        <div class="relative flex min-h-svh flex-col">
            <header class="border-b border-zinc-200 px-6 py-5 dark:border-zinc-800">
                <div class="mx-auto flex max-w-5xl items-center justify-between">
                    <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2.5">
                        <x-app-logo-icon class="size-6" />
                        <div class="flex items-baseline gap-2">
                            <span class="text-lg font-semibold tracking-tight">Conjuros.dev</span>
                            <span class="label-mono hidden text-zinc-400 dark:text-zinc-600 sm:inline">v0.1</span>
                        </div>
                    </a>
                    <a href="{{ route('home') }}" wire:navigate class="label-mono text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100">
                        ← Volver al sitio
                    </a>
                </div>
            </header>

            <main class="bg-dot-grid flex flex-1 items-center justify-center px-6 py-16">
                <div class="w-full max-w-md">
                    <div class="border border-zinc-200 bg-white p-8 md:p-10 dark:border-zinc-800 dark:bg-zinc-950">
                        {{ $slot }}
                    </div>

                    <p class="mt-6 text-center label-mono text-zinc-500">
                        Nº 001 · Siete PM SpA · Chile
                    </p>
                </div>
            </main>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
