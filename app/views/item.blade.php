@extends('layout')
@extends('header')
@extends('footer')

@section('body')
	<div class="width_960 catalog_gen">
		
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

		{{-- SINGLE ITEM --}}
		<div class="item">
			<h1 class="item_page_header">{{ $item->item }}</h1>
			<div class="item_page_photo_div">
				{{ HTML::image("photos/$item->photo", 'item', ['class'=>'item_page_photo']) }}
			</div>
			<div class="item_page_right_div">
				<table class="info_item_page">
					<tr>
						<td colspan='2'> @if ($item->type == 'ЗИП') Запчасти @else Техника @endif </td>
					</tr>
					<tr>
						<td>Бренд:&nbsp&nbsp&nbsp&nbsp</td>
						<td class='info_page_item_text  win_item_text'>{{ $item->producer }}</td>
					</tr>
					<tr>
						<td>Код:</td>
						<td class='info_page_item_text win_item_text'>{{ $item->code }}</td>
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
				{{-- NEED FIXES --}}
				<a href="/order?item_id={{ $item->id }}" class="btn btn-default items_button items_order">Заказать</a>

				<div class='info_page_item_procurement'>
					@if ($item->procurement == 'МРП') В наличии @else Под заказ @endif 
				</div>
				<div class="item_price">
					<p class="item_price_p item_price_number">{{ $item->price }}&nbsp</p>
					<p class="item_price_p item_price_currency">{{ $item->currency }}</p>
				</div>
			</div>
			<div class="description_item">
				<p>{{ $item->description }}</p>
			</div>
		</div>
		{{-- END SINGLE ITEM --}}

		{{-- SAME ITEMS --}}
		<h4 class="item_page_recommended_heading">Похожие товары</h4>
		@foreach ($same as $item)
			<div class="item">
				<h1 class="catalog_item_header">
					{{ HTML::link("view_item/$item->item?item_id=$item->id", $item->item ) }}
				</h1>
				<div class="item_page_photo_div">
					{{ HTML::image("photos/$item->photo", 'item', ['class'=>'item_page_photo']) }}
				</div>
				<div class="item_page_right_div">
					<table class="info_item_page">
						<tr>
							<td colspan='2'> @if ($item->type == 'ЗИП') Запчасти @else Техника @endif </td>
						</tr>
						<tr>
							<td>Бренд:&nbsp&nbsp&nbsp&nbsp</td>
							<td class='info_page_item_text  win_item_text'>{{ $item->producer }}</td>
						</tr>
						<tr>
							<td>Код:</td>
							<td class='info_page_item_text win_item_text'>{{ $item->code }}</td>
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
					{{-- NEED FIXES --}}
					<a href="/order?item_id={{ $item->item_id }}" class="btn btn-default items_button items_order">Заказать</a>

					<div class='info_page_item_procurement'>
						@if ($item->procurement == 'МРП') В наличии @else Под заказ @endif 
					</div>
					<div class="item_price">
						<p class="item_price_p item_price_number">{{ $item->price }}&nbsp</p>
						<p class="item_price_p item_price_currency">{{ $item->currency }}</p>
					</div>
				</div>
				<div class="description_item">
					<p>{{ $item->description }}</p>
				</div>
			</div>
		@endforeach
		{{-- END SAME ITEMS --}}

		</div>
	</div>	
@stop