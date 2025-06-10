<x-layouts.app :title="__('Dashboard')">
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 space-y-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Panel de administración</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total publicaciones -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="text-sm text-gray-500 dark:text-gray-300">Total de publicaciones</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Post::count() }}</div>
            </div>

            <!-- Usuarios registrados -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="text-sm text-gray-500 dark:text-gray-300">Usuarios registrados</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\User::count() }}</div>
            </div>

            <!-- Publicaciones hoy -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="text-sm text-gray-500 dark:text-gray-300">Publicaciones hoy</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ \App\Models\Post::whereDate('created_at', today())->count() }}
                </div>
            </div>

            <!-- Categorías -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="text-sm text-gray-500 dark:text-gray-300">Categorías activas</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ \App\Models\Category::count() }}</div>
            </div>
        </div>

        <div class="mt-10">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Últimas publicaciones</h2>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach(\App\Models\Post::latest()->take(5)->get() as $post)
                    <li class="py-4 flex justify-between items-center">
                        <div>
                            <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $post->title }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Por {{ $post->user->name }} · {{ $post->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <a href="{{ route('posts.show', ['post' => $post, 'from' => request()->fullUrl()]) }}" class="text-blue-500 text-sm hover:underline">
                            Ver
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layouts.app>
