@extends('layout')
@extends('admin/admin_header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
		<h2 class="groups_title">{{ $current }}</h2>
		<h2 class='msg'>{{Session::get('msg') ? Session::get('msg') : '' }}</h2>
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

		{{-- ITEMS --}}
		<div class="menu catalog_menu">
			@foreach($items as $item)
				<div class="catalog_item">
					<h2 class="catalog_item_header">
						{{ HTML::link("view_item/".urlencode2($item->item)."?item_id=$item->id", $item->item ) }}
					</h2>
					<div class="item_photo_div">
					<?php 
					$path = public_path().DIRECTORY_SEPARATOR.'photos'.DIRECTORY_SEPARATOR.$item->photo;
					?>
					@if(File::exists($path))
						{{ HTML::image("photos/$item->photo", 'item', ['class'=>'item_photo']) }}
					@else 
						{{ HTML::image("photos/no_image.png", 'item', ['class'=>'item_photo']) }}
					@endif
					</div>
					<table class="info_item_page info_item_page_catalog">
						<tr>
							<td class='info_page_item_title'>Бренд:&nbsp</td>
							<td class='info_page_item_text'>{{ $item->producer }}</td>
						</tr>
						<tr>
							<td class='info_page_item_title'>Код:&nbsp</td>
							<td class='info_page_item_text'>{{ $item->code }}</td>
						</tr>
						<tr>
							<td class='info_page_item_title'>Тип:&nbsp</td>
							<td class='info_page_item_text'>{{ $item->category }}</td>
						</tr>
						<tr>
							<td class='info_page_item_title'>Вид:&nbsp</td>
							<td class='info_page_item_text'>{{ $item->subcategory }}</td>
						</tr>
					</table>
					{{-- NEED FIXES --}}
					<a href="/order?item_id={{ $item->id }}" class="btn btn-default items_button items_order">Заказать</a>

					<div class='info_page_item_procurement'>
						@if ($item->procurement == 'МРП') В наличии @else Под заказ @endif 
					</div>
					<div class="catalog_item_price">
						@if($item->price == 0.00)
							<p class="catalog_item_price_p" style="float:left;">
								По запросу
							</p>	
						@else
							<p class="catalog_item_price_p catalog_item_price_number">
								{{ $item->price }}&nbsp
							</p>
						@endif
						<p class="catalog_item_price_p catalog_item_price_currency">
							@if($item->price != 0.00)
								{{ $item->currency }}
							@endif
						</p>
					</div>
				</div>
			@endforeach
		</div>
		{{-- END ITEMS --}}

		{{-- PAGINATION --}}
		<div class="catalog_bottom_pages">
			{{ $items->appends(Request::except('page'))->links('zurb_presenter') }}
		</div>
		{{-- END PAGINATION --}}
		{{ HTML::link('/admin', 'Добавить товар', ['class'=>"btn uni_btn m_adm_btn"]) }}
		{{ HTML::link('/admin/info', 'Панель информации', ['class'=>"btn uni_btn m_adm_btn add_adm_btn"]) }}
	</div><!-- width_960 catalog_gen -->
@stop