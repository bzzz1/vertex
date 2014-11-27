@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('css')
	{{ HTML::style('css/style.css') }}
@stop

@section('body')
	<div class="width_960">
		<div class="catalog_gen">
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
						</table>
						<div class='info_page_item_procurement'>
							@if ($item->procurement == 'МРП') В наличии @else Под заказ @endif 
						</div>
						<div class="catalog_item_price">
							<p class="catalog_item_price_p catalog_item_price_number">{{ $item->price }}&nbsp</p>
							<p class="catalog_item_price_p catalog_item_price_currency">{{ $item->currency }}</p>
						</div>
						<!--****************************************************
						| ITEM PAGE
						*****************************************************-->
						<div class="item" style='display: none; position: absolute'>
							<h1 class="item_page_header">{{ $item->item }}</h1>
							<div class="item_main clearfix">
								{{ HTML::image("photos/$item->photo", 'item', ['class'=>'item_photo']) }}
								<div class="item_page_right_div">
									<table class="info_item_page">
										<tr>
											<td>Бренд:</td>
											<td class='info_page_item_text'>{{ $item->producer }}</td>
										</tr>
										<tr>
											<td>Код:</td>
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
									</table>
									<div class='info_page_item_procurement'>
										@if ($item->procurement == 'МРП') В наличии @else Под заказ @endif 
									</div>
									<div class="item_price">
										<p class="item_price_p item_price_number">{{ $item->price }}&nbsp</p>
										<p class="item_price_p item_price_currency">{{ $item->currency }}.</p>
									</div>
								</div><!-- item_page_right_div -->
								<div class="description_item">
									<p>Холодильный шкаф TM 40 G предназначен для размещения на прилавках или монтирования на стену за стойкой бара. Холодильный шкаф помогает оптимизировать рабочее пространство внутри бара. В таком холодильном шкафу удобно хранить различные охлажденные продукты, которые бармен использует в процессе работы. Для удобства демонстрации хранимых в таком холодильнике продуктов предусмотрена стеклянная дверь и внутренняя подсветка.
									Материал корпуса - крашенный метал. Внутренний объем шкафа выполнен из пластика.
									Холодильный шкаф TM 40 G имеет электромеханическую систему управления.</p>
								</div><!-- description_item -->
							</div><!-- item_main clearfix -->
						</div><!-- item -->	
					</div>
				@endforeach
			</div><!-- menu catalog_menu -->
			<div class="catalog_bottom_pages">
				{{ $items->appends(Request::except('page'))->links('zurb_presenter') }}
			</div>


			<div class='change_item'>
				<h2 class="groups_title">Код: {{-- $code --}}</h2>
				{{ Form::open(array('route' => "codeSearchAdmin", 'method' => 'POST', 'class'=>'item_form')) }}
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
							<td>{{ Form::text('producer', null, ['placeholder'=>"", 'class'=>'change_input']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('price', 'Цена: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::text('price', null, ['placeholder'=>"", 'class'=>'change_input']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('type', 'Обрудование или ЗИП: ', ['class'=>'main_label']) }}</td>
							<td>
								{{ Form::label('type', 'Оборудование: ') }}
								{{ Form::radio('type', 'оборудование', true, ['class'=>'change_radio']) }}
								{{ Form::label('type', 'ЗИП: ') }}
								{{ Form::radio('type', 'ЗИП', false, ['class'=>'change_radio']) }}
							</td>
						</tr>
						<tr>
							<td>{{ Form::label('category', 'Категория (тип): ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::select('category', ['Under 18', '19 to 30', 'Over 30']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('subcategory', 'Подкатегория (вид): ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::text('subcategory', null, ['placeholder'=>"", 'class'=>'change_input']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('currency', 'Валюта: ', ['class'=>'main_label']) }}</td>
							<td>
								{{ Form::label('currency', 'РУБ: ') }}
								{{ Form::radio('currency', 'РУБ', true, ['class'=>'change_radio']) }}
								{{ Form::label('currency', 'USD: ') }}
								{{ Form::radio('currency', 'USD', false, ['class'=>'change_radio']) }}
								{{ Form::label('currency', 'EUR: ') }}
								{{ Form::radio('currency', 'EUR', false, ['class'=>'change_radio']) }}
							</td>
						</tr>
						<tr>
							<td>{{ Form::label('procurement', 'Закупка: ', ['class'=>'main_label']) }}</td>
							<td>
								{{ Form::label('procurement', 'ТВС: ') }}
								{{ Form::radio('procurement', 'ТВС', true, ['class'=>'change_radio']) }}
								{{ Form::label('procurement', 'МРП: ') }}
								{{ Form::radio('procurement', 'МРП', false, ['class'=>'change_radio']) }}
							</td>
						</tr>
						<tr>
							<td>{{ Form::label('code', 'Код: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::text('code', null, ['placeholder'=>"", 'class'=>'change_input']) }}</td>
						</tr>
						<tr>
							<td>{{ Form::label('photo', 'Изображение: ', ['class'=>'main_label']) }}</td>
							<td>{{ Form::file('photo', ['class'=>'change_input input_file']) }} 255 x 255</td>
						</tr>
					</table>
				{{ Form::close() }}

				<div class='item_preview'>

					<div class="catalog_item">
						<h2 class="catalog_item_header">{{ $item->item }}</h2>
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
						</table>
						<div class='info_page_item_procurement'>
							@if ($item->procurement == 'МРП') В наличии @else Под заказ @endif 
						</div>
						<div class="catalog_item_price">
							<p class="catalog_item_price_p catalog_item_price_number">{{ $item->price }}&nbsp</p>
							<p class="catalog_item_price_p catalog_item_price_currency">{{ $item->currency }}</p>
						</div>
						<!--****************************************************
						| ITEM PAGE
						*****************************************************-->
						<div class="item" style='display: none; position: absolute'>
							<h1 class="item_page_header">{{ $item->item }}</h1>
							<div class="item_main clearfix">
								{{ HTML::image("photos/$item->photo", 'item', ['class'=>'item_photo']) }}
								<div class="item_page_right_div">
									<table class="info_item_page">
										<tr>
											<td>Бренд:</td>
											<td class='info_page_item_text'>{{ $item->producer }}</td>
										</tr>
										<tr>
											<td>Код:</td>
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
									</table>
									<div class='info_page_item_procurement'>
										@if ($item->procurement == 'МРП') В наличии @else Под заказ @endif 
									</div>
									<div class="item_price">
										<p class="item_price_p item_price_number">{{ $item->price }}&nbsp</p>
										<p class="item_price_p item_price_currency">{{ $item->currency }}.</p>
									</div>
								</div><!-- item_page_right_div -->
								<div class="description_item">
									<p>Холодильный шкаф TM 40 G предназначен для размещения на прилавках или монтирования на стену за стойкой бара. Холодильный шкаф помогает оптимизировать рабочее пространство внутри бара. В таком холодильном шкафу удобно хранить различные охлажденные продукты, которые бармен использует в процессе работы. Для удобства демонстрации хранимых в таком холодильнике продуктов предусмотрена стеклянная дверь и внутренняя подсветка.
									Материал корпуса - крашенный метал. Внутренний объем шкафа выполнен из пластика.
									Холодильный шкаф TM 40 G имеет электромеханическую систему управления.</p>
								</div><!-- description_item -->
							</div><!-- item_main clearfix -->
						</div><!-- item -->	
					</div>

				</div>
			</div>
		</div><!--catalog gen -->
	</div><!-- width_960 catalog_gen -->
@stop