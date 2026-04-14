<x-layouts::auth :title="__('Email verification')">
    <div class="flex flex-col gap-6">
        <div class="flex w-full flex-col">
            <div class="label-mono text-zinc-500">Verificación · Correo</div>
            <h1 class="mt-3 text-2xl font-bold tracking-tight text-zinc-900 md:text-3xl dark:text-zinc-100">
                {{ __('Verify your email') }}
            </h1>
            <p class="mt-2 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                {{ __('Please verify your email address by clicking on the link we just emailed to you.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="border border-lime-200 bg-lime-50 px-4 py-3 text-sm text-lime-900 dark:border-lime-900 dark:bg-lime-950 dark:text-lime-200">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="flex flex-col items-stretch justify-between gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Resend verification email') }}
                </flux:button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:button variant="ghost" type="submit" class="w-full cursor-pointer text-sm" data-test="logout-button">
                    {{ __('Log out') }}
                </flux:button>
            </form>
        </div>
    </div>
</x-layouts::auth>
