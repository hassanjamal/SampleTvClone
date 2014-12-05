@extends('admin.layouts.master')
@section('title')
    {{ $title ." :: ". Config::get('site.title') }}
@stop
@section('pageHeading')
@stop
@section('content')
<div class="row">
    <div class="content">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 well">
        {{ Form::model($link, ['route' => ['admin.shows.sessions.episodes.links.update', $show->id, $session->id, $episode->id, $link->id],
        'method' => 'PUT','class'=>'form-horizontal']) }}
        	<!-- Link Form Input -->
        	<div class="form-group">
        	    {{ Form::label('link', 'Link :', ['class' => 'col-md-3 control-label ']) }}
        	    <div class="col-md-9 ">
        	        {{ Form::text('link', null, ['class' => 'form-control', 'placeholder' => '']) }}
        	    </div>
        	</div>
        {{ Form::submit('Update', ['class' => 'form-control btn-primary']) }}
        {{ Form::close() }}
        </div>
    </div>
</div>
@stop
