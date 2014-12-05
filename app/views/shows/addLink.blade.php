@extends('master')

@section('content')

    <section>

        <h3 class="h4">Add a new link for episode:</h3>
        <h2 class="h3"><a href="{{ route('episode', array( $episode->show->id, Str::slug($episode->show->name), $episode->id, Str::slug($episode->title) )) }}">{{ $episode->title }}</a></h2>

        <br><br>

        <form action="{{ route('addLink', $episode->id) }}" method="post" class="form-horizontal " role="form">

            {{ Form::token() }}

            <div class="input-group">
                <input type="text" class="form-control" name="link" placeholder="http://domain.com/episode-name.html" required>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">Add Link</button>
                </span>
            </div><!-- /input-group -->

        </form>

        <br><br>
        <h4 class="h5">Allowed Hosts For Links:</h4>
        <ul>
            @foreach( explode(":", $options->linkDomains) as $domain)
                <li>{{ ucfirst($domain) }}</li>
            @endforeach
        </ul>

    </section>

@stop

