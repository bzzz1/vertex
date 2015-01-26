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

	public function excelImport() {

			function timer_start() { // add error timing
				global $__start;
				date_default_timezone_set('Europe/Kiev');
				echo 'Start at: '.date('H:i:s');
				$__start = microtime(true); 
			}
			function memuse($line = 'unknown') {
				echo "</br>memory_get_usage(true) on line $line</br>";
				echo round(memory_get_usage(true)/1024/1024, 2);
				echo ' Mb</br>';
			}
			function mempeak($line = 'unknown') {	
				echo "</br>memory_get_peak_usage(true) on line $line</br>";
				echo round(memory_get_peak_usage(true)/1024/1024, 2);	
				echo ' Mb</br>';
			}
			
			function timer_stop() {
				global $__start;
				$__time = microtime(true) - $__start;
				echo '</br>EXECURION TIME: '.round($__time, 2).' sec</br>';
			}

			timer_start();
			/*----------------------------------------------*/
			// require 'vendor/autoload.php';
			/*----------------------------------------------*/
			// error_reporting(E_ALL);
			// ini_set('display_errors', TRUE);
			// ini_set('display_startup_errors', TRUE);
			// ignore_user_abort(true);
			set_time_limit(2*60);
			ini_set('memory_limit', '256M');
			$memoryCacheSizeMb = 1;
			$excel_file = 'public/excel/update_prices.xlsx';
			$servername = 'localhost';
			$username = 'iaroslav';
			$password = 'bzzzgroup';
			$dbname = 'vertex';
			$tablename = 'items';
			$sql = "UPDATE $tablename SET price = :price, currency = :currency WHERE code = :code;";
			$STOP = 100; // the row that has higher index than the last one
			global $DELTA;
			$DELTA = 100;
			$SKIP = 0; // amount of rows to be skiped
			global $limit;
			// SET $query->bindValue !!!
			/*------------------------------------------------
			| Mysql connection
			------------------------------------------------*/
			try {
				$db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				// echo "Connected successfully"; 
			}
			catch(PDOException $e) {
				echo $e->getMessage();
			}
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

			// $cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_discISAM;
			// PHPExcel_Settings::setCacheStorageMethod($cacheMethod);

			// PHPExcel_Settings::setLocale('en_us');

			for ($limit=$SKIP+$DELTA; $limit<=$STOP+$DELTA; $limit+=$DELTA) {
				$objReader->setReadFilter(new MyReadFilter());
				$objPHPExcel = $objReader->load($excel_file);
				$objWorksheet = $objPHPExcel->getActiveSheet();
				// remove empty rows that were skiped
				// $objWorksheet->removeRow(1, $SKIP);
				/*------------------------------------------------
				| Get max column and row indexes
				------------------------------------------------*/
				$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
				$highestColumnLetter = $objWorksheet->getHighestColumn(); // e.g 'F'

				$highestColumn = PHPExcel_Cell::columnIndexFromString($highestColumnLetter); // e.g. 5

				/*------------------------------------------------
				| Writing chunk to mysql
				------------------------------------------------*/
				for ($row=1; $row<=$highestRow; ++$row) {
					$row_array = [];
					for ($col=0; $col<=$highestColumn; ++$col) {
						$row_array[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
					}
					if ($row_array[0] !== NULL) {
						$query = $db->prepare($sql);

						$query->bindValue(':code', $row_array[0]);
						$query->bindValue(':price', $row_array[1]);
						$query->bindValue(':currency', $row_array[2]);

						try {
							$query->execute();
						}
						catch(PDOException $e) {
							echo $e->getMessage();
						}
					} else {
						// die('</br>ONLY EMPTY');
					}
				}
				$objPHPExcel->disconnectWorksheets();
				unset($objPHPExcel);
			}

			timer_stop();
			mempeak();

			echo '</br></br>IMPORT DONE.';
		/*------------------------------------------------
		| LARAVEL EXCEL NOT WORKING
		------------------------------------------------*/
		// Excel::load('vertex_update_price2.xlsx', function($reader) {
		// 	// Getting all results
		// 	// $results = $reader->get();
		// 	// ->all() is a wrapper for ->get() and will work the same
		// 	// $results = $reader->all();
		// 	// $results = $reader->first();
		// 	// $reader->dd();

		// 	$reader->each(function($sheet) {
		// 		$sheet->each(function($row) {

		// 		});
		// 	});
		// });

		// disable using first raw as column names 
		// $reader->noHeading();

		// ignore empty cells
		// $reader->ignoreEmpty();

		// Excel::filter('chunk')->load('vertex_update_price2.xlsx', 'UTF-8')->chunk(100, function($results) {
		// 	foreach($results as $row) {
		// 		echo $row;
		// 	}
		// });
		
		// $path = public_path();
		// $results = Excel::load('vertex_update_price2.xlsx', function($reader) {
			// $reader->each(function($sheet) {
			// 	$sheet->each(function($row) {
			// 		echo $row;
			// 	});
			// });
			// print_r($reader->get());
		// 	return $reader->get();
		// })->get();

		// print_r($results);
		/*----------------------------------------------*/
	}
}