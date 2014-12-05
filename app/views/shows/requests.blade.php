@extends('master')

@section('content')

    <section>
        <h3 class="h4">Link Requests</h3>
        <hr>

        @foreach( $linkRequests as $link )
            <div class="row">
                <div class="col-md-5">
                    <div class="thumbnail episodeImage"  style="max-width: 260px">
                        <img src="{{ route('thumbnail', array( 'episode',$link->episode->show->id, $link->episode->id) ) }}" alt="{{ $link->episode->title }}"  />
                    </div>
                    <div class="btn-group btn-group-justified"  style="max-width: 260px">
                        <span href="" class="btn  btn-info">{{ $link->count }} Requests</span>
                        <a href="{{ route('addLink', $link->episode->id) }}" class="btn btn-danger">Add Link</a>
                    </div>
                </div>
                <div class="col-md-7">
                    <table class="table table-hover table-striped">
                        <tbody>
                            <tr>
                                <th style="width:95px;text-align: right;">Episode:</th>
                                <td>
                                    <a href="{{ route('episode', array( $link->episode->show->id, Str::slug($link->episode->show->name), $link->episode->id, Str::slug($link->episode->name) )) }}">
                                        {{ $link->episode->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: right;">Number:</th>
                                <td>
                                    <?php preg_match_all('/\d+/', $link->episode->code, $matches); ?>
                                    {{  sprintf("Season %d Episode %d", $matches[0][0], $matches[0][1] ) }}
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: right;">Show:</th>
                                <td>
                                    <a href="{{ route('show', array( $link->episode->show->id, Str::slug($link->episode->show->name)) ) }}">
                                        {{ $link->episode->show->name }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th style="text-align: right;">Air Date:</th>
                                <td>{{ date('jS F Y', strtotime($link->episode->air_date)) }}</td>
                            </tr>
                            <tr>
                                <th style="width:130px;text-align: right;">First Requested:</th>
                                <td>{{ date('jS F Y', strtotime($link->created_at)) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
        @endforeach

        <div class="text-center">{{ $linkRequests->links() }}</div>
    </section>

@stop

