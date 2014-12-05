<table class="table table-striped">
    <tr>
        <td class="sideleft">Status: </td>
        <td class="sideleft">{{ $show->status }}</td>
    </tr>
    <tr>
        <td class="sideleft">TV Channel: </td>
        <td class="sideleft">{{ $show->network }}</td>
    </tr>
    {{--<tr>--}}
        {{--<td class="sideleft">Country: </td>--}}
        {{--<td class="sideleft">{{ $show->origin }}</td>--}}
    {{--</tr>--}}
    <tr>
        <td class="sideleft">Runtime: </td>
        <td class="sideleft">{{ $show->runtime }}</td>
    </tr>
    <tr>
        <td class="sideleft">Started: </td>
        <td class="sideleft"><a href="{{ route('year', \Carbon\Carbon::parse($show->firstAired)->year ) }}">{{ \Carbon\Carbon::parse($show->firstAired)->year }}</a></td>
    </tr>
</table>
<div>
    @foreach($show->genre as $genre)
        <a class="btn btn-sm btn-default" href="{{ route('genre', array( $genre->id, Str::slug($genre->name)) ) }}">{{ $genre->name }}</a>
    @endforeach
    <br><br>
</div>

