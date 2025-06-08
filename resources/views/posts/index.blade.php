<x-layouts.app :title="__('Publicaciones')">

    <div class="flex items-center justify-between mb-4">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{route('home')}}" wire:navigate>Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Publicaciones</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('posts.create') }}" variant="primary" wire:navigate>
            {{ __('Crear') }}
        </flux:button>
    </div>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Título
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Categoría
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Autor
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha de publicación
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Fecha de creación
                    </th>

                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Acciones</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $post)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $post->title }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $post->category->name ?? __('Sin categoría') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $post->user->name ?? __('Desconocido') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($post->is_published && $post->published_at)
                            <span title="{{ $post->published_at->translatedFormat('l d \d\e F \d\e Y H:i') }}">
                                {{ $post->published_at->diffForHumans() }}
                            </span>
                        @else
                            <flux:badge variant="solid" color="amber">{{ __('No publicado') }}</flux:badge>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                       <span title="{{ $post->created_at->translatedFormat('l d \d\e F \d\e Y H:i') }}">
                           {{ $post->created_at->diffForHumans() }}
                       </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            <flux:button href="{{ route('posts.edit', $post) }}" wire:navigate>
                                {{ __('Editar') }}
                            </flux:button>
                        </a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="danger" onclick="event.preventDefault(); Swal.fire({
                                title: '{{ __('¿Estás seguro de que deseas eliminar la publicación :title?', ['title' => $post->title]) }}',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: '{{ __('Aceptar') }}',
                                cancelButtonText: '{{ __('Cancelar') }}'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    this.closest('form').submit();
                                }
                            });">
                                {{ __('Eliminar') }}

                        </flux:button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $posts->links() }}
        </div>
    </div>
</x-layouts.app>

