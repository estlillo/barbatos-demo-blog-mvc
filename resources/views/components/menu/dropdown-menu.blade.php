@props([
    'name',
    'items' // array: [['label' => '...', 'route' => '...', 'params' => [], 'active' => false], ...]
])

<flux:dropdown position="top" align="end">
    <x-menu.menu-name :name="$name" />
    <flux:navmenu>
        @foreach($items as $item)
            <flux:navbar.item :href="route($item['route'], $item['params'] ?? [])" wire:navigate>
                {{ __($item['label']) }}
            </flux:navbar.item>
        @endforeach
    </flux:navmenu>
</flux:dropdown>
