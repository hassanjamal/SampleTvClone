<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
                </div>
            </li>
            <li>
                <a href="">
                    <i class="fa fa-dashboard"></i> <span>&nbsp;&nbsp;Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.configure') }}">
                    <i class="fa fa-sliders"></i> <span>&nbsp;&nbsp;Site Configuration</span>
                </a>
            </li>
            <li>
                <a href="#"><i class="fa fa-film fa-fw"></i>&nbsp;&nbsp; Shows Management<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('admin.shows.index') }}"><i class="fa fa-play-circle"></i>&nbsp;&nbsp;All Shows</a></li>
                    <li><a href="{{ route('admin.shows.create.tvdb') }}"><i class="fa fa-search"></i>&nbsp;&nbsp;Add Show From TvDb</a></li>
                    <li><a href="{{ route('admin.shows.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add Show Manually</a></li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-film fa-fw"></i>&nbsp;&nbsp; Session Management<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li><a href="{{ route('admin.show.search.session') }}"><i class="fa fa-search"></i>&nbsp;&nbsp;All Sessions</a></li>
                </ul>
            </li>
    </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
