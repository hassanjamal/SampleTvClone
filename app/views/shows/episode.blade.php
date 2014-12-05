@extends('master')

@section('name', " | " . $show->name . " | " . $episode->name)
@section('description', $episode->overview)

@section('content')
    <section>
        <h3 class="h4">
            <a href="{{ route('show', array($show->id, Str::slug($show->name) ))}}">
                {{ $show->name }}
            </a>
        </h3>
        <h2 class="h3">{{ $episode->code }} - {{ $episode->name }}</h2>
    </section>

    <br>
    <section class="show-info row">
        <div class="col-md-5">
            <div class="thumbnail episodeImage"  style="max-width: 260px">
                <img src="{{ route('thumbnail', array( 'episode',$show->id, $episode->id) ) }}" alt="{{ $episode->name }}"  />
            </div>

            @include('parts.episodeRating')

            <div class="btn-group btn-group-justified">
                <!-- <a class="btn btn-primary" title="Remove from WatchList" href="#"><span class="fa fa-trash-o"></span></a> -->
                <a class="btn btn-primary showTooltip" title="Add to Favorite" href="{{ route('addToFavorite', $episode->id ) }}" data-toggle="tooltip" data-placement="bottom"><span class="fa fa-heart"></span></a>
                <a class="btn btn-primary showTooltip" title="Add to WatchList" href="{{ route('addToWatchlist', $episode->id ) }}" data-toggle="tooltip" data-placement="bottom"><span class="fa fa-plus"></span></a>
                <a class="btn btn-primary showTooltip" title="Already Watched" href="{{ route('addToWatchedEpisode', $episode->id ) }}" data-toggle="tooltip" data-placement="bottom"><span class="fa fa-check"></span></a>
            </div>
        </div>

        <div class="col-md-7">
            @if( !is_null($episode->overview) )
                <p class="summary">{{ $episode->overview }}</p>
            @endif

            <script type="text/javascript">
                $(".summary").shorten({
                    "showChars" : 100
                });
            </script>

            <table class="table table-striped">
                <!-- <tr>
                    <td class="sideleft">Episode Number: </td>
                    <td class="sideleft">{{ $episode->number }}</td>
                </tr>
                <tr>
                    <td class="sideleft">Production Number: </td>
                    <td class="sideleft">{{ $episode->prod_num }}</td>
                </tr>
                <tr>
                    <td class="sideleft">Episode Title: </td>
                    <td class="sideleft">{{ $episode->name }}</td>
                </tr> -->
                <tr>
                    <td class="sideleft">Airs: </td>
                    <td class="sideleft">{{\Carbon\Carbon::parse($episode->firstAired)->format('Y-m-d') }}</td>
                </tr>
            </table>

            <hr>
            <div>
                @foreach($show->genre as $genre)
                    <a class="btn btn-sm btn-default" href="{{ route('genre', array( $genre->id, Str::slug($genre->name)) ) }}">{{ $genre->name }}</a>
                @endforeach
                <br><br>
            </div>


            <!-- <br> -->
            <!-- <div class="btn-group btn-group-justified">
                <a class="btn btn-small btn-primary" href="{{ route('addLink', $episode->id) }}">
                    <i class="fa fa-plus"></i> Add New Link
                </a>
                <a class="btn btn-small btn-warning" href="{{ route('requestLink', $episode->id) }}">
                    Request Links
                </a>
            </div>
            <br> -->
            <a href="{{ $options->hdLink }}" target="_blank" class="btn btn-info btn-block">Stream in HD <i class="fa fa-play fa fa-white"></i></a>
        </div>

    </section>
    <br>
    <section class="row">
        <div class="col-md-6">
            @if( $previousEpisode )
                <a href="{{ route('episode', array( $show->id, Str::slug($show->name), $previousEpisode->id, Str::slug($previousEpisode->name) )) }}" class="btn btn-warning"><i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Previous Episode ({{ $previousEpisode->code }})</a>
            @endif
        </div>

        <div class="col-md-6">
            @if( $nextEpisode )
                <a href="{{ route('episode', array( $show->id, Str::slug($show->name), $nextEpisode->id, Str::slug($nextEpisode->name) )) }}" class="btn btn-warning pull-right">Next Episode ({{ $nextEpisode->code }})&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></a>
            @endif
        </div>
    </section>

    <br><hr>

    <section class="user-buttons">
        <div class="clearfix">
            <h3 class="pull-left h4">Episode Links</h3>
            <div class="pull-right" style="margin-top: 7px;">
                <a class="btn btn-sm btn-primary" href="{{ route('addLink', $episode->id) }}">
                    <i class="fa fa-plus"></i> Add New Link
                </a>
                <a class="btn btn-sm btn-warning" href="{{ route('requestLink', $episode->id) }}">
                    Request Links
                </a>
            </div>
        </div>
        <br>

        @if( isset($episode->links[0]) )

            @if( $options->episodeLinksType == "videoEmbed" || $options->episodeLinksType == "all")
                <div class="videoEmbed"></div>
            @endif

            <div class="movie-links">
                <table class="table table-hover table-striped sort-table sortable-theme-bootstrap" data-sortable id="sortableLinks">
                    <thead>
                        <tr>
                            <th data-field="domain" data-sortable="true">Link</th>
                            <th data-field="age" data-sortable="true">Age</th>
                            <th data-field="vote" data-sortable="true">Votes</th>
                            <th data-sortable="false">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach( $episode->links as $link )
                            <tr>
                                <td>
                                    <img src="http://www.google.com/s2/favicons?domain_url={{ $link->domain }}" alt="">
                                    &nbsp;
                                    <a href="{{ $link->link }}" target="_blank" rel="nofollow">
                                        {{ ucfirst( $link->domain ) }}
                                    </a>
                                </td>
                                <td data-value="{{ $link->created_at }}">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($link->created_at))->diffForHumans() }}</td>
                                <td data-value="{{ countVotes( $link->votes, 1) }}">
                                    <a href="{{ route('linkVote', array($link->id,'up') ) }}" class="btn btn-vote btn-sm up"><i class="fa fa-thumbs-up"></i> {{ countVotes( $link->votes, 1) }}</a>
                                    &nbsp;&nbsp;
                                    <a href="{{ route('linkVote', array($link->id, 'down') ) }}" class="btn btn-vote btn-sm down"><i class="fa fa-thumbs-down"></i> {{ countVotes( $link->votes, 0) }}</a>
                                </td>
                                <td>
                                    @if( $options->episodeLinksType == "videoEmbed" || $options->episodeLinksType == "all")
                                        <a href="javascript:void(0);" data-href="{{ $link->link }}" class="btn btn-danger btn-sm playVideo"><i class="fa fa-play"></i> Play</a>
                                    @endif
                                    @if( $options->episodeLinksType == "videoModal" || $options->episodeLinksType == "all")
                                        <a href="javascript:void(0);" data-href="{{ $link->link }}" class="btn btn-danger btn-sm playVideoInModal"><i class="fa fa-play"></i> Play in Modal</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="4">
                                <img src="http://www.google.com/s2/favicons?domain_url=http://www.tubeoffline.com" alt="">
                                &nbsp;
                                <a href="http://www.tubeoffline.com/" target="_blank" rel="nofollow">Watch Offline</a>
                            </td>
                        </tr>

                    </tbody>
                </table>

                <p>Click on table header to sort by Link, Age &amp; Up Votes.</p>
            </div>

            @if( $options->episodeLinksType == "videoModal" || $options->episodeLinksType == "all")
                <!-- Modal -->
                <div class="modal fade" id="videoModalFrame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <div id="videoModal"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <script type="text/javascript">

                    $(".playVideoInModal").click(function(event) {
                        event.preventDefault();
                        var $this = $(this);
                        var url = $(this).attr('data-href');

                        $.ajax({
                            url: '{{ route("videoFrame") }}',
                            data: {'url':url, 'alternateSize': true},
                            complete : function(){
                            },
                            success: function(data){
                                if(data != "false")
                                {
                                    $('.playingModal').removeAttr('disabled').removeClass('playing').html('<i class="fa fa-play"></i> Play in Modal');
                                    $('#videoModal').html(data);
                                    $('#videoModalFrame').modal('show')
                                    $this.attr('disabled','disabled').addClass('playingModal').html('<i class="fa fa-play"></i> Playing');
                                }
                                else
                                {
                                    var win = window.open(url, '_blank');
                                    win.focus();
                                }
                            }
                        });
                    });

                    $('#videoModalFrame').on('hide.bs.modal', function (e) {
                        $('#videoModal').html("");
                        $('.playingModal').removeAttr('disabled').removeClass('playing').html('<i class="fa fa-play"></i> Play in Modal');
                    })
                </script>
            @endif

            @if( $options->episodeLinksType == "videoEmbed" || $options->episodeLinksType == "all")

                <script type="text/javascript">

                    $(".playVideo").click(function(event) {
                        event.preventDefault();
                        var $this = $(this);
                        var url = $(this).attr('data-href');

                        $.ajax({
                            url: '{{ route("videoFrame") }}',
                            data: {'url':url },
                            complete : function(){
                            },
                            success: function(data){
                                if(data != "false")
                                {
                                    $('.playing').removeAttr('disabled').removeClass('playing').html('<i class="fa fa-play"></i> Play');
                                    $('.videoEmbed').html(data);
                                    $this.attr('disabled','disabled').addClass('playing').html('<i class="fa fa-play"></i> Playing');
                                }
                                else
                                {
                                    var win = window.open(url, '_blank');
                                    win.focus();
                                }
                            }
                        });
                    });
                </script>
            @endif
        @endif
    </section>
    <script type="text/javascript">
        var exampleTable = document.querySelector('#sortableLinks');
        Sortable.initTable(exampleTable);
    </script>

    <hr>
    @include('parts.commentEpisode')


@stop

