<?php
/**  Define a Read Filter class implementing PHPExcel_Reader_IReadFilter  */ 
class chunkReadFilter implements PHPExcel_Reader_IReadFilter 
{ 
    private $_startRow = 0; 
    private $_endRow   = 0; 

    /**  Set the list of rows that we want to read  */ 
    public function setRows($startRow, $chunkSize) { 
        $this->_startRow = $startRow; 
        $this->_endRow   = $startRow + $chunkSize; 
    } 

    public function readCell($column, $row, $worksheetName = '') { 
        //  Only read the heading row, and the configured rows 
        if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) { 
            return true; 
        } 
        return false; 
    } 
} 
class Parser extends BaseController {
    public function index() {
        $offset = (array_key_exists('offset', $_GET)) ? $_GET['offset'] : 1;

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

        $SKIP = 1; // amount of rows to be skiped
        $ONE_ITER = 300; //amount of rows to import
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
                'Хлебопекарное',
                'Холодильное'
            ];
            $types = ['ЗИП', 'оборудование'];
            $codes = Item::lists('code');
            $producers_all = Item::lists('producer');
            $producers = array_unique($producers_all);
            $only_prices = Session::get('only_prices');

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

        $objReader = PHPExcel_IOFactory::createReader('Excel2007');

        /**  Define how many rows we want to read for each "chunk"  **/ 
        $chunkSize = $offset; 
        /**  Create a new Instance of our Read Filter  **/ 
        $chunkFilter = new chunkReadFilter(); 

        $objReader->setReadDataOnly(TRUE);

        $objReader->setReadFilter($chunkFilter); 

        $objPHPExcel = $objReader->load($excel_file);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        // Get the highest row and column numbers referenced in the worksheet
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
        $codes_duplication =[];
        $products_codes = Session::get('perser_products_codes', []);
        $products_duplication = Session::get('perser_duplications', []);


        if ($offset < $highestRow) {
            if ($offset+$ONE_ITER > $highestRow) {
                for ($row=$offset+$SKIP; $row <= $highestRow; $row++) {

                    // $chunkFilter->setRows($row, $chunkSize); 
                    // *  Load only the rows that match our filter  * 
                    // $objPHPExcel = $objReader->load($excel_file); 
                    // $objWorksheet = $objPHPExcel->getActiveSheet();
                    // $highestRow = $objWorksheet->getHighestRow(); // e.g. 10


                    //echo "{$row} строка";
                    $code           = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $title          = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $description    = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $type           = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $category       = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $subcat         = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $producer       = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $price          = $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $currency       = $objWorksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $procurement    = $objWorksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $image          = $objWorksheet->getCellByColumnAndRow(10, $row)->getValue();

                    // VALIDATION AND MAIN CODE
                    if (isset($code)) {
                        $message = '';
                        $error = '';
                        $rows++;


                        $code = trim($code);
                        $code = strval($code);
                        if (in_array($code, $products_codes)) {
                            if (!array_key_exists($code, $products_duplication)) {
                                $products_duplication[$code] = [];
                            }
                            $products_duplication[$code][] = $row;
                            continue;
                        } else {
                            $products_codes[] = $code;
                        }



                        // validation
                        //*** code - 0 not empty because of initial condition
                        if (in_array($code, $codes)) {
                            $message .= 'Товар с кодом '.$code.' существует! ';
                        } else {
                            $message .= 'Товар с кодом '.$code.' добавлен! ';
                        }
                        // check if code was in this price alerady
                        if ( in_array($code, $codes_duplication) ) {
                            $message .= 'Товар с кодом '.$code.' уже встречался в прайсе! ';
                        }

                        //*** title - 1
                        if (!isset($title)) {
                            $error .= 'Не указано название! ';
                        }

                        //*** type - 3
                        if ( !isset($type) ) {
                            $error .= 'Не указан тип товара(ЗИП или оборудование)! ';
                        }
                        if ( !in_array($type, $types) ) {
                            $error .= 'Тип товара указан не верно(ЗИП или оборудование)! ';
                        }

                        //*** category - 4 and subcat - can bee null
                        if (!isset($category)) {
                            $error .= 'Не указана категория! ';
                        } else {
                            if (!in_array($category, $categories)) {
                                $error .= 'Вы ввели неверную категорию. ';
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
                            $messages[] = $row.' строка. '.$message;
                            continue;
                        } else {
                            if ($only_prices == 'only_price') {
                                if ( in_array($code, $codes) ) {
                                    // update prices and procurement
                                    $fields = [
                                        'price'         => $price,
                                        'currency'      => $currency,
                                        'procurement'   => $procurement,
                                        'code'          => $code,
                                    ];
                                    try {
                                        $item = Item::where('code', $code)->update($fields);
                                        $caught = false;
                                    } catch (Exception $e) {
                                        $error .= 'UNCAUGHT EXCEPTION! ';
                                        // add error to errors array
                                        $errors[] = $row.' строка. '.$error;
                                        $caught = true;
                                        continue;
                                    }
                                    if (!$caught) {
                                        // add code to array of codes in price
                                        $codes_duplication[] = ($code);
                                    }
                                } else {
                                    // add item to DB with all fields
                                    $fields = [
                                        'item'          => $title,
                                        'description'   => ($description) ? $description : 'К сожалению, для данного товара описание временно отсутствует.',
                                        'producer'      => $producer,
                                        'price'         => $price,
                                        'type'          => $type,
                                        'category'      => $category,
                                        'subcategory'   => ($subcat) ? $subcat : 'Разное',
                                        'currency'      => $currency,
                                        'procurement'   => $procurement,
                                        'code'          => $code,
                                        'photo'         => ($image) ? $image : 'no_image.png',
                                    ];
                                    try {
                                        $item = Item::create($fields);
                                        $caught = false;
                                    } catch (Exception $e) {
                                        $error .= 'UNCAUGHT EXCEPTION! ';
                                        // add error to errors array
                                        $errors[] = $row.' строка. '.$error;
                                        $caught = true;
                                        continue;
                                    }
                                    // add code only if no exception thrown
                                    if (!$caught) {
                                        // add code to an array of codes when item is created
                                        $codes[] = $item->code;
                                        // add code to array of codes in price
                                        $codes_duplication[] = $code;
                                    }
                                }
                            } else {
                                if ( in_array($code, $codes) ) {
                                    // update item with all fields
                                    $fields = [
                                        'item'          => $title,
                                        'description'   => ($description) ? $description : 'К сожалению, для данного товара описание временно отсутствует.',
                                        'producer'      => $producer,
                                        'price'         => $price,
                                        'type'          => $type,
                                        'category'      => $category,
                                        'subcategory'   => ($subcat) ? $subcat : 'Разное',
                                        'currency'      => $currency,
                                        'procurement'   => $procurement,
                                        'code'          => $code,
                                        'photo'         => ($image) ? $image : 'no_image.png',
                                    ];
                                    try {
                                        $item = Item::where('code', $code)->update($fields);
                                        $caught = false;
                                    } catch (Exception $e) {
                                        $error .= 'UNCAUGHT EXCEPTION! ';
                                        // add error to errors array
                                        $errors[] = $row.' строка. '.$error;
                                        $caught = true;
                                        continue;
                                    }
                                    if (!$caught) {
                                        // add code to array of codes in price
                                        $codes_duplication[] =  $code;
                                    }
                                } else {
                                    // add item to db
                                    $fields = [
                                        'item'          => $title,
                                        'description'   => ($description) ? $description : 'Для данного товара описание отсутствует.',
                                        'producer'      => $producer,
                                        'price'         => $price,
                                        'type'          => $type,
                                        'category'      => $category,
                                        'subcategory'   => ($subcat) ? $subcat : 'Разное',
                                        'currency'      => $currency,
                                        'procurement'   => $procurement,
                                        'code'          => $code,
                                        'photo'         => ($image) ? $image : 'no_image.png',
                                    ];
                                    try {
                                        $item = Item::create($fields);
                                        $caught = false;
                                    } catch (Exception $e) {
                                        $error .= 'UNCAUGHT EXCEPTION! ';
                                        // add error to errors array
                                        $errors[] = $row.' строка. '.$error;
                                        $caught = true;
                                        continue;
                                    }

                                    // add code only if no exception thrown
                                    if (!$caught) {
                                        // add code to an array of codes when item is created
                                        $codes[] = $item->code;
                                        // add code to array of codes in price
                                        $codes_duplication[] =  $code;
                                    }
                                }
                            }
                        }
                        // Check if there are messages
                        if ($message) {
                            $messages[] = $row.' строка. '.$message;
                        }
                        // increment the number of added items
                        $added++;
                    }
                }
            } else {
                for ($row=$offset+$SKIP; $row <= $offset+$ONE_ITER; $row++) {
                    //echo "{$row} строка";
                    $code           = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $title          = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $description    = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $type           = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $category       = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $subcat         = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $producer       = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $price          = $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $currency       = $objWorksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $procurement    = $objWorksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $image          = $objWorksheet->getCellByColumnAndRow(10, $row)->getValue();
                    if (isset($code)) {
                        $message = '';
                        $error = '';
                        $rows++;
                        // validation
                        //*** code - 0 not empty because of initial condition
                        if (in_array($code, $codes)) {
                            $message .= 'Товар с кодом '.$code.' существует! ';
                        } else {
                            $message .= 'Товар с кодом '.$code.' добавлен! ';
                        }
                        // check if code was in this price alerady
                        if ( in_array($code, $codes_duplication) ) {
                            $message .= 'Товар с кодом '.$code.' уже встречался в прайсе! ';
                        }

                        //*** title - 1
                        if (!isset($title)) {
                            $error .= 'Не указано название! ';
                        }

                        //*** type - 3
                        if ( !isset($type) ) {
                            $error .= 'Не указан тип товара(ЗИП или оборудование)! ';
                        }
                        if ( !in_array($type, $types) ) {
                            $error .= 'Тип товара указан не верно(ЗИП или оборудование)! ';
                        }

                        //*** category - 4 and subcat - can bee null
                        if (!isset($category)) {
                            $error .= 'Не указана категория! ';
                        } else {
                            if (!in_array($category, $categories)) {
                                $error .= 'Вы ввели неверную категорию. ';
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
                            $messages[] = $row.' строка. '.$message;
                            continue;

                        } else {
                            if ($only_prices = 'only_price') {
                                if ( in_array($code, $codes) ) {
                                    // update prices and procurement
                                    $fields = [
                                        'price'         => $price,
                                        'currency'      => $currency,
                                        'procurement'   => $procurement,
                                        'code'          => $code,
                                    ];
                                    try {
                                        $item = Item::where('code', $code)->update($fields);
                                        $caught = false;
                                    } catch (Exception $e) {
                                        $error .= 'UNCAUGHT EXCEPTION! ';
                                        // add error to errors array
                                        $errors[] = $row.' строка. '.$error;
                                        $caught = true;
                                        continue;
                                    }
                                    if (!$caught) {
                                        // add code to array of codes in price
                                        $codes_duplication[] = $code;
                                    }
                                } else {
                                    // add item to DB with all fields
                                    $fields = [
                                        'item'          => $title,
                                        'description'   => ($description) ? $description : 'К сожалению, для данного товара описание временно отсутствует.',
                                        'producer'      => $producer,
                                        'price'         => $price,
                                        'type'          => $type,
                                        'category'      => $category,
                                        'subcategory'   => ($subcat) ? $subcat : 'Разное',
                                        'currency'      => $currency,
                                        'procurement'   => $procurement,
                                        'code'          => $code,
                                        'photo'         => ($image) ? $image : 'no_image.png',
                                    ];
                                    try {
                                        $item = Item::create($fields);
                                        $caught = false;
                                    } catch (Exception $e) {
                                        $error .= 'UNCAUGHT EXCEPTION! ';
                                        // add error to errors array
                                        $errors[] = $row.' строка. '.$error;
                                        $caught = true;
                                        continue;
                                    }
                                    // add code only if no exception thrown
                                    if (!$caught) {
                                        // add code to an array of codes when item is created
                                        $codes[] = $item->code;
                                        // add code to array of codes in price
                                        $codes_duplication[] = $code;
                                    }
                                }
                            } else {
                                if (in_array($code, $codes)) {
                                    // update item with all fields
                                    $fields = [
                                        'item'          => $title,
                                        'description'   => ($description) ? $description : 'К сожалению, для данного товара описание временно отсутствует.',
                                        'producer'      => $producer,
                                        'price'         => $price,
                                        'type'          => $type,
                                        'category'      => $category,
                                        'subcategory'   => ($subcat) ? $subcat : 'Разное',
                                        'currency'      => $currency,
                                        'procurement'   => $procurement,
                                        'code'          => $code,
                                        'photo'         => ($image) ? $image : 'no_image.png',
                                    ];
                                    try {
                                        $item = Item::where('code', $code)->update($fields);
                                        $caught = false;
                                    } catch (Exception $e) {
                                        $error .= 'UNCAUGHT EXCEPTION! ';
                                        // add error to errors array
                                        $errors[] = $row.' строка. '.$error;
                                        $caught = true;
                                        continue;
                                    }
                                    if (!$caught) {
                                        // add code to array of codes in price
                                        $codes_duplication[] = $code;
                                    }
                                } else {
                                    // add item to db
                                    $fields = [
                                        'item'          => $title,
                                        'description'   => ($description) ? $description : 'Для данного товара описание отсутствует.',
                                        'producer'      => $producer,
                                        'price'         => $price,
                                        'type'          => $type,
                                        'category'      => $category,
                                        'subcategory'   => ($subcat) ? $subcat : 'Разное',
                                        'currency'      => $currency,
                                        'procurement'   => $procurement,
                                        'code'          => $code,
                                        'photo'         => ($image) ? $image : 'no_image.png',
                                    ];
                                    try {
                                        $item = Item::create($fields);
                                        $caught = false;
                                    } catch (Exception $e) {
                                        $error .= 'UNCAUGHT EXCEPTION! ';
                                        // add error to errors array
                                        $errors[] = $row.' строка. '.$error;
                                        $caught = true;
                                        continue;
                                    }

                                    // add code only if no exception thrown
                                    if (!$caught) {
                                        // add code to an array of codes when item is created
                                        $codes[] = $item->code;
                                        // add code to array of codes in price
                                        $codes_duplication[] = $code;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $objPHPExcel->disconnectWorksheets();
            unset($objPHPExcel);
            timer_stop();
            mempeak();

            $merged_products_codes = array_merge(Session::get('perser_products_codes', []), $products_codes);
            $merged_products_duplication = array_merge(Session::get('perser_duplications', []), $products_duplication);
            Session::put('perser_products_codes', $merged_products_codes);
            Session::put('perser_duplications', $merged_products_duplication);


            if ($offset+$ONE_ITER <= $highestRow) {
                $offset = $offset + $ONE_ITER;
                return View::make('admin/import_s')->with([
                    'offset'        => $offset,
                    'errors'        => $errors,
                    'messages'      => $messages,
                    'added'         => $added,
                    'SKIP'          => $SKIP,
                    'missed'        => $rows-$added,
                    'time'          => timer_stop(),
                    'mempeak'       => mempeak(),
                    'original_name' => Session::get('original_name'),
                    'max_row'       => $highestRow,
                    'offset'        => $offset,
                    'iteration'     => $ONE_ITER
                    // 'codes_duplication' => $codes_duplication,

                ]);
            } elseif ($offset+$ONE_ITER > $highestRow) {
                $ONE_ITER = $highestRow - $offset;
                $offset = $offset + $ONE_ITER;
                return View::make('admin/import_s')->with([
                    'offset'        => $offset,
                    'errors'        => $errors,
                    'messages'      => $messages,
                    'added'         => $added,
                    'SKIP'          => $SKIP,
                    'missed'        => $rows-$added,
                    'time'          => timer_stop(),
                    'mempeak'       => mempeak(),
                    'original_name' => Session::get('original_name'),
                    'max_row'       => $highestRow,
                    'offset'        => $offset,
                    'iteration'     => $ONE_ITER
                    // 'codes_duplication' => $codes_duplication,

                ]);
            }
        }elseif ($offset >= $highestRow) {


//          Session::put('perser_products_codes', []);
//          Session::put('perser_duplications', []);

            print_r(Session::get('perser_duplications', ['error!']));

            exit;
            return View::make('admin/admin_import_status')->with([
                'errors'    => $errors,
                'messages'  => $messages,
                'added'     => $added,
                'SKIP'      => $SKIP,
                'missed'    => $rows-$added,
                'time'      => timer_stop(),
                'mempeak'   => mempeak(),
                'codes_duplications' => Session::get('perser_duplications', ['error!']),
                // 'original_name' => $_SESSION['original_name'],
                // 'codes_duplication' => $codes_duplication,
            ]);
        }
    }
}
