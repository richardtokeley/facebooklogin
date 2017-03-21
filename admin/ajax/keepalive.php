<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
$status = 'error';
$message = '';

// Include the required dependencies.
require( __DIR__.'/../../assets/facebook-php-sdk-v5/autoload.php' );

// Initialize the Facebook PHP SDK v5.
$fb = new Facebook\Facebook([
  'app_id'                => '2252903634933866',
  'app_secret'            => '9bf8b4fe36cd4bb2eac1f837664efae9',
  'default_graph_version' => 'v2.3',
]);

# Facebook PHP SDK v5: Check Login Status Example
 
// Choose your app context helper
//$helper = $fb->getCanvasHelper();
//$helper = $fb->getPageTabHelper();
//$helper = $fb->getJavaScriptHelper();
$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // There was an error communicating with Graph
  echo $e->getMessage();
  exit;
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
	//Unable to get access token
    $status = 'error';
    $message = 'Unable to get access token';
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