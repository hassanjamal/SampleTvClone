@extends('master')
@section('content')
@if($errors->has())
<div class="alert alert-danger">
    <h3>Error:</h3>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<br>
@endif
<div class="row">
    <div class="col-md-8">
        <h3>Update Email Address</h3>
        <hr>
        <form action="{{ route('postTwitterActivate', $user->id) }}" method="POST" class="form-horizontal" role="form">
            {{ Form::token() }}

            <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="email" placeholder="johndoe@example.com" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
</div>
</div>
@stop
