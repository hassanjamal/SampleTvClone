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
            <p class="lead">Create Link for <a href="">{{ $show->name }}</a> having Episode <a href="">{{ $episode->name }}</a></p>
        </blockquote>
            {{ Form::open(['route'=>['admin.shows.sessions.episodes.links.store',$show->id,$session->id, $episode->id],'method' => 'POST' ,'class'=>'form-horizontal']) }}

            <!-- Link Form Input -->
            <div class="form-group">
                {{ Form::label('link', 'Link :', ['class' => 'col-md-3 control-label ']) }}
                <div class="col-md-9 ">
                    {{ Form::text('link', null, ['class' => 'form-control', 'placeholder' => 'http://domain.com/episode-name.html']) }}
                </div>
            </div>
            <!--buttons here-->
            {{ Form::submit('create', ['class' => 'btn btn-primary form-control']) }}
            {{Form::close()}}
        </div>
    </div>
</div>

<div class="row">
    <div class="content">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 well">
        <blockquote class="bg-primary">
            <p class="lead">Allowed Hosts For Links</p>
        </blockquote>
        <ul>
            @foreach( explode(":", $options->linkDomains) as $domain)
                <li>{{ ucfirst($domain) }}</li>
            @endforeach
        </ul>
        </div>
    </div>
</div>
@stop
