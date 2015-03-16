<?php
class MainController extends BaseController {

	public static $admin_email;
	public static $site_email;
	public static $site_password;

	public function __construct() {
		static::$admin_email = 'beststrelok@gmail.com';
		static::$site_email = 'sportsecretshop@gmail.com';
		static::$site_password = '080493210893';
	}

	private static function sendMail($data, $subject, $view, $email=null) {
		if (! $email) {
			$email = self::$admin_email;
		}

		$mail = new PHPMailer;
		$mail->CharSet = "UTF-8";

		$mail->isSMTP(); // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
		$mail->SMTPAuth = true; // Enable SMTP authentication
		$mail->Username = self::$site_email; // SMTP username
		$mail->Password = self::$site_password; // SMTP password
		$mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
		$mail->Port = 587;         // TCP port to connect to

		// $mail->From = 'sportsecretshop@gmail.com';
		$mail->From = 'Vertex';
		$mail->FromName = 'Vertex';
		$mail->addAddress($email); // Add a recipient
		// $mail->addAddress('ellen@example.com'); // Name is optional
		// $mail->addReplyTo('info@example.com', 'Information');
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');

		// $mail->WordWrap = 50; // Set word wrap to 50 characters
		// $mail->addEmbeddedImage('public/img/vsx15.jpg', 'embed_1'); // Add attachments
		// $mail->addAttachment('public/img/vsx15.jpg', ''); // Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
		$mail->isHTML(true); // Set email format to HTML

		// $mail->Subject = 'Заказ оформлен';
		$mail->Subject = $subject;
		$mail->Body = View::make($view, $data);
		// $mail->Body = 'This is the HTML message body <b>in bold!</b>';
		// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if ( ! $mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		}
	}

	public function contacts() {
		return View::make('contacts')->with([
			'env' 		=> 'contacts'
		]);
	}

	public function order_page() {
		return View::make('order')->with([
			'item'		=> Item::find(Input::get('item_id')),
			'env'		=> ''
		]);
	}

	public function order() {
		$fields = Input::all();
		$email = Input::get('email');

		// send to admin
		self::sendMail($fields, 'Заказ оформлен', 'emails.email_order');
		// send to user
		self::sendMail($fields, 'Заказ оформлен', 'emails.email_order_user', $email);

		return Redirect::to('/')->with('message', 'Ваш заказ оформлен!');
	}

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

	public function item() {
		$type = Item::find(Input::get('item_id'))->type;
		($type = 'ЗИП') ? $env = 'spares' : $env = 'items'; 

		return View::make('item')->with([
			'item' 		=> Item::find(Input::get('item_id')),
			'env' 	    => $env,
			'same'		=> Item::getSameItems($type)
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

	public function attachment() {
		header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-disposition: attachment; filename=Komplexnoe_predl_s_1_12.xlsx');
		readfile(public_path().'/attachments/Komplexnoe_predl_s_1_12.xlsx');
	}
	
/*------------------------------------------------
| ADMIN AREA
------------------------------------------------*/
	public function login() {
		if (Auth::check()) {
			return View::make('admin/admin')->with([
				'element'	=> new Item
			]);
		} else {
			return View::make('admin/login');
		}
	}

	public function validate() {
		// dd(Hash::make('string'));
		// dd(hash('sha512', 'string'));

		// use $creds to escape where _token problem
		$creds = [
			'password'	=> Input::get('password'),
			'login' 	=> Input::get('login')
		];

		// if (Auth::validate($creds)) {
		// 	$admin = Member::where('login', $creds['login'])->first();
		// 	Auth::login($admin, true); 		// true to remember user not only for this page session
		// }

		Auth::attempt($creds);

		// with or without login, anyway redirect to /admin
		return Redirect::to('admin');
	}

	public function logout() {
		Auth::logout();
		return Redirect::to('admin');
	}

	public function adminInfo() {
		return View::make('admin/admin_info')->with([
			'articles' 		=> Article::readArticles()
		]);;
	}

	public function codeSearchAdmin() {
		$code = Input::get('code');
		// dd(Item::readItemByCode($code)->getCollection());

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
		$validator = Validator::make(Input::all(), [
			'code'				=> ($code === null) ? 'required|unique:items' : 'required'
			// 'username'			=> 'required|min:3|unique:users',
			// 'password'			=> 'required|min:6',
			// 'password_again'		=> 'required|same:password'
		]);

		if ($validator->fails()) {
			return Redirect::back()->with('error_msg', 'Код должен быть уникальным!')->withInput();
		} else {
			$fields = Input::all();
			unset($fields['photo_name']); // clear unneeded fields from item

			if (Input::hasFile('photo')) {
				$file = Input::file('photo');
				$destinationPath = public_path().'/photos/';
				$filename = $file->getClientOriginalName();
				$fields['photo'] = $filename; // get photo name to store in db if has file
				$file->move($destinationPath, $filename);
			} else {
				if (Input::has('photo_name')) { // ensure this is not brand new item
					$fields['photo'] = Input::get('photo_name'); // if filename was from updating
				} else {
					unset($fields['photo']); // use default value from mysql if not $element->photo
				}
			}
			
			Item::updateOrCreateItemByCode($code, $fields);
			return Redirect::back()->with('msg', 'Изменения сохранены');
		}
	}

	public function deleteItem($code) {
		Item::deleteItemByCode($code);
		return Redirect::back()->with('msg', 'Товар #'.$code.' удален');
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
		$fields = Input::all();
		unset($fields['photo_name']); // clear unneeded fields from article

		if (Input::hasFile('image')) {
			$file = Input::file('image');
			$destinationPath = public_path('/photos/articles/');
			$filename = $file->getClientOriginalName();
			$fields['image'] = $filename; // get photo name to store in db if has file
			$file->move($destinationPath, $filename);
		} else {
			if (Input::has('photo_name')) { // ensure this is not brand new item
				$fields['image'] = Input::get('photo_name'); // if filename was from updating
			} else {
				unset($fields['image']); // use default value from mysql if not $article->image
			}
		}

		Article::updateOrCreateArticleById($id, $fields);
		return Redirect::to('admin/info');
	}

	public function deleteArticle($id) {
		Article::deleteArticleById($id);
		return Redirect::to('admin/info');	
	}
}