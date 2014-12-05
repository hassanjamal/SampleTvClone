@extends('master')
@section('title', " | " . $show->name)
@section('description', $show->summary)
@section('content')
<section>
    <h2 class="h3">{{ $show->name }} </h2>
</section>
<br>
<section class="show-info row">
    <div class="col-md-3">
        <div class="thumbnail">
            <img src="{{ route('thumbnail', array( 'show',$show->id, 0) ) }}" alt="{{ $show->name }}" class="showImage" />
        </div>
        @include('parts.showRating')
        <div class="btn-group btn-group-justified">
            <!-- <a class="btn btn-primary" title="Remove from WatchList" href="#"><span class="fa fa-trash-o"></span></a> -->
            <a class="btn btn-primary showTooltip" title="Add to Favorite" href="{{ route('addToFavoriteShow', $show->id ) }}" data-toggle="tooltip" data-placement="bottom"><span class="fa fa-heart"></span></a>
            <a class="btn btn-primary showTooltip" title="Add to WatchList" href="{{ route('addToWatchlistShow', $show->id ) }}" data-toggle="tooltip" data-placement="bottom"><span class="fa fa-plus"></span></a>
            <a class="btn btn-primary showTooltip" title="Already Watched" href="{{ route('addToWatchedShow', $show->id ) }}" data-toggle="tooltip" data-placement="bottom"><span class="fa fa-check"></span></a>
        </div>
    </div>
    <div class="col-md-9">
        @if( !is_null($show->summary) )
        <p class="summary">{{ $show->summary }}</p>
        @endif
        <script type="text/javascript">
$(".summary").shorten({
        "showChars" : 100
        });
        </script>
        @include('parts.show_desc')
    </div>
</section>
<br><hr>
<section class="user-buttons">
    <div class="clearfix">
        <h3 class="h4">Episodes Guide</h3>
        <br>
    </div>
    <div class="movie-links">
        <div class="panel-group" id="accordion">
            @foreach( $show->sessions as $session )
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $session->id }}">
                            <i class="fa fa-plus"></i>  Season {{ $session->number }}
                        </a>
                    </h4>
                </div>
                <div id="collapse{{ $session->id }}" class="panel-collapse collapse">
                    <div class="panel-body">
                        <table class="table table-hover table-striped">
                            <tbody>
                            <?php $i = count($session->episodes); ?>
                            @foreach( $session->episodes as $episode )
                            <tr class="unwatched">
                                <td>
                                    <a href="{{ route('episode', array( $show->id, Str::slug($show->name), $episode->id, Str::slug($episode->name) )) }}">
                                        <i class="fa fa-play-circle"></i> Episode {{ $session->number }}x{{ sprintf("%02s", $i) }}
                                    </a>
                                </td>
                                <td>{{ $episode->title }}</td>
                                <td><div class="pull-right"><div class="star" data-rating="0"></div></div></td>
                                <td>{{ \Carbon\Carbon::createFromTimeStamp(strtotime($episode->firstAired))->toFormattedDateString() }}</td>
                                <td>
                                    <a href="{{ route('episode', array( $show->id, Str::slug($show->name), $episode->id, Str::slug($episode->name) )) }}" class="btn btn-warning btn-sm" href="#">
                                        {{ count($episode->links) }} Links
                                    </a>
                                </td>
                            </tr>
                            <?php $i--; ?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<hr>
@include('parts.comment')
<hr>
@include('parts.related')

@stop

