<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $general_settings->site_name ?? 'AddressZone' }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon"
        href="{{ asset(isset($general_settings->logo) ? 'storage/' . $general_settings?->favicon : 'admin/images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/backend-plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/backend.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendor/remixicon/fonts/remixicon.css') }}">
    @stack('css')
</head>

<body class="  ">
    <!-- loader Start -->
    @include('admin.layout.include.loader')
    <!-- loader END -->
    <!-- Wrapper Start -->
    <div class="wrapper">
        <div class="container">
            <div class="row no-gutters height-self-center">
                <div class="col-sm-12 text-center align-self-center">
                    <div class="iq-error position-relative">
                        <img src="{{ asset('admin/images/error/404.png') }}" class="img-fluid iq-error-img"
                            alt="">
                        <h2 class="mb-0 mt-4">Oops! This Page is Not Found.</h2>
                        <p>The requested page dose not exist.</p>
                        <a class="btn btn-primary d-inline-flex align-items-center mt-3" href="index.html"><i
                                class="ri-home-4-line"></i>Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content -->
    @yield('main-content')
    </div>
    <!-- Wrapper End-->
    @include('admin.layout.include.footer')
    @include('admin.layout.include.js')
    @stack('js')
</body>

</html>
