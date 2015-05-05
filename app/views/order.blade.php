@extends('layout')
@extends('header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
	@include('flash_messages')

		<h2 class="order_heading contacts_heading">Форма заказа</h2>
		<hr class="main_hr">
		{{ Form::model($item, ['url'=>['/order'], 'method'=>'POST', 'class'=>'order_form', 'data-parsley-validate']) }}
			<table class="order_form_table">
				<tr>
					<td>{{ Form::label('name', 'Имя: ', ['class'=>'main_label req']) }}</td>
					<td>{{ Form::text('name', null, ['class'=>'change_input_order form-control', 'required']) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label('surname', 'Фамилия: ', ['class'=>'main_label']) }}</td>
					<td>{{ Form::text('surname', null, ['class'=>'change_input_order form-control']) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label('item', 'Наименование: ', ['class'=>'main_label']) }}</td>
					<td>{{ Form::text('item', null, ['class'=>'change_input_order form-control', 'required', 'readonly'=>'readonly']) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label('price', 'Стоимость: ', ['class'=>'main_label']) }}</td>
					<td>{{ Form::text('price', null, ['class'=>'change_input_order form-control', 'required', 'readonly'=>'readonly']) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label('currency', 'Валюта: ', ['class'=>'main_label']) }}</td>
					<td>{{ Form::text('currency', null, ['class'=>'change_input_order form-control', 'required', 'readonly'=>'readonly']) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label('code', 'Код: ', ['class'=>'main_label']) }}</td>
					<td>{{ Form::text('code', null, ['class'=>'change_input_order change_input_order_code form-control', 'required', 'readonly'=>'readonly']) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label('phone', 'Телефон: ', ['class'=>'main_label req']) }}</td>
					<td>{{ Form::text('phone', null, ['class'=>'change_input_order change_input_order_code form-control', 'required']) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label('email', 'E-Mail: ', ['class'=>'main_label req']) }}</td>
					<td>{{ Form::email('email', null, ['class'=>'change_input_order change_input_order_code form-control', 'required']) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label('company', 'Компания: ', ['class'=>'main_label']) }}</td>
					<td>{{ Form::text('company', null, ['class'=>'change_input_order change_input_order_code form-control',]) }}</td>
				</tr>
				<tr>
					<td>{{ Form::label('comment', 'Комментарий: ', ['class'=>'main_label']) }}</td>
					<td>{{ Form::textarea('comment', null, ['class'=>'change_input_order change_input_order_code form-control',]) }}</td>
				</tr>
			</table>
			{{ Form::submit('Отправить', ['class'=>'submit_field save_button btn send_btn']) }}
		{{ Form::close() }}
	</div>
@stop