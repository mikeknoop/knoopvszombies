<?php

  $page_title = 'Fix';
  $require_login = false;
  $require_complete_account = false;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';


$database = DATABASE;
$db_host = DATABASE_HOSTNAME;
$db_user = 'webengine';
$db_pwd = DATABASE_PASS_FOR_WEB;
mysql_connect($db_host, $db_user, $db_pwd);
mysql_select_db($database);

$i = 0;

while ($i < 30){
  echo $GLOBALS['Game']->GenerateSecret(18).'<br>';
  $i = $i + 1;}
?>
done.
