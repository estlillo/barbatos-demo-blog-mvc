<x-layouts.app :title="__('Inicio')">

    <div class="max-w-3xl mx-auto py-8 space-y-6">
        <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
            @guest
                <nav class="flex items-center justify-center gap-4">
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                    >
                        Log in
                    </a>
                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif
                </nav>
            @endguest
        </div>
        @foreach($posts as $post)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 sm:p-6 space-y-3">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between text-sm text-gray-500 dark:text-gray-400 gap-2">
                    <div>
                        <span class="font-semibold">{{ $post->user->name }}</span>
                        ·
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs rounded mt-1 sm:mt-0">
            {{ $post->category->name ?? 'Sin categoría' }}
        </span>
                </div>

                <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white break-words">
                    {{ $post->title }}
                </h2>

                @if($post->image_path)
                    <img src="{{ route('file.download', $post->image_path) }}" alt="Imagen" class="w-full aspect-video object-cover rounded-lg">
                @endif

                <p class="text-gray-700 dark:text-gray-300 break-words">
                    {{ $post->excerpt }}
                </p>

                <div class="prose dark:prose-invert max-w-none">
                    {!! Str::limit($post->content, 300, '...') !!}
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center text-sm text-gray-500 dark:text-gray-400 gap-2">
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                    <a href="{{ route('posts.show', ['post' => $post, 'from' => request()->fullUrl()]) }}" class="mt-2 sm:mt-0">
                        Leer más →
                    </a>
                </div>
                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs block w-fit mt-2">
                    {{ $post->comments->count() }} comentario{{ $post->comments_count === 1 ? '' : 's' }}
                </span>
            </div>
        @endforeach

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>

</x-layouts.app>
