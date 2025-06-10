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
        <div class="mt-10">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Comentarios ({{ $post->comments->count() }})</h3>
            {{-- Formulario --}}
            @auth
                <form action="{{ route('comments.store', $post) }}" method="POST" class="space-y-4 mb-6">
                    @csrf
                    <textarea name="content" rows="3"
                              class="w-full p-3 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                              placeholder="Escribe tu comentario..."></textarea>
                    <flux:button
                        type="submit"
                        variant="primary"
                    >
                        {{ __('Comentar') }}
                    </flux:button>
                </form>
            @else
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Debes <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 underline">iniciar sesión</a> para comentar.
                </p>
            @endauth

            {{-- Lista de comentarios --}}
            @forelse($post->comments as $comment)
                <div class="border-t pt-4 mt-4 border-gray-200 dark:border-gray-700">
                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                        {{ $comment->user->name }}
                    </p>
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $comment->content }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $comment->created_at->diffForHumans() }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-gray-600 dark:text-gray-400">Todavía no hay comentarios.</p>
            @endforelse
        </div>

        {{-- Botón de regreso --}}
        <div class="pt-6">
            <a href="{{ request('from') ?? route('home') }}"
               class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                ← Volver
            </a>

        </div>

    </div>

</x-layouts.app>
