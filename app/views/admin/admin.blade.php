@extends('layout')

@extends('admin/admin_header')

@extends('footer')



@section('body')

	<div class="width_960 catalog_gen">

		<div class='change_item' ng-app='preview' ng-controller='PreviewController as previewCtrl' ng-cloak>

			<div class="headers" {{ isset($element->code) ? "ng-init='stat=\"update\"'" : ''}}>

				<h2 class="groups_title">{{ $element->code or 'Добавить товар'}}</h2>

				<h2 class='msg'>{{ Session::get('msg') ? Session::get('msg') : '' }}</h2>

				<h2 class='error_msg'>{{ Session::get('error_msg') ? Session::get('error_msg') : '' }}</h2>

			</div>

			<?php

				// Should work by itself without angular

				// if (!!Input::old()) {

				// 	$element = new Item;

				// 	$element->fill(Input::old());

				// }			

			?>

			{{ Form::model($element, ['url'=>['/admin/updateItem', $element->code], 'files'=>true, 'method'=>'POST', 'class'=>'item_form']) }}

				<table>

					<tr>

						<td>{{ Form::label('item', 'Название: ', ['class'=>'main_label']) }}</td>

						<td>{{ Form::text('item', null, ['class'=>'change_input', 'ng-model'=>'element.item', 'required']) }}</td>

					</tr>

					<tr>

						<td>{{ Form::label('description', 'Описание: ', ['class'=>'main_label']) }}</td>

						<td  ng-init='element.description="Описание отсутствует"'>{{ Form::textarea('description', null, ['class'=>'change_input', 'ng-model'=>'element.description']) }}</td>

					</tr>

					<tr>

						<td>{{ Form::label('producer', 'Бренд: ', ['class'=>'main_label']) }}</td>

						<td>{{ Form::text('producer', null, ['class'=>'change_input change_input_short', 'ng-model'=>'element.producer', 'required']) }}</td>

					</tr>

					<tr>

						<td>{{ Form::label('price', 'Цена: ', ['class'=>'main_label']) }}</td>

						<td>{{ Form::text('price', null, ['class'=>'change_input change_input_code', 'ng-model'=>'element.price', 'required']) }}</td>

					</tr>

					<tr>

						<td>{{ Form::label('currency', 'Валюта: ', ['class'=>'main_label']) }}</td>

						<td ng-init='element.currency="РУБ"'>

							{{ Form::radio('currency', 'РУБ', true, ['class'=>'change_radio', 'ng-model'=>'element.currency']) }}

							{{ Form::label('currency', 'РУБ', ['class'=>'small_label']) }}

							{{ Form::radio('currency', 'USD', false, ['class'=>'change_radio', 'ng-model'=>'element.currency']) }}

							{{ Form::label('currency', 'USD', ['class'=>'small_label']) }}

							{{ Form::radio('currency', 'EUR', false, ['class'=>'change_radio', 'ng-model'=>'element.currency']) }}

							{{ Form::label('currency', 'EUR', ['class'=>'small_label']) }}

						</td>

					</tr>

					<tr>

						<td>{{ Form::label('procurement', 'Закупка: ', ['class'=>'main_label']) }}</td>

						<td ng-init='element.procurement="ТВС"'>

							{{ Form::radio('procurement', 'ТВС', true, ['class'=>'change_radio', 'ng-model'=>'element.procurement']) }}

							{{ Form::label('procurement', 'ТВС (Под заказ)', ['class'=>'small_label']) }}

							{{ Form::radio('procurement', 'МРП', false, ['class'=>'change_radio', 'ng-model'=>'element.procurement']) }}

							{{ Form::label('procurement', 'МРП (В наличии)', ['class'=>'small_label']) }}

						</td>

					</tr>

					<tr>

						<td>{{ Form::label('type', 'Обрудование или ЗИП: ', ['class'=>'main_label']) }}</td>

						<td ng-init='element.type="оборудование"'>

							{{ Form::radio('type', 'оборудование', true, ['class'=>'change_radio', 'ng-model'=>'element.type']) }}

							{{ Form::label('type', 'Техника', ['class'=>'small_label']) }}

							{{ Form::radio('type', 'ЗИП', false, ['class'=>'change_radio', 'ng-model'=>'element.type']) }}

							{{ Form::label('type', 'Запчасти', ['class'=>'small_label']) }}

						</td>

					</tr>

					<tr>

						<td>{{ Form::label('category', 'Категория (тип): ', ['class'=>'main_label']) }}</td>

						<td>

							<select name='category' ng-init='element.category="Барное"' ng-model='element.category'>

								<option ng-repeat="category in categories" value="[[category]]">[[category]]</option>

							</select>

						</td>

						{{-- Form::select('category', [], null, ['ng-model'=>'element.category', 'ng-options'=>'element.name as category.value for category in categories']) --}}

					</tr>

					<tr>

						<td>{{ Form::label('subcategory', 'Подкатегория (вид): ', ['class'=>'main_label']) }}</td>

						<td>{{ Form::text('subcategory', null, ['class'=>'change_input change_input_short', 'ng-model'=>'element.subcategory', 'required']) }}</td>

					</tr>

					<tr>

						<td>{{ Form::label('code', 'Код: ', ['class'=>'main_label']) }}</td>

						<td>{{ Form::text('code', null, ['class'=>'change_input change_input_code', 'ng-model'=>'element.code', 'required']) }}</td>

					</tr>

					<tr>

						<td>{{ Form::label('photo_label', 'Изображение: 255px*255px', ['class'=>'main_label']) }}</td>

						<td>

							@if (isset($element->photo))

								{{ Form::text('photo_name', null, ['disabled', 'class'=>'change_input input_file_name photo_name', 'ng-model'=>'element.photo']) }}

								{{ Form::hidden('photo_name', '[[ element.photo ]]', ['class'=>'change_input input_file_name photo_name']) }}

						 	@else 

								{{ Form::text('photo_name', null, ['disabled', 'placeholder'=>'no_image.png', 'class'=>'change_input input_file_name photo_name', 'ng-model'=>'element.photo']) }}

								{{-- use default value from mysql in not $element->photo --}}

							@endif

							<div class="delete_icon"></div>

							{{ Form::file('photo', ['class'=>'change_input']) }}

						</td>

					</tr>

				</table>

				{{ Form::submit('Сохранить', ['class'=>'submit_field save_button']) }}
				<input class="btn btn-info" value="Очистить" style="float: right;" ng-click='clear_form_data()'>

			{{ Form::close() }}



			@include('admin/admin_preview')



		</div><!-- change_item -->

		<a href='/admin/changeItem' class='admin_button_link'>Добавить товар</a>

		<a href='/admin/info' class='admin_button_link'>Панель информации</a>

	</div><!-- width_960 catalog_gen -->

@stop