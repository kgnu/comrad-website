<?php

	//created sean williams 4/4/11
	//to be run every hour
	//reads upcoming shows from the database and writes them out to a text file
	//writes info of shows to be recorded into a text file
	
	//set a script timeout of thirty minutes
	set_time_limit(30 * 60);
	
	//include the configuration and log file
	require('config.php');
	require('log.php'); 
	
	//this error handler will write out any PHP errors
	set_error_handler('errorHandler');
	function errorHandler($errno, $errstr, $errfile, $errline) {
		logText('PHP Error from getUpcomingEvents.php: ' . $errstr . ' (line '.$errline.' in '.$errfile.')');
	}
	
	logText('Started executing getUpcomingEvents.php');
	
	//sw changed file on 8/16/12 to pull from geteventsbetween.php API instead of data access layer
	$apiUrl = 'http://kgnu.org/playlist/ajax/geteventsbetween.php?start=' . time() . '&end=' . (time() + 60*60*24*3); 
	logText('accesing url at ' . $apiUrl);
	$contents = file_get_contents($apiUrl);
	$events = json_decode($contents, TRUE);		
	
	//loop through the next day's events, and prepare a string to store in a text file
	$upcomingEvents = "";
	if (count($events) == 0) {
		logText('ERROR: no events found for upcoming events. Exiting getUpcomingEvents script.');
		exit();
	}
	
	//sort events 
	usort($events, 'sortByStartDateTime');
	
	foreach ($events as $scheduledEventInstance) {
		$scheduledEvent = $scheduledEventInstance['Attributes']['ScheduledEvent'];
		$event = $scheduledEvent['Attributes']['Event']['Attributes'];
		//if we're supposed to record the event, store the event in the text file
		if (isset($event['RecordAudio']) && $event['RecordAudio']) {
			$title = preg_replace("/[^A-Za-z0-9]/","",$event['Title']); //strip all non-alphanumeric characters out of the title, since this will be used for a file/folder name
			$startTime = $scheduledEventInstance['Attributes']['StartDateTime'];
			$recordingStartTime = $startTime + ($scheduledEvent['Attributes']['RecordingOffset'] * 60);
			$endTime = $startTime + ($scheduledEventInstance['Attributes']['Duration'] * 60);
			$showType = $event['Category'];
			$upcomingEvents .= $title . "|" . $recordingStartTime  . "|" . $endTime .  "|" . $startTime . "|" . $event['Title'] . "|" . 
							 (isset($event['Host']) ? $event['Host']['Attributes']['Name'] : '') 
							 . "|" . $event['Id'] . "|" . 
							 (isset($event['HostId']) ? $event['HostId'] : '') . 
							 "|".$showType."\n";
		}
	}
	
	
	//write out the upcoming events to a file
	$fh = fopen($upcomingEventsFile,'w');
	fwrite($fh,$upcomingEvents);
	fclose($fh);
	
	logText('Finished executing getUpcomingEvents.php');
	
	truncateLog();

	
	function sortByStartDateTime($a, $b) {
		return ($a['Attributes']['StartDateTime'] > $b['Attributes']['StartDateTime']);
	}
?>
