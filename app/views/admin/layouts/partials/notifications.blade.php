@if ($errors->any())
<div class="notifications alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
	@if ($message = $errors->first(0, ':message'))
	{{ $message }}
	@else
	Please check the form below for errors
	@endif
</div>
@endif

@if ($message = Session::get('error'))
<div class="notifications alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
	{{ $message }}
</div>
@endif
@if ($message = Session::get('success'))
<div class="notifications alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert"><i class="fa fa-minus-square"></i></button>
	{{ $message }}
</div>
@endif
