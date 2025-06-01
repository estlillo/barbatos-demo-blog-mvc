<button type="button" class="group flex items-center rounded-lg has-data-[circle=true]:rounded-full [ui-dropdown>&]:w-full p-1 hover:bg-zinc-800/5 dark:hover:bg-white/10" data-flux-profile>
    {{ $name ?? __('Nombre de menú') }}
    <div class="shrink-0 ms-auto size-8 flex justify-center items-center">
        <flux:icon icon="chevron-down" variant="outline" class="size-4" />
    </div>
</button>
