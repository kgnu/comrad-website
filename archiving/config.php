<?php
	//config.php - configuration variables for the archiving script
	//sw 4/21/11
	
	//the path to the root of the comrad-dev folder
	$root = "../../../"; 
	
	//this file is a text file that stores text data of the upcoming events
	$upcomingEventsFile = "/var/www/comrad-dev-read-only/lib/utilities/archiving/upcomingEvents.txt"; 
	
	//the stream URL to record - do not include the http:// part of the URL, as this causes a hostname can't be resolved error
	$stream = 'stream.kgnu.net:8000/KGNU_live_high.mp3.m3u'; 
	
	//the destination where the MP3 file of the stream will be written
	$destination = "/var/www/comrad-dev-read-only/lib/utilities/archiving/kgnu-archives/";
	
	//the extra time, in seconds, to record for
	//For example, if Afternoon Sound Alternative ends at 3:00 PM and this value is set to 5 * 60 seconds, the recording will end at 3:05 PM.
	$extraRecordingTime = 5 * 60;
	
	//the number of seconds after which to reconnect to the stream if the stream "hangs" and stops sending data
	$timeout = 60;
?>