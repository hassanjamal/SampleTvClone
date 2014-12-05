@extends('admin.layouts.master')
@section('title')
    {{ $title ." :: ". Config::get('site.title') }}
@stop
@section('pageHeading')

<div class="col-md-4">
   <a href="{{ route('admin.shows.sessions.episodes.links.create',[$show->id,$session->id,$episode->id]) }}" class="btn btn-block btn-primary">Add Links</a>
</div>
@stop
@section('content')
<div class="row">
    <div class="content">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 well">
        <blockquote class="bg-primary">
            <p class="lead">All Links for <a href="">{{ $show->name }}</a> having Episode <a href="">{{ $episode->name }}</a></p>
        </blockquote>
        <div class="list-group">
            @foreach( $links as $link)
                <div href="#" class="list-group-item clearfix">
                    <div class="pull-left">
                        <a href="{{ route('episode', array( $link->episode->show->id, Str::slug($link->episode->show->name), $link->episode->id, Str::slug($link->episode->title) )) }}" class="name" style="display: inline-block;" target="_blank">{{ Str::limit( $link->episode->title, 30) }}</a>
                        &nbsp;&nbsp;&nbsp; Link: <a href="{{ $link->link }}" class="name" style="display: inline-block;" target="_blank">{{ Str::limit( $link->domain, 30) }}</a>
                    </div>
                    <div class="pull-right">
                        <span class="badge">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($link->created_at))->diffForHumans() }}</span>

                        @if( $link->approved == 0 )
                            <a href="{{ route('adminLinkApprove', $link->id) }}" class="label label-success"> <i class="fa fa-check-square-o"></i> Approve</a>
                        @endif
                        <a href="{{ route('admin.shows.sessions.episodes.links.edit',[$show->id,$session->id, $episode->id, $link->id]) }}">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <a href="{{ route('adminLinkDelete', $link->id) }}" class="label label-danger"> <i class="fa fa-trash-o"></i> Delete</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center">{{ $links->appends(array('search' => Input::get('search') ))->links() }}</div>
        </div>
    </div>
</div>
@stop
