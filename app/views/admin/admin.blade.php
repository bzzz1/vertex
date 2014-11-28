@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('css')
	{{ HTML::style('css/style.css') }}
@stop

@section('body')
	<div class="width_960">
		<div class="catalog_gen">
			<div class='change_item'>
				<h2 class="groups_title"> @if (isset($element->code)) Код: {{ $element->code }} @else Добавить товар @endif </h2>
				{{ Form::model($element, ['route' => "codeSearchAdmin", 'method' => 'POST', 'class'=>'item_form']) }}
					<table>
						<tr>
							<td>{{ Form::label('item', 'Название: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::text('item', null, ['placeholder'=>"", 'class'=>'change_input']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('description', 'Описание: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::textarea('description', null, ['placeholder'=>"", 'class'=>'change_input']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('producer', 'Бренд: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::text('producer', null, ['placeholder'=>"", 'class'=>'change_input change_input_short']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('price', 'Цена: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::number('price', null, ['class'=>'change_input change_input_code']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('currency', 'Валюта: ', ['class'=>'main_label']) }}</td>
							<td>
								{{ Form::radio('currency', 'РУБ', true, ['class'=>'change_radio']) }}
								{{ Form::label('currency', 'РУБ', ['class'=>'small_label']) }}
								{{ Form::radio('currency', 'USD', false, ['class'=>'change_radio']) }}
								{{ Form::label('currency', 'USD', ['class'=>'small_label']) }}
								{{ Form::radio('currency', 'EUR', false, ['class'=>'change_radio']) }}
								{{ Form::label('currency', 'EUR', ['class'=>'small_label']) }}
							</td>
						</tr>
						<tr>
							<td>{{ Form::label('procurement', 'Закупка: ', ['class'=>'main_label']) }}</td>
							<td>
								{{ Form::radio('procurement', 'ТВС', true, ['class'=>'change_radio']) }}
								{{ Form::label('procurement', 'ТВС (Под заказ)', ['class'=>'small_label']) }}
								{{ Form::radio('procurement', 'МРП', false, ['class'=>'change_radio']) }}
								{{ Form::label('procurement', 'МРП (В наличии)', ['class'=>'small_label']) }}
							</td>
						</tr>
						<tr>
							<td>{{ Form::label('type', 'Обрудование или ЗИП: ', ['class'=>'main_label']) }}</td>
							<td>
								{{ Form::radio('type', 'оборудование', true, ['class'=>'change_radio']) }}
								{{ Form::label('type', 'Техника', ['class'=>'small_label']) }}
								{{ Form::radio('type', 'ЗИП', false, ['class'=>'change_radio']) }}
								{{ Form::label('type', 'Запчасти', ['class'=>'small_label']) }}
							</td>
						</tr>
						<tr>
							<td>{{ Form::label('category', 'Категория (тип): ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::select('category', ['Барное'=>'Барное', 'Нейтральное'=>'Нейтральное', 'Посуда и инвентарь'=>'Посуда и инвентарь', 'Посудомоечное'=>'Посудомоечное', 'Технологическое'=>'Технологическое', 'Упаковочное'=>'Упаковочное', 'Хлебопекарное'=>'Хлебопекарное', 'Холодильное'=>'Холодильное']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('subcategory', 'Подкатегория (вид): ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::text('subcategory', null, ['placeholder'=>"", 'class'=>'change_input change_input_short']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('code', 'Код: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::text('code', null, ['placeholder'=>"", 'class'=>'change_input change_input_code']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('photo', 'Изображение: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::file('photo', ['class'=>'change_input input_file']) }}255px * 255px</td>
						</tr>
					</table>
				{{ Form::close() }}

				<div class='item_preview'>
					<div class="catalog_item">
						<h2 class="catalog_item_header">{{ $element->item }}</h2>
						<!--****************************************************
						| ITEM PAGE
						*****************************************************-->
						<div class="item">
							<h1 class="item_page_header">{{ $element->item }}</h1>
							@if (isset($element->photo))
								{{ HTML::image("photos/$element->photo", 'item', ['class'=>'item_page_photo']) }}
						 	@else 
								{{ HTML::image("photos/no_image.png", 'item', ['class'=>'item_page_photo']) }}
							@endif
							<div class="item_page_right_div">
								<table class="info_item_page">
									<tr>
										<td colspan='2'> @if ($element->type == 'ЗИП') Запчасти @else Техника @endif </td>
									</tr>
									<tr>
										<td>Бренд:&nbsp&nbsp&nbsp&nbsp</td>
										<td class='info_page_item_text win_item_text'>{{ $element->producer }}</td>
									</tr>
									<tr>
										<td>Код:</td>
										<td class='info_page_item_text win_item_text'>{{ $element->code }}</td>
									</tr>
									<tr>
										<td>Тип:&nbsp</td>
										<td class='info_page_item_text win_item_text'>{{ $element->category }}</td>
									</tr>
									<tr>
										<td>Вид:&nbsp</td>
										<td class='info_page_item_text win_item_text'>{{ $element->subcategory }}</td>
									</tr>											
								</table>
								<div class='info_page_item_procurement'>
									@if ($element->procurement == 'МРП') В наличии @else Под заказ @endif 
								</div>
								<div class="item_price">
									<p class="item_price_p item_price_number">{{ $element->price }}&nbsp</p>
									<p class="item_price_p item_price_currency">{{ $element->currency }}</p>
								</div>
							</div><!-- item_page_right_div -->
							<div class="description_item">
								<p>{{ $element->description }}</p>
							</div><!-- description_item -->
						</div><!-- item -->	
						<!--****************************************************-->
						@if (isset($element->photo))
							{{ HTML::image("photos/$element->photo", 'item', ['class'=>'item_photo']) }}
					 	@else 
							{{ HTML::image("photos/no_image.png", 'item', ['class'=>'item_photo']) }}
						@endif
						<table class="info_item_page">
							<tr>
								<td>Бренд:&nbsp</td>
								<td class='info_page_item_text'>{{ $element->producer }}</td>
							</tr>
							<tr>
								<td>Код:&nbsp</td>
								<td class='info_page_item_text'>{{ $element->code }}</td>
							</tr>
							<tr>
								<td>Тип:&nbsp</td>
								<td class='info_page_item_text'>{{ $element->category }}</td>
							</tr>
							<tr>
								<td>Вид:&nbsp</td>
								<td class='info_page_item_text'>{{ $element->subcategory }}</td>
							</tr>
						</table>
						<div class='info_page_item_procurement'>
							@if ($element->procurement == 'МРП') В наличии @else Под заказ @endif 
						</div>
						<div class="catalog_item_price">
							<p class="catalog_item_price_p catalog_item_price_number">{{ $element->price }}&nbsp</p>
							<p class="catalog_item_price_p catalog_item_price_currency">{{ $element->currency }}</p>
						</div>
						{{ HTML::link('/admin/info', 'Перейти к редактированию информации', ['class'=>"info_page_admin_button"]) }}
					</div>
				</div>
			</div><!-- change_item -->
		</div><!-- catalog_gen -->
	</div><!-- width_960 -->
@stop