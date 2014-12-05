@extends('admin.master')

@section('navbar')
    @include('admin.navbar')
@stop

@section('layout')



    <div class="wrapper">
        <section class="row">
            <div class="col-md-10 col-md-offset-1">

                @if( Session::has('message') )
                    <div class="alert alert-success-alt alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('message') }}
                     </div>
                @endif

                @yield('content')

            </div>
        </section>
    </div><!--  /.wrapper  -->

    <footer>
        <p class="pull-left">&copy; 2012 - 2014 <a href="http://sochhq.com" target="_blank">Soch Studio</a>. All Rights Reserved</p>
        <p class="pull-right">TVClone v2.1.4</p>
    </footer>
@stop
