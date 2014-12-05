@extends('admin.layouts.master')
@section('title')
    {{ $title ." :: ". Config::get('site.title') }}
@stop
@section('pageHeading')
<div class="col-md-4">
   <a href="{{ route('admin.shows.sessions.index', $show->id) }}" class="btn btn-block btn-primary">View Sessions</a>
</div>
@stop
@section('content')
<div class="row">
    <div class="content">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 well">
        <blockquote class="bg-primary">
                    <p class="lead">
                        All Episodes For Show
                        <a href="{{ route('admin.shows.edit', $show->id) }}">{{ $show->name }}
                        </a>
                        Having Session
                        <a href="{{ route('admin.shows.sessions.show', [$show->id , $session->id]) }}"> {{ $session->number }}</a>
                    </p>
        </blockquote>
        <div class="panel-group" id="accordion">
            @foreach( $sessions->episodes as $episode )
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $episode->number }}">
                            <i class="fa fa-plus"></i>
                            Episode {{ $episode->number}}
                        </a>
                    </h4>

                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('admin.shows.sessions.episodes.links.index',[$show->id, $session->id, $episode->id ]) }}" style="color: orange">
                            <i class="fa fa-eye"></i>  Links
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.shows.sessions.episodes.edit',[$show->id, $session->id, $episode->id]) }}">
                            <i class="fa fa-pencil"></i>  Edit
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.shows.sessions.episodes.destroy',[$show->id, $session->id, $episode->id ]) }}" style="color: red">
                            <i class="fa fa-trash-o"></i>  Delete
                            </a>
                        </div>
                    </div>
                </div>


                <div id="collapse{{ $episode->number }}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            <tbody>
                            <tr class="unwatched">
                                <td>
                                    <a href="{{ route('admin.shows.sessions.episodes.edit',[$show->id, $session->id, $episode->id]) }}">
                                        <i class="fa fa-eye"></i>  {{ $episode->name }}
                                    </a>
                                </td>
                                <td>{{ $episode->code }}</td>
                                <td><div class="pull-right"><div class="star" data-rating="0"></div></div></td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($episode->firstAired))->toFormattedDateString() }}</td>
                                <td>
                                    <a href="{{ route('episode', array( $show->id, Str::slug($show->name), $episode->id, Str::slug($episode->name) )) }}" class="btn btn-warning btn-sm" href="#">
                                        {{ count($episode->links) }} Links
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="content">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 well">
        <blockquote>
            <p class="lead">Actions For Session</p>
        </blockquote>
        {{--implement progress bar--}}
        <a href="{{ route('admin.shows.sessions.episodes.create', [$show->id , $session->id])}}" class="btn btn-block btn-primary" style="margin-bottom: 20px;">
        Create New Episode</a>
        {{--implement progress bar--}}
        <a href={{ route('admin.shows.sessions.destroy',[$show->id, $session->id ]) }} class="btn btn-danger  form-control">
        Delete Session
        </a>
        </div>
    </div>
</div>
@stop
