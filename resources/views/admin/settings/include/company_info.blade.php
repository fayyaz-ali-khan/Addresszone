<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Company Info</h4>
        </div>
    </div>
    <div class="card-body">
        <p>Add Company information</p>
        @if (isset($settings))
            <form method="POST" action="{{ route('admin.general_settings.update', $settings->id) }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('admin.general_settings.store') }}">
        @endif

        @csrf
        <input type="hidden" name="type" value="company_info">
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('company_name'),
        ])>
            <label for="email">Name:</label>
            <input name="company_name" value="{{ old('company_name', $settings->company_name ?? '') }}" type="text"
                class="form-control" id="email1">
            @error('company_name')
                <div class="help-block with-errors">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('address'),
        ])>
            <label for="exampleFormControlTextarea1"> Address</label>
            <textarea name="address" class="form-control" id="exampleFormControlTextarea1" rows="3">{{ old('address', $settings->address ?? '') }}</textarea>
            @error('address')
                <div class="help-block with-errors">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
