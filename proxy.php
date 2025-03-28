<?php
// PHP Proxy example for Yahoo! Web services.
// Responds to both HTTP GET and POST requests
//
// Author: Jason Levitt
// December 7th, 2005
//
// Modified by Chyng-Yang Jang


// Get the URL from the AJAX application
// Is it a POST or a GET?
$url = ($_POST['url']) ? $_POST['url'] : $_GET['url'];

// Open the Curl session
$session = curl_init($url);
// If it's a POST, put the POST data in the body
if ($_POST['url']) {
	$postvars = '';
	while ($element = current($_POST)) {
		$postvars .= key($_POST).'='.$element.'&';
		next($_POST);
	}
	curl_setopt ($session, CURLOPT_POST, true);
	curl_setopt ($session, CURLOPT_POSTFIELDS, $postvars);
}

// Don't return HTTP headers. Do return the contents of the call
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// Make the call
$xml = curl_exec($session);

// If the remote server returns XML. Set the Content-Type appropriately
header("Content-Type: text/xml");

echo $xml;
curl_close($session);

?>
