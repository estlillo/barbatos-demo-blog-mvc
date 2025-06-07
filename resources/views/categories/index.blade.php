<x-layouts.app :title="__('Categories')">
    <div class="flex items-center justify-between mb-4">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{route('home')}}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Categorías</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('categories.create') }}" variant="primary" wire:navigate>
            {{ __('Crear') }}
        </flux:button>
    </div>


    <!--<x-page-title :title="__('Categories')" :subtitle="__('Subtitulo para categories')" />-->
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $category->name }}
                    </th>

                    <td class="px-6 py-4 text-right">
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            <flux:button href="{{ route('categories.edit', $category) }}" wire:navigate>
                                {{ __('Editar') }}
                            </flux:button>
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="danger" onclick="event.preventDefault(); Swal.fire({
                                title: '{{ __('¿Estás seguro de que deseas eliminar la categoría :name?', ['name' => $category->name]) }}',
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

    </div>
</x-layouts.app>
