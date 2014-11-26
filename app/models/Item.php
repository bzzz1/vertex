<?php

class Item extends Eloquent {
	protected $guarded = [];

	public static function giveItemsByBrands($type, $brand) {
		$sort = Input::get('sort', 'item');
		$order = Input::get('order', 'ASC');

		$items = new Item;
		$items = $items->whereType($type);
		$items = $items->whereProducer($brand);
		$items = $items->orderBy($sort, $order);
		$items = $items->paginate(12);
		return $items;
	}

	public static function giveItemsBySubcategory($type, $category, $subcategory) {
		$sort = Input::get('sort', 'item');
		$order = Input::get('order', 'ASC');

		$items = new Item;
		$items = $items->whereType($type);
		$items = $items->whereCategory($category);
		$items = $items->whereSubcategory($subcategory);
		$items = $items->orderBy($sort, $order);
		$items = $items->paginate(12);
		return $items;
	}

	public static function giveItemsByCategory($type, $category) {
		$sort = Input::get('sort', 'item');
		$order = Input::get('order', 'ASC');
		
		$items = new Item;
		$items = $items->whereType($type);
		$items = $items->whereCategory($category);
		$items = $items->orderBy($sort, $order);
		$items = $items->paginate(12);
		return $items;
	}


	public static function giveSubcategories($type) {
		$categories = [
			0 => 'Барное',
			1 => 'Нейтральное',
			2 => 'Посуда и инвентарь',
			3 => 'Посудомоечное',
			4 => 'Технологическое',
			5 => 'Упаковочное',
			6 => 'Хлебопекарное',
			7 => 'Холодильное'
		];

		$subcategories = [];
		for ($i=0; $i<8; $i++) {
			$subcategory = new Item;
			$subcategory = $subcategory->distinct();
			$subcategory = $subcategory->orderBy('subcategory');
			$subcategory = $subcategory->whereType($type);
			$subcategory = $subcategory->whereCategory($categories[$i]);
			$subcategory = $subcategory->lists('subcategory');
			$subcategories[$categories[$i]] = $subcategory;
		}

		return $subcategories;
	}

	public static function giveBrands($type) {
		$brands = new Item;
		$brands = $brands->distinct();
		$brands = $brands->whereType($type);
		$brands = $brands->orderBy('producer', 'ASC');
		$brands = $brands->lists('producer');
		return $brands;
	}
}