{{-- SINGLE ITEM --}}
		<div class="item">
			<h1 class="item_page_header">{{ $item->item }}</h1>
			<div class="itself">
				<div class="item_page_photo_div">
					{{ HTML::image("photos/$item->photo", 'item', ['class'=>'item_page_photo']) }}
				</div>
				<div class="item_page_right_div s_item_info">
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
				</div>
				<div class='info_page_item_procurement s_item_proc'>
					@if ($item->procurement == 'МРП') В наличии @else Под заказ @endif 
				</div>
				<div class="item_price">
					<p class="item_price_p item_price_number">{{ $item->price }}&nbsp</p>
					<p class="item_price_p item_price_currency">{{ $item->currency }}</p>
				</div>
			<a href="/order?item_id={{ $item->id }}" class="btn btn-default items_button items_order">Заказать</a>
			</div>
			<div class="description_item s_item_descr">
				<p>{{ $item->description }}</p>
			</div>
		</div>
		{{-- END SINGLE ITEM --}}