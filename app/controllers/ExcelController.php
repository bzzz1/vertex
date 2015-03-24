<?php
class MyReadFilter implements PHPExcel_Reader_IReadFilter {
	public function readCell($column, $row, $worksheetName = '') {
		global $limit;
		global $DELTA;
		if ($row >= $limit-$DELTA+1 && $row <= $limit) {
			return true;
		}
		return false;
	}
}

class ExcelController extends BaseController {

	public static $EXCEL_IMPORT_DIR;

	public function __construct() {
		static::$EXCEL_IMPORT_DIR = public_path().DIRECTORY_SEPARATOR.'excel';
	}

	public function excelImport() {
		function timer_start() { // add error timing
			global $__start;
			date_default_timezone_set('Europe/Kiev');
			// echo 'Start at: '.date('H:i:s');
			$__start = microtime(true); 
		}
		function memuse($line = 'unknown') {
			echo "</br>memory_get_usage(true) on line $line</br>";
			echo round(memory_get_usage(true)/1024/1024, 2);
			echo ' Mb</br>';
		}
		function mempeak($line = 'unknown') {
			$round = round(memory_get_peak_usage(true)/1024/1024, 2);	
			return "</br>Максимальная загрузка памяти: ".$round.' Mb</br>';
		}
		
		function timer_stop() {
			global $__start;
			$__time = microtime(true) - $__start;
			return '</br>Время работы скрипта: '.round($__time, 2).' с</br>';
		}

		timer_start();

		set_time_limit(10*60);
		ini_set('memory_limit', '256M');
		$memoryCacheSizeMb = 10;
		$excel_file = self::$EXCEL_IMPORT_DIR.DIRECTORY_SEPARATOR.'import.xlsx';
		$STOP = 50000; // the row that has higher index than the last one
		global $DELTA;
		$DELTA = 500;
		$SKIP = 0; // amount of rows to be skiped
		global $limit;
		$errors = [];
		$messages = [];
		$added = 0;
		$rows = 0;

		/*------------------------------------------------
		| RETRIEVE DATA
		------------------------------------------------*/ 
		$currencies = ['РУБ', 'EUR', 'USD'];

		/*------------------------------------------------
		| Read chunks of xlsx
		------------------------------------------------*/
		$objReader = new PHPExcel_Reader_Excel2007();
		$objReader->setReadDataOnly(TRUE);

		/*------------------------------------------------
		| Enabling Caching
		------------------------------------------------*/
		$cacheMethod=PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
		$cacheSettings=array("memoryCacheSize"=>"$memoryCacheSizeMb"."MB");
		PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

		for ($limit=$SKIP+$DELTA; $limit<=$STOP+$DELTA; $limit+=$DELTA) {
			$objReader->setReadFilter(new MyReadFilter());
			$objPHPExcel = $objReader->load($excel_file);
			$objWorksheet = $objPHPExcel->getActiveSheet();
			// remove empty rows that were skiped ???
			// $objWorksheet->removeRow(1, $SKIP);
			/*------------------------------------------------
			| Get max column and row indexes
			------------------------------------------------*/
			$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
			$highestColumnLetter = $objWorksheet->getHighestColumn(); // e.g 'F'
			$highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // e.g. 5

			/*------------------------------------------------
			| WRITE TO DB
			------------------------------------------------*/
			for ($row=1+$SKIP; $row<=$highestRow; ++$row) {

				$code 		= $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();		
				$price 		= $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
				$currency 	= $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();

				if (isset($code)) {
					$error = '';
					$rows++;

					$item = Item::where('code', $code)->first();

					if ($item) {
						// check price
						if (!isset($price)) {
							$error .= 'Не указана цена! ';
						} else {
							if (!is_float($price)) {
								$error .= 'Цена должна быть числом. ';
							} else if ($price < 0) {
								$error .= 'Цена не может быть отрицательной! ';
							}
						}

						// check currency
						if (!isset($currency)) {
							$error .= 'Не указана валюта! ';
						} else {
							if (!in_array($currency, $currencies)) {
								$error .= 'Выберите валюту: РУБ, EUR, USD. ';
							}
						}

						// check errors
						if ($error) {
							$errors[] = $row.' строка. '.$error;
							continue;
						} else {
							try {
								$item->price = $price;
								$item->currency = $currency;
								$item->save();

								// number of added items
								$added++;
							} catch (Exception $e) {
								$error .= 'UNCAUGHT EXCEPTION! ';
								$errors[] = $row.' строка. '.$error;
								continue;
							} 
						}
					}
				}

			}
			$objPHPExcel->disconnectWorksheets();
			unset($objPHPExcel);
		}

		timer_stop();
		mempeak();

		return View::make('admin/admin_import_status')->with([
			'errors' 	=> $errors,
			'added'		=> $added,
			'SKIP'		=> $SKIP,
			'missed'	=> $rows-$SKIP-$added,
			'time'		=> timer_stop(),
			'mempeak'	=> mempeak(),
		]);
	}
}