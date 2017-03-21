<?php
$status = '';
$message = '';

require_once '../sys/fb_config.php';

$jsHelper = $fb->getJavaScriptHelper();
$facebookClient = $fb->getClient();

try {
    $accessToken = $jsHelper->getAccessToken($facebookClient);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    $status = 'error';
	$message = 'Graph returned an error: ' . $e->getMessage();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    $status = 'error';
	$message = 'Facebook SDK returned an error: ' . $e->getMessage();
}

if (isset($accessToken)) {
    // Logged in.    
    $_SESSION['loggedin'] = '1';
    $_SESSION['accessToken'] = (string)$accessToken;
    $status = 'success';
	$message = 'Logged In';
    //Extend Access Token
    $cilent = $fb->getOAuth2Client();
	try {
	  // Returns a long-lived access token
	  $accessToken = $cilent->getLongLivedAccessToken($accessToken);
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  // There was an error communicating with Graph
	  $status = 'error';
	  $message = 'Graph returned an error: ' . $e->getMessage();
	  exit;
	}
} else {
	//Unable to read JavaScript SDK cookie
    $status = 'error';
    $message = 'Unable to read JavaScript SDK cookie';
    header ('REQUIRES_AUTH: 1'); 
	if (isset($_SESSION['loggedin'])) {
		session_unset();
		session_destroy();	   
	}
}
echo json_encode(array(
    'status' => $status,
    'message'=> $message
));
?>