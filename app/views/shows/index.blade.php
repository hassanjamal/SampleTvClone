@extends('master')
@section('content')
    <section>
        <h3 class="h4">Tv Shows List:</h3>
        <hr>
        <ul class="thumbnails list-inline clearfix">
            @foreach( $shows as $show )
                <li class="col-md-3">
                    <a href="{{ route('show', array( $show->id, Str::slug($show->name) ) ) }}" class="thumbnail"  title="{{ $show->name }}" rel="tooltip">
                        {{--<img class="thumbimg" src="{{ $show->poster }}" alt="{{ $show->name }}">--}}
                        <img class="thumbimg" src="{{ route('thumbnail', array( 'show',$show->id, 0) ) }}" alt="{{ $show->name }}">
                        <div class="caption">{{ Str::limit($show->name, 16) }}</div>
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="text-center">{{ $shows->appends(array('search' => Input::get('search') ))->links() }}</div>
    </section>
@stop

