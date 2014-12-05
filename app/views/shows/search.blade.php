@extends('master')

@section('content')

    <section>
        <h3 class="h4">Search for: {{{ $search }}}</h3>
        <hr>

        @include('parts.shows')

    </section>

@stop

