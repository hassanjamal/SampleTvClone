@extends('admin.layouts.master')
@section('title')
    {{ $title ." :: ". Config::get('site.title') }}
@stop
@section('pageHeading')
<div class="col-md-4">
   <a href="{{ route('admin.shows.sessions.show',[$show->id, $session->id ]) }}" class="btn btn-block btn-primary">All Episodes</a>
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
                Edit Episode For Show
                <a href="{{ route('admin.shows.edit', $show->id) }}">{{ $show->name }}
                </a>
                {{--Having Session--}}
                {{--<a href="{{ route('admin.shows.sessions.show', [$show->id , $session->id]) }}"> {{ $session->number }}</a>--}}
            </p>
        </blockquote>
            {{ Form::model($episode,['method'=>'PATCH', 'route'=>['admin.shows.sessions.episodes.update',$show->id,$session->id,
    $episode->id],'class' => 'form-horizontal', 'files' => true]    )}}

            <!-- Session_id Form Input -->
            <div class="form-group">
                {{ Form::label('session_id', 'Season :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                    {{ Form::select('session_id',$allSeasons ,$episode->session_id ,['class' => 'form-control']) }}
                </div>
            </div>
            
            <!-- Number Form Input -->
            <div class="form-group">
                {{ Form::label('number', 'Number :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                    {{ Form::text('number', null, ['class' => 'form-control', 'placeholder' => '']) }}
                </div>
            </div>
            
            <!-- Name Form Input -->
            <div class="form-group">
                {{ Form::label('name', 'Name :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => '']) }}
                </div>
            </div>  

            <!-- Language Form Input -->
            <div class="form-group">
                {{ Form::label('language', 'Language :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                    {{ Form::text('language', null, ['class' => 'form-control', 'placeholder' => '']) }}
                </div>
            </div>
            <!-- ImdbId Form Input -->
            <div class="form-group">
                {{ Form::label('imdbId', 'ImdbId :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                    {{ Form::text('imdbId', null, ['class' => 'form-control', 'placeholder' => '']) }}
                </div>
            </div>

            <!-- Code Form Input -->
            <div class="form-group">
                {{ Form::label('code', 'Code :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                    {{ Form::text('code', null, ['class' => 'form-control', 'placeholder' => '']) }}
                </div>
            </div>  
            
            <!-- FirstAired Form Input -->
            <div class="form-group">
                {{ Form::label('firstAired', 'First Aired :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                    {{ Form::text('firstAired', null, ['class' => 'form-control', 'placeholder' => '']) }}
                </div>
            </div>
            
            <!-- Thumbnail Form Input -->
            <div class="form-group">
                {{ Form::label('thumbnail', 'Thumbnail :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                <div class="thumbnail">
                    <img class="img-responsive" src="{{ route('thumbnail', array( 'episode',$show->id, $episode->id ) ) }}" alt="{{ $episode->name }}">
                 </div>
                    {{ Form::file('thumbnail', null, ['class' => 'form-control', 'placeholder' => '']) }}
                </div>
            </div>
            
            <!-- Overview Form Input -->
            <div class="form-group">
                {{ Form::label('overview', 'Overview :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                    {{ Form::textarea('overview', null, ['class' => 'form-control', 'placeholder' => '']) }}
                </div>
            </div>
            {{ Form::submit('Update', ['class' => 'btn btn-primary form-control']) }}
            {{ Form::close()}}
        </div>
    </div>
</div>
@stop
@section('scripts')
 <script type="text/javascript">
     $(function(){
        $('#firstAired').datetimepicker({
            dateFormat : 'yy-mm-dd',
            timeFormat : 'hh:mm:ss',
            changeMonth: true,
            changeYear: true
        });
     });
 </script>
@stop









    
