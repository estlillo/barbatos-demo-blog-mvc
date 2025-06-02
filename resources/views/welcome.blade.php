<x-layouts.app>

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">



    <p class="text-center text-lg">
        {{ __('Welcome!') }}
    </p>
        @auth
            <p class="text-center text-lg">
                {{ auth()->user()->name }}
            </p>
        @else
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
        @endauth
        <p class="text-center text-sm text-gray-500">
            {{ __('Feel free to explore and enjoy your stay.') }}
        </p>
    </div>
</x-layouts.app>
