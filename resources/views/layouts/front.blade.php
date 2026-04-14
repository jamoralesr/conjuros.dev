<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        @stack('meta')
    </head>
    <body class="min-h-screen bg-white text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100">
        <flux:header class="border-b border-zinc-200 bg-white/90 backdrop-blur dark:border-zinc-800 dark:bg-zinc-950/90">
            <a href="{{ route('home') }}" wire:navigate class="flex items-baseline gap-2">
                <flux:heading size="lg" class="!mb-0 tracking-tight">Conjuros.dev</flux:heading>
                <span class="label-mono hidden text-zinc-400 dark:text-zinc-600 sm:inline">v0.1</span>
            </a>

            <flux:navbar class="-mb-px max-lg:hidden">
                @if (Route::has('front.articles.index'))
                    <flux:navbar.item :href="route('front.articles.index')" wire:navigate>Artículos</flux:navbar.item>
                @endif
                @if (Route::has('front.tutorials.index'))
                    <flux:navbar.item :href="route('front.tutorials.index')" wire:navigate>Tutoriales</flux:navbar.item>
                @endif
                @if (Route::has('front.courses.index'))
                    <flux:navbar.item :href="route('front.courses.index')" wire:navigate>Cursos</flux:navbar.item>
                @endif
                @if (Route::has('front.resources.index'))
                    <flux:navbar.item :href="route('front.resources.index')" wire:navigate>Recursos</flux:navbar.item>
                @endif
                @if (Route::has('front.methodology'))
                    <flux:navbar.item :href="route('front.methodology')" wire:navigate>Metodología</flux:navbar.item>
                @endif
                @if (Route::has('front.plans'))
                    <flux:navbar.item :href="route('front.plans')" wire:navigate>Planes</flux:navbar.item>
                @endif
            </flux:navbar>

            <flux:spacer />

            @auth
                <flux:dropdown position="bottom" align="end">
                    <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />
                    <flux:menu>
                        @if(auth()->user()->isAdmin())
                            <flux:menu.item :href="route('admin.dashboard')" icon="cog-6-tooth" wire:navigate>Admin</flux:menu.item>
                        @endif
                        <flux:menu.item :href="route('profile.edit')" icon="user" wire:navigate>Mi cuenta</flux:menu.item>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">
                                Cerrar sesión
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            @else
                <flux:button :href="route('login')" variant="ghost" size="sm" wire:navigate>Ingresar</flux:button>
                <flux:button :href="route('register')" variant="primary" size="sm" wire:navigate>Suscribirse</flux:button>
            @endauth
        </flux:header>

        <main class="mx-auto w-full max-w-5xl px-6">
            {{ $slot }}
        </main>

        <footer class="mt-24 border-t border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950">
            <div class="mx-auto max-w-5xl px-6 py-16">
                <div class="grid gap-12 md:grid-cols-12">
                    <div class="md:col-span-5">
                        <div class="flex items-center gap-2.5">
                            <x-app-logo-icon class="size-6" />
                            <flux:heading size="lg" class="!mb-0 tracking-tight">Conjuros.dev</flux:heading>
                        </div>
                        <p class="mt-4 max-w-sm text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                            Contenido educativo sobre desarrollo con IA, escrito en colaboración con Claude.
                        </p>
                        <div class="mt-6 label-mono flex flex-wrap items-center gap-x-4 gap-y-2 text-zinc-500">
                            <span>Nº 001</span>
                            <span>·</span>
                            <span>Siete PM SpA</span>
                            <span>·</span>
                            <span>Chile · {{ date('Y') }}</span>
                        </div>
                    </div>

                    <div class="md:col-span-3">
                        <div class="label-mono text-zinc-500">Sitio</div>
                        <ul class="mt-4 space-y-2 text-sm">
                            @if (Route::has('front.tutorials.index'))
                                <li><a href="{{ route('front.tutorials.index') }}" wire:navigate class="hover:text-zinc-900 dark:hover:text-zinc-100">Tutoriales</a></li>
                            @endif
                            @if (Route::has('front.articles.index'))
                                <li><a href="{{ route('front.articles.index') }}" wire:navigate class="hover:text-zinc-900 dark:hover:text-zinc-100">Artículos</a></li>
                            @endif
                            @if (Route::has('front.courses.index'))
                                <li><a href="{{ route('front.courses.index') }}" wire:navigate class="hover:text-zinc-900 dark:hover:text-zinc-100">Cursos</a></li>
                            @endif
                            @if (Route::has('front.resources.index'))
                                <li><a href="{{ route('front.resources.index') }}" wire:navigate class="hover:text-zinc-900 dark:hover:text-zinc-100">Recursos</a></li>
                            @endif
                        </ul>
                    </div>

                    <div class="md:col-span-4">
                        <div class="label-mono text-zinc-500">Newsletter</div>
                        <p class="mt-4 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                            Un correo cada dos semanas con el contenido nuevo. Sin ruido.
                        </p>
                        <div class="mt-4">
                            <livewire:front.newsletter-form />
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex items-center justify-between border-t border-zinc-200 pt-6 label-mono text-zinc-500 dark:border-zinc-800">
                    <span>© {{ date('Y') }} Siete PM SpA</span>
                    <span>Escrito con Claude · Anthropic</span>
                </div>
            </div>
        </footer>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
