@extends('layout')
@extends('header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
		
		{{-- <ol class="breadcrumb">
		  <li><a href="/">Главная</a></li>
		  <li class="active">Контакты</li>
		</ol> --}}
		<h2 class="about_heading universal_heading">Контакты</h2>
		<hr class="main_hr">
		<div class="about_text_block">
			<table class="contacts_info_table">
				<tr>
					<td class="info_label">Адрес</td>
					<td>г. Санкт-Петербург, Болотная улица дом 16</td>
				</tr>
				<tr>
					<td class="info_label">Телефон</td>
					<td>+7 (812) 987-22-06</td>
				</tr>
				<tr>
					<td class="info_label">Доп. телефон</td>
					<td>+7 (812) 987-08-81</td>
				</tr>
				<tr>
					<td class="info_label">Эл. почта</td>
					<td><a href="mailto:9872206@mail.ru">9872206@mail.ru</a></td>
				</tr>
				<tr>
					<td class="info_label">Дополнительный сайт</td>
					<td><a href="http://www.mssservice.ds78.ru" target="_blank">mssservice.ds78.ru</a></td>
				</tr>
				<tr>
					<td class="info_label">Контактное лицо</td>
					<td>Дежурный менеджер</td>
				</tr>
				<tr>
					<td class="info_label">Часы работы</td>
					<td>09:00-18:00, без перерыва, по субботам по договоренности</td>
				</tr>
			</table>
		</div>
		{{-- <p class="conacts_subheading">Если у вас остались вопросы - напишите нам.</p>
		<div class="contacts_contact_form" id="contact_sorm_ancher">
			{{ Form::open(['url'=>'/feedback', 'method'=>'POST', 'class'=>'item_form admin_info_form']) }}
				<table class="contacts_form_table">
					<tr>
						<td class="req">{{ Form::label('name', 'Имя: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('name', null, ['class'=>'change_input_contacts form-control req', 'required']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('company', 'Компания: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('company', null, ['class'=>'change_input_contacts form-control']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('phone', 'Контактный телефон: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('phone', null, ['class'=>'change_input_contacts form-control']) }}</td>
					</tr>
					<tr>
						<td class="req">{{ Form::label('email', 'E-mail: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::email('email', null, ['class'=>'change_input_contacts form-control req', 'required']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('theme', 'Тема письма: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('theme', null, ['class'=>'change_input_contacts form-control']) }}</td>
					</tr>
					<tr>
						<td class="req">{{ Form::label('body', 'Текст: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::textarea('body', null, ['class'=>'change_input_contacts contacts_form_body form-control req', 'required']) }}</td>
					</tr>
				</table>
				{{ Form::submit('Отправить', ['class'=>'btn submit_field save_button']) }} 
			{{ Form::close() }}
		</div> --}}
		<button class="btn btn-info contact_form_button">Свяжитесь с нами</button>
		<iframe 
			width="550"
			height="300" 
			frameborder="0"
			style="border:0"
			src="https://www.google.com/maps/embed/v1/place?q=%D0%A1%D0%B0%D0%BD%D0%BA%D1%82-%D0%9F%D0%B5%D1%82%D0%B5%D1%80%D0%B1%D1%83%D1%80%D0%B3%2C%D1%83%D0%BB.%D0%91%D0%BE%D0%BB%D0%BE%D1%82%D0%BD%D0%B0%D1%8F%2C%D0%B4.16&key=AIzaSyBR6ruk6PgDAPS4ObXScQCVKtw9a2y0RXw">
		</iframe>	
	</div>
@stop
