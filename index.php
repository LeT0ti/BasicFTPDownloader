<?php
error_reporting(E_All);
ini_set('display_errors', 1);

define('FTP_HOST', '');
define('FTP_USER', '');
define('FTP_PASS', '');

// *** Include the class
include('FtpDownloader.php');
// *** Create the FTP object

$usr = new FtpDownloader();
 
if ($usr -> connect(FTP_HOST, FTP_USER, FTP_PASS, FTP_SSL)) {
 
    $usr -> setDownloadPath("/home/ftpdes/");
	$usr -> downloadRecent();
	//$usr -> downloadAll();
	
    echo 'connected';
 
} else {
    echo 'Failed to connect :c 1';
}


