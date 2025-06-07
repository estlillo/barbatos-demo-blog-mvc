<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                <x-app-logo />
            </a>

            @auth
                <!-- Desktop Navbar -->
                <flux:navbar class="-mb-px">
                    <x-menu.nav-list />
                </flux:navbar>

                <flux:spacer />

                <!-- Desktop User Menu -->
                <flux:dropdown position="top" align="end">
                    <flux:profile
                        class="cursor-pointer"
                        :initials="auth()->user()->initials()"
                    />

                    <flux:menu>
                        <flux:menu.radio.group>
                            <div class="p-0 text-sm font-normal">
                                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </flux:menu.radio.group>

                        <flux:menu.separator />

                        @if(config('app.show_default_options'))
                            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                                <flux:tooltip :content="__('Buscar')" position="bottom">
                                    <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="magnifying-glass" href="#" :label="__('Search')" />
                                </flux:tooltip>
                            </flux:navbar>
                        @endif

                        @if(config('app.enable_user_settings'))
                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Opciones') }}</flux:menu.item>
                            </flux:menu.radio.group>

                            <flux:menu.separator />
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                                {{ __('Cerrar sesión') }}
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>

            @endauth
        </flux:header>

        {{ $slot }}

        @fluxScripts

        @if(session()->has('message'))
            <script>
                Swal.fire(Object.assign({
                    confirmButtonText: 'Aceptar',
                    timer: 10000,
                    timerProgressBar: true,
                    confirmButtonColor: "#3085d6",
                }, @json(session('message'))));
            </script>
        @endif
</html>
