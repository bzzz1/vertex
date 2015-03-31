<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		// Eloquent::unguard();
		// $this->call('UserTableSeeder');

		// $path = "D:\\EASYPH~1.1VC\\data\\localweb\\projects\\vertex\\public\\photos\\articles\\";
		$path = "D:\\EASYPH~1.1VC\\data\\localweb\\projects\\vertex\\public\\photos\\";
		$imgs = File::allFiles($path);
		// $imgs = File::files($path);

		for ($i=0; $i<count($imgs); $i++) {
			try {
				$data = $imgs[$i]->getBasename();
				$name = iconv('utf-8', 'windows-1251', $data);
				File::move($path.$data, $path.$name);
			} catch (Exception $e) {
				echo $i;
				echo "\n";
				// echo $e;
			}
		}
	}

}
