@extends('admin.layout.app')

@section('main-content')
    <x-Admin.Shared.form-page-container title="Add New Service">
        <form action="{{ route('admin.services.store') }}" method="POST" data-toggle="validator" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <x-Admin.Shared.input-form-group label="Title *" name="title" value="{{ old('title') }}"
                        errorKey="title" />
                </div>
                <div class="col-md-4">
                    <x-Admin.Shared.input-form-group type="number" label="Price *" name="price"
                        value="{{ old('price') }}" errorKey="price" />
                </div>
                <div class="col-md-4">
                    <x-Admin.Shared.input-form-group type="number" label="Months *" name="months"
                        value="{{ old('months') }}" errorKey="months" />
                </div>
                <div class="col-md-4">
                    <div @class([
                        'form-group',
                        'has-error has-danger' => $errors->has('service_category_id'),
                    ])>
                        <label>Service Category</label>
                        <select name="service_category_id" class="form-control mb-3">
                            @foreach ($service_categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach

                        </select>
                        @error('service_category_id')
                            <div class="help-block with-errors">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="email">Image:</label>
                    <div @class([
                        'form-group',
                        'has-error has-danger' => $errors->has('image'),
                    ])>
                        <div class="custom-file">
                            <input name="image" type="file" class="custom-file-input p-1" id="customFile"
                                onchange="previewImage(event)">
                            <label style="height: 44px" class="custom-file-label selected" for="customFile">select
                                image</label>
                        </div>
                        @error('image')
                            <div class="help-block with-errors">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                <div class="col-4">
                    <div class="iq-avatar">
                        <img id="preview" class="avatar-100 rounded"
                            src="{{ asset('admin/images/image-placeholder.png') }}"
                            onclick="document.getElementById('customFile').click();" style="cursor: pointer;"alt="#"
                            data-original-title="" title="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div @class([
                        'form-group',
                        'has-error has-danger' => $errors->has('status'),
                    ])>
                        <label>Status</label>
                        <select name="status" class="form-control mb-3">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status')
                            <div class="help-block with-errors">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label for="description">Description</label>


                        <textarea id="editor1" name="description" required cols="30" rows="10">
                            {{ old('description') }}
                        </textarea>
                        <div class="invalid-feedback"></div>
                        @if ($errors->has('description'))
                            <div class="invalid-feedback" style="display:block;">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-primary mr-2">Add Service</button>
            <button type="reset" class="btn btn-danger">Reset</button>
        </form>
    </x-Admin.Shared.form-page-container>
@endsection

@push('js')
    <script src="{{ asset('assets/js/editor/simple-mde/simplemde.min.js') }}"></script>

    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/js/editor/ckeditor/ckeditor.custom.js') }}"></script>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
@endpush
