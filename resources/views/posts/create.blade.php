<x-layouts.app :title="__('Crear publicación')">
    <div class="flex items-center justify-between mb-4">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{route('home')}}" wire:navigate>Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{route('posts.index')}}" wire:navigate>Publicaciones</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Crear</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('posts.index') }}" variant="primary" wire:navigate>
            {{ __('Volver') }}
        </flux:button>
    </div>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <form action="{{ route('posts.store') }}" method="POST" class="w-full">
                @csrf
                <div class="p-6 space-y-6">
                    <flux:input name="title" :label="__('Título')" type="text" autofocus value="{{old('title')}}" />
                    <flux:select name="category_id" :label="__('Categoría')" value="{{old('category_id')}}">
                        <option value="">{{ __('Selecciona una Categoría') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ ucfirst($category->name) }}</option>
                        @endforeach
                    </flux:select>
                    <flux:input name="excerpt" :label="__('Extracto')" type="text" value="{{old('excerpt')}}" />
                    <x-rich-text
                        name="content"
                        :label="__('Contenido')"
                    />
                    <flux:radio.group name="is_published" label="¿Publicar ahora?" variant="segmented" value="{{ old('is_published', 1) }}">
                        <flux:radio icon="eye" label="Publicar" value="1" checked/>
                        <flux:radio icon="eye-slash" label="No Publicar" value="0" />
                    </flux:radio.group>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 text-right">
                    <flux:button type="submit" variant="primary">{{ __('Guardar') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
