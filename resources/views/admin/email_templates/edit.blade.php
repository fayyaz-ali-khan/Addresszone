@extends('admin.layout.app')


@section('main-content')
    <x-Admin.Shared.form-page-container title="Edit Email Template">
        <form id="email-template-form" action="{{ route('admin.email_templates.update', $emailTemplate->id) }}" method="POST"
            enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row">
                <div class="col-6">
                    <x-Admin.Shared.input-form-group label="Subject *" name="subject"
                        value="{{ old('subject', $emailTemplate->subject) }}" errorKey="subject" />

                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Category</label>
                        <select id="category" name="category" class="form-control mb-3">
                            <option value="">-- Select category ---</option>
                            @foreach ($available_categories as $value)
                                <option value="{{ $value }}" @selected(old('category', $emailTemplate->category) == $value)>
                                    {{ ucwords(str_replace('_', ' ', $value)) }}</option>
                            @endforeach

                        </select>
                    </div>

                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Status</label>
                        <select id="status" name="status" class="form-control mb-3">
                            <option value="1" @selected(old('status', $emailTemplate->status) == 1)>Active</option>
                            <option value="0" @selected(old('status', $emailTemplate->status) == 0)>Inactive</option>
                        </select>
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" name="body" id="body_editor-content">
                    <label>Body *</label>
                    <div id="body_editor" style="height: 150px;">
                        {!! old('body', $emailTemplate->body) !!}
                    </div>
                    <x-Shared.input-error field="body" />

                </div>
            </div>
            <span class="d-flex justify-content-between w-100">
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
                <span id="tags" class="text-muted"></span>
            </span>
        </form>
    </x-Admin.Shared.form-page-container>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            const quill_body_editor = new Quill('#body_editor', {
                theme: 'snow',
            });

            document.getElementById('email-template-form').addEventListener('submit', function(e) {
                const editorContent = quill_body_editor.root.innerHTML;
                document.getElementById('body_editor-content').value = editorContent;
            });
            // Tags of selected category

            let template = @js($emailTemplate->category);
            let tags = @json($templates_categories);
            tags = tags[template];
            tags = tags.map((item) => `{ ${item} }`);
            tags = tags.join(', ');
            $('#tags').text('Available tags: ' + tags);

            $('#category').on('change', function() {
                if ($(this).val() == '') {
                    $('#tags').text('');
                    return;
                }
                let tags = @json($templates_categories);
                tags = tags[$(this).val()];
                tags = tags.map((item) => `{ ${item} }`);
                tags = tags.join(', ');
                $('#tags').text('Available tags: ' + tags);
            });
        })
    </script>
@endpush
