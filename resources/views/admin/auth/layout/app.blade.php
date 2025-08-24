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
    <style>
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0 1000px white inset !important;
            box-shadow: 0 0 0 1000px white inset !important;
            /* -webkit-text-fill-color: #000 !important; */
        }
    </style>
</head>

<body class=" ">
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->

    @yield('main-content')

    <!-- Backend Bundle JavaScript -->
    <script src="{{ asset('admin/js/backend-bundle.min.js') }}"></script>

    <!-- Table Treeview JavaScript -->
    <script src="{{ asset('admin/js/table-treeview.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script src="{{ asset('admin/js/customizer.js') }}"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="{{ asset('admin/js/chart-custom.js') }}"></script>

    <!-- app JavaScript -->
    <script src="{{ asset('admin/js/app.js') }}"></script>
</body>

</html>
