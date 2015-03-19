@section('preview')
	<div class='item_preview'> 
		{{-- <h2 class="catalog_item_header">[[ element.item ]]</h2> --}}
		<!--****************************************************
		| ITEM PAGE
		*****************************************************-->
		<div class="catalog_item">
			<h2 class="catalog_item_header">
				[[ element.item ]]
			</h2>
			<div class="item_photo_div">
				<img ng-src="[[ origin ]]/photos/[[ element.photo ? element.photo : 'no_image.png' ]]" alt="item" class='item_photo'/>
			</div>
			<table class="info_item_page info_item_page_catalog">
				{{-- <tr>
					<td colspan='2'>
						[[ (element.type === 'оборудование') ? 'Техника' : 'Запчасти' ]]
					</td>
				</tr> --}}
				<tr>
					<td class='info_page_item_title'>Бренд:&nbsp</td>
					<td class='info_page_item_text'>[[ element.producer ]]</td>
				</tr>
				<tr>
					<td class='info_page_item_title'>Код:&nbsp</td>
					<td class='info_page_item_text'>[[ element.code ]]</td>
				</tr>
				<tr>
					<td class='info_page_item_title'>Тип:&nbsp</td>
					<td class='info_page_item_text'>[[ element.category ]]</td>
				</tr>
				<tr>
					<td class='info_page_item_title'>Вид:&nbsp</td>
					<td class='info_page_item_text'>[[ element.subcategory ]]</td>
				</tr>
			</table>
			<p class="btn btn-default items_button items_order">Заказать</p>
			<div class='info_page_item_procurement'>
				[[ (element.procurement === 'ТВС') ? 'Под заказ' : 'В наличии' ]]
			</div>
			<div class="catalog_item_price">
				<p class="catalog_item_price_p catalog_item_price_number">[[ element.price ]]&nbsp</p>
				<p class="catalog_item_price_p catalog_item_price_currency">[[ element.currency ]]</p>
			</div>
		</div>
	</div>		







			{{-- <div class="item">
				<h1 class="item_page_header">[[ element.item ]]</h1>
				<div class="item_page_photo_div">
					<img ng-src="[[ origin ]]/photos/[[ element.photo ? element.photo : 'no_image.png' ]]" alt="item" class='item_page_photo'/>
				</div>
				<div class="item_page_right_div">
					<table class="info_item_page">
						<tr>
							<td colspan='2'>
								[[ (element.type === 'оборудование') ? 'Техника' : 'Запчасти' ]]
							</td>
						</tr>
						<tr>
							<td>Бренд:&nbsp&nbsp&nbsp&nbsp</td>
							<td class='info_page_item_text win_item_text'>[[ element.producer ]]</td>
						</tr>
						<tr>
							<td>Код:&nbsp</td>
							<td class='info_page_item_text win_item_text'>[[ element.code ]]</td>
						</tr>
						<tr>
							<td>Тип:&nbsp</td>
							<td class='info_page_item_text win_item_text'>[[ element.category ]]</td>
						</tr>
						<tr>
							<td>Вид:&nbsp</td>
							<td class='info_page_item_text win_item_text'>[[ element.subcategory ]]</td>
						</tr>											
					</table>
					<div class='info_page_item_procurement'>
						[[ (element.procurement === 'ТВС') ? 'Под заказ' : 'В наличии' ]]
					</div>
					<div class="item_price">
						<p class="item_price_p item_price_number">[[ element.price ]]&nbsp</p>
						<p class="item_price_p item_price_currency">[[ element.currency ]]</p>
					</div>
				</div><!-- item_page_right_div -->
				<div class="description_item">
					<p>[[ element.description ]]</p>
				</div><!-- description_item -->
			</div><!-- item -->	 --}}
			{{-- <!--****************************************************-->
			<div class="item_photo_div">
				<img ng-src="[[ origin ]]/photos/[[ element.photo ? element.photo : 'no_image.png' ]]" alt="item" class='item_photo'/>
			</div>
			<table class="info_item_page">
				<tr>
					<td>Бренд:&nbsp</td>
					<td class='info_page_item_text'>[[ element.producer ]]</td>
				</tr>
				<tr>
					<td>Код:&nbsp</td>
					<td class='info_page_item_text'>[[ element.code ]]</td>
				</tr>
				<tr>
					<td>Тип:&nbsp</td>
					<td class='info_page_item_text'>[[ element.category ]]</td>
				</tr>
				<tr>
					<td>Вид:&nbsp</td>
					<td class='info_page_item_text'>[[ element.subcategory ]]</td>
				</tr>
			</table>
			<div class='info_page_item_procurement'>
				[[ (element.procurement === 'ТВС') ? 'Под заказ' : 'В наличии' ]]
			</div>
			<div class="catalog_item_price">
				<p class="catalog_item_price_p catalog_item_price_number">[[ element.price ]]&nbsp</p>
				<p class="catalog_item_price_p catalog_item_price_currency">[[ element.currency ]]</p>
			</div>
		</div>
	</div><!-- item_preview --> --}}
@show