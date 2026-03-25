<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('admin.layouts.title-meta')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"
        integrity="sha512-/1cUFB..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('/assets/admin/css/bootstrap.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/admin/css/icons.css') }}" id="icons-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/admin/css/app.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/assets/admin/css/custom-admin.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    @yield('css')
</head>

@section('body')

    <body>
    @show

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.topbar')
        @include('admin.layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('admin.layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('admin.layouts.right-sidebar')
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('/assets/admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/metismenu/metismenu.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/node-waves/node-waves.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/libs/jquery-counterup/jquery-counterup.min.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/editor.js') }}"></script>
    <script src="{{ asset('/assets/admin/js/app.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/super-build/ckeditor.js"></script>
    <script src="{{ asset('assets/admin/js/ckeditor-init.js') }}"></script>


    @yield('script')
    @yield('script-bottom')

</body>

</html>
