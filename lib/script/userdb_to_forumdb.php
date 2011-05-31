<?php

$require_login = false;

require 'module/includes.php';

require 'module/general.php';
  
$all_users = $GLOBALS['User']->GetAccounts('all', 1);

$GLOBALS['Db']->SelectDb(FORUM_DATABASE);

foreach ($all_users as $user)
{

  $UserID = $user['uid'];
  $Name = addslashes($user['name']);
  
  if ($user['using_fb'])
  {
    $Photo = "http://graph.facebook.com/{$user['fb_id']}/picture";
  }
  else
  {
    $Photo = "{DOMAIN}/img/user/u{$user['uid']}.jpg";
  }  
  
  $Email = $user['email'];
  $Permissions = 'a:6:{i:0;s:19:"Garden.SignIn.Allow";i:1;s:20:"Garden.Activity.View";i:2;s:20:"Garden.Profiles.View";s:24:"Vanilla.Discussions.View";a:1:{i:0;s:1:"1";}s:23:"Vanilla.Discussions.Add";a:1:{i:0;s:1:"1";}s:20:"Vanilla.Comments.Add";a:1:{i:0;s:1:"1";}}';

  $Date = date("Y-d-m H:i:s");
  
    $sql = "INSERT INTO ".FORUM_DATABASE.".GDN_User (UserID, Name, Email, DateInserted, Permissions, Photo) VALUES('{$UserID}', '{$Name}', '{$Email}', '{$Date}', '{$Permissions}', '{$Photo}')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error creating user.');
    }

  $sql = "INSERT INTO ".FORUM_DATABASE.".GDN_UserRole (UserID, RoleID) VALUES('{$user['uid']}', '8')";
  if (!$GLOBALS['Db']->Execute($sql))
  {
    throw new Exception('Error updating user.');
  }

  $GLOBALS['Db']->Commit();

}

?>

All done.