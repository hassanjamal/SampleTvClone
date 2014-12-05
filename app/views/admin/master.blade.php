<!doctype html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>@yield('title', 'AdminCP')</title>

        <meta name="viewport" content="width=device-width">
        <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">

        {{ HTML::style('admin-assets/css/bootstrap.min.css') }}
        {{ HTML::style('admin-assets/css/font-awesome.min.css') }}
        {{ HTML::style('admin-assets/css/datepicker.css') }}
        {{ HTML::style('admin-assets/css/chosen.min.css') }}
        {{ HTML::style('admin-assets/css/websterfolks.css') }}
        {{ HTML::style('admin-assets/css/style.css') }}

        {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js') }}

</head>
<body>

        @yield('navbar')

        <div class="container">

            @yield('layout')

        </div>

        {{ HTML::script('admin-assets/js/bootstrap.min.js') }}
        {{ HTML::script('admin-assets/js/bootstrap-datepicker.js') }}
        {{ HTML::script('admin-assets/js/script.js') }}
        {{ HTML::script('admin-assets/js/chosen.jquery.min.js') }}
</body>
</html>
