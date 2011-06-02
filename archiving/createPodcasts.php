<?php
	//sw created 4/28/11
	
	require_once('config.php');
	require_once('log.php');
	
	//this error handler will write out any PHP errors
	set_error_handler('errorHandler');
	function errorHandler($errno, $errstr, $errfile, $errline) {
		logText('PHP Error: ' . $errstr . ' (line '.$errline.' in '.$errfile.')');
	}
	
	function writeRssFeedForHost($host) {
		writeRssFeed($host);
	}
	
	function writeRssFeedForShow($show) {
		writeRssFeed(NULL, $show);
	}
	
	function writeRssFeed($host = NULL, $show = NULL)
	{
		global $root;
		global $rssFilePath;
	
		//initialize classes that will let us access the database
		require_once($root.'lib/classes/Initialize.php');
		$init = new Initialize();
		$init->setAutoload();
		
		//disable authorization
		$pm = PermissionManager::getInstance();
		$pm->disableAuthorization();
		//get an array of past shows
		$em = EventManager::getInstance();
		if (isset($show)) {
			$shows = $em->getEventsBetween(0, time(),
			'Show',
			$show);
		} else if (isset($host)) {
			$shows = $em->getEventsBetween(0, time(),
			'Show',
			NULL, $host);
		}
		
		
		//turn on output buffering - we'll capture all the content in a variable
		ob_start();
		
		$numberOfItems = 0;
	
echo '<'.'?';?>xml version="1.0"<?php echo '?'.'>'; ?>
<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
	<channel>
		<title><?php  echo htmlspecialchars($shows[0]->ScheduledEvent->Event->Title); ?></title>
		<link>http://www.kgnu.org</link>
		<category>Music</category>
		<language>en-us</language>
		<copyright>Copyright (C) <?php echo date("Y"); ?> KGNU</copyright>
		<description><?php echo htmlspecialchars($shows[0]->ScheduledEvent->Event->LongDescription); ?></description>
		<itunes:subtitle><?php echo htmlspecialchars($shows[0]->ScheduledEvent->Event->ShortDescription); ?></itunes:subtitle>
		<itunes:author>KGNU</itunes:author>
		<itunes:summary><?php echo htmlspecialchars($shows[0]->ScheduledEvent->Event->LongDescription); ?></itunes:summary>
		<itunes:owner>
			<itunes:name>KGNU</itunes:name>
		</itunes:owner>
		<itunes:category text="Music" />
		<itunes:explicit>no</itunes:explicit>
		<pubDate><?php echo gmdate('D, d M Y G:i:s',time()).' GMT'; ?></pubDate>
		<lastBuildDate><?php echo gmdate('D, d M Y G:i:s',time()).' GMT'; ?></lastBuildDate>
		<?php
			foreach ($shows as $show) {
				$url = $show->ScheduledShowInstance->RecordedFileName; //TODO: set this variable
				if (!empty($url)) {
					$numberOfItems++;
				?>
					<item>
						<title><?php echo $show->ScheduledEvent->Event->Title . ' for ' .date("m-d-y",$show->StartDateTime); ?></title>
						<enclosure url="http://kgnu.net/podcasts/<?php echo $url; ?>" type="audio/mp3" /> <?php /* TODO: add URL path */ ?>
						<guid><?=$url ?></guid>
						<pubDate><?php echo gmdate('D, d M Y G:i:s',$show->StartDateTime).' GMT'; ?></pubDate>
						<itunes:author>KGNU - <?=$show->ScheduledEvent->Event->Host?></itunes:author>
						<itunes:subtitle><?php echo htmlspecialchars($show->ScheduledEvent->Event->ShortDescription); ?></itunes:subtitle>
						<itunes:summary><?php echo htmlspecialchars($show->ScheduledEvent->Event->LongDescription); ?></itunes:summary>
						<itunes:duration><?php
							$duration = round($show->Duration / 60,0).":".($show->Duration % 60);
							echo $duration;
						?></itunes:duration>
					</item>
				<?php
				}
			}
		?>
	</channel>
   </rss><?php
   
		//output the contents to a file
		$output = ob_get_contents();
		ob_clean();
		if ($numberOfItems > 0) {
			//determine the file name for the RSS file
			if (isset($show)) {
				$rssFileName = preg_replace("/[^A-Za-z0-9]/","",$shows[0]->ScheduledEvent->Event->Title).'.xml';
			} else if (isset($host)) {
				$rssFileName = preg_replace("/[^A-Za-z0-9]/","",$shows[0]->ScheduledEvent->Event->Host).'.xml';
			}
			$fh = fopen($rssFilePath.$rssFileName,'w');
			fwrite($fh,$output);
			fclose($fh);
		}
	}

   ?>