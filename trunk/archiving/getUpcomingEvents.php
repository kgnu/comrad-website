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
	
	//initialize classes that will let us access the database
	require_once($root.'lib/classes/Initialize.php');
	$init = new Initialize();
	$init->setAutoload();
	
	//disable authorization
	$pm = PermissionManager::getInstance();
	$pm->disableAuthorization();
	
	//get all events in the next day
	$em = EventManager::getInstance();
	$events = $em->getEventsBetween(time(), time() + 60*60*24);
	
	//loop through the next day's events, and prepare a string to store in a text file
	$upcomingEvents = "";
	foreach ($events as $scheduledEventInstance) {
		$scheduledEvent = $scheduledEventInstance->ScheduledEvent;
		$event = $scheduledEvent->Event;
		//if we're supposed to record the event, store the event in the text file
		if ($event->RecordAudio) {
			$title = preg_replace("/[^A-Za-z0-9]/","",$event->Title); //strip all non-alphanumeric characters out of the title, since this will be used for a file/folder name
			$startTime = $scheduledEventInstance->StartDateTime;
			$recordingStartTime = $startTime + ($scheduledEventInstance->ScheduledEvent->RecordingOffset * 60);
			$endTime = $startTime + ($scheduledEventInstance->Duration * 60);
			$showType = $scheduledEventInstance->ScheduledEvent->Event->Category;
			$upcomingEvents .= $title . "|" . $recordingStartTime  . "|" . $endTime .  "|" . $startTime . "|" . $event->Title . "|" . 
							 $event->Host . "|" . $event->EventId . "|" . $event->HostId . "|".$showType."\n";
		}
	}
	
	
	//write out the upcoming events to a file
	$fh = fopen($upcomingEventsFile,'w');
	fwrite($fh,$upcomingEvents);
	fclose($fh);
	
	logText('Finished executing getUpcomingEvents.php');
	
	truncateLog();

	
?>
