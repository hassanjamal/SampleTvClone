<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- font Awesome -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <link href="{{ asset('backend/css/ionicons.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Morris chart -->
    <link href="{{ asset('backend/css/morris/morris.css') }}" rel="stylesheet" type="text/css"/>
    <!-- jvectormap -->
    <link href="{{ asset('backend/css/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css"/>
    <!-- fullCalendar -->
    <link href="{{ asset('backend/css/fullcalendar/fullcalendar.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Daterange picker -->
    <link href="{{ asset('backend/css/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css"/>
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="{{ asset('backend/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet"
          type="text/css"/>
    <!-- Theme style -->
    <link href="{{ asset('backend/css/AdminLTE.css') }}" rel="stylesheet" type="text/css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-blue" onload="init();">
<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="{{ URL::to('adminDashboard') }}" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        Admin Home
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->

                <!-- Notifications: style can be found in dropdown.less -->

                <!-- Tasks: style can be found in dropdown.less -->

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span>{{ Sentry::getUser()->first_name }} <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-light-blue">
                            <img src="" class="img-circle" alt="User Image"/>

                            <p>
                                {{ Sentry::getUser()->first_name }}
                                <small>Member since Nov. 2012</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!--                        <li class="user-body">-->
                        <!--                            <div class="col-xs-4 text-center">-->
                        <!--                                <a href="#">Followers</a>-->
                        <!--                            </div>-->
                        <!--                            <div class="col-xs-4 text-center">-->
                        <!--                                <a href="#">Sales</a>-->
                        <!--                            </div>-->
                        <!--                            <div class="col-xs-4 text-center">-->
                        <!--                                <a href="#">Friends</a>-->
                        <!--                            </div>-->
                        <!--                        </li>-->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
</body>