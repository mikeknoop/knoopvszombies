<?php

// Handles connection to database
require DOCUMENT_ROOT.'/lib/class/SqlConnection.php';

// Handles cacheing
require DOCUMENT_ROOT.'/lib/class/CacheEngine.php';

// Handles user session
require DOCUMENT_ROOT.'/lib/class/Session.php';

// Handles facebook photos
require DOCUMENT_ROOT.'/lib/class/Photo.php';

// Handles facebook Wall
require DOCUMENT_ROOT.'/lib/class/Wall.php';

// Handles User
require DOCUMENT_ROOT.'/lib/class/User.php';

// Handles Game
require DOCUMENT_ROOT.'/lib/class/Game.php';

// Handles Mailer
require DOCUMENT_ROOT.'/lib/class/Mail.php';

// Handles Misc Functions
require DOCUMENT_ROOT.'/lib/class/Misc.php';

// Handles Admin
// require DOCUMENT_ROOT.'/lib/class/Admin.php';

// Handles CURL interaction with Facebook Graph API
require DOCUMENT_ROOT.'/lib/class/Curl.php';

 // the facebook client library
require DOCUMENT_ROOT.'/www/client/facebook.php';

/**
 * Establishes a prelim. connection, but doesn't actually connect until DB action happens
 */
 $GLOBALS['Db'] = new SqlConnection();
 

// Create general cache object
 $GLOBALS['Cache'] = new CacheEngine(DOCUMENT_ROOT.'/cache/');

// Create user cache object
 $GLOBALS['UserCache'] = new CacheEngine(DOCUMENT_ROOT.'/cache/user/');
 
 // Create rate limit cache object
 $GLOBALS['RateCache'] = new CacheEngine(DOCUMENT_ROOT.'/cache/rate/');

 $GLOBALS['Session'] = new Session();
 $GLOBALS['Photo'] = new Photo();
 $GLOBALS['Wall'] = new Wall();
 $GLOBALS['User'] = new User();
 $GLOBALS['Game'] = new Game();
 $GLOBALS['Mail'] = new Mail();
 $GLOBALS['Misc'] = new Misc();
 $GLOBALS['Curl'] = new Curl();
 //$GLOBALS['Admin'] = new Admin();
?>