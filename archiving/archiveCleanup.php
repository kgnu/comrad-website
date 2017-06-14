<?php

	echo 'Running archiveCleanup.php ... ' . "\n";

	require('config.php');
	
	
	$deleteBefore = time() - 60 * 60 * 24 * 365; // delete files modified before this date, which is one year before now
	
	checkDirectory($destination);
	
	function checkDirectory($dir) {
		$files = scandir($dir);
		foreach($files as $file) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			
			$path = $dir . $file;
			
			if (is_dir($path)) {
				checkDirectory($path . '/');
			} else {
				if (filemtime($path) < $GLOBALS['deleteBefore']) {
					if (unlink($path)) {
						echo 'Removing file at ' . $path;
					} else {
						echo "Couldn't remove file at " . $path;
					}
					echo "\n";
					
				}
			}
		}
	}
	
	echo 'Finished running archiveCleanup.php';
?>