@extends('admin.layouts.master')
@section('title')
{{ $title ." :: ". Config::get('site.title') }}
@stop
@section('styles')
<link href="/backend/css/adminshows.css" rel="stylesheet">
@stop
@section('pageHeading')
<div class="col-md-4">
   <a href="{{ route('admin.shows.create') }}" class="btn btn-block btn-primary">Add Show Manually</a>
</div>
@stop
@section('content')
<div class="row">
    <div class="content">
        <div class="col-md-1">
        </div>
        <div class="col-md-10 well">
            {{ Form::open(['route' =>'adminShowSearchNew' ,'method' => 'GET', 'id'=>'searchForm' ,'accept-charset'=>'utf-8']) }}
            <div class="form-group">
                <div class="icon-addon">
                    <input type="text" placeholder="Search Shows" name="search" id="search" class="form-control"
                    {{ Input::has('search') ? 'value="' . Input::get('search') . '"' : '' }}>
                    <label for="search" class="fa fa-search" rel="tooltip" title="search"></label>
                </div>
            </div>
            {{Form::close()}}
            <div class="list-group" id="result">
            </div>
        </div>
    </div>
</div>
</div>
@stop
@section('scripts')
    <script type="text/javascript">
        var jsonUrl = "{{ route('adminShowSearchNew') }}";
        $("#searchForm").submit(function(event){
            event.preventDefault();
            var search = $("#search").val();
            if (search.length == 0) {
                $("#search").focus();
            } else {
                $("#result").empty().html( "<div class='text-center' style='margin-top:60px;'><img src='{{ asset('assets/img/loading.gif') }}' alt='loading'></div>" );
                $.getJSON(
                    jsonUrl,
                    {search: search},
                    function(data) {
                        var items = [];
//                        console.log(data);
                        $.each( data, function( key, show ) {
                            var link = 'http://thetvdb.com/?tab=series&id='+show.id;
                            items.push( "<div href='#' class='list-group-item clearfix'><div class='pull-left'>" + show.id + "  - " + show.name + " ( " + show.network + " )</div><div class='pull-right'><a href='{{ route('adminShowStore', "") }}/" + show.id + "' class='label label-success add'> <i class='fa fa-check-square-o'></i> Add </a><a href='" + link + "' class='label label-primary' target='_blank'> <i class='fa fa-eye'></i> View </a></div></div>");
                        });
                        // var result = "Language code is \"<strong>" + json + "\"";
                        $("#result").empty().html( items.join( "" ) );
                    }
                );
            }
            return false;
        });
        // $('#add').click( store() );
        // function store () {
            $("a.add").click(function( e ){
                e.preventDefault();
                e.stopPropagation();
                var jsonUrl = this.attr('href').val();
                $.getJSON(
                        jsonUrl,
                        function(data) {
                            var items = [];
                            alert( data );
                            // var result = "Language code is \"<strong>" + json + "\"";
                            // $("#result").html( items.join( "" ) );
                        }
                    );
                return false;
            });
        // }
    </script>
@stop
