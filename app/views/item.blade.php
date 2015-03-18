@extends('layout')
@extends('header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen s_item_wrap">
		{{-- BREADCRUMBS FOR ITEM --}}
		<h2 class = "groups_title breadcrumbs">
			@if ($env == 'items')
				{{ HTML::link($env, 'Техника') }}
			@elseif ($env == 'spares')
				{{ HTML::link($env, 'Запчасти') }}
			@endif
			<span class='glyphicon glyphicon-arrow-right'></span>

			{{ HTML::link("$env/".$item->category."/Всё", $item->category) }}
			<span class='glyphicon glyphicon-arrow-right'></span>
			{{ HTML::link("$env/".$item->category."/".$item->subcategory, $item->subcategory) }}
			<span class='glyphicon glyphicon-arrow-right'></span>
			{{ HTML::link(URL::current(), $item->item) }}
		</h2>
		{{-- END BREADCRUMBS --}}
		<div class="s_item_head_block">
			<h1 class="s_item_heading contacts_heading">{{ $item->item }}</h1>
			<h4 class="item_page_recommended_heading">Товары из этой категории</h4>
		</div>
		<div class="single_item">
			<div class="s_item_descr">
				{{ HTML::image("photos/$item->photo", 'item', ['class'=>'s_item_img']) }}
				<div class="s_item_creteries">
					<table class="s_itiem_table">
					<tr>
						<td colspan='2'> @if ($item->type == 'ЗИП') Запчасти @else Техника @endif </td>
					</tr>
					<tr>
						<td>Бренд:&nbsp&nbsp&nbsp&nbsp</td>
						<td class=''>{{ $item->producer }}</td>
					</tr>
					<tr>
						<td>Код:</td>
						<td class=''>{{ $item->code }}</td>
					</tr>
					<tr>
						<td>Тип:&nbsp</td>
						<td class=''>{{ $item->category }}</td>
					</tr>
					<tr>
						<td>Вид:&nbsp</td>
						<td class=''>{{ $item->subcategory }}</td>
					</tr>											
					</table>
				</div>
				<div class="s_item_button">
					@if ($item->procurement == 'МРП') 
						<p class="s_item_proc">В наличии</p>
					@else 
						<p class="s_item_proc">Под заказ</p>
					@endif 
					<div class="s_item_price">
						<p class="s_item_price_p s_item_price_number">{{ $item->price }}&nbsp</p>
						<p class="s_item_price_p s_item_price_currency">{{ $item->currency }}</p>
					</div>
					<a href="/order?item_id={{ $item->id }}" class="btn btn-default s_item_btn">Заказать</a>
				</div>
			</div>
			<div class="s_item_info_big">
				<p>{{ $item->description }}</p>
			</div>
		</div>
		{{-- SAME ITEMS --}}
		<div class="rec_item">
			@foreach ($same as $item)
				<div class="catalog_item s_item_item">
					<h2 class="catalog_item_header">
						{{ HTML::link("view_item/$item->item?item_id=$item->id", $item->item ) }}
					</h2>
					<div class="item_photo_div">
						{{ HTML::image("photos/$item->photo", 'item', ['class'=>'item_photo']) }}
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
						<p class="catalog_item_price_p catalog_item_price_number">{{ $item->price }}&nbsp</p>
						<p class="catalog_item_price_p catalog_item_price_currency">{{ $item->currency }}</p>
					</div>
				</div>
			@endforeach
			{{-- END SAME ITEMS --}}
		</div>	
	</div>
@stop












