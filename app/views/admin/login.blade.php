@extends('layout')

@section('body')
	<div class='login_section'>
		{{ Form::open(['action' => 'MainController@validate']) }}
			{{ HTML::image('icons/warning.png', 'Объект под охраной', array('class'=>'admin_warning')) }}
			<h2 class='admin_area'>Объект под охраной</h2>
			{{ Form::text('login', null, ['class'=>'form-control admin_input', 'placeholder'=>'Логин']) }}
			{{ Form::password('password', ['class'=>'form-control admin_input', 'placeholder'=>'Пароль']) }}
			{{ Form::submit('Войти', ['class'=>'form-control login_button']) }} 
		{{ Form::close() }}
	</div>
@stop