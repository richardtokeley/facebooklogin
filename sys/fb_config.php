<?php
// Include the required dependencies.
require( __DIR__.'/../assets/facebook-php-sdk-v5/autoload.php' );

// Initialize the Facebook PHP SDK v5.
$fb = new Facebook\Facebook([
  'app_id'                => '{your app id',
  'app_secret'            => '{your app secret}',
  'default_graph_version' => 'v2.3',
]);
?>