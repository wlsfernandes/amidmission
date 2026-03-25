<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('admin.layouts.title-meta')
    @include('admin.layouts.head')
</head>

@section('body')

<body class="authentication-bg">
    @show
    @yield('content')
    @include('admin.layouts.vendor-scripts')
</body>

</html>