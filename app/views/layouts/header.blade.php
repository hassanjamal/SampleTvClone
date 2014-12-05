<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ $options->name }} @yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="keywrs , sfs">

        <!-- Le styles -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/sortable-theme-bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/star-rating.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

        <!-- Le javascript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/sortable.min.js') }}"></script>
        <script src="{{ asset('assets/js/star-rating.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.shorten.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.twbsPagination.min.js') }}"></script>
        <script src="{{ asset('assets/js/typeahead.bundle.js') }}"></script>
        <script src="{{ asset('assets/js/custom-typeahead.js') }}"></script>


        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    <body>

        <div class="navbar navbar-inverse" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{{URL::to('/')}}}"><img src="{{ asset('assets/img/logo.png') }}" alt="{{ $options->name }}"></a>
                </div>
                <div class="navbar-collapse collapse">
                    <div class="navbar-left">
                        <form action="{{ route('ajaxShowSearch') }}" method="get" class="navbar-form navbar-left">
                            <input type="text" class="form-control" name="showSearch" placeholder="Search here...">
                        </form>

                    </div>
                    @if(Sentry::check())
                        <div class="btn-group navbar-right navbar-btn">
                            <a href="{{ route('dashboard') }}" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-user"></i> {{ Sentry::getUser()->first_name }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li><a href="{{ route('logout') }}">Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <div class="btn-group navbar-right navbar-btn">
                            @if(!Sentry::check())
                                <a class="btn btn-primary" href="{{ route('register') }}"><i class="fa fa-fw fa-user"></i> &nbsp;Register</a>
                                <a class="btn btn-primary" href="{{ route('login') }}"><i class="fa fa-fw fa-sign-in"></i> &nbsp;Login</a>
                            @else
                                <a class="btn btn-primary" href="{{{ URL::to('/') }}}"><i class="fa fa-fw fa-user"></i> &nbsp;{{ Sentry::getUser()->first_name }}</a>
                                <a class="btn btn-primary" href="{{ route('logout') }}"><i class="fa fa-fw fa-sign-in"></i> &nbsp;Logout</a>
                            @endif
                        </div>
                    @endif
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('shows') }}">TV Shows List</a></li>
                        <li><a href="{{ route('updates') }}">Latest Updates</a></li>
                        <li><a href="{{ route('requests') }}">Requests</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container wrapper">

            <div class="text-center adHeader">
                {{ $options->adHeader }}
            </div>

            @if( Session::has('message') )
                <br>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {{ Session::get('message') }}
                </div>
            @endif

            @if( Session::has('error') )
                <br>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    {{ Session::get('error') }}
                </div>
            @endif

            <div class="col-md-8">
