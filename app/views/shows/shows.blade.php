@extends('master')
@section('content')
    <section>
        <h3 class="h4">
            Latest Updates
            <a href="{{ route('updates') }}" class="btn btn-primary btn-sm pull-right">More Updates</a>
        </h3>
        <hr>
        <?php $i=1;$j=1; ?>
                @foreach( $links as $link )
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
                                            <td id="summary{{$j}}">
                                                {{ $link->episode->summary }}
                                                <script type="text/javascript">
                                                    $("#summary{{$j}}").shorten({
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
                    <?php $j++;?>
                @endforeach
        <div class="paginator text-center">{{ $links->links() }}</div>
        <br>
    </section>

@stop

