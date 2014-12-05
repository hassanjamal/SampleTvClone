<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', Config::get('site.title'))</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    @yield('meta')

    <!-- stylesheets -->
    <link href="/backend/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/backend/bootstrap/css/plugins/metisMenu/metisMenu.css" rel="stylesheet">
    <link href="/backend/css/sb-admin-2.css" rel="stylesheet">
    <link href="/backend/jqueryui/jquery-ui.min.css" rel="stylesheet">
    <link href="/backend/jqueryui/jquery-ui.structure.min.css" rel="stylesheet">
    <link href="/backend/jqueryui/jquery-ui.theme.min.css" rel="stylesheet">
    <link href="/backend/jqueryui/jquery-ui-timepicker-addon.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>


    <![endif]-->
    @yield('styles')
</head>
<body>


<div id="wrapper">
    @yield('navbar.prepend')
    @include('admin.layouts.navbar')
    @yield('navbar.append')

    <div id="page-wrapper">
        <div class="row">
            <div class="col-xs-12 page-header">
                <h2>
                    <div class="col-md-offset-1 col-md-6">
                        {{ $title }}
                    </div>
                    @yield('pageHeading')
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
            @include('admin.layouts.partials.notifications')
            </div>
        </div>
        @yield('content')
    </div>
</div>
<!-- ./ #main -->

<!-- scripts -->
<script src="/backend/js/jquery-1.11.0.js"></script>
<script src="/backend/jqueryui/jquery-ui.min.js"></script>
<script src="/backend/jqueryui/jquery-ui-timepicker-addon.js"></script>
<script src="/backend/bootstrap/js/bootstrap.min.js"></script>
@yield('scripts')
<script src="/backend/js/plugins/metisMenu/metisMenu.min.js"></script>
<script src="/backend/js/sb-admin-2.js"></script>

<script>
    var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
    (function (d, t) {
        var g = d.createElement(t), s = d.getElementsByTagName(t)[0];
        g.src = '//www.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g, s)
    }(document, 'script'));
</script>

</body>
</html>
