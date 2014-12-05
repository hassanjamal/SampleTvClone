<section>
    <h3 class="h4">Related TV Shows</h3>
    <br>

    <ul class="thumbnails list-inline clearfix">
        @foreach( $shows as $show )
            @include('parts.show')
        @endforeach
    </ul>
</section>