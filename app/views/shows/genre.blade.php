@extends('master')

@section('content')

    <section>
        <h3 class="h4">Latest TV Shows in Genre: {{ $genre->name }}</h3>
        <hr>

        @include('parts.shows')

    </section>

@stop

