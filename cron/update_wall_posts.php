#!/usr/bin/php5
<?php

  ini_set('display_errors',1);
  
  $_SERVER['DOCUMENT_ROOT'] = '/home/mike/public_html/muzombies.org/public/';
  require $_SERVER['DOCUMENT_ROOT'] . 'module/includes.php';

  $GLOBALS['Wall']->GenerateWallCache();
  
?>