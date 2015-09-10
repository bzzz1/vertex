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
	public function excelImport($only_prices) {
		function timer_start() { // add error timing
			global $__start;
			date_default_timezone_set('Europe/Moscow');
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
		$excel_file = public_path().DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'excel.xlsx';
		$STOP = 10000; // the row that has higher index than the last one
		global $DELTA;
		$DELTA = 1000;
		$SKIP = 1; // amount of rows to be skiped
		global $limit;
		$errors = [];
		$messages = [];
		$added = 0;
		$rows = 0;

		/*------------------------------------------------
		| RETRIEVE DATA
		------------------------------------------------*/ 

		$currencies = ['РУБ', 'EUR', 'USD'];
		$categories = [
			'Барное',
			'Нейтральное',
			'Посуда и инвентарь',
			'Посудомоечное',
			'Технологическое',
			'Упаковочное',
			'Хлебопекарское',
			'Холодильное'
		];
		$types = ['ЗИП', 'оборудование'];
		$codes = Item::lists('code');
		$producers_all = Item::lists('producer');
		$producers = array_unique($producers_all);

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

		for ($limit=$SKIP+$DELTA; $limit <= $STOP+$DELTA; $limit+=$DELTA) {
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
				
				$code 			= $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();		
				$title 			= $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
				$description 	= $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();	
				$type		 	= $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();	
				$category 		= $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
				$subcat 		= $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
				$producer 		= $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
				$price 			= $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
				$currency 		= $objWorksheet->getCellByColumnAndRow(8, $row)->getValue();
				$procurement 	= $objWorksheet->getCellByColumnAndRow(9, $row)->getValue();	
				$image 			= $objWorksheet->getCellByColumnAndRow(10, $row)->getValue();	

				if (isset($code)) {
					$message = '';
					$error = '';
					$rows++;

					// VALIDATION
 
					//*** code - 0 not empty because of initial condition
					if (in_array($code, $codes)) {
						$message .= 'Товар с кодом '.$code.' уже существует! ';
					} else {
						$message .= 'Товар с кодом '.$code.' добавлен! ';
					}

					//*** title - 1
					if (!isset($title)) {
						$error .= 'Не указано название! ';
					}

					//*** description - 2 can be null

					//*** type - 3
					if ( !isset($type) ) {
						$error .= 'Не указан тип товара(запчасть или оборудование)! ';
					} 
					if ( !in_array($type, $types) ) {
						$error .= 'Тип товара указан не верно(ЗИП или оборудование)! ';
					}

					//*** category - 4 and subcat - 5 
					if (!isset($subcat)) {
						$error .= 'Не указана подкатегория! ';
					} else if (!isset($category)) {
						$error .= 'Не указана категория! ';
					} else {
						if (!in_array($category, $categories)) {
							$error .= 'Вы ввели неверную категорию. ';
						}
					}

					//*** producer - 6
					if (!isset($producer)) {
						$error .= 'Не указан производитель! ';
					} else {
						if (!in_array($producer, $producers)) {
							$message .= 'Добавлен новый производитель '.$producer.'. ';
						}
					}

					//*** price - 7
					if (!isset($price)) {
						$error .= 'Не указана цена! ';
					} else {
						if (!is_float($price)) {
							$error .= 'Цена должна быть числом. ';
						} else if ($price < 0) {
							$error .= 'Цена не может быть отрицательной! ';
						}
					}

					//*** currency - 8
					if (!isset($currency)) {
						$error .= 'Не указана валюта! ';
					}

					//*** procurement - 9
					if (!isset($procurement)) {
						$error .= 'Не указано наличие! ';
					} else {
						if (!($procurement == 'МРП' || $procurement == 'ТВС')) {
							$error .= 'Поле Наличие должно иметь значение ТВС - нет, МРП - есть. ';
						}
					}

					//*** image - 10
					if ( !isset($image) ) {
						$message .= 'Не указана картинка у товара';
					}

					if ($error) {
						$errors[] = $row.' строка. '.$error;
						$messages[] = $row.'строка'.$message;
						continue;
					} else {
						if ( !in_array($code, $codes) ) {
							
							// add item to db
							$fields = [
								'item' 			=> $title,
								'description'   => ($description) ? $description : 'Для данного товара описание отсутствует.',
								'producer'		=> $producer,
								'price'			=> $price,
								'type'			=> $type,
								'category'		=> $category,
								'subcategory'	=> $subcat,
								'currency' 		=> $currency,
								'procurement' 	=> $procurement,
								'code' 			=> $code,
								'photo'			=> ($image) ? $image : 'no_image.png',
							];

							try {
								$item = Item::create($fields);
								$caught = false;
							} catch (Exception $e) {
								$error .= 'UNCAUGHT EXCEPTION! ';
								$errors[] = $row.' строка. '.$error;
								$caught = true;
								continue;
							} 

							// add code only if no exception thrown
							if (!$caught) {
								$codes[] = $item->code;
							}
						} else {
							if ($only_prices == 'only_price') {
								
								// update only price
								$fields = [
									'price'			=> $price,
									'currency' 		=> $currency,
									'code' 			=> $code,
								];

								try {
									$item = Item::where('code', $code)->update($fields);
									$caught = false;
								} catch (Exception $e) {
									$error .= 'UNCAUGHT EXCEPTION! ';
									$errors[] = $row.' строка. '.$error;
									$caught = true;
									continue;
								} 
							} else {
								
								// update item
								$fields = [
									'item' 			=> $title,
									'description'   => ($description) ? $description : 'Для данного товара описание отсутствует.',
									'producer'		=> $producer,
									'price'			=> $price,
									'type'			=> $type,
									'category'		=> $category,
									'subcategory'	=> $subcat,
									'currency' 		=> $currency,
									'procurement' 	=> $procurement,
									'code' 			=> $code,
									'photo'			=> ($image) ? $image : 'no_image.png',
								];

								try {
									$item = Item::where('code', $code)->update($fields);
									// $item_updated = $item->update($fields);
									$caught = false;
								} catch (Exception $e) {
									$error .= 'UNCAUGHT EXCEPTION! ';
									$errors[] = $row.' строка. '.$error;
									$caught = true;
									continue;
								} 
							}
						}	
					}

					if ($message) {
						$messages[] = $row.' строка. '.$message;
					}

					// number of added items
					$added++;
				}
			}
			$objPHPExcel->disconnectWorksheets();
			unset($objPHPExcel);
		}

		timer_stop();
		mempeak();

		return View::make('admin/admin_import_status')->with([
			'errors' 	=> $errors,
			'messages'  => $messages,
			'added'		=> $added,
			'SKIP'		=> $SKIP,
			'missed'	=> $rows-$added,
			'time'		=> timer_stop(),
			'mempeak'	=> mempeak(),
		]);
	}
}