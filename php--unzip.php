<?php
	$zip = new ZipArchive;
	$res = $zip->open('vertex_done_15_01+DB.zip');
	if ($res === TRUE) {
		$zip->extractTo(getcwd());
		$zip->close();
		echo 'Ok. '.getcwd();
	} else {
	    echo 'Failed. '.getcwd();
	}