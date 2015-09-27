<?php
class Parser extends BaseController {
    private $offset;
    private $one_iteration = 300;
    private $total_rows;
    private $data = [];
    private $rows;
    private $products_codes = [];
    private $products_duplication = [];
    private $errors = [];
    private $errors_session;
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
        $this->products_codes = Session::get('perser_products_codes', []);
        $this->products_duplication = Session::get('perser_duplications', []);
        $this->codes = Item::lists('code');
        $this->errors_session = Session::get('parser_errors', []);
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
            if (mb_check_encoding($document[$offset_parse]) === 'Windows-1251' ) {
                $this->data[] = explode(";", iconv('Windows-1251', "utf-8", $document[$offset_parse]));
            } elseif (mb_check_encoding($document[$offset_parse]) === 'ANSII' ) {
                $this->data[] = explode(";", iconv('ANSII', "utf-8", $document[$offset_parse]));
            } else {
                $this->data[] = explode(";", $document[$offset_parse]);
            }
        }

    }
    private function _validate($data) {
        if ($this->offset <= $this->one_iteration) {
            $i = $this->offset;
        } else {
            $i = $this->offset;
        }
        foreach ($data as $row) {
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
            if (isset($code)) {
                $this->rows+=$this->real_num;
//				$this->_isValidCode($code);
                $this->_isValidTitle($title);
//				$this->_isValidType($type);
//				$this->_isValidCategory($category);
//				$this->_isValidPrice($price);
//				$this->_isValidCurrency($currency);
//				$this->_isValidProcurement($procurement);

                if ($this->errors) {
                    print_r($this->errors);
                    $merged_errors = array_merge($this->errors_session, $this->errors);
                    continue;
                } else {
                    echo "shiit";
                }
//				print_r($merged_errors);
                exit;
            }
        }

    }
    private function _isValidProcurement($procurement) {
        if (!isset($procurement)) {
            $error = 'Не указано наличие! ';
            $this->errors[] = 'В строке'.$this->real_num.' '.$error;
        } else {
            if (!($procurement == 'МРП' || $procurement == 'ТВС')) {
                $error = 'Поле Наличие должно иметь значение ТВС - нет, МРП - есть. ';
                $this->errors[] = 'В строке'.$this->real_num.' '.$error;
            }
        }
    }
    private function _isValidCurrency($currency) {
        if (!isset($currency)) {
            $error = 'Не указана валюта! ';
            $this->errors[] = 'В строке'.$this->real_num.' '.$error;
        }
    }
    private function _isValidPrice ($price) {
        if (!isset($price)) {
            $error = 'Не указана цена! ';
            $this->errors[] = 'В строке'.$this->real_num.' '.$error;
        } else {
            if (!is_float($price)) {
                $error = 'Цена должна быть числом. ';
                $this->errors[] = 'В строке'.$this->real_num.' '.$error;
            } else if ($price < 0) {
                $error = 'Цена не может быть отрицательной! ';
                $this->errors[] = 'В строке'.$this->real_num.' '.$error;
            }
        }
    }
    private function _isValidCategory($category) {
        if (!isset($category)) {
            $error = 'Не указана категория! ';
            $this->errors[] = 'В строке'.$this->real_num.' '.$error;
        } elseif (!in_array($category, $this->categories)) {
            $error = 'Вы ввели неверную категорию. ';
            $this->errors[] = 'В строке'.$this->real_num.' '.$error;
        }
    }


    private function _isValidType($type) {
        if ( !isset($type) ) {
            $error = 'Не указан тип товара(ЗИП или оборудование)! ';
            $this->errors[] = 'В строке'.$this->real_num.' '.$error;
        } elseif ( !in_array($type, $this->types) ) {
            $error = 'Тип товара указан не верно(ЗИП или оборудование)! ';
            $this->errors[] = 'В строке'.$this->real_num.' '.$error;
        }
    }
    private function _isValidTitle($title) {
        if (mb_strlen($title) === 0) {
            $error = 'Не указано название! ';
            $this->errors[$this->real_num][] = $error;
        }
    }
    private function _isValidCode($code) {
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
    }
    private function _saveItems() {

    }
    public function index() {


        $this->_prepareData();
        $this->_validate($this->data);
        exit;
        $this->_saveItems();
        $this->offset = $this->offset + $this->one_iteration + 1;
        return View::make('admin/import_s')->with([
            'offset' 		=> $this->offset,
            'skip'			=> 1,
            'original_name' => Session::get('original_name'),
            'iteration'		=> $this->one_iteration,
            'max_row'		=> $this->total_rows,
        ]);
    }
}