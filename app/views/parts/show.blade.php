

<li class="col-md-4">
    <a href="{{ route('show', array( $show->id, Str::slug($show->name) ) ) }}" class="thumbnail"  title="{{ $show->name }}" rel="tooltip">
        <img class="thumbimg" src="{{ route('thumbnail', array( 'show',$show->id, 0) ) }}" alt="{{ $show->name }}">
        <div class="caption">{{ Str::limit($show->name, 16) }}</div>
    </a>
</li>