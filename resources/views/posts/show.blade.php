<x-layouts.app :title="$post->title">

    <div class="max-w-3xl mx-auto py-10 space-y-6">

        {{-- Encabezado con autor, categoría y fecha --}}
        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400">
            <div>
                <span class="font-semibold">{{ $post->user->name }}</span>
                ·
                <span>{{ $post->created_at->diffForHumans() }}</span>
            </div>
            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs rounded">
                {{ $post->category->name ?? 'Sin categoría' }}
            </span>
        </div>

        {{-- Título --}}
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            {{ $post->title }}
        </h1>

        {{-- Imagen destacada --}}
        @if ($post->image_path)
            <img src="{{ route('file.download', $post->image_path) }}"
                 alt="Imagen de {{ $post->title }}"
                 class="w-full aspect-video object-cover rounded-lg shadow">
        @endif

        {{-- Etiquetas --}}
        @if ($post->tags->count())
            <div class="flex flex-wrap gap-2 text-sm text-gray-500 dark:text-gray-400">
                @foreach ($post->tags as $tag)
                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">
                        #{{ $tag->name }}
                    </span>
                @endforeach
            </div>
        @endif

        {{-- Contenido en HTML --}}
        <div class="prose dark:prose-invert max-w-none">
            {!! $post->content !!}
        </div>

        {{-- Botón de regreso --}}
        <div class="pt-6">
            <a href="{{ route('home') }}"
               class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                ← Volver a publicaciones
            </a>
        </div>

    </div>

</x-layouts.app>
