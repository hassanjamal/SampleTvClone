@extends('admin.layouts.master')
@section('title')
{{ $title ." :: ". Config::get('site.title') }}
@stop
@section('styles')
<link href="/backend/css/adminshows.css" rel="stylesheet">
@stop
@section('pageHeading')
<div class="col-md-4">
   <a href="{{ route('admin.shows.create.tvdb') }}" class="btn btn-block btn-primary">Add Show from TvDb</a>
</div>
@stop
@section('content')
<div class="row">
    <div class="content">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 well">
            {{ Form::open(['route' =>'adminShowSearch' ,'method' => 'GET', 'accept-charset'=>'utf-8']) }}
            <div class="form-group">
                <div class="icon-addon">
                    <input type="text" placeholder="Search Shows" name="search" class="form-control"
                    {{ Input::has('search') ? 'value="' . Input::get('search') . '"' : '' }}>
                    <label for="search" class="fa fa-search" rel="tooltip" title="search"></label>
                </div>
            </div>
            {{Form::close()}}

            <ul class="list-inline">
                @foreach( $shows as $show)
                <li class="">
                    <div class="thumbnail">
                        <a href="{{ route('admin.shows.edit', $show->id) }}" title="{{ $show->name }}">
                            <img class="thumbimg" src="{{ route('thumbnail', array( 'show',$show->id, 0) ) }}" alt="{{ $show->name }}">
                            {{--<img class="thumbimg" src="{{ $show->poster }}" alt="{{ $show->name }}">--}}
                        </a>
                        <div class="caption">
                            <a href="{{ route('admin.shows.edit', $show->id) }}" title="{{ $show->name }}">{{ Str::limit($show->name, 16) }}</a><br>
                            <span class="">{{ Str::limit( \Carbon\Carbon::createFromTimeStamp(strtotime($show->updated_at))->diffForHumans(), 11) }}</span>
                            <div class="pull-right">
                                <a href="{{route('show',array( $show->id,Str::slug($show->name)))}}" target="_blank">
                                    <i class="fa fa-eye"></i>&nbsp;
                                </a>
                                <a href="{{route('adminShowUpdate',$show->id)}}">
                                    <i class="fa fa-refresh"></i>&nbsp;
                                </a>
                                <a href="{{ route('adminShowDelete', $show->id) }}"> <i class="fa fa-trash-o"></i> </a>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
</div>
@stop
