@if (Session::get('message'))
	<div class="message alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i aria-hidden="true" class="fa fa-times close_message"></i></button>
		<p class="message_text">{{ Session::get('message') }}</p>
	</div>
@endif
@if ($errors->has())
	<div class="message alert alert-danger alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i aria-hidden="true" class="fa fa-times close_message"></i></button>
		<p class="error_message">
			@foreach ($errors->all() as $error)
				{{ $error }}<br>
			@endforeach
		</p>
	</div>
@endif