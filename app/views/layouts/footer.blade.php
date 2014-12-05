
        </div>
        <div class="col-md-4 sidebar">
            <div class="widget">
                {{ $options->adSidebar }}
            </div>
            <div class="widget most-popular">
                <h3 class="h4">Most Popular Shows</h3>
                <table class="table table-striped table-hover">
                    <tbody>
                        <?php $i=1; ?>
                        @foreach($favouriteShows as $favourite)
                            <tr>
                                <td class="counter"><p>{{ $i++ }}</p></td>
                                <td>
                                    <a href="{{ route('show', array( $favourite->show->id, Str::slug($favourite->show->name) ) ) }}" class=""  title="{{ $favourite->show->name }}" rel="tooltip">
                                        {{ Str::limit($favourite->show->name, 35) }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="widget most-wanted">
                <h3 class="h4">Most Wanted</h3>
                <table class="table table-striped table-hover">
                    <tbody>
                        <?php $i=1; ?>

                        @foreach( $mostWanted as $link )
                            @if( count($link->episode->links) == 0 )
                                <tr>
                                    <td class="counter"><p>{{ $i++ }}</p></td>
                                    <td>
                                        <a href="{{ route('episode', array( $link->episode->show->id, Str::slug($link->episode->show->name), $link->episode->id, Str::slug($link->episode->name) )) }}">
                                            {{ Str::limit($link->episode->name, 35) }}
                                        </a>
                                    </td>
                                    <!-- <td>
                                        <div class="btn-group pull-right">
                                            <span href="" class="btn btn-sm btn-info">{{ $link->count }} Link Requests</span>
                                            <a href="{{ route('addLink', $link->episode->id) }}" class="btn btn-sm btn-danger">Add Link</a>
                                        </div>
                                    </td> -->
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

             <div class="widget">
                {{ $options->adSidebarBottom }}
            </div>

        </div>

        <div class="clearfix"></div>

        <div class="row col-md-12">
            <hr class="col-md-8 col-md-offset-2">
            <div class="col-md-12 genreCloud">
                <h3 class="h4">Genres</h3>
                <br>

                @foreach($genreCloud as $genre)

                    <a href="{{ route('genre', array( $genre->id, Str::slug($genre->name) )) }}" class="btn btn-default">
                        {{ $genre->name }}
                    </a>
                @endforeach
            </div>
            <hr class="col-md-8 col-md-offset-2">
            <div class="col-md-12 text-center">
                {{ $options->adFooter }}
            </div>
        </div>
    </div>



    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="pagination pull-left">
                    {{ $options->footerLinks }}
                    <p class="copyright">{{ $options->copyright }} Designed &amp; Developed by <a href="http://www.sochhq.com" title="Soch Studio" target="_blank">Soch Studio</a>.</p>
                </div>

                <div class="pull-right">
                    <div class="pagination">
                        {{ $options->socialLinks }}
                        <a href="#" class="pull-right">To Top</a>
                    </div>
                </div>

            </div>

        </div>
    </footer> <!-- /container -->

    <script type="text/javascript">
        // $("[data-rel=tooltip]").tooltip();
        $(document).ready(function(){

            $(".fb-comments").attr("data-width", $(".fb-comments").parent().width());

            $('.showTooltip').tooltip({container: 'body'});
        });

    </script>



    </body>
</html>
