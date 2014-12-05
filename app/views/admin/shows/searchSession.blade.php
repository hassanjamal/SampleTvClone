@extends('admin.layouts.master')
@section('title')
{{ $title ." :: ". Config::get('site.title') }}
@stop
@section('styles')
<link href="/backend/css/adminshows.css" rel="stylesheet">
@stop
@section('pageHeading')
{{--<div class="col-md-4">--}}
   {{--<a href="{{ route('admin.shows.create.tvdb') }}" class="btn btn-block btn-primary">Add Show from TvDb</a>--}}
{{--</div>--}}
@stop
@section('content')
<div class="row">
    <div class="content">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 well">
            {{ Form::open(['method' => 'POST', 'accept-charset'=>'utf-8']) }}
            {{ Form::hidden('to_show_id', Input::old('to_show_id'),array('id'=>'to_show_id'))}}
            <div class="form-group">
                <div class="icon-addon">
                    <input type="text" placeholder="Search Shows" name="show" id="show" class="form-control"
                    {{ Input::has('search') ? 'value="' . Input::get('search') . '"' : '' }}>
                    <label for="search" class="fa fa-search" rel="tooltip" title="search"></label>
                </div>
            </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@if ($mode === 'result')
<div class="row">
    <div class="content">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 well">
        <div class="panel-group" id="accordion">
            @foreach( $show->sessions as $session )
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $session->id }}">
                            <i class="fa fa-plus"></i>
                            @if ($session->number != 0)
                                Season {{ $session->number }}
                            @else 
                                Special Season
                            @endif  
                        </a>
                    </h4>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('admin.shows.sessions.show',[$show->id, $session->id ]) }}">
                            <i class="fa fa-eye"></i>  View
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.shows.sessions.edit',[$show->id, $session->id ]) }}">
                            <i class="fa fa-pencil"></i>  Edit
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('admin.shows.sessions.destroy',[$show->id, $session->id ]) }}" style="color: red;">
                            <i class="fa fa-trash-o"></i>  Delete
                            </a>
                        </div>
                    </div>

                </div>
                <div id="collapse{{ $session->id }}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            <tbody>
                            <?php $i = count($session->episodes); ?>
                            @foreach( $session->episodes as $episode )
                            <tr class="unwatched">
                                <td>
                                    <a href="{{ route('episode', array( $show->id, Str::slug($show->name), $episode->id, Str::slug($episode->name) )) }}">
                                        <i class="fa fa-play-circle"></i> Episode {{ $session->number }}x{{ sprintf("%02s", $i) }}
                                    </a>
                                </td>
                                <td>{{ $episode->title }}</td>
                                <td><div class="pull-right"><div class="star" data-rating="0"></div></div></td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($episode->firstAired))->toFormattedDateString() }}</td>
                                <td>
                                    <a href="{{ route('episode', array( $show->id, Str::slug($show->name), $episode->id, Str::slug($episode->name) )) }}" class="btn btn-warning btn-sm" href="#">
                                        {{ count($episode->links) }} Links
                                    </a>
                                </td>
                            </tr>
                            <?php $i--; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <a href="{{ route('admin.shows.sessions.create', $show->id)}}" class="btn btn-block btn-primary">Create New Session For {{$show->name }}</a>
        </div>
    </div>
</div>
@endif
@stop
@section('scripts')
<script>
$(function(){
        $('#show').autocomplete({
            source: "add_to_show_id",
            select: function(event, ui){
                $('#to_show_id').val(ui.item.id);
            }
        });
    });
</script>
@stop
