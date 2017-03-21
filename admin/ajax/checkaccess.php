<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* Security */
if($_SERVER['HTTP_X_REQUESTED_WITH'] !== 'XMLHttpRequest') {
        //Request not identified as ajax request
        die;
}	
session_start();
if (!isset($_SESSION['loggedin'])) {
	header ('REQUIRES_AUTH: 1'); 
}
?>