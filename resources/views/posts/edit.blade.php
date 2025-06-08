
<x-layouts.app :title="__('Editar publicación')">
    <div class="flex items-center justify-between mb-4">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{route('home')}}" wire:navigate>Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{route('posts.index')}}" wire:navigate>Publicaciones</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Editar</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('posts.index') }}" variant="primary" wire:navigate>
            {{ __('Volver') }}
        </flux:button>
    </div>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <form action="{{ route('posts.update', $post) }}" method="POST" class="w-full" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-6 space-y-6 relative mb-2">
                    {{-- Imagen actual o previsualización --}}
                    <img id="preview-image" class="w-full aspect-video object-center object-contain" src="{{ asset('images/no-image.png') }}" alt="Imagen actual">

                    {{-- Botón para subir --}}
                    <div class="absolute top-0 right-0 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-bl-lg">
                        <label class="cursor-pointer text-xs font-semibold">
                            {{ __('Cambiar imagen') }}
                            <input type="file" name="image" class="hidden" accept="image/*" onchange="previewSelectedImage(this)">
                        </label>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <flux:input name="title" :label="__('Título')" type="text" autofocus value="{{old('title', $post->title)}}" />
                    <flux:input name="slug" :label="__('Slug')" type="text" value="{{old('slug', $post->slug)}}" disabled/>
                    <flux:select name="category_id" :label="__('Categoría')" value="{{old('category_id', $post->category_id)}}">
                        <option value="">{{ __('Selecciona una Categoría') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>
                                {{ ucfirst($category->name) }}
                            </option>
                        @endforeach
                    </flux:select>
                    <flux:input name="excerpt" :label="__('Extracto')" type="text" value="{{old('excerpt', $post->excerpt)}}" />
                    <flux:textarea name="content" rows="15" :label="__('Contenido')">{{ old('content', $post->content) }}</flux:textarea>

                    <flux:radio.group name="is_published" label="¿Publicar ahora?" variant="segmented">
                        <flux:radio
                            icon="eye"
                            label="Publicar"
                            value="1"
                            :checked="(old('is_published', $post->is_published) == true)"
                        />
                        <flux:radio
                            icon="eye-slash"
                            label="No Publicar"
                            value="0"
                            :checked="(old('is_published', $post->is_published) == false)"
                        />
                    </flux:radio.group>
                </div>
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 text-right">
                    <flux:button type="submit" variant="primary">{{ __('Actualizar') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function previewSelectedImage(input) {
            const file = input.files[0];
            if (file) {
                const preview = document.getElementById('preview-image');
                preview.src = URL.createObjectURL(file);
            }
        }
    </script>
</x-layouts.app>
