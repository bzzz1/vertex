<?php
	$zip = new ZipArchive;
	$res = $zip->open('articles.zip');
	if ($res === TRUE) {
		$zip->extractTo(getcwd());
		$zip->close();
		echo 'Ok. '.getcwd();
	} else {
	    echo 'Failed. '.getcwd();
	}