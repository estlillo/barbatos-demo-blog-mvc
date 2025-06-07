<x-layouts.app :title="__('Crear categoría')">
    <div class="flex items-center justify-between mb-4">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{route('home')}}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{route('categories.index')}}">Categorías</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Crear</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('categories.index') }}" variant="primary" wire:navigate>
            {{ __('Volver') }}
        </flux:button>
    </div>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <form action="{{ route('categories.store') }}" method="POST" class="w-full">
                @csrf
                <div class="p-6 space-y-6">
                    <flux:input name="name" :label="__('Nombre')" type="text" autofocus value="{{old('name')}}" />
                    <flux:textarea name="description" :label="__('Descripción')" />
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 text-right">
                    <flux:button type="submit" variant="primary">{{ __('Guardar') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
