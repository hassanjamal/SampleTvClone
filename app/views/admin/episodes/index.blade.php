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
        <h3 class="pull-left" style="margin-top:0px">
            Manage Episodes For
            <a href="{{ route('admin.shows.edit', $show->id) }}">{{ $show->name}}</a>
            of <a href="{{ route('admin.shows.sessions.show', [$show->id, $sessions->id]) }}">Season {{
                $sessions->number }}</a></h3>

        <a href="{{ route('admin.shows.sessions.episodes.create', [$show->id, $sessions->id]) }}"
           class="btn btn-sm btn-success pull-right">Add New</a>
    </div>
    <div class="list-group">
        @foreach( $episodes as $episode)
            <div href="#" class="list-group-item clearfix">
                <div class="pull-left">
                    <a href="{{ route('admin.shows.sessions.episodes.edit', [$show->id, $sessions->id, $episode->id]) }}"
                       class="name" style="display: inline-block;">{{ 'Code : '. $episode->code }}</a>
                    &nbsp;&nbsp;&nbsp; : {{ $episode->title}}
                </div>
                <div class="pull-right">
                    <span class="badge badge-success">{{ date('jS F Y', strtotime($episode->air_date)) }}</span>
                    <span class="badge">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($episode->created_at))->diffForHumans() }}</span>
                    <a href="" class="badge badge-delete"> <i class="fa fa-trash-o"></i> </a>
                </div>
            </div>
        @endforeach

    </div>

    <div class="text-center">{{ $episodes->appends(array('search' => Input::get('search') ))->links() }}</div>
@stop
