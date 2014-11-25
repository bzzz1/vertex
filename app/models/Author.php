<?php

class Author extends Eloquent {
	protected $guarded = [];
	
	public function posts() {
		return $this->hasMany('Post');
	}
}