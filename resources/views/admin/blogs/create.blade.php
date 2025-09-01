@extends('admin.layout.app')


@section('main-content')
    <x-Admin.Shared.form-page-container title="Create New Blog">
        <form id="email-template-form" action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <x-Admin.Shared.input-form-group label="Title *" name="title" value="{{ old('title') }}"
                        errorKey="subject" />

                </div>

            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Category</label>
                        <select id="category" name="category" class="form-control mb-3">
                            <option value="">-- Select category ---</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category') == $category->id)>{{ $category->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                </div>

                <div class="col-3">
                    <div class="form-group">
                        <label>Status</label>
                        <select id="status" name="status" class="form-control mb-3">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <input type="hidden" name="body" id="body_editor-content">
                    <label>Body *</label>
                    <div id="body_editor" style="height: 150px;">
                        {!! old('body') !!}
                    </div>
                    <x-Shared.input-error field="body" />

                </div>
            </div>
            <div class="col-3 mt-2">
                <input type="file" name="image" class="custom-file-input" accept="image/*" id="customFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
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
            $('#category').on('change', function() {
                if ($(this).val() == '') {
                    $('#tags').text('');
                    return;
                }

            });
        })
    </script>
@endpush
