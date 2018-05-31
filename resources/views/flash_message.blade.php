@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>	
        <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>	
        <strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>	
	<strong>{{ $message }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
	<button type="button" class="close" data-dismiss="alert">&times;</button>	
	<strong>{{ $message }}</strong>
</div>
@endif


@if ($errors->any())
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>	
	Please check the form below for errors
</div>
@endif

@if ($error_messages = Session::get('mult_error'))
	@foreach($error_messages as $error_message)
	<div class="alert alert-danger alert-block fade in">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>{{ $error_message["title"] }}</strong>{{$error_message["body"]}}
		@if ($error_message["is_invalid"] || $error_message["is_quoted"])
			<ul>
				@foreach($error_message["subjects"] as $subject)
				<li><strong>{{$subject}}</strong></li>
				@endforeach
			</ul>
		@endif
	</div>
	@endforeach
@endif