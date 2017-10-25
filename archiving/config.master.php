<?php
	//archivingConfig.php - configuration variables for the archiving script
	//sw 4/21/11
	
	//the path of the log file to store all script output
	$logFile = "/srv2/www/cgi-bin/archivinglogs/archivingLog.txt";
	$oldLogFiles = "/srv2/www/cgi-bin/archivinglogs/archivingLog.txt";
	
	//the maximum number of lines for the log file
	$logFileMaxLines = 1000;
	
	//this file is a text file that stores text data of the upcoming events
	$upcomingEventsFile = "/srv2/www/kgnu/audioarchives/upcomingEvents.txt"; 
	
	//the stream URL to record - do not include the http:// part of the URL, as this causes a hostname can't be resolved error
	$musicStream = 'peridot.streamguys.com:5400/kgnu160.m3u';
	$newsStream = 'peridot.streamguys.com:5400/kgnu160.m3u';
	$stream = 'peridot.streamguys.com:5400/kgnu160.m3u';

	//the destination where the MP3 file of the stream will be stored
	//the folder structure looks like:
	// $destination . "(show title) / (year) / ShowName_Year-Month-Date.mp3"
	$destination = "/srv2/www/kgnu/audioarchives/";
	
	//the HTTP address to the destination folder specified above:
	$httpDestination = "";
	
	//the temporary recording location streamripper will use to record the file - after the file is done recording, it
	//will move the file to the permanent destination specified above
	$temporaryDestination = "/srv2/www/kgnu/audioarchives/temp/";
	
	//the extra time, in seconds, to record for
	//For example, if Afternoon Sound Alternative ends at 3:00 PM and this value is set to 5 * 60 seconds, the recording will end at 3:05 PM.
	$extraRecordingTime = 5 * 60;
	
	//the number of seconds after which to reconnect to the stream if the stream "hangs" and stops sending data
	$timeout = 60;
	
	//Set the API token that will be used to access the write API
	$archiveToken = 'SET ME';
?>
