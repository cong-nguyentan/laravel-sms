<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>@yield('page.title')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- global css -->
    <link href="{!! asset('themes/josh/backend/css/all.min.css') !!}" rel="stylesheet" type="text/css" />
    <link href="{!! asset('css/backend.min.css') !!}" rel="stylesheet" type="text/css" />
    @yield('styles')
    <!-- end of global css -->
</head>

<body class="skin-josh">
    @include('layouts.backend.header')
    <div class="wrapper row-offcanvas row-offcanvas-left">
        @include('layouts.backend.sidebar_left')
        <aside class="right-side">
            <section class="content-header">
                <h1>@yield('page.top_title')</h1>
                @include('layouts.backend.breadcrumb')
            </section>
            <section class="content">
                @include('layouts.backend.notify')
                @yield('content')
            </section>
        </aside>
    </div>
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="plane-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
    </a>
    <!-- global js -->
    <script src="{!! asset('themes/josh/backend/js/all.min.js') !!}" type="text/javascript"></script>
    <script src="{!! asset('js/backend.js') !!}" type="text/javascript"></script>
    <!-- end of global js -->
    @yield('scripts')
</body>