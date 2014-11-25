<?php

class Movies extends BaseController {

	public function index() {
		return View::make('movie.index');
	}

	public function show() {
		return 'Showing one movie';
	}

	public function create() {
		return 'Form for createing a new movie';
	}
}