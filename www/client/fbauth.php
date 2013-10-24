<?php

 // the facebook client library
include_once $_SERVER['DOCUMENT_ROOT'].'/client/facebook.php';

// Create our Application instance.
$GLOBALS['Facebook'] = new Facebook(array(
  'appId'  => FB_APP_ID,
  'secret' => FB_SECRET,
  'cookie' => true,
));

?>