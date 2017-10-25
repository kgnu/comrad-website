<?php
	// script to generate missing archives
	
	//first, need a list of files
		

	function listFolderFiles($dir){
		$ffs = scandir($dir);

		unset($ffs[array_search('.', $ffs, true)]);
		unset($ffs[array_search('..', $ffs, true)]);

		// prevent empty ordered elements
		if (count($ffs) < 1)
			return;

		foreach($ffs as $ff){
			if(is_dir($dir.'/'.$ff)) { 
				listFolderFiles($dir.'/'.$ff);
			} else {
				echo $dir . '/' . $ff . "\n";
			}
		}
	}

	listFolderFiles('audioarchives');


	
	//SELECT * FROM ScheduledEventInstance WHERE sei_ScheduledEventId IN (SELECT se_Id FROM ScheduledEvent WHERE se_eventId IN (SELECT e_Id FROM Event WHERE e_Title = 'A Classic Monday')) AND YEAR(sei_StartDateTime) = 2017 AND MONTH(sei_StartDateTime) = 10 AND DAY(sei_StartDateTime) = 23
?>