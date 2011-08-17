<?php
	//sean williams - created 5/4/11
	//utility for recording to a log file
	
	//write the log text at the beginning of the file
	function logText($text) {
		global $logFile;
		//if the log file doesn't exist, create it
		$contents = '';
		if (file_exists($logFile)) {
			$fh = fopen($logFile, 'r+');
			//read the file's contents to a string
			$contents = '';
			while (!feof($fh)) {
				$contents .= fread($fh, 8192);
			}
			fclose($fh);
		}
		$fh = fopen($logFile,'w');
		fwrite ($fh, '['.date('Y-m-d G:i').'] '.$text."\n".$contents);
		fclose($fh);
	}
	
	//limits the log to 10,000 lines
	function truncateLog() {
		global $logFile;
		global $logFileMaxLines;
		if (file_exists($logFile)) {
			$fh = fopen($logFile, 'r+');
			//read the file's contents to a string
			$contents = '';
			while (!feof($fh) && strlen($contents) < 8388608 / 2) {
				$contents .= fread($fh, 8192);
			}
			fclose($fh);
			//break out the lines in the file
			$lines = explode("\n",$contents);
			$newContent = "";
			//if the file is longer than our maximum length, rewrite it
			if (count($lines) > $logFileMaxLines) {
				for ($i = 0; $i < $logFileMaxLines; $i++) {
					$newContent .= $lines[$i]."\n";
				}
				//rewrite the file
				$fh = fopen($logFile, 'w');
				fwrite($fh,$newContent);
				fclose($fh);
			}
			
		}
	}
?>