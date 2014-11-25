<?php
class AuthorsController extends BaseController {

	public function index()	{
		return 'show all authors';
	}

	public function create() {
		return 'form to create a author';
	}

	public function store()	{
		return 'storing new author to datebase';
	}

	public function show($id) {
		return 'author with id: '.$id;
	}

	public function edit($id) {
		return 'edit author with id: '.$id;
	}

	public function update($id) {
		return 'update author with id: '.$id;
	}

	public function destroy($id) {
		return 'delete author with id: '.$id;
	}
}