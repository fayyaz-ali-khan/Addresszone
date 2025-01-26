<div @class([
    'form-group',
    'has-error has-danger' => $errors->has($errorKey),
])>
    <label for="{{ $name }}">{{ $label }}</label>
    <input name="{{ $name }}" value="{{ $value }}" type="{{ $type }}" class="form-control"
        id="{{ $name }}">
    @error($errorKey)
        <div class="help-block with-errors">
            {{ $message }}
        </div>
    @enderror
</div>
