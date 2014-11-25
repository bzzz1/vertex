<?php
class MainController extends BaseController {

	public function index($env='items') {
		($env === 'spares') ? $type = 'ЗИП' : $type = 'оборудование';
		$subcategories = DB::select(DB::raw("SELECT DISTINCT category, subcategory
											FROM `items`
											WHERE type=".'"'.$type.'"'."
											ORDER BY category;
										"));
		$brands = DB::table('items')->distinct()->whereType($type)->lists('producer');

		return View::make('index')->with([
			'brands' 		=> $brands,
			'subcategories' => $subcategories,
			'env' 			=> $env
		]);	
	}

	public function catalog($env, $brand) {
		($env === 'spares') ? $type = 'ЗИП' : $type = 'оборудование';
		$items = DB::table('items')->whereType($type)->whereProducer($brand)->paginate(12);
		return View::make('catalog')->with([
			'items' 		=> $items,
			'current_brand' => $brand,
			'env' 			=> $env
		]);
	}

	public function info() {
		$env = 'info';
		$articles = DB::table('articles')->orderBy('priority', 'ASC')->get();
		return View::make('info')->with([
			'env' 		=> $env,
			'articles'  => $articles
		]);	
	}
	/*
	public function categorization($type, $groupby, $param) {
		$items = DB::table($type)->where($groupby, $param)->get();
		return View::make('catalog')->with([
			'items' => $items,
			'current_param' => $param
		]);
	}
	*/

	/*------------------------------------------------
	| REGISTRATION
	------------------------------------------------*/
	public function login() {
		if (true) {

			// $purchases = Purchase::orderBy('created_at', 'desc')->get();
			// $items = Item::all();
			return View::make('admin.admin')->with([
			]);
		} else {
			return View::make('admin.login');
		}
	}

	// public function catalog($category) {
	// 	return View::make('catalog')->with([
	// 		'current_subcategory' => $this->subcategories[$category]
	// 	]);
	// }



	// public function category($category) {
	// 	// $categories = DB::table('products')->where('subcategory', $category)->get();
	// 	return View::make('catalog')->with([
	// 		'brand_items' => [],
	// 		'current_subcategory' => $category
	// 	]);
	// }

	// public function get_producers() {
	// 	$all_brands = DB::table('products')->distinct()->lists('producer');
	// 	print_r($all_brands);
	// 	return View::make('index')->with([
	// 		'all_brands' => $all_brands 
	// 	]);	
	// }
	

// 		$items = Item::whereEnabled('1')->get();
// 		$file = fopen(public_path('async/async.html'), 'w');
// 		$string = '';

// 		foreach ($items as $item) {
// 			if ( ! ($item->model_id)) {
// $string .= '<div class="item-page-ctnt" data-id='.$item->id.'>
// 	<img src="icons/close.png" class="close-icon"/>
// 	<img src="img/'.$item->img.'" class="item-page-img"/>
// 	<div class="btn-group item-page-btn-group">
// 		<button class="btn btn-success price-btn">'.$item->price.' грн</button>
// 		<button class="btn btn-danger to-cart-btn">Купить</button>
// 	</div>
// </div>
// ';
// 			}
// 		}

// 		fwrite($file, $string);
// 		fclose($file);

// 		return View::make('index')->with([
// 			'items' => $items
// 		]);
	// }

	public function ajaxItems() { 
		if(Request::ajax()) {
			return Item::whereEnabled('1')->get();
	    } else {
	    	App::abort(404);
	    }
	}

	public function ajaxNp() { 
		if(Request::ajax()) {
			return self::getNp();
	    } else {
	    	App::abort(404);
	    }
	}

	public function postPurchase() {
		// store Purchase in DB
		$data = Input::all();
		$purchase = new Purchase;

		$purchase->cart = e($data['cart']);
		$purchase->name = e($data['name']);
		$purchase->surname = e($data['surname']);
		$purchase->phone = e($data['phone']);
		$purchase->email = e($data['email']);
		$purchase->city = e($data['city']);
		$purchase->np = e($data['np']);
		$purchase->address = e($data['address']);
		$purchase->manual_address = e($data['manual_address']);

		$purchase->save();

		// send emails
		self::sendMails($data);
	}

	public static function sendMails($data) {
		$mail = new PHPMailer;
		$mail->CharSet = "UTF-8";

		$mail->isSMTP(); // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
		$mail->SMTPAuth = true; // Enable SMTP authentication
		$mail->Username = 'sportsecretshop@gmail.com'; // SMTP username
		$mail->Password = '080493210893'; // SMTP password
		$mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
		$mail->Port = 587;         // TCP port to connect to

		$mail->From = 'sportsecretshop@gmail.com';
		$mail->FromName = 'Secretshop';
		$mail->addAddress('beststrelok@gmail.com'); // Add a recipient
		// $mail->addAddress('ellen@example.com'); // Name is optional
		// $mail->addReplyTo('info@example.com', 'Information');
		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');

		// $mail->WordWrap = 50; // Set word wrap to 50 characters
		$mail->addEmbeddedImage('public/img/vsx15.jpg', 'embed_1'); // Add attachments
		// $mail->addAttachment('public/img/vsx15.jpg', ''); // Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
		$mail->isHTML(true); // Set email format to HTML

		// $mail->Subject = 'Заказ оформлен';
		$mail->Subject = 'Order done';
		$mail->Body = View::make('emails.purchase', $data);
		// $mail->Body = 'This is the HTML message body <b>in bold!</b>';
		// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		if ( ! $mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}
	}

	
	

	public function validate() {
		date_default_timezone_set('Europe/Kiev');
		$hours = date('H');
		$cred = $hours[1].Member::first()->password.$hours[0];
		$input = e(Input::get('credentials'));

		try {
			$input = $input[0].md5(substr($input, 1, 20)).$input[21];
		} catch (Exception $e) {
			return Redirect::to('admin');
		}

		if ($cred === $input) {
			Auth::login(Member::find(1));		
		}
		
		return Redirect::to('admin');
	}

	public function logout() {
		Auth::logout();
		return Redirect::to('/');
	}
	/*----------------------------------------------*/
}