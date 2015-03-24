@extends('layout')
@extends('header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
		{{-- <ol class="breadcrumb">
		  <li><a href="/">Главная</a></li>
		  <li class="active">Контакты</li>
		</ol> --}}
		<h2 class="contacts_heading main_cont_heading">Контактная информация</h2>
		<hr class="main_hr">
		<div class="contacts_text_block">
			<div class="contacts_left_block">		
				<div class="adress_block">
					<h3 class="contacts_heading">Мы находимся по адрессу:</h3>
					<p>
						Россия,<br>
						Санкт-Петербург<br>
						Улица Кантемировская д.12<br> 
						БЦ "Радуга"
					</p>
				</div>
				<div class="time_block">
					<h3 class="contacts_heading">График работы:</h3>
					<p>
						ПН-ПТ 9:00-18:00<br>
						СБ - выходной<br>
						ВС - выходной
					</p>
				</div>
				<div class="tel_block">
					<h3 class="contacts_heading">Звоните нам:</h3>
					<p>
						8 (812) 982 33 54<br>
						8 (905) 222 33 54<br>
						<a class="footer_contacts_p contact_form_button">Обратный звонок</a>
					</p>
				</div>
			</div>
			<iframe 
				width="480"
				height="380" 
				frameborder="0"
				style="border:0"
				src="https://www.google.com/maps/embed/v1/place?q=%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D1%8F%2C%20%D0%B3%D0%BE%D1%80%D0%BE%D0%B4%20%D0%A1%D0%B0%D0%BD%D0%BA%D1%82-%D0%9F%D0%B5%D1%82%D0%B5%D1%80%D0%B1%D1%83%D1%80%D0%B3%2C%20%D0%A1%D0%B0%D0%BD%D0%BA%D1%82-%D0%9F%D0%B5%D1%82%D0%B5%D1%80%D0%B1%D1%83%D1%80%D0%B3%2C%20%D0%9A%D0%B0%D0%BD%D1%82%D0%B5%D0%BC%D0%B8%D1%80%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F%20%D1%83%D0%BB%D0%B8%D1%86%D0%B0%2012&key=AIzaSyBR6ruk6PgDAPS4ObXScQCVKtw9a2y0RXw">
			</iframe>	
		</div>
		<div class="contacts_rest">	
			<div class="contacts_inline_block">
				<div class="contacts_var">
					<h3 class="contacts_var_head">По вопросам приобритения</h3>
					<p>Иванов Иван Иванович</p>
					<p>+7(912) 987 78 43</p>
				</div>
				<div class="contacts_var">
					<h3 class="contacts_var_head">По вопросам заказа</h3>
					<p>Иванов Иван Иванович</p>
					<p>+7(912) 987 78 43</p>
				</div>
				<div class="contacts_var">
					<h3 class="contacts_var_head">По вопросам обслуживания</h3>
					<p>Иванов Иван Иванович</p>
					<p>+7(912) 987 78 43</p>
				</div>
			</div>	
		</div>
		<h3 class="ques">Остались вопросы? Напишите нам!</h3>
		<button class="btn btn-info contact_form_button contacts_btn">Задать вопрос</button>
	</div>
@stop
