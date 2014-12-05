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
    <br>
    <br>
    <div class="row">
        <div class="col-md-10 well">
            <h3>Social Login</h3>
            <hr>
            <div class="form-group">
                <div class="col-sm-12">
                    <a href="{{{ URL::to('oauth/authorize/facebook')}}}" class="btn btn-primary"><i class="fa fa-facebook"></i>  Facebook</a>
                    <a href="{{{ url::to('oauth/authorize/twitter')}}}" class="btn btn-info"><i class="fa fa-twitter"></i>  Twitter</a>
                    <a href="{{{ url::to('oauth/authorize/google')}}}" class="btn btn-danger"><i class="fa fa-google"></i>  Google</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <br>
    <div class="row">
        <div class="col-md-10 well">

            <h3>Register</h3>
            <hr>

            <form action="{{ route('register') }}" method="post" class="form-horizontal" role="form" autocomplete="off" autofill="off">
                {{ Form::token() }}

                <div class="form-group">
                    <label for="first_name" class="col-sm-3 control-label">First Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="first_name" placeholder="john" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="last_name" class="col-sm-3 control-label">Last Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="last_name" placeholder="doe" required>
                    </div>
                </div>


                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" name="email" placeholder="john@doe.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" placeholder="********" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="********" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        {{ Form::captcha() }}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-primary">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop
