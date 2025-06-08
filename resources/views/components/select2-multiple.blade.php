<div class="mb-4">
    @if($label)
        <label for="{{ $id }}"
               class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">
            {{ $label }}
        </label>
    @endif

    <select
        id="{{ $id }}"
        name="{{ $name }}[]"
        multiple
        class="select2 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 {{ $class }}"
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
