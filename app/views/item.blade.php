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
			{{ HTML::link(URL::current()."?item_id=$item->id", $item->item) }}
		</h2>
		{{-- END BREADCRUMBS --}}
		<div class="s_item_head_block">
			<h1 class="s_item_heading contacts_heading">{{ $item->item }}</h1>
			<h4 class="item_page_recommended_heading">Товары из этой категории</h4>
		</div>
		<div class="single_item">
			<div class="top_block">
				<div class="s_item_descr">
					<div class="image">
						{{ HTML::image("photos/$item->photo", 'item', ['class'=>'s_item_img']) }}
					</div>
					<div class="descr_parent">
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
								<p class="s_item_price_p s_item_price_number">
								@if($item->price == 0.00)
									По запросу
								@else
									{{ $item->price }}&nbsp
								@endif
								</p>
								<p class="s_item_price_p s_item_price_currency">
									@if($item->price != 0.00)
										{{ $item->currency }}
									@endif
								</p>
							</div>
							<a href="/order?item_id={{ $item->id }}" class="btn btn-default s_item_btn">Заказать</a>
						</div>
					</div>
				</div>
			</div>
			<div class="bottom_block">
				<div class="s_item_info_big">
					<p>{{ $item->description }}</p>
				</div>
			</div>
		</div>
		<style>
			.top_block {
				overflow: hidden;
				width: 100%;
			}
			.bottom_block {
				overflow: hidden;
				width: 100%;
			}
			.image {
				width: 220px;
				height: 250px;
				overflow: hidden;
				float: left;
			}
			.descr_parent {
				overflow: hidden;
				float: right;
				width: 59%;
			}
			.s_item_creteries {
				margin-left: 0;
				/*float: right;*/
				/*width: auto;*/
				/*padding-left: 70px;*/
				/*padding-right: 70px;*/
			}
			.s_item_btn {
				display: table;	
				margin: auto;
				margin-top: 15px;
				/*float: right;*/
			}
			.s_item_img {
				max-height: 250px;
			}
		</style>
		{{-- SAME ITEMS --}}
		<div class="rec_item">
			@foreach ($same as $item)
				<div class="catalog_item s_item_item">
					<h2 class="catalog_item_header">
						{{ HTML::link("view_item/".urlencode2($item->item)."?item_id=$item->id", $item->item ) }}
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
			{{-- END SAME ITEMS --}}
		</div>	
	</div>
	// <script>
	// 	$(window).load(function(){
	// 		var $num = $(".s_item_price_number").text();
	// 		var $len = $num.length;
	// 		if ($len > 8) {
	// 			$(".s_item_price").css({
	// 				'margin-left' : '0',
	// 				'padding' : '10px 10px'});
	// 		};
	// 	});
		
	// </script>
@stop












