<?php
// Pass session data over.
session_start();
 
require_once '../../sys/fb_config.php';

//print_r($_SESSION);
$accessToken = $_SESSION['accessToken'];
$fb->setDefaultAccessToken($accessToken);
try {
  //$res = $fb->get('/me', $_SESSION['accessToken']);
  $res = $fb->get('/me?fields=id,about,age_range,birthday,first_name,gender,last_name,location,name,email');
  $userNode = $res->getGraphUser();
} catch (Facebook\Exceptions\FacebookSDKException $e) {
  echo $e->getMessage();
  exit;
}


//var_dump($res->getDecodedBody());
//echo $userNode->getName();

//$graphObject = $res->getGraphObject();
//echo $graphObject->getProperty('email');
//echo $graphObject->getProperty('gender');

$array = $res->getDecodedBody();
print '{"data":['.json_encode($array).']}';

?>