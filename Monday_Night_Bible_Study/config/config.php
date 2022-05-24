<?php
ob_start(); // Turns on output buffering

session_start(); // So the values of the form don't get deleted.
$timezone = date_default_timezone_set("America/Chicago"); //America and Chicago is central time.

$con = mySqli_connect("GET YOUR OWN SERVER", "GET YOUR OWN SERVER USERNAME", "GET YOUR OWN SERVER PASSWORD", "GET YOUR OWN SERVER DB");
if (mySqli_connect_errno()) {
	echo "Failed to connect: ".mySqli_connect_errno();
}
?>