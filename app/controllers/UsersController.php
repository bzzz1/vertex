<?php

class UsersController extends BaseController {

	public function getIndex() {
		return '<h1>Users controller index page.</h1>';
	}

	public function getCreate() {
		return View::make('users.create');
	}

	public function postIndex() {
		return 'Form was posted with data: '.e(Input::get('username'));
	}

	public function edit($all) {
		return 'Editing user: '.$all;
	}

/*------------------------------------------------
| This is catch-all method when missing
------------------------------------------------*/
	// public function missingMethod($parameters = []) {
 //    	return 'This method is missing yet in MoviesController!';
	// }
}
