<?php
  $filename = $_GET['mp3file'];
  if($filename && preg_match('/\.mp3$/', $filename) && file_exists($filename)) {
    header('Content-Type: audio/mpeg');
    header('Content-Length: ' . filesize($filename));
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header("Content-Transfer-Encoding: binary");

    $fp = fopen($filename, 'r');
    fpassthru($fp);
    fclose($fp);
  } else {
    header("HTTP/1.1 404 Not Found");

    print "The requested MP3 file appears to be unavailable.";
  }
?>


