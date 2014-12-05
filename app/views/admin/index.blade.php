@extends('admin.layout')
@section('content')
        <form action="{{ route('admin') }}" method="post" class="form-horizontal" role="form">
            {{ Form::token() }}
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
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary">Save Configurations</button>
                </div>
            </div>
        </form>
@stop
