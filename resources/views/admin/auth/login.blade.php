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
                                            <h2 class="mb-2">Sign In</h2>
                                            <p>Login to stay connected.</p>
                                            <form action="{{ route('admin.store-login') }}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-lg-12">

                                                        <div class="floating-label form-group">
                                                            <input name="email" class="floating-input form-control"
                                                                autocomplete="off" value="{{ old('email') }}">
                                                            <label>Email</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="floating-label form-group">
                                                            <input name="password" autocomplete="off"
                                                                class="floating-input form-control" type="password">
                                                            <label>Password</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="custom-control custom-checkbox mb-3">
                                                            <input name="remember_me" type="checkbox"
                                                                class="custom-control-input" id="customCheck1">
                                                            <label class="custom-control-label control-label-1"
                                                                for="customCheck1">Remember Me</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <a href="{{ route('admin.forgot-password') }}"
                                                            class="text-primary float-right">Forgot Password?</a>
                                                    </div>

                                                </div>
                                                @error('email')
                                                    <p class="text-danger"> {{ $message }}</p>
                                                @enderror
                                                <button type="submit" class="btn btn-primary">Sign In</button>

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
