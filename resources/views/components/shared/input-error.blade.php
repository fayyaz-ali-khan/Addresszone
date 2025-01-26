@props(['field'])

@error($field)
    <div class="help-block with-errors">
        {{ $message }}
    </div>
@enderror
