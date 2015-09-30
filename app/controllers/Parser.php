<?php
header('Content-Type: text/html; charset=utf-8');
class Parser extends BaseController {
	private $offset;
	private $one_iteration = 299;
	private $total_rows;
	private $data = [];
	private $data_correct = [];
	private $rows;
	private $added;
	private $products_codes = [];
	private $products_codes_session;
	private $products_duplication = [];
	private $products_duplication_session;
	private $errors = [];
	private $errors_session;
	private $only_prices;
	private $codes;
	private $real_num = 0;
	private $types = ['ЗИП', 'оборудование'];
	private $categories = [
		'Барное',
		'Нейтральное',
		'Посуда и инвентарь',
		'Посудомоечное',
		'Технологическое',
		'Упаковочное',
		'Хлебопекарное',
		'Холодильное'
	];

	public function __construct() {
		$this->offset = (array_key_exists('offset', $_GET)) ? $_GET['offset'] : 1;
		$this->products_codes_session = Session::get('parser_products_codes', []);
		$this->products_duplication_session = Session::get('parser_duplications', []);
//		$this->products_duplication_session = Cache::get('parser_duplications', []);
		$this->codes = Item::lists('code');
		$this->errors_session = Session::get('parser_errors', []);
		$this->only_prices = Session::get('only_prices');
		$this->rows = Session::get('rows', 0);
		$this->added = Session::get('added', 0);
	}
	private function _prepareData(){
		$csv_file = public_path().DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'excel.csv';
		$document = file($csv_file, FILE_SKIP_EMPTY_LINES);
		unset($document[0]);
		$this->total_rows = count($document);
		$limit = $this->offset + $this->one_iteration;
		for ($offset_parse = $this->offset; $offset_parse <= $limit; $offset_parse++) {
			if (!array_key_exists($offset_parse, $document)) {
				continue;
			}
//			if (mb_check_encoding($document[$offset_parse]) === 'Windows-1251' ) {
				$this->data[] = explode(";", iconv('Windows-1251', "utf-8", $document[$offset_parse]));
//			} elseif (mb_check_encoding($document[$offset_parse]) === 'ANSII' ) {
//				$this->data[] = explode(";", iconv('ANSII', "utf-8", $document[$offset_parse]));
//			} else {
//				$this->data[] = explode(";", $document[$offset_parse]);
//			}
		}
	}
	private function _validate($data) {
		if ($this->offset <= $this->one_iteration) {
			$i = $this->offset;
		} else {
			$i = $this->offset;
		}
		foreach ($data as $row) {
			$this->rows++;
			$i++;
			$this->real_num = $i;
			foreach ($row as $id => $value) {
				$row[$id] = addslashes($value);
			}
			$code = $row[0];
			$title = $row[1];
			$description = $row[2];
			$type = $row[3];
			$category = $row[4];
			$subcat = $row[5];
			$producer = $row[6];
			$price = $row[7];
			$currency = $row[8];
			$procurement = $row[9];
			$image = $row[10];
			if (mb_strlen($code) !== 0) {
				if ($this-> _isValid($code, $title, $description, $type, $category, $subcat, $producer, $price, $currency, $procurement, $image)) {
					$this->data_correct[] = $row;
				}
			}
		}
	}
	private function _isValid($code, $title, $description, $type, $category, $subcat, $producer, $price, $currency, $procurement, $image) {
		$error = '';
		$code = trim($code);
		$code = strval($code);
		if (in_array($code, $this->products_codes)) {
			if (!array_key_exists($code, $this->products_duplication)) {
				$this->products_duplication[$code] = [];
			}
			$this->products_duplication[$code][] = $this->real_num;

		} else {
			$this->products_codes[] = $code;
		}

		//*** title - 1
		if (mb_strlen($title) === 0) {
			$error .= 'Не указано название! ';
		}

		//*** type - 3
		if (mb_strlen($type) === 0) {
			$error .= 'Не указан тип товара(ЗИП или оборудование)!';
		} elseif (!in_array($type, $this->types)) {
			$error .= 'Тип товара указан не верно(ЗИП или оборудование)! ';
		}

		//*** category - 4 and subcat - can be null
		if (mb_strlen($category) === 0) {
			$error .= 'Не указана категория! ';
		} else {
			if (!in_array($category, $this->categories)) {
				$error .= 'Вы ввели неверную категорию. ';
			}
		}

		//*** price - 7
		if (mb_strlen($price) === 0) {
			$error .= 'Не указана цена! ';
		} else {
			$price = str_replace(",", ".", $price);
			$price = floatval($price);
			if (!is_numeric ($price) ) {
				$error .= 'Цена должна быть числом. ';
			} else if ($price < 0) {
				$error .= 'Цена не может быть отрицательной! ';
			}
		}

		//*** currency - 8
		if (mb_strlen($currency) === 0) {
			$error .= 'Не указана валюта! ';
		}

		//*** procurement - 9
		if (mb_strlen($procurement) === 0) {
			$error .= 'Не указано наличие! ';
		} else {
			if (!($procurement == 'МРП' || $procurement == 'ТВС')) {
				$error .= 'Поле Наличие должно иметь значение ТВС - нет, МРП - есть. ';
			}
		}

		if ($error) {
			$this->errors[] = $this->real_num . ' строка. ' . $error;
		} else {
			return true;
		}
	}
	private function _updatePrice($price, $currency, $procurement, $code) {
		$fields = [
			'price' => $price,
			'currency' => $currency,
			'procurement' => $procurement,
			'code' => $code
		];
		try {
			$item = Item::where('code', $code)->update($fields);
			$caught = false;
		} catch (Exception $e) {
			$error = 'UNCAUGHT EXCEPTION! ';
			$this->errors = $this->real_num . ' строка. ' . $error;
			$caught = true;
		}
		if (!$caught) {
			$this->added++;
		}
	}
	private function _addItems($code, $title, $description, $type, $category, $subcat, $producer, $price, $currency, $procurement, $image) {
		$fields = [
			'item' => $title,
			'description' => ($description) ? $description : 'К сожалению, для данного товара описание временно отсутствует.',
			'producer' => $producer,
			'price' => $price,
			'type' => $type,
			'category' => $category,
			'subcategory' => ($subcat) ? $subcat : 'Разное',
			'currency' => $currency,
			'procurement' => $procurement,
			'code' => $code,
			'photo' => ($image) ? $image : 'no_image.png',
		];
		try {
			$item = Item::create($fields);
			$caught = false;
		} catch (Exception $e) {
			$error = 'UNCAUGHT EXCEPTION! ';
			// add error to errors array
			$this->errors = $this->real_num . ' строка. ' . $error;
			$caught = true;
		}
		if (!$caught) {
			$this->codes[] = $item->code;
			$this->added++;
		}
	}
	private function _updateItem($code, $title, $description, $type, $category, $subcat, $producer, $price, $currency, $procurement, $image) {
		$fields = [
			'item' => $title,
			'description' => ($description) ? $description : 'К сожалению, для данного товара описание временно отсутствует.',
			'producer' => $producer,
			'price' => $price,
			'type' => $type,
			'category' => $category,
			'subcategory' => ($subcat) ? $subcat : 'Разное',
			'currency' => $currency,
			'procurement' => $procurement,
			'code' => $code,
			'photo' => ($image) ? $image : 'no_image.png',
		];
		try {
			$item = Item::where('code', $code)->update($fields);
			$caught = false;
		} catch (Exception $e) {
			$error = 'UNCAUGHT EXCEPTION! ';
			// add error to errors array
			$this->errors = $this->real_num . ' строка. ' . $error;
			$caught = true;
		}
		if (!$caught) {
			$this->added++;
		}
	}
	private function _saveItems($data) {
		print_r($this->only_prices);
		foreach ($data as $row) {
			foreach ($row as $id => $value) {
				$row[$id] = addslashes($value);
			}
			$code = $row[0];
			$title = $row[1];
			$description = $row[2];
			$type = $row[3];
			$category = $row[4];
			$subcat = $row[5];
			$producer = $row[6];
			$price = $row[7];
			$currency = $row[8];
			$procurement = $row[9];
			$image = $row[10];
			if ($this->only_prices === 'only_price') {
				if (in_array($code, $this->codes)) {
					$this->_updatePrice($price, $currency, $procurement, $code);
				} else {
					$this->_addItems($code, $title, $description, $type, $category, $subcat, $producer, $price, $currency, $procurement, $image);
				}
			} else {
				if (in_array($code, $this->codes)) {
					$this->_updateItem($code, $title, $description, $type, $category, $subcat, $producer, $price, $currency, $procurement, $image);
				} else {
					$this->_addItems($code, $title, $description, $type, $category, $subcat, $producer, $price, $currency, $procurement, $image);
				}
			}
		}
	}
	private function _putInSession() {
		$merged_errors = array_merge($this->errors_session, $this->errors);
//		foreach ($this->products_duplication as $code=>$row) {
//			$this->products_duplication_session[$code][] = $row;
//		}
		$merged_duplications = $this->products_duplication_session+$this->products_duplication;//TODO::change it, it adds more arrays
		$merged_codes = array_merge($this->products_codes_session, $this->products_codes);
		Session::put('parser_errors', $merged_errors);
		Session::put('parser_products_codes', $merged_codes);
//		echo "<p> this is duplications in session before merging</p>";
//		print_r(Session::get('parser_duplications'));
//		Cache::put('parser_duplications', $merged_duplications, 60);
		Session::put('parser_duplications', $merged_duplications);
		Session::put('rows', $this->rows);
		Session::put('added', $this->added);
//		echo "<p>this is all codes in session</p>";
//		print_r(Session::get('parser_products_codes'));
//		echo "<p>this is duplications in iteration</p>";
//		print_r($this->products_duplication);
//		echo "<p> this is duplications merged</p>";
//		print_r($merged_duplications);
//		echo "<p>this is duplications in session </p>";
//		print_r(Session::get('parser_duplications'));
//		exit;
	}
	public function index() {
		set_time_limit(10*60);
		ini_set('memory_limit', '256M');
		$this->_prepareData();
		$this->_validate($this->data);
		$this->_saveItems($this->data_correct);
		$this->_putInSession();
		$this->offset = $this->offset + $this->one_iteration + 1;
//		print_r($this->products_duplication_session);
		if ($this->offset > $this->total_rows) {
//			exit;
			return View::make('admin/admin_import_status')->with([
				'errors' 			=>  Session::get('parser_errors'),
				'added'				=> Session::get('added'),
				'SKIP'				=> 1,
				'missed'			=> Session::get('rows')- Session::get('added'),
				'original_name'		=> Session::get('original_name'),
				'codes_duplications'=>Session::get('parser_duplications')
			]);
		} else {
			return View::make('admin/import_s')->with([
				'offset'		=> $this->offset,
				'skip' 			=> 0,
				'original_name' => Session::get('original_name'),
				'iteration'		=> $this->one_iteration,
				'max_row' 		=> $this->total_rows,
			]);
		}
	}
}