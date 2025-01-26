<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Basic Info</h4>
        </div>
    </div>
    <div class="card-body">
        <p>Add site basic information</p>
        @if (isset($settings))
            <form method="POST" action="{{ route('admin.general_settings.update', $settings->id) }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('admin.general_settings.store') }}">
        @endif

        @csrf


        <input type="hidden" name="type" value="basic_info">
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('site_name'),
        ])>
            <label for="email">Title:</label>
            <input name="site_name" value="{{ old('site_name', $settings->site_name ?? '') }}" type="text"
                class="form-control" id="email1">
            <x-shared.input-error field="site_name" />


        </div>
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('email'),
        ])>
            <label for="email">Email:</label>
            <input name="email" value="{{ old('email', $settings->email ?? '') }}" type="phone" class="form-control"
                id="email1">
            <x-shared.input-error field="email" />

        </div>
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('phone'),
        ])>
            <label for="email">Phone:</label>
            <input name="phone" value="{{ old('phone', $settings->phone ?? '') }}" type="phone" class="form-control"
                id="email1">
            <x-shared.input-error field="phone" />

        </div>
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('alternate_phone'),
        ])>
            <label for="email">Alternate Phone:</label>
            <input name="alternate_phone" value="{{ old('alternate_phone', $settings->alternate_phone ?? '') }}"
                type="phone" class="form-control" id="email1">
            <x-shared.input-error field="alternate_phone" />

        </div>
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('copyright'),
        ])>
            <label for="email">Copyright:</label>
            <input name="copyright" value="{{ old('copyright', $settings->copyright ?? '') }}" type="text"
                class="form-control" id="email1">
            <x-shared.input-error field="copyright" />

        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
