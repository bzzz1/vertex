@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('css')
	{{ HTML::style('css/style.css') }}
@stop

@section('body')
	<div class="width_960">
		<div class="catalog_gen">

			@if (isset($items))
				<h2 class="groups_title">{{ $current }}</h2>
				<div class="catalog_sort">
					<ul class="catalog_sort_text_ul">
						<li class="catalog_sort_text catalog_sort_text_li">Сортировать по: </li>
						<li class="catalog_sort_titel catalog_sort_text_li">наименованию 
							<?php $q = http_build_query(Input::except(['item', 'order'])); ?>
							{{ HTML::link(URL::current().'?'.$q.'&sort=item&order=desc', '', ['class'=>"icon_tr_dw"]) }}
							{{ HTML::link(URL::current().'?'.$q.'&sort=item&order=asc', '', ['class'=>"icon_tr_up"]) }}
						</li>
						<li class="catalog_sort_price catalog_sort_text_li">цене 
							{{ HTML::link(URL::current().'?'.$q.'&sort=price&order=desc', '', ['class'=>"icon_tr_dw"]) }}
							{{ HTML::link(URL::current().'?'.$q.'&sort=price&order=asc', '', ['class'=>"icon_tr_up"]) }}
						</li>
					</ul>
					<div class="catalog_sort_pages_div">
						{{ $items->appends(Request::except('page'))->links('zurb_presenter') }}
					</div>
				</div><!-- catalog_sort -->
				<div class="menu catalog_menu">
					@foreach($items as $item)
						<div class="catalog_item">
							<h2 class="catalog_item_header">{{ $item->item }}</h2>
							<!--****************************************************
							| ITEM PAGE
							*****************************************************-->
							<div class="item">
								<h1 class="item_page_header">{{ $item->item }}</h1>
								{{ HTML::image("photos/$item->photo", 'item', ['class'=>'item_page_photo']) }}
								<div class="item_page_right_div">
									<table class="info_item_page">
										<tr>
											<td colspan='2'> @if ($item->type == 'ЗИП') Запчасти @else Техника @endif </td>
										</tr>
										<tr>
											<td>Бренд:&nbsp&nbsp&nbsp&nbsp</td>
											<td class='info_page_item_text win_item_text'>{{ $item->producer }}</td>
										</tr>
										<tr>
											<td>Код:</td>
											<td>{{ $item->code }}</td>
										</tr>
										<tr>
											<td>Тип:&nbsp</td>
											<td class='info_page_item_text win_item_text'>{{ $item->category }}</td>
										</tr>
										<tr>
											<td>Вид:&nbsp</td>
											<td class='info_page_item_text win_item_text'>{{ $item->subcategory }}</td>
										</tr>											
									</table>
									<div class='info_page_item_procurement'>
										@if ($item->procurement == 'МРП') В наличии @else Под заказ @endif 
									</div>
									<div class="item_price">
										<p class="item_price_p item_price_number">{{ $item->price }}&nbsp</p>
										<p class="item_price_p item_price_currency">{{ $item->currency }}</p>
									</div>
								</div><!-- item_page_right_div -->
								<div class="description_item">
									<p>{{ $item->description }}</p>
								</div><!-- description_item -->
							</div><!-- item -->	
							<!--****************************************************-->
							{{ HTML::image("photos/$item->photo", 'item', ['class'=>'item_photo']) }}
							<table class="info_item_page">
								<tr>
									<td>Бренд:&nbsp</td>
									<td class='info_page_item_text'>{{ $item->producer }}</td>
								</tr>
								<tr>
									<td>Код:&nbsp</td>
									<td>{{ $item->code }}</td>
								</tr>
								<tr>
									<td>Тип:&nbsp</td>
									<td class='info_page_item_text'>{{ $item->category }}</td>
								</tr>
								<tr>
									<td>Вид:&nbsp</td>
									<td class='info_page_item_text'>{{ $item->subcategory }}</td>
								</tr>
								<tr>
									<td>
										{{ Form::open(array('url' => "/admin/changeItem", 'method' => 'POST', 'class'=>'submit_form')) }}
											{{ Form::hidden('code', "$item->code") }}
											{{ Form::submit('Изменить', ['class'=>'submit_field']) }}&nbsp 
										{{ Form::close() }}
									</td>
									<td>
										{{ Form::open(array('url' => "/admin/deleteItem", 'method' => 'POST', 'class'=>'submit_form')) }}
											{{ Form::hidden('code', "$item->code") }}
											{{ Form::submit('Удалить', ['class'=>'submit_field']) }} 
										{{ Form::close() }}
									</td>
								</tr>
							</table>
							<div class='info_page_item_procurement'>
								@if ($item->procurement == 'МРП') В наличии @else Под заказ @endif 
							</div>
							<div class="catalog_item_price">
								<p class="catalog_item_price_p catalog_item_price_number">{{ $item->price }}&nbsp</p>
								<p class="catalog_item_price_p catalog_item_price_currency">{{ $item->currency }}</p>
							</div>
						</div>
					@endforeach	
				</div><!-- menu catalog_menu -->
				<div class="catalog_bottom_pages">
					{{ $items->appends(Request::except('page'))->links('zurb_presenter') }}
				</div>
			@endif  
			{{-- @if (isset($items)) --}}

			@if (isset($element))
				<div class='change_item'>
					<h2 class="groups_title">Код: {{ $element->code }} </h2>
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
								{{ HTML::image("photos/$element->photo", 'item', ['class'=>'item_page_photo']) }}
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
											<td>{{ $element->code }}</td>
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
							{{ HTML::image("photos/$element->photo", 'item', ['class'=>'item_photo']) }}
							<table class="info_item_page">
								<tr>
									<td>Бренд:&nbsp</td>
									<td class='info_page_item_text'>{{ $element->producer }}</td>
								</tr>
								<tr>
									<td>Код:&nbsp</td>
									<td>{{ $element->code }}</td>
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
							<button class="info_page_admin_button">Перейти к редактированию информации</button>	
						</div>
					</div>
				</div>
			@endif
			{{-- @if (isset($element)) --}}
		</div><!--catalog gen -->
	</div><!-- width_960 catalog_gen -->
@stop