<!-- Normal routes with flux -->


@if(auth()->user()->hasRole('admin'))
    <flux:navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navbar.item>
@endif

<flux:navbar.item :href="route('casa')" :current="request()->routeIs('casa')" wire:navigate>{{ __('Casita') }}</flux:navbar.item>


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



