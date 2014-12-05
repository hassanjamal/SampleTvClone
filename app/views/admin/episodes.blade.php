@extends('admin.layout')

@section('content')

<style type="text/css" media="screen">
.center-block {
    float: none;
    margin-left: auto;
    margin-right: auto;
}

.input-group .icon-addon .form-control {
    border-radius: 0;
}

.icon-addon {
    position: relative;
    color: #555;
    display: block;
}

.icon-addon:after,
.icon-addon:before {
    display: table;
    content: " ";
}

.icon-addon:after {
    clear: both;
}

.icon-addon .fa {
    position: absolute;
    z-index: 2;
    right: 10px;
    font-size: 14px;
    width: 20px;
    margin-left: -2.5px;
    text-align: center;
    padding: 10px 0;
    top: 1px
}


.icon-addon.addon-sm .form-control {
    height: 30px;
    padding: 5px 28px 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    min-width: 320px;
}

.icon-addon.addon-sm .fa,
.icon-addon.addon-sm .fa {
    margin-left: 0;
    font-size: 12px;
    right: 5px;
    top: -1px
}

.icon-addon .form-control:focus + .fa,
.icon-addon:hover .fa,
.icon-addon .form-control:focus + .fa,
.icon-addon:hover .fa {
    color: #2580db;
}
</style>
        <div class="clearfix">
            <h3 class="pull-left" style="margin-top:0px">Manage Episodes</h3>
            <form action="{{ route('adminEpisodeSearch') }}" method="get" accept-charset="utf-8">
                <div class="form-group pull-right">
                    <div class="icon-addon addon-sm">
                        <input type="text" placeholder="Search Episodes" name="search" class="form-control"
                        {{ Input::has('search') ? 'value="' . Input::get('search') . '"' : '' }}>
                        <label for="search" class="fa fa-search" rel="tooltip" title="search"></label>
                    </div>
                </div>
            </form>
        </div>


        <div class="list-group">

            @foreach( $episodes as $episode)
                <div href="#" class="list-group-item clearfix">
                    <div class="pull-left">
                        <a href="{{ route('episode', array( $episode->id, Str::slug($episode->title))) }}" class="name" style="display: inline-block;" target="_blank">{{ Str::limit( $episode->title, 30) }}</a>
                        &nbsp;&nbsp;&nbsp; Number: {{ $episode->prod_num }}
                        &nbsp;&nbsp;&nbsp; Air Date: {{ $episode->air_date }}
                    </div>
                    <div class="pull-right">
                        <span class="badge">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($episode->created_at))->diffForHumans() }}</span>
                        <a href="{{ route('adminEpisodeDelete', $episode->id) }}" class="badge badge-delete"> <i class="fa fa-trash-o"></i> </a>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="text-center">{{ $episodes->appends(array('search' => Input::get('search') ))->links() }}</div>


@stop