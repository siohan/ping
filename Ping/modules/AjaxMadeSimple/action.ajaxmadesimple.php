<?php
if (!function_exists("cmsms")) exit;
// First step: This is a JS File.
header("Content-type:text/javascript; charset=utf-8");

// We must to load the session via CMSMS

//check for autostarting sessions
if (session_id()=="") session_start();

if (isset($_SESSION['ajaxmsgeneratedcode'])) {
	echo $_SESSION["ajaxmsgeneratedcode"];
} else {
	echo '/*

	No given content for this js file. Please check your methods.

	*/';
}

//Stop all output
die();

?>