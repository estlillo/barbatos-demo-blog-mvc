<div class="mb-4">
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-900 mb-1">
            {{ $label }}
        </label>
    @endif

    <select id="{{ $id }}" name="{{ $name }}[]" multiple
            class="select2 w-full shadow-xs {{ $class }}"
    >
        @foreach($options as $option)
            <option value="{{ $option[$textField] }}"
                @selected(in_array($option[$valueField], old($name, $selected)))
            >
                {{ $option[$textField] }}
            </option>
        @endforeach
    </select>


    @error($name)
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    @once
        @push('scripts')
            <script>
                $(document).ready(function () {
                    $('#{{ $id }}').select2({
                        placeholder: "{{ $placeholder }}",
                        tags: {{ $tags ? 'true' : 'false' }},
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
