<?php
class MainController extends BaseController {

	public function index($env='items') {
		($env === 'spares') ? $type = 'ЗИП' : $type = 'оборудование';
		
		return View::make('index')->with([
			'brands' 		=> Item::readBrands($type),
			'subcategories' => Item::readSubcategories($type),
			'env' 			=> $env
		]);	
	}

	public function catalogSubcategory($env, $category, $subcategory) {
		($env === 'spares') ? $type = 'ЗИП' : $type = 'оборудование';
		
		return View::make('catalog')->with([
			'items' 		=> Item::readItemsBySubcategory($type, $category, $subcategory),
			'current' 		=> HTML::link("$env/$category/Всё", $category).' -> '.HTML::link("$env/$category/$subcategory", $subcategory),
			'env' 			=> $env
		]);
	}

	public function catalogCategory($env, $category) {
		($env === 'spares') ? $type = 'ЗИП' : $type = 'оборудование';
		
		return View::make('catalog')->with([
			'items' 		=> Item::readItemsByCategory($type, $category),
			'current' 		=> HTML::link("$env/$category/Всё", $category).' -> '.HTML::link("$env/$category/Всё", 'Всё'),
			'env' 			=> $env
		]);
	}

	public function catalogBrand($env, $brand) {
		($env === 'spares') ? $type = 'ЗИП' : $type = 'оборудование';
		
		return View::make('catalog')->with([
			'items' 		=> Item::readItemsByBrands($type, $brand),
			'current' 		=> HTML::link("$env/$brand", $brand),
			'env' 			=> $env
		]);
	}

	public function itemSearch() {
		$param = Input::get('param');

		return View::make('catalog')->with([
			'current' 		=> $param,
			'items' 		=> Item::readItemsBySearch($param),
			'env'			=> null
		]);
	}

	public function info() {
		return View::make('info')->with([
			'articles'  => Article::readArticles(),
			'env' 		=> 'info'
		]);	
	}
	
/*------------------------------------------------
| ADMIN AREA
------------------------------------------------*/
	public function login() {
		if (true) {
			return View::make('admin/admin')->with([
				'element'	=> new Item
			]);
		} else {
			return View::make('admin.login');
		}
	}

	public function adminInfo() {
		return View::make('admin/admin_info')->with([
			'articles' 		=> Article::readArticles()
		]);;
	}

	public function codeSearchAdmin() {
		$code = Input::get('code');

		return View::make('admin/admin_catalog')->with([
			'current' 		=> $code,
			'items' 		=> Item::readItemByCode($code),
			'element'		=> null
		]);
	}

	public function itemSearchAdmin() {
		$param = Input::get('param');

		return View::make('admin/admin_catalog')->with([
			'current' 		=> $param,
			'items' 		=> Item::readItemsBySearch($param),
			'element'		=> null
		]);
	}
/*------------------------------------------------
| ITEM
------------------------------------------------*/
	public function changeItem($code=null) {
		return View::make('admin/admin')->with([
			'current' 		=> null,
			'element'		=> $code ? Item::readElementByCode($code) : new Item
		]);
	}

	public function changeItemJson($code=null) {
		$data = $code ? Item::readElementByCode($code) : new Item;
		return Response::json($data);
	}

	public function updateOrCreateItem($code=null) {
		Item::updateOrCreateItemByCode($code, Input::all());
		return Redirect::to('admin');
	}

	public function deleteItem($code) {
		Item::deleteItemByCode($code);
		return Redirect::to('admin');
	}
/*------------------------------------------------
| ARTICLE
------------------------------------------------*/
	public function changeArticle($id=null) {
		return View::make('admin/admin_info_change')->with([
			'current' 		=> $id,
			'article'		=> $id ? Article::readArticleById($id) : new Article
		]);
	}

	public function updateOrCreateArticle($id=null) {
		Article::updateOrCreateArticleById($id, Input::all());
		return Redirect::to('admin/info');
	}

	public function deleteArticle($id) {
		Article::deleteArticleById($id);
		return Redirect::to('admin/info');	
	}
}