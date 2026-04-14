<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        @stack('meta')
    </head>
    <body class="min-h-screen bg-white text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100">
        <flux:header class="border-b border-zinc-200 bg-white/80 backdrop-blur dark:border-zinc-800 dark:bg-zinc-950/80">
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2">
                <x-app-logo-icon class="size-6" />
                <flux:heading size="lg" class="!mb-0">Conjuros.dev</flux:heading>
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

        <main class="mx-auto w-full max-w-5xl px-6 py-10">
            {{ $slot }}
        </main>

        <footer class="mt-20 border-t border-zinc-200 bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900">
            <div class="mx-auto max-w-5xl px-6 py-12">
                <div class="grid gap-10 md:grid-cols-2">
                    <div>
                        <flux:heading size="lg">Conjuros.dev</flux:heading>
                        <flux:text class="mt-2">Contenido educativo sobre desarrollo con IA, escrito en colaboración con Claude.</flux:text>
                        @if (Route::has('front.methodology'))
                            <div class="mt-4 flex gap-3 text-sm text-zinc-500">
                                <a href="{{ route('front.methodology') }}" wire:navigate class="hover:underline">Metodología</a>
                                <span>·</span>
                                <a href="{{ route('front.plans') }}" wire:navigate class="hover:underline">Planes</a>
                            </div>
                        @endif
                    </div>
                    <div>
                        <flux:heading size="lg">Newsletter</flux:heading>
                        <flux:text class="mt-2">Un correo cada dos semanas con el contenido nuevo. Sin ruido.</flux:text>
                        @if (class_exists(\App\Livewire\Front\NewsletterForm::class))
                            <div class="mt-4">
                                <livewire:front.newsletter-form />
                            </div>
                        @endif
                    </div>
                </div>
                <div class="mt-10 border-t border-zinc-200 pt-6 text-xs text-zinc-500 dark:border-zinc-800">
                    © {{ date('Y') }} Siete PM SpA · Escrito con Claude (Anthropic)
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
