@extends('admin.auth.layout.app')


@section('main-content')
    <div class="wrapper">
        <section class="login-content">
            <div class="container">
                <div class="row align-items-center justify-content-center height-self-center">
                    <div class="col-lg-8">
                        <div class="card auth-card">
                            <div class="card-body p-0">
                                <div class="d-flex align-items-center auth-content">
                                    <div class="col-lg-7 align-self-center">
                                        <div class="p-3">
                                            <h2 class="mb-2">Reset Password</h2>
                                            <p>Here enter your new password.</p>
                                            @if ($errors->any())
                                                @foreach ($errors->all() as $error)
                                                    <p>{{ $error }}</p>
                                                @endforeach
                                            @endif
                                            <form action="{{ route('admin.update-password') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="token" value="{{ $token ?? '' }}"
                                                    id="">
                                                <div class="row mb-0">

                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input name="email" autocomplete="off"
                                                                class="floating-input form-control" type="email">
                                                            <label>Email</label>
                                                            @error('email')
                                                                <p class="text-danger mt-0 p-0">{{ $message }}</p>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input name="password" autocomplete="off"
                                                                class="floating-input form-control" type="password">
                                                            <label>Password</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 mb-0">
                                                        <div class="floating-label form-group">
                                                            <input name="password_confirmation" autocomplete="off"
                                                                class="floating-input form-control" type="password">
                                                            <label>Confirm Password</label>
                                                        </div>
                                                    </div>


                                                </div>
                                                @error('password')
                                                    <p class="text-danger mt-0 p-0">{{ $message }}</p>
                                                @enderror
                                                <button type="submit" class="btn btn-primary">Update Password</button>
                                                <p class="mt-3">
                                                    Login to Account <a href="{{ route('admin.login') }}"
                                                        class="text-primary">Sign
                                                        In</a>
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 content-right">
                                        <img src="{{ asset('admin/images/login/01.png') }}" class="img-fluid image-right"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            window.onload = function() {
                                // document.querySelectorAll('input').forEach(input => input.value = '');
                            };
                        </script>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
