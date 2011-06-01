#!/usr/bin/php5
<?php

  require '../muzombies.ini.php';
  require DOCUMENT_ROOT.'/www/module/includes.php';

  $GLOBALS['Wall']->GenerateWallCache();
  
?>