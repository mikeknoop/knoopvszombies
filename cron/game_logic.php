#!/usr/bin/php5
<?php

  require realpath(dirname($_SERVER['SCRIPT_NAME']).'/../knoopvszombies.ini.php');
  require DOCUMENT_ROOT.'/www/module/includes.php';

  // Get Game State
  $GLOBALS['state'] = $GLOBALS['Game']->GetState();
  
  /* This CRON script does several things:
  *
  *   1. Check to see if any games need to be marked active (now > start_time)
  *       => If so, mark database column as active
  *       => Email all original zombies that they were chosen
  *
  *   2. Check to see if any zombies of the current game need to be deceased (now > zombie_feed_timer + ZOMBIE_MAX_FEED_TIMER)
  *       => If so, mark that zombie as decease. Send an email
  */
  
  // (1)
  $GLOBALS['Game']->CheckStartGame();
  
  // (2)
  if ($GLOBALS['state'])
  {
    if (isset($GLOBALS['state']['active']) && $GLOBALS['state']['active'])
    {
      $GLOBALS['Game']->CheckFeedTimers();
    }
  }
  
  
?>