<?php
class PostsController extends BaseController {

	public function index()	{
		return 'show all posts';
	}

	public function create() {
		return 'form to create a post';
	}

	public function store()	{
		return 'storing new post to datebase';
	}

	public function show($id) {
		return 'post with id: '.$id;
	}

	public function edit($id) {
		return 'edit post with id: '.$id;
	}

	public function update($id) {
		return 'update post with id: '.$id;
	}

	public function destroy($id) {
		return 'delete post with id: '.$id;
	}
}