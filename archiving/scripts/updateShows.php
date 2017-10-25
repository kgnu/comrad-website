<?php
	//updated the database's archive values...tries to deduce the right scheduled event instance based on
	//the file name.
	//uses the list in $archives below
	//requires setting the $archiveToken for your installation of comrad
	//will not work if an event occurs more than twice in one day.
	$archives = [
		'LaLuchaSigue/2017/LaLuchaSigue_2017-10-23.mp3',
		'ReggaeBloodlines/2017/ReggaeBloodlines_2017-10-21.mp3',
		'RestlessMornings/2017/RestlessMornings_2017-10-21.mp3',
		'RestlessMornings/2017/RestlessMornings_2017-10-23.mp3',
		'APublicAffair/2017/APublicAffair_2017-10-25.mp3',
		'AfternoonSoundAlternative/2017/AfternoonSoundAlternative_2017-10-20.mp3',
		'Corriente/2017/Corriente_2017-10-24.mp3',
		'DubPalace/2017/DubPalace_2017-10-22.mp3',
		'GratefulDeadSpecial/2017/GratefulDeadSpecial_2017-10-21.mp3',
		'TerraSonic/2017/TerraSonic_2017-10-21.mp3',
		'RestlessMornings/2017/RestlessMornings_2017-10-24.mp3',
		'Tributaries/2017/Tributaries_2017-10-22.mp3',
		'SmashItBack/2017/SmashItBack_2017-10-20.mp3',
		'RestlessMornings/2017/RestlessMornings_2017-10-25.mp3'
	];
	
	$archiveToken = '';
	
	foreach ($archives as $a) {
		preg_match('/([0-9\-]*)\.mp3/', $a, $matches);
		$startDate = $matches[1];
		$startTimeSearch = strtotime($startDate);
		$endTimeSearch = $startTimeSearch + (24 * 60 * 60);
		
		$url = 'https://kgnu.org/playlist/ajax/geteventsbetween.php?start=' . $startTimeSearch . '&end=' . $endTimeSearch . '&types=' . urlencode('["Show"]');
		$contents = file_get_contents($url);
		$eventInstance = json_decode($contents, TRUE);
		
		$parts = explode('/', $a);
		$eventTitle = $parts[0];
		
		$existingInstance = null;
		
		foreach ($eventInstance as $ei) {
			if (preg_replace("/[^A-Za-z0-9]/","",$ei['Attributes']['ScheduledEvent']['Attributes']['Event']['Attributes']['Title']) == $eventTitle) {
				if ($ei['Type'] === 'ScheduledShowInstance' && isset($ei['Attributes']['Id'])) {
					$existingInstance = array(
						'Type' => 'ScheduledShowInstance',
						'Attributes' => array(
							'Id' => $ei['Attributes']['Id'],
							'RecordedFileName' => $a
						)
					);
				} else {
					$existingInstance = array(
						'Type' => 'ScheduledShowInstance',
						'Attributes' => array(
							'ScheduledEventId' => $ei['Attributes']['ScheduledEventId'],
							'StartDateTime' => $ei['Attributes']['StartDateTime'],
							'Duration' => $ei['Attributes']['Duration'],
							'RecordedFileName' => $a
						)
					);
				}
			}
		}
		
		if (!isset($existingInstance)) {
			echo "no event instance found for " . $a . "\n";
			continue;
		}
		
		$url = 'https://kgnu.org/playlist/ajax/ajaxdbinterface.php';
		$data = 'method=save&db=MySql&token=' . $archiveToken . '&params='.json_encode($existingInstance);
		
		echo 'Preparing CURL request to update file name to ' . $url . "\n";
		//echo 'Data for CURL request: ' . $data . "\n";
		
		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
		
		$response = curl_exec( $ch );
		
		echo 'CURL response: '.$response . "\n";
		
	}

	exit();
	
		
		
		logText('geteventsbetween: '.$url.': '.print_r($contents, TRUE));
		
		foreach ($eventInstance as $ei) {
			// Whatever the file name is
			$recordedFileName = $httpDestination.$event["title"]."/".date("Y", $event["recordingStartTime"])."/".$event["title"]."_".date("Y-m-d", $event["recordingStartTime"]).".mp3";
			logText('updating database with file path: checking instance');
			// Create a new ScheduledShowInstance if $ei is a ScheduledEventInstance
			logText('$ei contains: ' . print_r($ei, TRUE));
			
			
			
		}
?>