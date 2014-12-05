@extends('admin.master')

@section('title', 'AdminCP - Login')

@section('layout')

    <div class="row login">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <h1 class="text-center">AdminCP</h1>
            <form action="{{ route('admin-login') }}" method="post" role="form">
                <fieldset>
                    <h3>Please Sign In</h3>
                    <hr class="colorgraph">

                    @if(Session::has('message'))
                        <p class="text-danger">{{ Session::get('message') }}</p>
                    @endif

                    {{ Form::token() }}

                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
                    </div>
                    <hr class="colorgraph">
                    <div class="row">
                        <div class="col-md-6 pull-right">
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Sign In">
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

@stop