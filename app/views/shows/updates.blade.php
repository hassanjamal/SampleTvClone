@extends('master')

@section('content')

    <section>
        <h3 class="h4">Latest Updates</h3>
        <hr>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">

            <?php $i = 1; ?>
            @foreach ($linksByWeek as $date => $row)
                <li class="{{ ($i == 1) ? 'active' : ''; }}"><a href="#{{ $date }}" role="tab" data-toggle="tab"><strong>Week {{ $i }}</strong></a></li>
                <?php $i++; ?>
            @endforeach
        </ul>
        <br>
        <!-- Tab panes -->
        <div class="tab-content">
            <?php $j = 1;$l=1; ?>
            @foreach ($linksByWeek as $date => $row)
                <div class="tab-pane {{ ($j == 1) ? 'active' : ''; }}" id="{{ $date }}">
                    <h4 class="h5">{{ $row->weekTitle }}</h4>
                    <br>
                    <?php $k=1; $pageCount = count($row->links); ?>
                    @foreach( $row->links as $chunk )
                        <div class="{{$j}}page-{{$k}} {{$j}}page" {{ ($k != 1) ? 'style="display: none;"' : ''; }}>
                            @foreach( $chunk as $link )
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="thumbnail episodeImage"  style="max-width: 260px">
                                            <img src="{{ route('thumbnail', array( 'episode',$link->episode->show->id, $link->episode->id) ) }}" alt="{{ $link->episode->name }}"  />
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <table class="table table-hover table-striped">
                                            <tbody>
                                                <tr>
                                                    <th style="width:145px;text-align: right;">Show:</th>
                                                    <td>
                                                        <a href="{{ route('show', array( $link->episode->show->id, Str::slug($link->episode->show->name)) ) }}">
                                                            {{ $link->episode->show->name }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: right;">Episode Number:</th>
                                                    <td>
                                                        <?php preg_match_all('/\d+/', $link->episode->code, $matches); ?>
                                                        {{  sprintf("Season %d Episode %d", $matches[0][0], $matches[0][1] ) }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: right;">Episode Name:</th>
                                                    <td>
                                                        <a href="{{ route('episode', array( $link->episode->show->id, Str::slug($link->episode->show->name), $link->episode->id, Str::slug($link->episode->name) )) }}">
                                                            {{ $link->episode->name }}
                                                        </a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: right;">Air Date:</th>
                                                    <td>{{ date('jS F Y', strtotime($link->episode->air_date)) }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: right;">Added On:</th>
                                                    <td>{{ date('jS F Y', strtotime($link->created_at)) }}</td>
                                                </tr>
                                                @if( !is_null($link->episode->summary) )
                                                    <tr>
                                                        <th style="text-align: right;">Episode Summary:</th>
                                                        <td id="summary{{$link->episode->id}}">
                                                            {{ $link->episode->summary }}
                                                            <script type="text/javascript">
                                                                $("#summary{{$link->episode->id}}").shorten({
                                                                    "showChars" : 100
                                                                });
                                                            </script>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <br>
                                <?php $l; ?>
                            @endforeach
                        </div>
                        <?php $k++; ?>
                    @endforeach

                    <div class="paginator{{$j}} text-center"></div>

                    @if( $pageCount > 1 )
                    <script type="text/javascript">
                        $(".paginator{{$j}}").twbsPagination({
                            totalPages: {{ $pageCount }},
                            onPageClick: function (event, page) {
                                $('.{{$j}}page:visible').hide();
                                $('.{{$j}}page-' + page).show();
                            }
                        });
                    </script>
                    @endif

                </div>
                <?php $j++; ?>
            @endforeach
        </div>


    </section>

@stop

