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

            <h3>Login</h3>
            <hr>


            <form action="{{ route('login') }}" method="post" class="form-horizontal" role="form">

                {{ Form::token() }}

                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="email" placeholder="johndoe@example.com" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" placeholder="********" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember_me" value="selected"> Remember me
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-success">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <h3>Social Login</h3>
            <hr>
            <div class="form-group">
                <div class="col-sm-12">
                <a href="{{{ URL::to('oauth/authorize/facebook')}}}" class="btn btn-primary">Facebook</a>
                <a href="{{{ url::to('oauth/authorize/twitter')}}}" class="btn btn-info">Twitter</a>
                <a href="{{{ url::to('oauth/authorize/google')}}}" class="btn btn-danger">Google</a>
                </div>
            </div>
        </div>
    </div>


@stop