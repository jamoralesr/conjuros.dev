<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950">
            <flux:sidebar.header>
                <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex items-baseline gap-2">
                    <flux:heading size="lg" class="!mb-0 tracking-tight">Conjuros</flux:heading>
                    <span class="label-mono text-zinc-400 dark:text-zinc-600">admin</span>
                </a>
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group heading="Panel" class="grid [&>[data-flux-sidebar-heading]]:label-mono [&>[data-flux-sidebar-heading]]:!text-zinc-400 dark:[&>[data-flux-sidebar-heading]]:!text-zinc-600">
                    <flux:sidebar.item icon="home" :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>
                        Dashboard
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group heading="Contenido" class="grid [&>[data-flux-sidebar-heading]]:label-mono [&>[data-flux-sidebar-heading]]:!text-zinc-400 dark:[&>[data-flux-sidebar-heading]]:!text-zinc-600">
                    @if (Route::has('admin.articles.index'))
                        <flux:sidebar.item icon="document-text" :href="route('admin.articles.index')" :current="request()->routeIs('admin.articles.*')" wire:navigate>Artículos</flux:sidebar.item>
                    @endif
                    @if (Route::has('admin.tutorials.index'))
                        <flux:sidebar.item icon="book-open" :href="route('admin.tutorials.index')" :current="request()->routeIs('admin.tutorials.*')" wire:navigate>Tutoriales</flux:sidebar.item>
                    @endif
                    @if (Route::has('admin.courses.index'))
                        <flux:sidebar.item icon="academic-cap" :href="route('admin.courses.index')" :current="request()->routeIs('admin.courses.*')" wire:navigate>Cursos</flux:sidebar.item>
                    @endif
                    @if (Route::has('admin.resources.index'))
                        <flux:sidebar.item icon="puzzle-piece" :href="route('admin.resources.index')" :current="request()->routeIs('admin.resources.*')" wire:navigate>Recursos</flux:sidebar.item>
                    @endif
                </flux:sidebar.group>

                <flux:sidebar.group heading="Taxonomía" class="grid [&>[data-flux-sidebar-heading]]:label-mono [&>[data-flux-sidebar-heading]]:!text-zinc-400 dark:[&>[data-flux-sidebar-heading]]:!text-zinc-600">
                    @if (Route::has('admin.categories.index'))
                        <flux:sidebar.item icon="folder" :href="route('admin.categories.index')" :current="request()->routeIs('admin.categories.*')" wire:navigate>Categorías</flux:sidebar.item>
                    @endif
                    @if (Route::has('admin.tags.index'))
                        <flux:sidebar.item icon="tag" :href="route('admin.tags.index')" :current="request()->routeIs('admin.tags.*')" wire:navigate>Tags</flux:sidebar.item>
                    @endif
                    @if (Route::has('admin.authors.index'))
                        <flux:sidebar.item icon="user-circle" :href="route('admin.authors.index')" :current="request()->routeIs('admin.authors.*')" wire:navigate>Autores</flux:sidebar.item>
                    @endif
                </flux:sidebar.group>

                <flux:sidebar.group heading="Negocio" class="grid [&>[data-flux-sidebar-heading]]:label-mono [&>[data-flux-sidebar-heading]]:!text-zinc-400 dark:[&>[data-flux-sidebar-heading]]:!text-zinc-600">
                    @if (Route::has('admin.plans.index'))
                        <flux:sidebar.item icon="credit-card" :href="route('admin.plans.index')" :current="request()->routeIs('admin.plans.*')" wire:navigate>Planes</flux:sidebar.item>
                    @endif
                    @if (Route::has('admin.subscribers.index'))
                        <flux:sidebar.item icon="users" :href="route('admin.subscribers.index')" :current="request()->routeIs('admin.subscribers.*')" wire:navigate>Suscriptores</flux:sidebar.item>
                    @endif
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="globe-alt" :href="route('home')" wire:navigate>Ver sitio</flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <flux:header class="border-b border-zinc-200 dark:border-zinc-800 lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
            <flux:spacer />
            <flux:dropdown position="top" align="end">
                <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />
                <flux:menu>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>Cuenta</flux:menu.item>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">Cerrar sesión</flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <flux:main>
            {{ $slot }}
        </flux:main>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
