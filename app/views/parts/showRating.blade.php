<div class="text-center rating">
    <input id="input-id" type="number" value="{{ $rating }}">
</div>

<br>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<div class="text-center"><div class="addthis_native_toolbox"></div></div>

<br>


<script type="text/javascript">
    $("#input-id").rating(
        {
            'min':0,
            'max':5,
            'step':"0.5",
            'size':'xs',
            'showClear':false,
        }
    );



    $("#input-id").on("rating.change", function(event, value, caption) {

        window.location.replace("{{ route('showRating', $show->id ) }}" + value);

        // $.get( "{{ route('showRating', $show->id ) }}", function( data ) {
        //         // $( ".result" ).html( data );
        //         alert( "Load was performed. " + data );
        // });
        // alert("You rated: " + value + " = " + $(caption).text());
    });
</script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54032714107cc3fa"></script>
