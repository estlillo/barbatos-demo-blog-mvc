{{-- Ítems del navbar según rol --}}
@if(auth()->user()->hasRole('admin'))
    <flux:navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
        {{ __('Dashboard') }}
    </flux:navbar.item>

    <flux:navbar.item :href="route('categories.index')" :current="request()->routeIs('categories.*')" wire:navigate>
        {{ __('Categorías') }}
    </flux:navbar.item>
@endif

@if(auth()->user()->hasAnyRole(['admin', 'user']))
    <flux:navbar.item :href="route('posts.index')" :current="request()->routeIs('posts.*')" wire:navigate>
        {{ __('Publicaciones') }}
    </flux:navbar.item>
@endif

{{-- Menú desplegable solo para super-admin --}}
@if(auth()->user()->hasRole('super-admin'))
    <x-menu.dropdown-menu
        :name="__('Mi Menú')"
        :items="[
            ['label' => 'Casita', 'route' => 'casa'],
            ['label' => 'Dashboard', 'route' => 'dashboard']
        ]"
    />
@endif
