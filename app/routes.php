<?php

Route::get('/', 'MainController@index');
Route::get('/info', 'MainController@info');
Route::get('/contacts', 'MainController@contacts');
Route::get('/itemSearch', ['as'=>'itemSearch', 'uses'=>'MainController@itemSearch']);
Route::get('/admin', 'MainController@login');
Route::get('/order', 'MainController@order_page');
Route::post('/order', 'MainController@order');
Route::post('/validate', 'MainController@validate');
Route::get('/attachment', 'MainController@attachment');
Route::get('/{env}', 'MainController@index'); // items and spares

Route::group(['prefix'=>'/admin', 'before'=>'auth2'], function() {
	Route::get('/importExcel', 'ExcelController@excelImport'); // items and spares
	Route::get('/logout', 'MainController@logout');
	Route::get('/info', 'MainController@adminInfo');
	Route::get('/codeSearch', ['as'=>'codeSearchAdmin', 'uses'=>'MainController@codeSearchAdmin']);
	Route::get('/itemSearch', ['as'=>'itemSearchAdmin', 'uses'=>'MainController@itemSearchAdmin']);

	/*------------------------------------------------
	| ITEM
	------------------------------------------------*/

	Route::get('/changeItem/{code?}', 'MainController@changeItem');
	Route::post('/changeItem/{code?}', 'MainController@changeItemJson');
	Route::post('/updateItem/{code?}', 'MainController@updateOrCreateItem');
	Route::post('/deleteItem/{code}', 'MainController@deleteItem');
	/*------------------------------------------------
	| ARTICLE
	------------------------------------------------*/
	Route::get('/info/changeArticle/{id?}', 'MainController@changeArticle');
	Route::post('/info/updateArticle/{id?}', 'MainController@updateOrCreateArticle');
	Route::post('/info/deleteArticle/{id}', 'MainController@deleteArticle');

});

Route::get('/view_item/{item_title}', 'MainController@item');
Route::get('/{env}/{brand}', 'MainController@catalogBrand');
Route::get('/{env}/{category}/Всё', 'MainController@catalogCategory');
Route::get('/{env}/{category}/{subcategory}', 'MainController@catalogSubcategory');

// App::missing(function($exception) {
// 	return Redirect::to('/');
// });

/*------------------------------------------------
| SQL Listener or using debug bar
------------------------------------------------*/

// if (Config::get('database.log_sql')) {           
// 	Event::listen('illuminate.query', function($query, $bindings, $time, $name) {
// 		$data = compact('bindings', 'time', 'name');
// 		// Format binding data for sql insertion
// 		foreach ($bindings as $i => $binding) {
// 			if ($binding instanceof \DateTime) {
// 				$bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
// 			} else if (is_string($binding)) {
// 				$bindings[$i] = "'$binding'";
// 			}
// 		}
// 		// Insert bindings into query
// 		$query = str_replace(array('%', '?'), array('%%', '%s'), $query);
// 		$query = vsprintf($query, $bindings); 

// 		echo '<pre>';
// 		var_dump($query);
// 		echo '</pre>';
// 	});
// }

/*----------------------------------------------*/