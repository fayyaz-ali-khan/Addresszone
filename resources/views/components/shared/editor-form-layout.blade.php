@props(['type', 'settings'])


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">{{ $type }}</h4>
                </div>
            </div>
            <div class="card-body">
                @if ($settings != '')
                    <form id="{{ $type }}" method="POST"
                        action="{{ route('admin.general_settings.update', $settings->id) }}">
                        @method('PUT')
                    @else
                        <form id="{{ $type }}" method="POST"
                            action="{{ route('admin.general_settings.store') }}">
                @endif

                @csrf
                <input type="hidden" name="{{ $type }}" id="{{ $type }}-content">
                <input type="hidden" name="type" value="{{ $type }}">

                <!-- Quill editor container -->
                <div id="{{ $type }}_editor" style="height: 150px;">
                    {!! old($type, $settings[$type] ?? '') !!}
                </div>
                <x-shared.input-error field="about" />

                <button type="submit" class="btn btn-primary mt-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        const quill_{{ $type }} = new Quill('#{{ $type }}_editor', {
            theme: 'snow',
        });

        document.getElementById('{{ $type }}').addEventListener('submit', function(e) {
            const editorContent = quill_{{ $type }}.root.innerHTML;
            document.getElementById('{{ $type }}-content').value = editorContent;
        });
    </script>
@endpush
