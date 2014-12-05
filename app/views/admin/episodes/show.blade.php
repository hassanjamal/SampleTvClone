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
        	<div class="row">
	        	<div class="col-md-3">
	        		Thumbnail
	        	</div>
	        	<div class="col-md-9">
	                <img class="thumbimg" src="{{ route('thumbnail', ['episode',$show->id, $episode->id] ) }}" alt="{{ $episode->name }}">
	        	</div>
        	</div>
			
        	<div class="row">
	        	<div class="col-md-3">
	        		Season
	        	</div>
	        	<div class="col-md-9">
					{{ $session->number}}
	        	</div>
	        </div>

        	<div class="row">
	        	<div class="col-md-3">
	        		Episode Number
	        	</div>
	        	<div class="col-md-9">
					{{ $episode->number}}
	        	</div>
	        </div>

        	<div class="row">
	        	<div class="col-md-3">
	        		Episode Name
	        	</div>
	        	<div class="col-md-9">
					{{ $episode->name}}
	        	</div>
	        </div>

        </div>
    </div>
</div>
@stop
