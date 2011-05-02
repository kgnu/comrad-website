<?php
	//sw created 4/28/11
	
	//this error handler will write out any PHP errors
	set_error_handler('errorHandler');
	function errorHandler($errno, $errstr, $errfile, $errline) {
		echo '<br /><b>Error</b>: ' . $errstr . ' (line '.$errline.' in '.$errfile.')<br />';
	}
	
	//$root is the path to the comrad-dev folder
	$root = "../../../"; 
	
	//
	$rssFilePath = "/var/www/comrad-dev-read-only/lib/utilities/podcasting/"; 
	
	//see if either host or show was provided
	$rssFileName = ""; //the RSS file name is in this format: host5.rss, or show7.rss
	if (isset($_GET["host"])) {
		$host = array('HostId' => $_GET["host"]);
		$rssFileName .= "host".$_GET["host"];
	}
	else if (isset($_GET["show"])) {
		$show = array('Id' => $_GET["show"]);
		$rssFileName .= "show".$_GET["show"];
	}
	$rssFileName .= ".rss";
	
	//if host or show was not provided, exit the script
	if (!isset($host) && !isset($show)) {
		exit();
	}
	
	//this variable shows the number of days back to show in the podcast
	//so, for example, if the variable is set to 10, the podcast script will show
	//all shows in the past 10 days
	$numberOfDaysToShowInPodcast = 10;
	
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
		$shows = $em->getEventsBetween(time() - (60*60*24*$numberOfDaysToShowInPodcast), time(),
		'Show',
		$show);
	} else if (isset($host)) {
		$shows = $em->getEventsBetween(time() - (60*60*24*$numberOfDaysToShowInPodcast), time(),
		'Show',
		NULL, $host);
	}
		
	//if there aren't any shows, exit the script
	if (count($shows) == 0) {
		exit();
	}
	
	//TODO: order the array
	
	//turn on output buffering - we'll capture all the content in a variable
	ob_start();
	
echo '<'.'?';?>xml version="1.0"<?php echo '?'.'>'; ?>
<rss xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd" version="2.0">
	<channel>
		<title><?php  echo htmlspecialchars($shows[0]->ScheduledEvent->Event->Title); ?></title>
		<link>http://www.kgnu.org</link>
		<category>Music</category>
		<language>en-us</language>
		<copyright><?php echo date("Y"); ?> KGNU</copyright>
		<description><?php echo htmlspecialchars($shows[0]->ScheduledEvent->Event->LongDescription); ?></description>
		<itunes:subtitle><?php echo htmlspecialchars($shows[0]->ScheduledEvent->Event->ShortDescription); ?></itunes:subtitle>
		<itunes:author>KGNU</itunes:author>
		<itunes:summary><?php echo htmlspecialchars($shows[0]->ScheduledEvent->Event->LongDescription); ?></itunes:summary>
		<itunes:owner>
			<itunes:name>KGNU</itunes:name>
		</itunes:owner>
		<itunes:category text="Music" />
		<itunes:explicit>no</itunes:explicit>
		<?php
			foreach ($shows as $show) {
				$url = ''; //TODO: set this variable
				if (!empty($show->RecordedFileName)) {
				?>
					<item>
						<title><?php echo $show->ScheduledEvent->Event->Title . ' for ' .date("m-d-y",$show->StartDateTime); ?></title>
						<enclosure url="http://kgnu.net/podcasts/<?php echo $url; ?>" type="audio/mp3" /> <?php /* TODO: add URL path */ ?>
						<guid><?=$url ?></guid>
						<pubDate><?php echo gmdate('D, d M Y G:i:s',$show->StartDateTime).' GMT'; ?></pubDate>
						<itunes:author>KGNU</itunes:author>
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
	$fh = fopen($rssFilePath.$rssFileName,'w');
	fwrite($fh,$output);
	fclose($fh);

   ?>