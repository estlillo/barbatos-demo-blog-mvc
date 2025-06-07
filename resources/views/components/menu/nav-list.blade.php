<!-- Normal routes with flux -->


@if(auth()->user()->hasRole('admin'))
    <flux:navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navbar.item>
    <flux:navbar.item :href="route('categories.index')" :current="request()->routeIs('categories.*')" wire:navigate>{{ __('Categorías') }}</flux:navbar.item>
@endif

<!-- Dropdown menu with local component -->
@if(auth()->user()->hasRole('super-admin'))
<x-menu.dropdown-menu
    :name="__('Mi Menú')"
    :items="[
        ['label' => 'Casita', 'route' => 'casa'],
        ['label' => 'Dashboard', 'route' => 'dashboard']
    ]"
/>
@endif



