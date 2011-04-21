<?php

	//created sean williams 4/4/11
	//to be run every 30 minutes
	//reads upcoming shows from the database and writes them out to a text file
	//writes info of shows to be recorded into a text file
	
	//this error handler will write out any PHP errors
	set_error_handler('errorHandler');
	function errorHandler($errno, $errstr, $errfile, $errline) {
		echo '<br /><b>Error</b>: ' . $errstr . ' (line '.$errline.' in '.$errfile.')<br />';
	}
	
	//include the configuration file
	require('config.php');
	
	//initialize classes that will let us access the database
	require_once($root.'lib/classes/Initialize.php');
	$init = new Initialize();
	$init->setAutoload();
	
	//get all events in the next day
	$em = EventManager::getInstance();
	$events = $em->getEventsBetween(time(), time() + 60*60*24);
	
	//loop through the next day's events, and prepare a string to store in a text file
	$upcomingEvents = "";
	//TODO: Add an offset
	foreach ($events as $scheduledEventInstance) {
		$scheduledEvent = $scheduledEventInstance->ScheduledEvent;
		$event = $scheduledEvent->Event;
		//if we're supposed to record the event, store the event in the text file
		if ($event->RecordAudio) {
			$startTime = $scheduledEventInstance->StartDateTime;
			$endTime = $startTime + ($scheduledEventInstance->Duration * 60);
			$upcomingEvents .= $event->Title . "|" . $startTime  . "|" . $endTime . "\n";
		}
	}
	
	//write out the upcoming events to a file
	$fh = fopen($upcomingEventsFile,'w');
	fwrite($fh,$upcomingEvents);
	fclose($fh);
?>
