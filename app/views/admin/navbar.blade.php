<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span><span
                    class="icon-bar"></span><span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('admin') }}"><span class="fa fa-shield "></span> AdminCP</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{ route('admin') }}"><span class="fa fa-fw fa-cogs"></span> Configurations</a></li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-fw fa-tasks"></span> Manage <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('admin.shows.index') }}">Shows</a></li>
                        <!-- <li><a href="{{ route('adminEpisodes') }}">Episodes</a></li> -->
                        <li><a href="{{ route('adminLinks') }}">Links</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('adminPages') }}">Pages</a></li>
                        <li><a href="{{ route('adminUsers') }}">Users</a></li>
                    </ul>
                </li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ $options->url }}" target="_blank"><span class="fa fa-fw fa-external-link"></span> Visit Home</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-user"></i> {{ Sentry::getUser()->first_name}} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('adminLogout') }}"><i class="fa fa-fw fa-sign-out"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
</nav>
