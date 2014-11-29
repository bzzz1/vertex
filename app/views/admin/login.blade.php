@extends('layout')

@section('body')
	{{ Form::open(array('url' => '/validate', 'method' => 'post')) }}
		{{ HTML::image('icons/warning.png', 'Объект под охраной', array('class' => 'admin_warning')) }}
		<h2 class='admin_area'>Объект под охраной</h2>
		<input type="text" class="form-control admin_input" name='creds_login' placeholder="Логин"/>
		<input type="password" class="form-control admin_input" name='creds_password' placeholder="Пароль"/>
	{{ Form::close() }}
@stop