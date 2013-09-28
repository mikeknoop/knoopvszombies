<?php

  $page_title = 'Fix';
  $require_login = false;
  $require_complete_account = false;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';


$database = DATABASE;
$db_host = DATABASE_HOSTNAME;
$db_user = 'web';
$db_pwd = DATABASE_PASS_FOR_WEB;
mysql_connect($db_host, $db_user, $db_pwd);
mysql_select_db($database);
$result = mysql_query("SELECT uid, status FROM game_xref WHERE gid='12'");
while ($tmp = mysql_fetch_array($result)) {
	$uid = $tmp['uid'];
	$status = $tmp['status'];
	if ($status == 'zombie') {
		$GLOBALS['User']->AddForumRoleZombie($uid);
	}
	if ($status == 'human') {
		$GLOBALS['User']->AddForumRoleHuman($uid);
	}
}
mysql_free_result($result);

?>
done.