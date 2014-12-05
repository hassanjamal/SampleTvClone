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
            {{ Form::open(['method'=>'POST', 'route'=>['admin.shows.sessions.store',$show->id],'class' => 'form-horizontal'])}}
                <!-- Season_id Form Input -->
                <div class="form-group">
                    {{ Form::label('season_id', 'Season Id :', ['class' => 'col-md-3 control-label ']) }}
                    <div class="col-md-9 ">
                        {{ Form::text('season_id', null, ['class' => 'form-control', 'placeholder' => '']) }}
                    </div>
                </div>
                <!-- Number Form Input -->
                <div class="form-group">
                    {{ Form::label('number', 'Number :', ['class' => 'col-md-3 control-label ']) }}
                    <div class="col-md-9 ">
                        {{ Form::text('number', null, ['class' => 'form-control', 'placeholder' => '']) }}
                    </div>
                </div>
            {{ Form::submit('Submit', ['class' => 'btn btn-primary btn-block']);}}
            {{ Form::close()}}
        </div>
    </div>
</div>
@stop




