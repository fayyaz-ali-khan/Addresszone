<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>POS Dash | Responsive Bootstrap 4 Admin Dashboard Template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.ico') }}" />
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

        <!-- Sidebar -->
        @include('admin.layout.include.sidebar')
        <!-- Navbar -->
        @include('admin.layout.include.navbar')

        <div class="modal fade" id="new-order" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="popup text-left">
                            <h4 class="mb-3">New Order</h4>
                            <div class="content create-workform bg-body">
                                <div class="pb-3">
                                    <label class="mb-2">Email</label>
                                    <input type="text" class="form-control" placeholder="Enter Name or Email">
                                </div>
                                <div class="col-lg-12 mt-4">
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                        <div class="btn btn-primary mr-4" data-dismiss="modal">Cancel</div>
                                        <div class="btn btn-outline-primary" data-dismiss="modal">Create</div>
                                    </div>
                                </div>
                            </div>
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
