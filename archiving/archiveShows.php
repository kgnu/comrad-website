<?php

	//created sean williams 4/4/11
	//to be run every minute
	//checks the list of upcoming shows created by getUpcomingShowsFromDb.php
	//and starts StreamRipper to record the audio stream
	
	//this script uses StreamRipper - http://manpages.ubuntu.com/manpages/dapper/man1/streamripper.1.html
	
	//this error handler will write out any PHP errors
	set_error_handler('errorHandler');
	function errorHandler($errno, $errstr, $errfile, $errline) {
		echo '<br /><b>Error</b>: ' . $errstr . ' (line '.$errline.' in '.$errfile.')<br />';
	}
	
	//include the configuration file
	require('config.php');
	
	//open the file of upcoming events
	if (!file_exists($upcomingEventsFile)) {
		require('getUpcomingEvents.php'); //this script will create the upcoming events file
	}
	$upcomingEventsText = file_get_contents($upcomingEventsFile);
	$upcomingEventsText = explode("\n",$upcomingEventsText); //each line in the upcoming events text file represents its own event to record
	
	//see if there are any events from the file that are currently active
	$activeEvent = false;
	foreach ($upcomingEventsText as $uet) {
		if (!empty($uet)) { //ignore blank lines in the text file
			$v = explode("|",$uet);
			$event = array();
			$event["title"] = $v[0];
			$event["startTime"] = $v[1];
			$event["endTime"] = $v[2];
			if (time() >= (int)$event["startTime"] && time() <= (int)$event["endTime"]) { //the event is active if the current time is after the start time, but before the end time
				$activeEvent = true;
				break;
			}
		}
	}
	
	//if we didn't find an active event, abandon the script
	if (!$activeEvent) {
		echo 'no active event, exiting script.<br />';
		exit();
	} else {
		echo 'active event, trying to begin recording...<br />';
	}
	
	//make a new directory for the show ...streamripper will automatically create the directory
	$folder = date("m-d-y_Gi",$event["startTime"])."_".$event["title"];
	$folder = str_replace(" ","",$folder); //remove spaces from the folder name
	if (file_exists($destination.$folder."/stream.mp3")) {
		//file already exists - the script is already running
		//TODO: we should check to see if the file is locked, and restart recording if it's not. if the file is not locked, we could assume that streamripper
		//has stopped for some reason
		echo 'stream is already being recorded at '.$destination.$folder.'/stream.mp3...exiting script.';
		exit();
	}
	$command = "streamripper ".$stream; //setup the terminal command
	$command .= " -d ".$destination.$folder; //set the destination directory
	$command .= " -a stream"; //record to one file - we don't want to separate the stream into tracks
	$command .= " -m 60"; //reset stream connection after a 60 second timeout
	//get the duration of the file
	$duartion = (int)$event["endTime"] - (int)$event["startTime"] + $extraRecordingTime;
	$command .= " -l ".($duration);
	$command .= " --debug"; //save a debugging log
	$command .= " > /dev/null &"; //run asynchronously so the script finishes - got this from http://www.sitecrafting.com/blog/to-run-php-code-in/
	
	echo 'launching streamripper: '.$command."<br />";;
	exec($command);
	
	//TODO: update the database with the recording path

	//let the script start if it's running late...possibly, just by checking if the file's there. it should also resume if it unexpectedly restarts (the resume functionality can be deferred)
	

?>
