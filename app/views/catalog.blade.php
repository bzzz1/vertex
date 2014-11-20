@extends('layout')
@extends('header')
@extends('footer')

@section('css')
	{{ HTML::style('css/style.css') }}
@stop

@section('body')
	<div class="width_960">
		<div class = "catalog_gen">
			<h2 class = "groups_title">{{ $current_brand }}</h2>
			<div class="catalog_sort">
				<ul class="catalog_sort_text_ul">
					<li class="catalog_sort_text catalog_sort_text_li">Сортировать по: </li>
					<li class="catalog_sort_titel catalog_sort_text_li">наименованию <div class="icon_tr_dw"></div><div class="icon_tr_up"></div></li>
					<li class="catalog_sort_price catalog_sort_text_li">цене <div class="icon_tr_dw"></div><div class="icon_tr_up"></div></li>
					<li class="catalog_sort_brands catalog_sort_text_li">брендам <div class="icon_tr_dw"></div><div class="icon_tr_up"></div></li>
				</ul>
				<div class="catalog_sort_pages_div">
					<ul class="catalog_sort_pages_ul">
						<li class="catalog_sort_pages catalog_sort_pages_li"><a href="#">1 </a></li>
						<li class="catalog_sort_pages catalog_sort_pages_li"><a href="#">2 </a></li>
						<li class="catalog_sort_pages catalog_sort_pages_li"><a href="#">3 </a></li>
						<li class="catalog_sort_pages catalog_sort_pages_li"><a href="#">4 </a></li>
						<li class="catalog_sort_pages catalog_sort_pages_li dots">...</li>
						<li class="catalog_sort_pages catalog_sort_pages_li"><a href="#">9 </a></li>
						<li class="catalog_sort_pages catalog_sort_pages_li"><a href="#">след</a></li>
						<li class="catalog_sort_pages catalog_sort_pages_li"><a href="#">>></a></li>
					</ul>	
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
				<a class="catalog_sort_pages catalog_bottom_pages_item">1</a>
				<a class="catalog_sort_pages catalog_bottom_pages_item">2</a>
				<a class="catalog_sort_pages catalog_bottom_pages_item">3</a>
				<a class="catalog_sort_pages catalog_bottom_pages_item">4</a>
				<a class="catalog_sort_pages catalog_bottom_pages_item dots">...</a>
				<a class="catalog_sort_pages catalog_bottom_pages_item">9</a>
			</div>
		</div><!--catalog gen -->
	</div><!-- width_960 catalog_gen -->
@stop