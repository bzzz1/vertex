<?php 
	// Custom helper functions

	function urlencode2($string) {
		$string = urlencode($string);
		$string = str_replace("%2F", "-", $string);
		return $string;
	}