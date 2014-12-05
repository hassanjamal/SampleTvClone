<section class="show-sec-last comments">
    <h3 class="h4">Comments</h3>
    <br>

    @if( Sentry::check() )
        <div id="comments">
            <ul class="commentList">
            </ul>
                <?php 
                commentsView($show->id,"show", $comments);
                $type = 'show';
                ?>
            {{ Form::open(['route' => ['postComment', $type, $show->id], 'method' => 'post']) }}
            	<div class="form-group">
            	        {{ Form::textarea('comment', null, ['class' => 'form-control' , 'rows' => '5' , 'style' => 'background-color: #F9F9F9']) }}
            	</div>
            	{{ Form::submit('Comment' ,['class' => 'btn btn-primary']) }}
            {{ Form::close() }}

        </div>

        <script type="text/javascript">
            $(document).ready(function() {
                 $('.reply').click(function() {
                        var elm = $(this).parents(".commentItem").eq(0).children('.replyBox');

                        $(".replyBox:visible").slideUp("slow")

                        if(!elm.is(":visible"))
                            elm.slideToggle("slow");
                });
            });
        </script>
    @else
        <h4 class="text-center">Please <a href="{{ route('register') }}"> register</a> or <a href="{{ route('login') }}">login</a> to comment.</h4>
    @endif


</section>
