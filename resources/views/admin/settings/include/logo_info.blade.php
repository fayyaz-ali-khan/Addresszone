<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Logo Info</h4>
        </div>
    </div>
    <div class="card-body">
        <p>Add site Logo/Favicon information</p>
        @if (isset($settings))
            <form method="POST" action="{{ route('admin.general_settings.update', $settings->id) }}"
                enctype="multipart/form-data">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('admin.general_settings.store') }}" enctype="multipart/form-data">
        @endif
        @csrf
        <input type="hidden" name="type" value="logo">

        <div>
            <label for="email">Logo:</label>
            <div @class(['form-group', 'has-error has-danger' => $errors->has('logo')])>
                <div class="custom-file">
                    <input name="logo" type="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label selected"
                        for="customFile">{{ isset($settings) ? substr($settings->logo, 0, 24) : 'select logo' }}</label>
                </div>
                @error('logo')
                    <div class="help-block with-errors">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>
        <div>
            <label for="email">Favicon:</label>
            <div @class([
                'form-group',
                'has-error has-danger' => $errors->has('favicon'),
            ])>
                <div class="custom-file">
                    <input name="favicon" type="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label selected"
                        for="customFile">{{ isset($settings) ? substr($settings->favicon, 0, 24) : 'select favicon' }}</label>
                </div>
                @error('favicon')
                    <div class="help-block with-errors">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
