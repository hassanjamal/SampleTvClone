
<ul class="thumbnails list-inline clearfix">

    @foreach( $shows as $show )

        @include('parts.show')

    @endforeach

</ul>

<div class="text-center">{{ $shows->appends(array('search' => Input::get('search') ))->links() }}</div>