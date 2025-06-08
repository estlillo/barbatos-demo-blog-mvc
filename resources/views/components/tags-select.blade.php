<div class="mb-4">
    <label for="tags" class="block text-sm font-medium text-gray-900 mb-1">
        {{ $label ?? __('Etiquetas') }}
    </label>

    <select id="tags" name="tags[]" multiple
            class="select2 w-full shadow-xs"
    >
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}"
                @selected(in_array($tag->id, old('tags', $selected ?? [])))
            >
                {{ ucfirst($tag->name) }}
            </option>
        @endforeach
    </select>

    @error('tags')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    @once
        @push('styles')
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        @endpush

        @push('scripts')
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"
                    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
                    crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#tags').select2({
                        placeholder: "Selecciona etiquetas",
                        tags: true,
                        tokenSeparators: [',', ' '],
                        theme: 'classic',
                        width: '100%',
                        allowClear: true,
                    });
                });
            </script>
        @endpush
    @endonce
</div>
