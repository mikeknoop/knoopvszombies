<?php
require '../../knoopvszombies.ini.php';
  
require 'includes.php';
  
require 'general.php';
  
$commend =  $_POST['bi'];
$giver = $_POST['giver'];
$sender = $_POST['sender'];

//probably unnecessary
mysql_real_escape_string($giver);
mysql_real_escape_string($sender);


$failure = FALSE;

// try to update the DB
$sql = "UPDATE user SET commend_send=commend_send-1 WHERE uid='$sender' and commend_send>0";
if (!$GLOBALS['Db']->Execute($sql))

	{
    	$failure = TRUE;
    }

$GLOBALS['Db']->Commit();

if ($commend == 'friendly' && $failure==FALSE){
	$sql = "UPDATE user SET commend_recieve_friendly=commend_recieve_friendly+1 WHERE uid='$giver'";
	if (!$GLOBALS['Db']->Execute($sql))

	{
    	$failure = TRUE;
    }

    $GLOBALS['Db']->Commit();
}	

if ($commend == 'teamwork' && $failure==FALSE){
	$sql = "UPDATE user SET commend_recieve_teamwork=commend_recieve_teamwork+1 WHERE uid='$giver'";
	if (!$GLOBALS['Db']->Execute($sql))

	{
    	$failure = TRUE;
    }

    $GLOBALS['Db']->Commit();
}	

$GLOBALS['UserCache']->RemoveFromCache($sender);
$GLOBALS['UserCache']->RemoveFromCache($giver);
header('Location: ../playerlist.php')
?>