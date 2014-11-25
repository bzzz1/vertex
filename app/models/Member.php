<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Member extends Eloquent implements UserInterface, RemindableInterface {
	use UserTrait, RemindableTrait;
	protected $guarded = [];
	// protected $table = 'members';
	// protected $hidden = array('password', 'remember_token');

	public static $creds = [
		'name' 		=> 'Jeffrey',				// Input::get('name'),
		'email'		=> 'Jeffrey@envato.com',	// Input::get('email'),	
		'password' 	=> 'tutsplus' 				// Input::get('password')
	];


	// protected $fillable = ['email', 'password'];
	// protected $guarded = []; // no fields to be guarded from mass assignment
	// public static $unguarded = true;
}
