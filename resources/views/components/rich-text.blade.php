@props([
    'name',
    'label' => null,
    'value' => '',
    'height' => '300px',
    'placeholder' => 'Escribe el contenido aquí...'
])

<div>
    @if ($label)
        <p class="font-medium text-sm mb-2">{{ $label }}</p>
    @endif

    <div id="editor-{{ $name }}" class="quill-editor">
        {!! old($name, $value) !!}
    </div>

    <textarea name="{{ $name }}" id="textarea-{{ $name }}" class="hidden">{{ old($name, $value) }}</textarea>
</div>

@push('scripts')
    <script>
        function initQuillEditor(name, placeholder, height) {
            const container = document.getElementById(`editor-${name}`);
            const hiddenField = document.getElementById(`textarea-${name}`);

            if (container && !container.classList.contains('quill-initialized')) {
                container.style.minHeight = height;
                const quill = new Quill(container, {
                    theme: 'snow',
                    placeholder: placeholder,
                });

                quill.on('text-change', function () {
                    hiddenField.value = quill.root.innerHTML;
                });

                container.classList.add('quill-initialized');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            initQuillEditor(@json($name), @json($placeholder), @json($height));
        });

        document.addEventListener('livewire:navigated', () => {
            initQuillEditor(@json($name), @json($placeholder), @json($height));
        });
    </script>
@endpush
