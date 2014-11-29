@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
		<div class='change_item'  ng-app='preview'  ng-controller='PreviewController as previewCtrl'>
			<h2 class="groups_title"> @if (isset($element->code)) Код: {{ $element->code }} @else Добавить товар @endif </h2>
			{{ Form::model($element, ['route' => "codeSearchAdmin", 'method' => 'POST', 'class'=>'item_form']) }}
				<table>
					<tr>
						<td>{{ Form::label('item', 'Название: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('item', null, ['placeholder'=>"", 'class'=>'change_input', 'ng-model'=>'element.item', 'ng-init'=>"element.item="."'"."$element->item"."'"]) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('description', 'Описание: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::textarea('description', null, ['placeholder'=>"", 'class'=>'change_input', 'ng-model'=>'element.description']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('producer', 'Бренд: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('producer', null, ['placeholder'=>"", 'class'=>'change_input change_input_short', 'ng-model'=>'element.producer']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('price', 'Цена: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::number('price', null, ['class'=>'change_input change_input_code', 'ng-model'=>'element.price']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('currency', 'Валюта: ', ['class'=>'main_label']) }}</td>
						<td>
							{{ Form::radio('currency', 'РУБ', true, ['checked', 'class'=>'change_radio', 'ng-model'=>'element.currency']) }}
							{{ Form::label('currency', 'РУБ', ['class'=>'small_label']) }}
							{{ Form::radio('currency', 'USD', false, ['class'=>'change_radio', 'ng-model'=>'element.currency']) }}
							{{ Form::label('currency', 'USD', ['class'=>'small_label']) }}
							{{ Form::radio('currency', 'EUR', false, ['class'=>'change_radio', 'ng-model'=>'element.currency']) }}
							{{ Form::label('currency', 'EUR', ['class'=>'small_label']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('procurement', 'Закупка: ', ['class'=>'main_label']) }}</td>
						<td>
							{{ Form::radio('procurement', 'ТВС', true, ['class'=>'change_radio', 'ng-model'=>'element.procurement']) }}
							{{ Form::label('procurement', 'ТВС (Под заказ)', ['class'=>'small_label']) }}
							{{ Form::radio('procurement', 'МРП', false, ['class'=>'change_radio', 'ng-model'=>'element.procurement']) }}
							{{ Form::label('procurement', 'МРП (В наличии)', ['class'=>'small_label']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('type', 'Обрудование или ЗИП: ', ['class'=>'main_label']) }}</td>
						<td>
							{{ Form::radio('type', 'оборудование', true, ['class'=>'change_radio', 'ng-model'=>'element.type']) }}
							{{ Form::label('type', 'Техника', ['class'=>'small_label']) }}
							{{ Form::radio('type', 'ЗИП', false, ['class'=>'change_radio', 'ng-model'=>'element.type']) }}
							{{ Form::label('type', 'Запчасти', ['class'=>'small_label']) }}
						</td>
					</tr>
					<tr>
						<td>{{ Form::label('category', 'Категория (тип): ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::select('category', ['Барное'=>'Барное', 'Нейтральное'=>'Нейтральное', 'Посуда и инвентарь'=>'Посуда и инвентарь', 'Посудомоечное'=>'Посудомоечное', 'Технологическое'=>'Технологическое', 'Упаковочное'=>'Упаковочное', 'Хлебопекарное'=>'Хлебопекарное', 'Холодильное'=>'Холодильное'], ['ng-model'=>'element.category']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('subcategory', 'Подкатегория (вид): ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('subcategory', null, ['placeholder'=>"", 'class'=>'change_input change_input_short', 'ng-model'=>'element.subcategory']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('code', 'Код: ', ['class'=>'main_label']) }}</td>
						<td>{{ Form::text('code', null, ['placeholder'=>"", 'class'=>'change_input change_input_code', 'ng-model'=>'element.code']) }}</td>
					</tr>
					<tr>
						<td>{{ Form::label('photo', 'Изображение: 255px*255px', ['class'=>'main_label']) }}</td>
						<td>
							@if (isset($element->photo))
								{{ Form::text('photo', null, ['disabled', 'class'=>'change_input input_file_name', 'ng-model'=>'element.photo']) }}
						 	@else 
								{{ Form::text('photo', 'no_image.png', ['disabled', 'class'=>'change_input input_file_name', 'ng-model'=>'element.photo']) }}
							@endif
							{{ Form::file('photo', ['class'=>'change_input']) }}
						</td>
					</tr>
				</table>
			{{ Form::close() }}

			<div class='item_preview'>
				<div class="catalog_item">
					<h2 class="catalog_item_header">@{{ element.item }}</h2>
					<!--****************************************************
					| ITEM PAGE
					*****************************************************-->
					<div class="item">
						<h1 class="item_page_header">@{{ element.item }}</h1>
						<img ng-show='@{{element.photo}}' ng-src="photos/@{{element.photo}}" alt="item" class='item_page_photo'/>
						<img ng-hide='@{{element.photo}}' ng-src="photos/no_image.png" alt="item" class='item_page_photo'/>
						<div class="item_page_right_div">
							<table class="info_item_page">
								<tr>
									<td colspan='2'> @if ($element->type == 'ЗИП') Запчасти @else Техника @endif </td>
								</tr>
								<tr>
									<td>Бренд:&nbsp&nbsp&nbsp&nbsp</td>
									<td class='info_page_item_text win_item_text'>@{{ element.producer }}</td>
								</tr>
								<tr>
									<td>Код:</td>
									<td class='info_page_item_text win_item_text'>@{{ element.code }}</td>
								</tr>
								<tr>
									<td>Тип:&nbsp</td>
									<td class='info_page_item_text win_item_text'>@{{ element.category }}</td>
								</tr>
								<tr>
									<td>Вид:&nbsp</td>
									<td class='info_page_item_text win_item_text'>@{{ element.subcategory }}</td>
								</tr>											
							</table>
							<div class='info_page_item_procurement'>
								@if ($element->procurement == 'МРП') В наличии @else Под заказ @endif 
							</div>
							<div class="item_price">
								<p class="item_price_p item_price_number">@{{ element.price }}&nbsp</p>
								<p class="item_price_p item_price_currency">@{{ element.currency }}</p>
							</div>
						</div><!-- item_page_right_div -->
						<div class="description_item">
							<p>@{{ element.description }}</p>
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
							<td class='info_page_item_text'>@{{ element.producer }}</td>
						</tr>
						<tr>
							<td>Код:&nbsp</td>
							<td class='info_page_item_text'>@{{ element.code }}</td>
						</tr>
						<tr>
							<td>Тип:&nbsp</td>
							<td class='info_page_item_text'>@{{ element.category }}</td>
						</tr>
						<tr>
							<td>Вид:&nbsp</td>
							<td class='info_page_item_text'>@{{ element.subcategory }}</td>
						</tr>
					</table>
					<div class='info_page_item_procurement'>
						@if ($element->procurement == 'МРП') В наличии @else Под заказ @endif 
					</div>
					<div class="catalog_item_price">
						<p class="catalog_item_price_p catalog_item_price_number">@{{ element.price }}&nbsp</p>
						<p class="catalog_item_price_p catalog_item_price_currency">@{{ element.currency }}</p>
					</div>
				</div>
			</div>
		</div><!-- change_item -->
		{{ HTML::link('/admin', 'Добавить товар', ['class'=>"admin_button_link"]) }}
		{{ HTML::link('/admin/info', 'Панель информации', ['class'=>"admin_button_link"]) }}
	</div><!-- width_960 catalog_gen -->
@stop