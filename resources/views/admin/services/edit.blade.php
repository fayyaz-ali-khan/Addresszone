@extends('admin.layout.app')
<style>
    .cke_chrome {
        border-radius: 10px !important;
        border: 1px solid #695656 !important;
        border-width: thin !important;
    }

    .cke_top {
        border-radius: 10px 10px 0px 0px !important;
    }

    .cke_bottom {
        border-radius: 0px 0px 10px 10px !important;
    }
</style>
@section('main-content')
    <x-Admin.Shared.form-page-container title="Edit Service">
        <form action="{{ route('admin.services.update', $service->id) }}" method="POST" id="service-form"
            class="form-horizontal" data-toggle="validator" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <x-Admin.Shared.input-form-group label="Title *" name="title"
                        value="{{ old('title', $service->title) }}" errorKey="title" />
                </div>
                <div class="col-md-4">
                    <x-Admin.Shared.input-form-group type="number" label="Price *" name="price"
                        value="{{ old('price', $service->price) }}" errorKey="price" />
                </div>
                <div class="col-md-4">
                    <x-Admin.Shared.input-form-group type="number" label="Months *" name="months"
                        value="{{ old('months', $service->months) }}" errorKey="months" />
                </div>
                <div class="col-md-4">
                    <div @class([
                        'form-group',
                        'has-error has-danger' => $errors->has('service_category_id'),
                    ])>
                        <label>Service Category</label>
                        <select name="service_category_id" class="form-control mb-3">
                            @foreach ($service_categories as $category)
                                <option value="{{ $category->id }}" @selected(old('service_category_id', $service->service_category_id) == $category->id)>{{ $category->name }}
                                </option>
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
                            <input name="image" type="file" accept="image/*" class="custom-file-input p-1"
                                id="customFile" onchange="previewImage(event)">
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
                        <img id="preview" class="avatar-100 rounded" src="{{ asset('storage/' . $service->image) }}"
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
                            {{ old('description', $service->description) }}
                        </textarea>
                        <div class="invalid-feedback"></div>
                        @if ($errors->has('description'))
                            <div class="invalid-feedback" style="display:block;">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                </div>

            </div>
            <button type="submit" class="btn btn-primary mr-2">Update Service</button>
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
