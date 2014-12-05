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
            {{ Form::open(['route'=>['admin.shows.sessions.update',$show->id,$session->id],'method' => 'PUT' ,'class'=>'form-horizontal']) }}
                <div class="form-group">
                    {{ Form::label('season_id', 'Season Id :', ['class' => 'col-md-3 control-label ']) }}
                    <div class="col-md-9 ">
                        {{ Form::text('season_id', $session->season_id, ['class' => 'form-control', 'placeholder' => '']) }}
                    </div>
                </div>
                <!-- Number Form Input -->
                <div class="form-group">
                    {{ Form::label('number', 'Number :', ['class' => 'col-md-3 control-label ']) }}
                    <div class="col-md-9 ">
                        {{ Form::text('number', $session->number, ['class' => 'form-control', 'placeholder' => '']) }}
                    </div>
                </div>
            {{ Form::submit('Update', ['class' => 'btn btn-primary form-control']) }}
            {{Form::close()}}
        </div>
    </div>
</div>
@stop
