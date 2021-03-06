<?php

	//created sean williams 4/4/11
	//to be run every minute
	//checks the list of upcoming shows created by getUpcomingShowsFromDb.php
	//and starts StreamRipper to record the audio stream
	
	//this script uses StreamRipper - http://manpages.ubuntu.com/manpages/dapper/man1/streamripper.1.html
	
	//set a script timeout of one day
	set_time_limit(24 * 60 * 60);
	
	//include the configuration and the log file
	require('config.php');
	require('log.php');
	
	//this error handler will write out any PHP errors
	set_error_handler('errorHandler');
	function errorHandler($errno, $errstr, $errfile, $errline) {
		logText('PHP Error from archiveShows.php: ' . $errstr . ' (line '.$errline.' in '.$errfile.')');
	}
	
	logText('Starting executing archiveShows.php');
	
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
			$event["recordingStartTime"] = $v[1];
			$event["endTime"] = $v[2];
			$event["startTime"] = $v[3];
			$event["titleWithSpaces"] = $v[4];
			$event["host"] = $v[5];
			$event["eventId"] = $v[6];
			$event["hostId"] = $v[7];
			$event["category"] = $v[8];
			if (time() >= (int)$event["recordingStartTime"] && time() <= (int)$event["endTime"]) { //the event is active if the current time is after the start time, but before the end time
				//make a new directory for the show ...streamripper will automatically create the directory
				$folder = $event["title"]."_".date("Y-m-d",$event["recordingStartTime"]);
				$folder = str_replace(" ","",$folder); //remove spaces from the folder name
				if (file_exists($temporaryDestination.$folder."/stream.mp3")) {
					//file already exists - the script is already running
					//TODO: we should check to see if the file is locked, and restart recording if it's not. if the file is not locked, we could assume that streamripper
					//has stopped for some reason
					logText('stream for ' . $event['title'] . ' is already being recorded at '.$temporaryDestination.$folder.'/stream.mp3');
					continue;
				}
				$activeEvent = true;
				break;
			}
		}
	}
	
	//if we didn't find an active event, abandon the script
	if (!$activeEvent) {
		logText('no active event that needs to be recorded, exiting script.');
		truncateLog();
		exit();
	} else {
		logText('active event that isn\'t being recorded, trying to begin recording...');
	}
	
	//sw 2/14/12 - determine which stream to rip from depending on whether the show is music or news/pa:
	switch ($event["category"]) {
		case "Music":
			$stream = $musicStream;
			break;
		case "NewsPA":
			$stream = $newsStream;
			break;
	}
	$command = "streamripper ".$stream; //setup the terminal command
	$command .= " -d ".$temporaryDestination.$folder; //set the destination directory
	$command .= " -a stream"; //record to one file - we don't want to separate the stream into tracks
	$command .= " -m ".$timeout; //reset stream connection after a 60 second timeout
	//get the duration of the file
	$duration = (int)$event["endTime"] - (int)$event["recordingStartTime"] + $extraRecordingTime;
	$command .= " -l ".($duration);
	$command .= " --debug"; //save a debugging log
	//sw commented out 5/4/11 - we decided to run this syncrhonously, then monitor the return value
	//$command .= " > /dev/null &"; //run asynchronously so the script finishes - got this from http://www.sitecrafting.com/blog/to-run-php-code-in/
	
	logText('launching streamripper with command: '.$command);
	exec($command, $output, $returnStatus);
	
	if ($returnStatus == "0") {
		logText('streamripper successful - moving file to permanent location');
		//logText('streamripper successful, output:');
		//foreach ($output as $o) {
		//	logText('--- ' . $o);
		//}
		//logText('moving file to permanent location');



		//successful execution
		//move the file to its permanent location
		//create any folders that are not created yet
		if (!file_exists($destination.$event["title"])) {
			logText('trying to create directory at '.$destination.$event["title"]);
			mkdir($destination.$event["title"]);
		}
		if (!file_exists($destination.$event["title"]."/".date("Y", $event["recordingStartTime"]))) {
			logText('trying to create directory at '.$destination.$event["title"]."/".date("Y", $event["recordingStartTime"]));
			mkdir($destination.$event["title"]."/".date("Y", $event["recordingStartTime"]));
		}
		//move the file to its permanent location
		$recordedFileName = $destination.$event["title"]."/".date("Y", $event["recordingStartTime"])."/".$event["title"]."_".date("Y-m-d", $event["recordingStartTime"]).".mp3";
		rename($temporaryDestination.$folder."/stream.mp3", $recordedFileName);
		
		//delete the temporary file
		unlinkRecursive($temporaryDestination.$folder, true);
	
		//update the database with the recording path
		logText('file moved to permanent location - updating the database with the file path');
		
		// //initialize classes that will let us access the database
		// require_once($root.'lib/classes/Initialize.php');
		// $init = new Initialize();
		// $init->setAutoload();
		
		// //disable authorization
		// $pm = PermissionManager::getInstance();
		// $pm->disableAuthorization();
		
		// //get all events in the next day
		// $em = EventManager::getInstance();
		// $eventInstance = $em->getEventsBetween($event["startTime"], $event["endTime"], "Show");
		//sw added 8/16/12
		$url = 'https://kgnu.org/playlist/ajax/geteventsbetween.php?start=' . $event['startTime'] . '&end=' . $event['endTime'] . '&types=' . urlencode('["Show"]');
		$contents = file_get_contents($url);
		$eventInstance = json_decode($contents, TRUE);
		logText('geteventsbetween: '.$url.': '.print_r($contents, TRUE));
		
		foreach ($eventInstance as $ei) {
			// Whatever the file name is
			$recordedFileName = $httpDestination.$event["title"]."/".date("Y", $event["recordingStartTime"])."/".$event["title"]."_".date("Y-m-d", $event["recordingStartTime"]).".mp3";
			logText('updating database with file path: checking instance');
			// Create a new ScheduledShowInstance if $ei is a ScheduledEventInstance
			logText('$ei contains: ' . print_r($ei, TRUE));
			if ($ei['Type'] === 'ScheduledShowInstance' && isset($ei['Attributes']['Id'])) {
				// Save the existing ScheduledShowInstance
				$ei = array(
					'Type' => 'ScheduledShowInstance',
					'Attributes' => array(
						'Id' => $ei['Attributes']['Id'],
						'RecordedFileName' => $recordedFileName
					)
				);
			} else {
				// $ei['Type'] is assumed to be ScheduledEventInstance. Create a new ScheduledShowInstance
				$ei = array(
					'Type' => 'ScheduledShowInstance',
					'Attributes' => array(
						'ScheduledEventId' => $ei['Attributes']['ScheduledEventId'],
						'StartDateTime' => $ei['Attributes']['StartDateTime'],
						'Duration' => $ei['Attributes']['Duration'],
						'RecordedFileName' => $recordedFileName
					)
				);
			}
			
			$url = 'https://kgnu.org/playlist/ajax/ajaxdbinterface.php';
			$data = 'method=save&db=MySql&token=' . $archiveToken . '&params='.json_encode($ei);
			
			logText('Preparing CURL request to update file name to ' . $url);
			logText('Data for CURL request: ' . $data);
			
			$ch = curl_init( $url );
			curl_setopt( $ch, CURLOPT_POST, 1);
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt( $ch, CURLOPT_HEADER, 0);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
			
			$response = curl_exec( $ch );
			
			logText('CURL response: '.$response);
		}
		
		//write ID3 tags using EYED3
		//http://eyed3.nicfit.net/
		$command = "eyeD3";
		$command .= ' -a "'.$event["host"].'"'; //artist - here, we're using the host
		$command .= ' -A "'.$event["titleWithSpaces"].'"'; // album - we'll use the show title
		$command .= ' -t "'.$event["titleWithSpaces"].'"'; //title - we'll use the show title
		$command .= ' -Y '.date("Y", $event["recordingStartTime"]); //year
		$command .= ' -p KGNU'; //publisher
		$command .= ' ' . $destination . $recordedFileName;
		logText('writing ID3 tags with commad: '.$command);
		exec($command, $output, $returnStatus);
		if ($returnStatus == "0") {
			logText("successfully wrote ID3 tags");
		} else {
			logText("error writing ID3 tags");
		}
		
		//write RSS feed for podcasting
		//require('createPodcasts.php');
		//writeRssFeedForHost($event["hostId"]);
		//writeRssFeedForShow($event["showId"]);
		
	} else {
		//unsuccessful execution
		//$streamRipperOutput = '';
		//foreach ($output as $o) {
		//	$streamRipperOutput .= "\n".$o;
		//}
		logText("streamripper returned an unsuccessful status code");
	}
	
	truncateLog();

	//TODO: let the script start if it's running late...possibly, just by checking if the file's there. it should also resume if it unexpectedly restarts (the resume functionality can be deferred)
	
	
	
	//code from http://fr2.php.net/manual/en/function.unlink.php
	/**
	 * Recursively delete a directory
	 *
	 * @param string $dir Directory name
	 * @param boolean $deleteRootToo Delete specified top-level directory as well
	 */
	function unlinkRecursive($dir, $deleteRootToo) {
	    if(!$dh = @opendir($dir)) {
			return;
	    }
	    while (false !== ($obj = readdir($dh))) {
			if($obj == '.' || $obj == '..') {
				continue;
			}
			if (is_dir($dir . '/' . $obj)) {
				unlinkRecursive($dir.'/'.$obj, true);
			} else {
				unlink($dir . '/' . $obj);
			}
	    }

	    closedir($dh);
	   
	    if ($deleteRootToo) {
			@rmdir($dir);
	    }
	   
	    return;
	} 
?>
