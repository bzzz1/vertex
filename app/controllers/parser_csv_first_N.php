<?php
class Parser extends BaseController {
    public function index() {
        set_time_limit(10*60);
        ini_set('memory_limit', '256M');
        $offset = (array_key_exists('offset', $_GET)) ? $_GET['offset'] : 1;
        $excel_file = public_path().DIRECTORY_SEPARATOR.'excel'.DIRECTORY_SEPARATOR.'excel.xlsx';
        $SKIP = 1; // amount of rows to be skiped
        $ONE_ITER = 300; //amount of rows to import
        $errors_session = Session::get('errors', []);
        $messages_session = Session::get('messages', []);
        $errors = [];
        $messages = [];
        $added = Session::get('added', 0);
        $rows = Session::get('rows', 0);
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
                'missed'	=> Session::get('rows')-Session::get('added'),
                'original_name'	=> Session::get('original_name'),
            ]);
        }

        $limit = $offset + 299;
        for ( ; $offset <= $limit; $offset++) {
            if (mb_detect_encoding($document[$offset]) === 'Windows-1251') {
//			print_r(mb_detect_encoding($document[$offset]));
                $data[] = explode(";", iconv('Windows-1251', "utf-8//IGNORE", $document[$offset]));
            }elseif(mb_detect_encoding($document[$offset]) === 'ASCII') {
                $data[] = explode(";", iconv('ASCII', "utf-8//IGNORE", $document[$offset]));
            }else {
                $data[] = explode(";", $document[$offset]);
            }
        }
        print_r($data);
        exit;
//		$this->_saveBrands($data);
//		$this->_saveCategories($data);
        $this->_saveProducts($data);


        return View::make('admin/import_s')->with([
            'offset' 		=> $offset,
            'skip'			=> $SKIP,
            'original_name' => Session::get('original_name'),
            'iteration'		=> $ONE_ITER,
        ]);
//		$content = $this->load->view('backend/csv_parser/process.html', array(
//			'url'  => '/backend/csvParser/process/'.$offset.'/',
//			'rows' => $data,
//		));
//		echo $this->load->view('backend/wrapper.html', array(
//			'title'   => 'Парсинг прайс-листа',
//			'content' => $content,
//		));
    }

    private function _saveProducts(array $data)
    {
        foreach ($data as $row) {
            foreach ($row as $id => $value) {
                $row[$id] = addslashes($value);
            }
            $code = $row[0];
            print_r($code);
            $title = $row[1];
            print_r($title);

            $description = $row[2];
            print_r($description);

            $type = $row[3];
            print_r($type);

            $category = $row[4];
            $subcat = $row[5];
            $producer = $row[6];
            $price = $row[7];
            $currency = $row[8];
            $procurement = $row[9];
            $image = $row[10];
            exit;
        }
    }
}