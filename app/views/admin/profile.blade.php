@extends('admin.layout')

@section('content')

    <form action="{{ route( 'admin-profile' ) }}" method="post" class="form-horizontal" role="form">

        {{ Form::token() }}

        <div class="form-group">
            <label for="title" class="col-md-3 col-sm-2 control-label">Full Name</label>
            <div class="col-md-8 col-sm-10">
                <input type="text" class="form-control" name="name" value="{{{ Auth::user()->name }}}">
            </div>
        </div>

        <div class="form-group">
            <label for="title" class="col-md-3 col-sm-2 control-label">Email Address</label>
            <div class="col-md-8 col-sm-10">
                <input type="email" class="form-control" name="email" value="{{{ Auth::user()->email }}}">
            </div>
        </div>

        <div class="form-group">
            <label for="title" class="col-md-3 col-sm-2 control-label">New Password</label>
            <div class="col-md-8 col-sm-10">
                <input type="password" class="form-control" name="password">
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-3 col-md-8 col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-info">Save Page</button>
            </div>
        </div>

    </form>

@stop