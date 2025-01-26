<div class="card">
    <div class="card-header d-flex justify-content-between">
        <div class="header-title">
            <h4 class="card-title">Social links</h4>
        </div>
    </div>
    <div class="card-body">
        <p>Add Social links information</p>
        @if (isset($settings))
            <form method="POST" action="{{ route('admin.general_settings.update', $settings->id) }}">
                @method('PUT')
            @else
                <form method="POST" action="{{ route('admin.general_settings.store') }}">
        @endif

        @csrf
        <input type="hidden" name="type" value="social_links" id="">
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('social_links.facebook'),
        ])>
            <label for="email">Facebook:</label>
            <input name="social_links[facebook]"
                value="{{ old('social_links.facebook', $settings->social_links['facebook'] ?? '') }}" type="url"
                class="form-control" id="email1">
            @error('social_links.facebook')
                <div class="help-block with-errors">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('social_links.twitter'),
        ])>
            <label for="email">Twitter:</label>
            <input name="social_links[twitter]"
                value="{{ old('social_links.twitter', $settings->social_links['twitter'] ?? '') }}" type="url"
                class="form-control" id="email1">
            @error('social_links.twitter')
                <div class="help-block with-errors">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('social_links.instagram'),
        ])>
            <label for="email">Instagram:</label>
            <input name="social_links[instagram]"
                value="{{ old('social_links.instagram', $settings->social_links['instagram'] ?? '') }}" type="url"
                class="form-control" id="email1">
            @error('social_links.instagram')
                <div class="help-block with-errors">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('social_links.youtube'),
        ])>
            <label for="email">YouTube:</label>
            <input name="social_links[youtube]"
                value="{{ old('social_links.youtube', $settings->social_links['youtube'] ?? '') }}" type="url"
                class="form-control" id="email1">
            @error('social_links.youtube')
                <div class="help-block with-errors">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div @class([
            'form-group',
            'has-error has-danger' => $errors->has('social_links.pinterest'),
        ])>
            <label for="email">Pinterest:</label>
            <input name="social_links[pinterest]"
                value="{{ old('social_links.pinterest', $settings->social_links['pinterest'] ?? '') }}" type="url"
                class="form-control" id="email1">
            @error('social_links.pinterest')
                <div class="help-block with-errors">
                    {{ $message }}
                </div>
            @enderror
        </div>


        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
