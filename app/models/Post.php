<?php

class Post extends Eloquent {
	protected $guarded = [];

	public function author() {
		return $this->belongsTo('Author');
	}
}