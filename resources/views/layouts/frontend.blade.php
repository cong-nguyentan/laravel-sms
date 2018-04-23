<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page.title')</title>
    <!--global css starts-->
    <link rel="shortcut icon" href="{!! asset('themes/josh/frontend/images/favicon.png') !!}" type="image/x-icon">
    <link rel="icon" href="{!! asset('themes/josh/frontend/images/favicon.png') !!}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="{!! asset('themes/josh/frontend/css/all.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('css/frontend.min.css') !!}">
    <!--end of global css-->
    @yield('styles')
</head>
<body>
    <!-- Header Start -->
    @include('layouts.frontend.header')
    <!-- //Header End -->
    @yield('content')
    <!-- Footer Section Start -->
    @include('layouts.frontend.footer')
    <!-- Footer Section End -->
    <!--global js starts-->
    <script type="text/javascript" src="{!! asset('themes/josh/frontend/js/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('themes/josh/frontend/js/bootstrap.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('themes/josh/frontend/js/all.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('js/frontend.js') !!}"></script>
    <!--global js end-->
    @yield('scripts')
</body>