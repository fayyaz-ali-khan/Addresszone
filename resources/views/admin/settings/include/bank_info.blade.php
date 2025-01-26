<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Bank Info</h4>
        </div>
    </div>
    <div class="card-body">
        <p>Add Bank information</p>
        @if (isset($settings))
            <form method="POST" action="{{ route('admin.general_settings.update', $settings->id) }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('admin.general_settings.store') }}">
        @endif
        @csrf
        <input type="hidden" name="type" value="bank_details">
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('social_links.facebook'),
        ])>
            <label for="email">Account Title:</label>
            <input name="bank_details[account_title]"
                value="{{ old('bank_details.account_title', $settings->bank_details['account_title'] ?? '') }}"
                type="text" class="form-control" id="email1">
            @error('bank_details.account_title')
                <div class="help-block with-errors">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('social_links.facebook'),
        ])>
            <label for="email">Account Number:</label>
            <input name="bank_details[account_number]"
                value="{{ old('bank_details.account_number', $settings->bank_details['account_number'] ?? '') }}"
                type="number" class="form-control" id="email1">
            @error('bank_details.account_number')
                <div class="help-block with-errors">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('social_links.facebook'),
        ])>
            <label for="email">Bank Name:</label>
            <input name="bank_details[bank_name]"
                value="{{ old('bank_details.bank_name', $settings->bank_details['bank_name'] ?? '') }}" type="text"
                class="form-control" id="email1">
            @error('bank_details.bank_name')
                <div class="help-block with-errors">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('social_links.facebook'),
        ])>
            <label for="email">Bank Code:</label>
            <input name="bank_details[bank_code]"
                value="{{ old('bank_details.bank_code', $settings->bank_details['bank_code'] ?? '') }}" type="text"
                class="form-control" id="email1">
            @error('bank_details.bank_code')
                <div class="help-block with-errors">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
