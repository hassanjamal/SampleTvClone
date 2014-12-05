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
            {{ Form::open(['method' => 'POST' ,'class'=>'form-horizontal']) }}
            @foreach( $options->raw as $option)
                @if( $option->type != 'hidden' )
                    @if( $option->uses == 'text')
                        <div class="form-group">
                            <label for="{{ $option->name }}" class="col-sm-3 control-label">{{ trans('admin.options.'.$option->name) }}</label>
                            <div class="col-sm-9">
                                <input type="text" name="{{ $option->name }}" class="form-control" id="{{ $option->name }}" value="{{{ $option->value }}}">
                                <p class="help-block">{{ trans('admin.help.'.$option->name) }}</p>
                            </div>
                        </div>
                    @else
                        <div class="form-group">
                            <label for="{{ $option->name }}" class="col-sm-3 control-label">{{ trans('admin.options.'.$option->name) }}</label>
                            <div class="col-sm-9">
                                <textarea type="text" name="{{ $option->name }}" class="form-control" id="{{ $option->name }}">{{ $option->value }}</textarea>
                                <p class="help-block">{{ trans('admin.help.'.$option->name) }}</p>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
            <!--buttons here-->
            {{ Form::submit('Update', ['class' => 'btn btn-primary form-control']) }}
            {{Form::close()}}
        </div>
    </div>
</div>
@stop
