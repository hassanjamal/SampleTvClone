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
        <blockquote class="bg-primary">
            <p class="lead">Create New Show </p>
        </blockquote>
        {{ Form::open(['route'=>'admin.shows.store','method'=>'POST', 'class' => 'form-horizontal', 'files' => true])}}
            <div class="form-group">
                <label for="name" class="col-md-3 control-label">Show Name</label>
                <div class="col-md-9">
                    <input type="text" name="name" id="name" class="form-control" value="">
                </div>
            </div>

            <div class="form-group">
                <label for="link" class="col-md-3 control-label">Link</label>
                <div class="col-md-9">
                    <input type="text" name="link" id="link" class="form-control"  value=" ">
                </div>
            </div>

            <div class="form-group">
                <label for="firstAired" class="col-md-3 control-label">First Aired</label>
                <div class="col-md-9">
                    <input type="text" name="firstAired" id="firstAired" class="form-control datepicker"  value=" ">
                </div>
            </div>

            <div class="form-group">
                <label for="imdbId" class="col-md-3 control-label">IMDB ID</label>
                <div class="col-md-9">
                    <input type="text" name="imdbId" id="imdbId" class="form-control datepicker"  value=" ">
                </div>
            </div>

            <div class="form-group">
                <label for="airtime" class="col-md-3 control-label">Air Time</label>
                <div class="col-md-9">
                    <div class="col-md-2" style="padding-left: 0px">
                    {{ Form::selectRange('hours', 0, 23 , null , ['class' => 'form-control']) }}
                    </div>
                    <div class="col-md-2" style="padding-left: 0px">
                    {{ Form::selectRange('minutes', 0, 60 , null  , ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>

            <!-- Airday Form Input -->
            <div class="form-group">
                {{ Form::label('airday', 'Air day :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                    {{ Form::select('airday', $weekDays, null,['class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group">
                <label for="contentRating" class="col-md-3 control-label">Content Rating</label>
                <div class="col-md-9">
                    <input type="text" name="contentRating" id="contentRating" class="form-control"  value=" ">
                </div>
            </div>

            <div class="form-group">
                <label for="network" class="col-md-3 control-label">Network</label>
                <div class="col-md-9">
                    <input type="text" name="network" id="network" class="form-control"  value="">
                </div>
            </div>

            <!-- status Form Input -->
            <div class="form-group">
                {{ Form::label('status', 'Status', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                    {{ Form::text('status',null , ['class' => 'form-control']) }}
                </div>
            </div>
            <!-- End status Form Input -->
            

            <div class="form-group">
                <label for="runtime" class="col-md-3 control-label">Runtime</label>
                <div class="col-md-9">
                    <input type="text" name="runtime" id="runtime" class="form-control"  value="">
                </div>
            </div>

            <div class="form-group">
                <label for="genres" class="col-md-3 control-label">Genres</label>
                <div class="col-md-9">
                    {{Form::select('genres',$genres,null,['multiple'=>'multiple','name'=>'genres[]','class'=>'form-control'])}}

                    {{--<select data-placeholder="Genres" multiple class="chosen-select form-control" id="genres[]" name="genres[]">--}}
                        {{--@foreach ($genres as $genre)--}}
                            {{--<option value="{{ $genre }}" {{ (in_array( $genre, $showGenres)) ? 'selected': '' }} >--}}
                                {{--{{ $genre }}--}}
                            {{--</option>--}}
                        {{--@endforeach--}}
                    {{--</select>--}}
                </div>
            </div>

            <!-- Banner Form Input -->
            <div class="form-group">
                {{ Form::label('poster', 'Poster :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">

                    {{ Form::file('poster', null, ['class' => 'form-control', 'placeholder' => '']) }}
                </div>
            </div>

            <!-- FanArt Form Input -->
            <div class="form-group">
                {{ Form::label('fanArt', 'FanArt :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">

                    {{ Form::file('fanArt', null, ['class' => 'form-control', 'placeholder' => '']) }}
                </div>
            </div>

            <!-- Banner Form Input -->
            <div class="form-group">
                {{ Form::label('banner', 'Banner :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">

                    {{ Form::file('banner', null, ['class' => 'form-control', 'placeholder' => '']) }}
                </div>
            </div>

            <!-- overview Form Input -->
            <div class="form-group">
                {{ Form::label('overview', 'Overview :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9">
                    {{ Form::textarea('overview',null, ['class' => 'form-control']) }}
                </div>
            </div>
            <!-- End overview Form Input -->

            <!--buttons here-->
            {{ Form::submit('Create', ['class' => 'btn btn-primary form-control']) }}
            {{Form::close()}}
        </div>
    </div>
</div>

@stop

@section('scripts')
 <script type="text/javascript">
//     $(function() {
//         $('#genres').chosen({
//             no_results_text: 'Oops, nothing found!',
//             min_selected_options: '1'
//         });
//     });
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
