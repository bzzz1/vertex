<?php
class Parser extends BaseController {
    public function index() {
        set_time_limit(10*60);
        ini_set('memory_limit', '256M');
        $SKIP = 1; //delete
        $ONE_ITER = 300; //amount of rows to import
        $errors_session = Session::get('errors', []);
        $messages_session = Session::get('messages', []);
        $errors = [];
        $messages = [];
        $added = Session::get('added', 0);
        $rows = Session::get('rows', 0);
        $products_codes = Session::get('perser_products_codes', []);
        $products_duplication = Session::get('perser_duplications', []);
        $offset = (array_key_exists('offset', $_GET)) ? $_GET['offset'] : 1;
        $excel_file = public_path().DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'excel.csv';
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
        $data = array();
        $document = file($excel_file, FILE_SKIP_EMPTY_LINES);
        unset($document[0]);
        $totalCount = count($document);


        if ($offset >= $totalCount) {
            return View::make('admin/admin_import_status')->with([
                'errors' 	=> $errors_session,
                'messages'  => $messages_session,
                'added'		=> Session::get('added'),
                'SKIP'		=> $SKIP,
                'missed'	=> Session::get('rows')- Session::get('added'),
                'original_name'	=> Session::get('original_name'),
            ]);
        }


//		if ($offset + $ONE_ITER > $totalCount) {
//			$offset = $totalCount - $offset;
//		}
        $limit = $offset + $ONE_ITER;
        for ( ; $offset <= $limit; $offset++) {
            if (!array_key_exists($offset, $document)) {
                continue;
            }
            $data[] = explode(";", iconv('Windows-1251', "utf-8", $document[$offset]));
        }
        $i = $offset;
        foreach ($data as $row) {
            $real_num = $i - $ONE_ITER;
//			echo "<p> $real_num </p>";
            foreach ($row as $id => $value) {
                $row[$id] = addslashes($value);
            }
//			print_r($row);
//			exit;
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
//			 VALIDATION AND MAIN CODE
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
                    $products_duplication[$code][] = $real_num;
                    continue;
                } else {
                    $products_codes[] = $code;
                }


                // validation
                //*** code - 0 not empty because of initial condition
                if (in_array($code, $codes)) {
                    $message .= 'Товар с кодом ' . $code . ' существует! ';
                } else {
                    $message .= 'Товар с кодом ' . $code . ' добавлен! ';
                }

                //*** title - 1
                if (!isset($title)) {
                    $error .= 'Не указано название! ';
                }

                //*** type - 3
                if (!isset($type)) {
                    $error .= 'Не указан тип товара(ЗИП или оборудование)! ';
                } elseif (!in_array($type, $types)) {
                    $error .= 'Тип товара указан не верно(ЗИП или оборудование)! ';
                }

                //*** category - 4 and subcat - can be null
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
                if (!isset($image)) {
                    $message .= 'Не указана картинка у товара';
                }

                if ($error) {
                    $errors[] = $real_num . ' строка. ' . $error;
                    $messages[] = $real_num . ' строка. ' . $message;
                    continue;
                } else {
                    if ($only_prices == 'only_price') {
                        if (in_array($code, $codes)) {
                            // update prices and procurement
                            $fields = [
                                'price' => $price,
                                'currency' => $currency,
                                'procurement' => $procurement,
                                'code' => $code,
                            ];
                            try {
                                $item = Item::where('code', $code)->update($fields);
                                $caught = false;
                            } catch (Exception $e) {
                                $error .= 'UNCAUGHT EXCEPTION! ';
                                // add error to errors array
                                $errors[] = $real_num . ' строка. ' . $error;
                                $caught = true;
                                continue;
                            }
                            if (!$caught) {
                                // add code to array of codes in price
//								$codes_duplication[] = ($code);
                                $added++;
                            }
                        } else {
                            // add item to DB with all fields
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
                                $error .= 'UNCAUGHT EXCEPTION! ';
                                // add error to errors array
                                $errors[] = $real_num . ' строка. ' . $error;
                                $caught = true;
                                continue;
                            }
                            // add code only if no exception thrown
                            if (!$caught) {
                                // add code to an array of codes when item is created
                                $codes[] = $item->code;
                                // add code to array of codes in price
                                //$codes_duplication[] = $code;
                                $added++;
                            }
                        }
                    } else {
                        if (in_array($code, $codes)) {
                            // update item with all fields
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
                                $error .= 'UNCAUGHT EXCEPTION! ';
                                // add error to errors array
                                $errors[] = $real_num . ' строка. ' . $error;
                                $caught = true;
                                continue;
                            }
                            if (!$caught) {
                                // add code to array of codes in price
                                $codes_duplication[] = $code;
                                $added++;
                            }
                        } else {
                            // add item to db
                            $fields = [
                                'item' => $title,
                                'description' => ($description) ? $description : 'Для данного товара описание отсутствует.',
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
                                $error .= 'UNCAUGHT EXCEPTION! ';
                                // add error to errors array
                                $errors[] = $real_num . ' строка. ' . $error;
                                $caught = true;
                                continue;
                            }

                            // add code only if no exception thrown
                            if (!$caught) {
                                // add code to an array of codes when item is created
                                $codes[] = $item->code;
                                // add code to array of codes in price
                                $codes_duplication[] = $code;
                                $added++;
                            }
                        }
                    }
                }
                // Check if there are messages
                if ($message) {
                    $messages[] = $real_num . ' строка. ' . $message;
                }
                // increment the number of added items
                // $added++;
            }
            $i++;
        }
//		exit;
//		print_r($offset);
//		exit;
        return View::make('admin/import_s')->with([
            'offset' 		=> $offset,
            'skip'			=> $SKIP,
            'original_name' => Session::get('original_name'),
            'iteration'		=> $ONE_ITER,
            'max_row'		=> $totalCount,
        ]);
    }
}