<x-layouts.app :title="__('Inicio')">

    <div class="max-w-3xl mx-auto py-8 space-y-6">
        @foreach($posts as $post)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 space-y-3">
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

                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ $post->title }}
                </h2>

                @if($post->image_path)
                    <img src="{{ route('file.download', $post->image_path) }}" alt="Imagen" class="w-full aspect-video object-cover rounded-lg">
                @endif

                <p class="text-gray-700 dark:text-gray-300">
                    {{ $post->excerpt }}
                </p>

                <div class="prose dark:prose-invert max-w-none">
                    {!! Str::limit($post->content, 300, '...') !!}
                </div>

                <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex gap-2">
                        @foreach($post->tags as $tag)
                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>

                    <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline dark:text-blue-400">
                        Leer más →
                    </a>
                </div>
            </div>
        @endforeach

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>

</x-layouts.app>
