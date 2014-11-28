<?php
Route::get('/', 'MainController@index');
Route::get('/info', 'MainController@info');
Route::get('/admin', 'MainController@login');
Route::get('/admin/info', 'MainController@adminInfo');
Route::get('/admin/codeSearch', ['as'=>'codeSearchAdmin', 'uses'=>'MainController@codeSearchAdmin']);
Route::get('/admin/itemSearch', ['as'=>'itemSearchAdmin', 'uses'=>'MainController@itemSearchAdmin']);
Route::get('/itemSearch', ['as'=>'itemSearch', 'uses'=>'MainController@itemSearch']);
Route::get('/{env}', 'MainController@index');
Route::get('/{env}/{brand}', 'MainController@catalogBrand');
Route::get('/{env}/{category}/Всё', 'MainController@catalogCategory');
Route::get('/{env}/{category}/{subcategory}', 'MainController@catalogSubcategory');

// apply auth filter:
Route::post('/admin/changeItem', 'MainController@changeItem');
Route::post('/admin/deleteItem', 'MainController@deleteItem');


Route::get('/technics', ['as'=>'index', 'uses'=>'MainController@index']);
// Route::get('{any?}', ['as'=>'any', 'uses'=>'MainController@index']);
Route::get('/{type}/{groupby}/{param}', 'MainController@categorization');
	// ->where('category', '[1-8]');
// Route::get('/technics/{any}', function() { 
// 	return Redirect::route('index');
// });


Route::get('/admin', 'MainController@login');
Route::get('/category', 'MainController@index');
Route::get('/test', 'MainController@get_producers');



// Route::group(['before' => 'auth'], function() {
// 	Route::get('/', function() {
// 		// Has Auth Filter
// 	});

// 	Route::get('user/profile', function() {
// 		// Has Auth Filter
// 	});
// });





// Route::get('/', 'MainController@index');
// Route::get('/ajaxItems', 'MainController@ajaxItems');
// Route::get('/ajaxNp', 'MainController@ajaxNp');
// Route::get('/admin', 'MainController@admin');
// Route::post('/validate', 'MainController@validate');
// Route::post('/logout', 'MainController@logout');
// Route::post('/postPurchase', 'MainController@postPurchase');
// Route::controller('/artisan', 'ArtisanController');

// Route::get('/', function() { 
	// Author::create([
	// 	'name'	=> 'Jeffrey Way',
	// 	'email'	=> 'jeffrey@envato.com'
	// ]);
	// Author::create([
	// 	'name'	=> 'John Doe',
	// 	'email'	=> 'john@envato.com'
	// ]);

	// Author::find(2)->posts()->create([
	// 	'title'	=> 'My fourth post',
	// 	'body'	=> 'Body for the post'
	// ]);

	// dd(Author::find(1)->posts);
	// dd(Post::find(4)->author);
// });

// Route::get('authors/{any}/posts', function($id) { 
// 	// $posts = Author::find($id)->posts;
// 	/*------------------------------------------------
// 	| Eager loading
// 	------------------------------------------------*/
// 	$posts = Post::with('author')->whereAuthor_id($id)->get();
// 	/*----------------------------------------------*/

// 	return View::make('posts.index')
// 		->with('posts', $posts);
// })->where('any', '.*');

// Route::resource('members', 'MembersController');
// Route::resource('authors', 'AuthorsController');
// Route::resource('posts', 'PostsController');
// // Route::get('admin', 'MembersController@admin');
// 	// ->before('auth');
// Route::controller('/', 'MembersController');

/*------------------------------------------------
| SQL Listener or using debug bar
------------------------------------------------*/
// Event::listen('illuminate.query', function($query, $bindings, $time, $name) {
// 	$data = compact('bindings', 'time', 'name');
// 	// Format binding data for sql insertion
// 	foreach ($bindings as $i => $binding)
// 	{
// 		if ($binding instanceof \DateTime)
// 		{
// 			$bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
// 		}
// 		else if (is_string($binding))
// 		{
// 			$bindings[$i] = "'$binding'";
// 		}
// 	}
// 	// Insert bindings into query
// 	$query = str_replace(array('%', '?'), array('%%', '%s'), $query);
// 	$query = vsprintf($query, $bindings); 

// 	echo '<pre>';
// 	var_dump($query);
// 	echo '</pre>';
// });
/*----------------------------------------------*/

// Route::get('/','UsersController@getIndex');
// Route::get('users/{all}/edit', 'UsersController@edit')
// 	->where('all', '.*');
// Route::controller('users','UsersController');


/*----------------------------------------------*/
// Route::get('/', ['as'=>'movies', 'uses'=>'movies@index']);

// Route::get('movies', ['as'=>'movies', 'uses'=>'movies@index']);
// Route::get('movies/create', ['as'=>'create_movie', 'uses'=>'movies@create']);
// Route::post('movies', 'movies@store');
// Route::get('movies/{any}', ['as'=>'movie', 'uses'=>'movies@show'])
// 	->where('any','.*');
// Route::get('movies/{any}/edit', ['as'=>'edit_movie', 'uses'=>'movies@edit'])
// 	->where('any','.*');
// Route::put('movies/{any}', 'movies@update')
// 	->where('any','.*');
// Route::delete('movies/{any}', 'movies@destroy')
// 	->where('any','.*');


/*----------------------------------------------*/
// Route::get('/', 'MoviesController@index');
// Route::resource('movies', 'MoviesController');
/*----------------------------------------------*/

// Route::get('/vars', function() {
//     $view = View::make('hello');
//     $view->name = 'James';
//     $view->surname = 'Brown';

//     return $view;
// /*----------------------------------------------*/
//    $data = [
//        'name'      => 'James',
//        'surname'   => 'Brown',
//    ];
//    return View::make('hello', $data);
// /*----------------------------------------------*/
//    $name = 'James';
//    $surname = 'Brown';
// 	return View::make('hello')->with([
//        'name'      => $name,
//        'surname'   => $surname,
//    ]);
// /*----------------------------------------------*/
// });

// Route::get('about', function() {
//     return View::make('emails/about');
// });

// Route::get('db', function() {
// 	$posts = DB::select(DB::raw('SELECT * FROM posts'));
// 	dd($posts);
// 	return $posts[0]->title;

// 	$posts = DB::table('posts')->get();
// 	$posts = DB::table('posts')->first();
// 	$posts = DB::table('posts')->where('id','=',1)->pluck('title');
// 	$posts = DB::table('posts')->get(['title as heading']);
// 	$posts = DB::table('posts')->where('id','!=',1)->orWhere('title','=','My title')->get();
// 	$posts = DB::table('posts')->whereTitleAndBody('My title','body of the fourth post')->get();
// 	$posts = DB::table('posts')->whereIdOrTitle('2','My title')->get();
	
// 	$posts = DB::table('posts')->where(function($query) {
// 		$query->where('id','=',2);
// 		$query->where('title','!=','My title');
// 	})->get();

// 	$posts = DB::table('posts')->orderBy('id','desc')->take(2)->get();

// 	dd($posts);
// });

// Route::get('eloquent', function() {
// 	$users = Users::all();
// 	$email = Users::find(1)->pluck('email');
// 	$users = Users::find(1);
// 	return $users->password;

// 	$users = Users::all();
// 	return View::make('emails/about')->with('users', $users);
// });

// Route::get('auth', function() {

// 	/*----------------------------------------------*/
// 	// if (Auth:attempt(['username'=>$email, 'password'=>$password])) {

// 	// }
// 	/*----------------------------------------------*/

// 	$email = 'jeffrey';
// 	$password = '1234';

// 	$user = Users::whereEmailAndPassword($email, $password)->first();
// 	if ($user) {
// 		// redirect to the logged in area
// 		return 'Correct!';
// 	} else {
// 		return 'Nope. Creds are incorrect.';
// 	}
// });

// Route::get('add_user', function() {
// 	$user = new Users;
// 	$user->email = 'jane';
// 	$user->password = Hash::make('1234');
// 	$user->save();

// 	/*----------------------------------------------*/
// 	$user = Users::create([
// 		'email' 	=> 'chuck',
// 		'password'	=> Hash::make(1234)
// 	]);

// 	if ($user) return 'New user added!';
// });