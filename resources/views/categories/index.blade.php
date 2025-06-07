<x-layouts.app :title="__('Categories')">
    <div class="flex items-center justify-between mb-4">
        <flux:breadcrumbs class="mb-4">
            <flux:breadcrumbs.item href="{{route('home')}}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Categorías</flux:breadcrumbs.item>
        </flux:breadcrumbs>
        <flux:button href="{{ route('categories.create') }}" variant="primary" >
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
                        <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-layouts.app>
