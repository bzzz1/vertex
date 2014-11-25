<?php

class MembersController extends BaseController {

	public function index()	{
		if (Auth::attempt(Member::$creds)) {	// logging in the user 
			// Auth::validate(Member::$creds)	// check if the user is already a member without logging in 
			// Auth::login(Member::find(1))		// manually logging in the user
			// if (Auth::check()) {				// checks if the user is already logged in
			// 	return 'Session has been set, user is logged in.';
			// } else {
			// 	return 'Session has not been set yet, user is not logged in.';
			// }
			return Redirect::to('admin');
		} else {
			return 'You are not a member!';
		}
	}

	public function create() {
		// $member = Member::find(1);
		// $member->password = Hash::make('tutsplus');
		// $member->save();
		return 'form to create a member';
	}

	public function store()	{
		return 'storing new member to datebase';
	}

	public function show($id) {
		return 'member with id: '.$id;
	}

	public function edit($id) {
		return 'edit member with id: '.$id;
	}

	public function update($id) {
		return 'update member with id: '.$id;
	}

	public function destroy($id) {
		return 'delete member with id: '.$id;
	}
/*----------------------------------------------*/
	public function getAdmin() {
		if (Auth::check()) {

			$member = Auth::user();
			return 'Welcome back to the admin section, '.$member->name.'.';

		} else {
			return Redirect::to('login');
		}
	}

	// public function admin() {
	// 	// @ use auth filter 
	// 	return 'Private admin area.';
	// }

	public function getLogin() {
		return 'Login the user form';
	}

	public function getLogout() {
		Auth::logout();
		return 'Logged out.';
		// sleep(3);
		// return Redirect::to('login');
	}
}