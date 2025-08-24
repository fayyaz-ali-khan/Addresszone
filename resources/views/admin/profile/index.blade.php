@extends('admin.layout.app')

@section('main-content')
    <div class="content-page">
        <div class="container-fluid add-form-list">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">Profile</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.profile.update', $user->id) }}" method="POST"
                                data-toggle="validator" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-Admin.Shared.input-form-group label="Name *" name="name"
                                            value="{{ old('name', $user->name) }}" errorKey="name" />

                                    </div>
                                    <div class="col-md-6">
                                        <x-Admin.Shared.input-form-group label="User Name *" name="username"
                                            value="{{ old('username', $user->username) }}" errorKey="username" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-Admin.Shared.input-form-group label="email *" name="email" type="email"
                                            value="{{ old('email', $user->email) }}" errorKey="email" />
                                    </div>
                                    <div class="col-md-6">

                                        <x-Admin.Shared.input-form-group label="Current Password *" type="password"
                                            name="current_password" errorKey="current_password" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-Admin.Shared.input-form-group label="New Password" name="password"
                                            type="password" errorKey="password" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-Admin.Shared.input-form-group label="Confirm Password"
                                            name="password_confirmation" errorKey="password_confirmation" type="password" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">Profile Image:</label>
                                        <div @class([
                                            'form-group',
                                            'has-error has-danger' => $errors->has('image'),
                                        ])>
                                            <div class="custom-file">
                                                <input name="image" type="file" accept="image/*"
                                                    class="custom-file-input" id="customFile">
                                                <label class="custom-file-label selected"
                                                    for="customFile">{{ isset($user) ? substr($user->image, 0, 24) : 'select logo' }}</label>
                                            </div>
                                            @error('image')
                                                <div class="help-block with-errors">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary mr-2">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Page end  -->
        </div>
    </div>
@endsection
