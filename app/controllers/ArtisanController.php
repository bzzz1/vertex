<?php
/*------------------------------------------------
| Shoud be disabled on product version!
------------------------------------------------*/
class ArtisanController extends BaseController {
	public function getMigrate() {
		Artisan::call('migrate', ['--force'=>true]);
		echo 'artisan migrate';
		// $stdin = fopen('php://stdin', 'r');
		$stdout = fopen('php://stdout', 'w');
		$result = stream_get_contents($stdout);
		echo '</br>'.$result;
	}

	public function getMigrateRollback() {
		Artisan::call('migrate:rollback', ['--force'=>true]);
		echo 'artisan migrate:rollback';		
	}

	public function getMigrateMake($name) {
		try {
			Artisan::call('migrate:make', ['name'=>$name]);
		} catch (RuntimeException $ex) {
			// echo "The Process class relies on proc_open, which is not available on your PHP installation.</br>&nbsp&nbsp&nbsp&nbsp--> Catched with RuntimeException.</br></br>";
		}
		echo 'artisan migrate:make '.$name;
	}

	public function getMigrateReset() {
		Artisan::call('migrate:reset', ['--force'=>true]);
		echo 'artisan migrate:reset';
	}
}