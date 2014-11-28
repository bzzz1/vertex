@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('css')
	{{ HTML::style('css/style.css') }}
@stop

@section('body')
	<div class="width_960">
		<!-- <div class='change_item'> -->
		
		<!-- </div> -->
		<button class="info_page_admin_button">Перейти к редактированию информации</button>	
	</div>

@stop