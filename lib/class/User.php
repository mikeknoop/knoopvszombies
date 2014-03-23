<?php
/**  
 * User database class
 * 
 * Handles user database realted activities
 * 	
 * @access		public
 */
 
class User {

  // Salt for password hash in DB (note: do not change or all user passwords will be invalid!)
  // if changed, need to also update forum salt to match in library/core/class.passwordhash.php
  var $salt = 'ZoMBi35_vs_hum4n5';
  
  /**
   * Rate limits certain application functions to given $limit_seconds
   * Returns true if $seconds has passed, false if it has not.
   *
   * @return  bool
   */
  function RateLimit($limit_seconds, $cache_id=null)
  {
  
    if (!$cache_id)
    {
      // custom cache_id was not specified, default to IP address
      $user_ip = str_replace('.', '_', $_SERVER['REMOTE_ADDR']);
      $cache_id = $user_ip;
    }
    
    $cache_id = $GLOBALS['Misc']->SafeFileName($cache_id);
    
    if ($cache = $GLOBALS['RateCache']->GetFromCache($cache_id, $Seconds=$limit_seconds, $IsObject=false)) {
      return false;
    }
    
    $GLOBALS['RateCache']->WriteToCache($cache_id, '1');
    return true;
  }
  
  /**
  *
  * Checks to see if a given uid is a valid user
  *
  * @return bool
  */
  function IsValidUser($uid)
  {
      $sql = "SELECT uid FROM user WHERE uid='$uid'";
      $results = $GLOBALS['Db']->GetRecords($sql);
      
      if (is_array($results) && count($results) > 0)
      {
        return true;
      }
      else
      {
        false;
      }
      
      return false;
    
  }
  
  /**
   * Sanitizes and checks the given email/pass of a user
   * Returns array with keys "valid", "uid"
   *
   * @return  array
   */
  function CheckLogin($email, $pass)
  {
    // Sanitize imput, convert pass to hash
    $email = addslashes($email);
    $pass = md5(addslashes($this->salt.$pass));

    $sql = "SELECT uid, password FROM user WHERE email='$email'";
    $results = $GLOBALS['Db']->GetRecords($sql);

    $return['valid'] = false;
    $return['uid'] = null;

    if (is_array($results) && isset($results[0]))
    {
      $check = $results[0];
      if ($pass == $check['password'])
      {
        $return['valid'] = true;
        $return['uid'] = $check['uid'];
      }
      else
      {
        $return['valid'] = false;
      }
    }
    
    return $return;
  
  }
  
  
  /**
   * Returns standard user columns
   *
   * @return  array
   */
  function GetUser($uid)
  {
    $uid = addslashes($uid);
    $cache_id = $uid;
    
    try
    {
      if ($cache = $GLOBALS['UserCache']->GetFromCache($cache_id, $Seconds=(60*60*1), $IsObject=true)) {
        return $cache;
      }
    }
    catch (Exception $e)
    {
      // cache file was empty (0 bytes) or corrupt
    }
    
    $sql = "SELECT uid, email, password, fb_id, using_fb, fb_image, admin, privileges, name, code_of_conduct, liability_waiver, active_game, active_squad, squad_name, created, email_confirmed, approved, forum_privileges FROM user WHERE uid='$uid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    if (is_array($results) && count($results) > 0)
    {
      $user = $results[0];
    }
    else
    {
      $GLOBALS['Session']->DestroySession();
      throw new Exception('User does not exist.');
    }

    $GLOBALS['UserCache']->WriteToCache($cache_id, $user);
    return $user;
    
  }

  /**
   * Returns historical data for a given UID
   *
   * @return  array
   */
  function GetHistorical($uid)
  {
    $uid = addslashes($uid);
    $cache_id = $uid.'_historical';
    
    try
    {
      if ($cache = $GLOBALS['UserCache']->GetFromCache($cache_id, $Seconds=(60*60*1), $IsObject=true)) {
        return $cache;
      }
    }
    catch (Exception $e)
    {
      // cache file was empty (0 bytes) or corrupt
    }
    
    $sql = "SELECT * FROM historical WHERE uid='$uid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    if (is_array($results) && count($results) > 0)
    {
      $user = $results[0];
    }
    else
    {
      $user = array();
      return $user;
    }

    $GLOBALS['UserCache']->WriteToCache($cache_id, $user);
    return $user;
    
  }

  /**
   * Returns active game data for a given UID and gid
   *
   * @return  array
   */
  function GetUserFromGame($uid, $gid=null)
  {
    if (!$gid)
    {
      if ($GLOBALS['state'])
      {
        $game = $GLOBALS['state']['gid'];
      }
      else
      {
				return array();
        //throw new Exception('GetUserFromGame: No active game.');
      }
    }
    
    $uid = addslashes($uid);
    $cache_id = $uid.'_game';
    
    try
    {
      if ($cache = $GLOBALS['UserCache']->GetFromCache($cache_id, $Seconds=(60*60*1), $IsObject=true)) {
        return $cache;
      }
    }
    catch (Exception $e)
    {
      // cache file was empty (0 bytes) or corrupt
    }
    
    $sql = "SELECT * FROM game_xref WHERE uid='$uid' AND gid='$gid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    if (is_array($results) && count($results) > 0)
    {
      $user = $results[0];
    }
    else
    {
      $user = array();
      return $user;
    }

    $GLOBALS['UserCache']->WriteToCache($cache_id, $user);
    return $user;
    
  }

  /**
   * Returns all game rows for which the user is associated with
   *
   * @return  array
   */
  function GetUserGameXrefAll($uid)
  {

    $uid = addslashes($uid);
    $cache_id = $uid.'_gameAll';
    
    try
    {
      if ($cache = $GLOBALS['UserCache']->GetFromCache($cache_id, $Seconds=(60*60*1), $IsObject=true)) {
        return $cache;
      }
    }
    catch (Exception $e)
    {
      // cache file was empty (0 bytes) or corrupt
    }
    
    $sql = "SELECT * FROM game_xref WHERE uid='$uid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    if (is_array($results) && count($results) > 0)
    {
      $user = $results;
    }
    else
    {
      $user = array();
      return $user;
    }

    $GLOBALS['UserCache']->WriteToCache($cache_id, $user);
    return $user;
    
  }
  
  /**
   * Creates a new user given email and password and returns a mixed array 
   * of validity and uid
   *
   * @return  array
   */
  function CreateUser($email, $password)
  {
  
    // Sanitize imput, convert pass to hash
    $email = addslashes($email);
    $password = md5(addslashes($this->salt.$password));
    
    // Generate hash
    $email_confirm_hash = $this->GenerateRandomHash($email);
    
    $created = date("U");
    
    // Save to DB
    $sql = "INSERT INTO user (email, password, email_confirm_hash, created) VALUES('$email', '$password', '$email_confirm_hash', '$created')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error creating user.');
    }
    $GLOBALS['Db']->Commit();
    
    // Get UID for new user
    $sql = "SELECT uid FROM user WHERE email='$email'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      $uid = $results[0]['uid'];
    }
    else
    {
      throw new Exception('Error creating user.');
    }
    
    // Also create an entry for this user in the historical table
    $sql = "INSERT INTO historical (uid, zombie_kills, time_alive) VALUES('$uid', '0', '0')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error creating user.');
    }
    $GLOBALS['Db']->Commit();
    
    // Also create a forum account for this new user
    $GLOBALS['Db']->SelectDb(FORUM_DATABASE);
    $perm = 'a:6:{i:0;s:19:"Garden.SignIn.Allow";i:1;s:20:"Garden.Activity.View";i:2;s:20:"Garden.Profiles.View";s:24:"Vanilla.Discussions.View";a:1:{i:0;s:1:"1";}s:23:"Vanilla.Discussions.Add";a:1:{i:0;s:1:"1";}s:20:"Vanilla.Comments.Add";a:1:{i:0;s:1:"1";}}';
    $date = date("Y-m-d H:i:s");
    $sql = "INSERT INTO ".FORUM_DATABASE.".GDN_User (UserID, Email, DateInserted, Permissions) VALUES('$uid', '$email', '$date', '')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error creating user.');
    }
    $GLOBALS['Db']->Commit();

    $sql = "INSERT INTO ".FORUM_DATABASE.".GDN_UserRole (UserID, RoleID) VALUES('$uid', '8')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error creating user.');
    }
    $GLOBALS['Db']->Commit();
    
    $GLOBALS['Db']->SelectDb(DATABASE);
    
    $this->SendEmailConfirmation(null, $email, $email_confirm_hash);

    $return['valid'] = true;
    $return['uid'] = $uid;
    
    return $return;
  }
  
  /*
  * Sends an email confirmation email to a user
  *
  * @Return bool
  */
  function SendEmailConfirmation($uid=null, $email=null, $hash=null, $update=false)
  {
  
    if ((!$email || !$hash))
    {
      if (!$uid && !$email)
      {
        throw new Exception('User not specified.');
      }
      
      // pull email and hash out of DB for UID
      $sql = "SELECT email, email_confirm_hash FROM user WHERE uid='$uid'";
      $results = $GLOBALS['Db']->GetRecords($sql);
      if (is_array($results) && count($results) > 0)
      {
        $email = $results[0]['email'];
        $hash = $results[0]['email_confirm_hash'];
      }
      else
      {
        throw new Exception('User does not exist.');
      }
    }

    // Remove user from unsubscribe list
    $GLOBALS['Mail']->Resubscribe($email);

    // Mail user at email address
    $to = $email;
    $subject = "".UNIVERSITY." HvZ Email Confirmation Link";
    
    if ($update)
    {
    $body = "Hello,<br>An account was recently updated for $email at ".DOMAIN.".<br>To use this new email address, you must confirm it by visiting the following website address:<br><a href='".DOMAIN."/emailconfirm/$hash'>".DOMAIN."/emailconfirm/$hash</a><br>Note, if you cannot click on the link above, you may need to copy and paste it into your web browser.<br>If you did not request an account to be created, you may safely ignore this email.";
    }
    else
    {
    $body = "Hello,<br>An account was recently created for $email at ".DOMAIN.".<br>To activate your account and join games each semester, you must confirm your email by visiting the following website address:<br><a href='".DOMAIN."/emailconfirm/$hash'>".DOMAIN."/emailconfirm/$hash</a><br>Note, if you cannot click on the link above, you may need to copy and paste it into your web browser.<br>If you did not request an account to be created, you may safely ignore this email.";
    }
    $footer = true;
    $bcc = false;
    $opt = array('o:campaign' => 'confirmation',);
    
    if (!$GLOBALS['Mail']->SimpleMail($to, $subject, $body, $footer, $bcc, $opt))
      return false;
   
    return true;
  
  }
  
  /*
  * Trys to update a user to have a confirmed email where the email_confirm_hash = $hash
  * array returned as 2 keys, (bool)valid and (int)uid
  *
  * @return array
  */
  function ConfirmEmail($hash)
  {
  
    if (strlen($hash) < 32)
    {
      $return['valid'] = false;
      return $return;
    }
  
    $hash = addslashes($hash);
    
    // try to get the uid of hash
    $sql = "SELECT uid FROM user WHERE email_confirm_hash='$hash'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      $uid = $results[0]['uid'];
    }
    else
    {
      // hash doesn't exist
      $return['valid'] = false;
      return $return;
    }
    
    // save email confirmation to database
    $sql = "UPDATE user SET email_confirmed='1', email_confirm_hash='' WHERE uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      $return['valid'] = false;
      return $return;
    }
    
    $GLOBALS['Db']->Commit();

    $return['valid'] = true;
    $return['uid'] = $uid;
    
    $GLOBALS['UserCache']->RemoveFromCache($uid);
    
    return $return;
    
  }
  
  /**
   * Resets a users password by generating a lost_pw_hash
   * then mailing the user the link with hash to reset it
   *
   * @return  bool
   */
  function ResetPasswordInit($email)
  {
  
    $email = addslashes($email);
    
    // Generate hash
    $hash = $this->GenerateRandomHash($email);
    
    // Save to DB
    $sql = "UPDATE user SET lost_pw_hash='$hash' WHERE email='$email'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    //$GLOBALS['UserCache']->RemoveFromCache($uid);
    
    $GLOBALS['Mail']->Resubscribe($email);
    // Mail user at email address
    $to = $email;
    $subject = "".UNIVERSITY." HvZ Password Reset Link";
    $body = "Hello,<br>A password reset was recently requested for $email from IP address {$_SERVER['REMOTE_ADDR']}<br>To reset your password, please visit the following website address:<br>".DOMAIN."/lostpassword/reset/$hash <br>Note, if you cannot click on the link above, you may need to copy and paste it into your web browser.<br>If you received this email in error or did not request your password to be reset, you may safely ignore this email.<br>";
             
    if (!$GLOBALS['Mail']->SimpleMail($to, $subject, $body))
    {
      return false;
    }
    
    return true;
    
  }
  
  
  /**
   * Checks a given hash to see if it exists for any users
   *
   * @return  bool
   */
  function CheckValidPasswordResetHash($hash)
  {

    if (strlen($hash) < 32)
      return false;
      
    $hash = addslashes($hash);

    $sql = "SELECT uid FROM user WHERE lost_pw_hash='$hash'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    if (!is_array($results))
    {
      return false;
    }
    
    if (!count($results) > 0)
    {
      return false;
    }
    
    return true;
    
  }


  /**
   * Updates a users password who matches a given hash
   *
   * @return  bool
   */
  function UpdatePassFromHash($lost_pass_hash, $new_pass)
  {
  
    // Sanitize imput, convert pass to hash
    $lost_pass_hash = addslashes($lost_pass_hash);
    $pass = md5(addslashes($this->salt.$new_pass));
       
    // Save to DB
    $sql = "UPDATE user SET password='$pass' WHERE lost_pw_hash='$lost_pass_hash'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    //$GLOBALS['UserCache']->RemoveFromCache($uid);
    
    $sql = "SELECT email FROM user WHERE lost_pw_hash='$lost_pass_hash'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    if (!is_array($results))
    {
      return false;
    }
    
    if (!count($results) > 0)
    {
      return false;
    }
    
    $to = $results[0]['email'];
    
    
    // Now delete the hash from the users account
    $sql = "UPDATE user SET lost_pw_hash='' WHERE lost_pw_hash='$lost_pass_hash'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    //$GLOBALS['UserCache']->RemoveFromCache($uid);

    // Mail user at email address
    $subject = "".UNIVERSITY." HvZ Password Changed";
    $body = "Hello,<br>The password to your ".UNIVERSITY." Humans vs. Zombies account was recently changed. If you did not request a password change, please alert a Moderator.<br>";
             
    $GLOBALS['Mail']->SimpleMail($to, $subject, $body);
    
    return true;
    
  }
  
  
  /**
   * Checks to make sure email is valid, returns array
   * with validity and uid associated with the email
   *
   * @return  array
   */
  function CheckValidEmail($email)
  {
  
    if (!$GLOBALS['Mail']->ValidateEmailAddr($email))
    {
      return false;
    }
    
    $email = addslashes($email);
    
    $sql = "SELECT uid FROM user WHERE email='$email'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    if (!is_array($results))
    {
      return false;
    }
    
    if (!count($results) > 0)
    {
      return false;
    }

    return true;
    
  }
  
  /*
  * Checks to make sure a given password conforms to rules
  *
  * @return bool
  */
  function PasswordRuleCheck($password)
  {
    $length = strlen($password);
    
    if ($length < 6)
      return false;
      
    return true;
    
  }
  
  /* 
  * Decides if a user account is setup and complete
  *
  * @return bool
  */
  function AccountComplete($uid = null)
  {

    try
    {
    $step = $this->AccountStep($uid);
    }
    catch (Exception $e)
    {
      return false;
    }
    
    if ($step == 0)
      return true;
    else
      return false;    
    
  }
  
  /*
  * Returns the signup step the account is on
  * or if the account is completed, returns 0
  * 
  * @return int
  */
  function AccountStep($uid = null)
  {

    if (!$uid && isset($_SESSION['uid']))
    {
      $uid = $_SESSION['uid'];
    }

    if (!$uid)
    {
      throw new Exception('Account not specified.');
    }
      
    // pull user out of db
    try
    {
    $user = $this->GetUser($uid);
    }
    catch (Exception $e)
    {
      throw new Exception($e->getMessage());
    }
      
    if (!$_SESSION)
    {
          
      $email_confirmed = $user['email_confirmed'];
      $code_of_conduct = $user['code_of_conduct'];
      $liability_waiver = $user['liability_waiver'];
      $fb_id = $user['fb_id'];
      $using_fb = $user['using_fb'];
      $name = $user['name'];

      // Approval happens aync of user session (moderator approvs via admin panel), always pull it from the DB
      $approved = $user['approved'];
      
    }
    else
    {
      // assign session vars to local vars
      $email_confirmed = $_SESSION['email_confirmed'];
      $code_of_conduct = $_SESSION['code_of_conduct'];
      $liability_waiver = $_SESSION['liability_waiver'];
      $fb_id = $_SESSION['fb_id'];
      $using_fb = $_SESSION['using_fb'];
      $name = $_SESSION['name'];
      
      // Approval happens aync of user session (moderator approvs via admin panel), always pull it from the DB
      $approved = $user['approved'];
      //$approved = $_SESSION['approved'];

    }
    
    if (!$email_confirmed)
      return 2;
    
    if (!$code_of_conduct)
      return 3;
    
    if ($liability_waiver == '')
      return 4;
    
    if (empty($fb_id) && ($using_fb))
      return 5;
    
    if ($using_fb && empty($name))  
      return 5;
      
    if (!$approved)
      return 5;
    
    // user is completed
    
    if ($_SESSION)
    {
      $_SESSION['approved'] = 1;
    }
    
    return 0;
  }
  
  /*
  * Sets the given $field to the given $bool state
  *
  * @return bool
  */
  function UpdateUserColumn($uid, $field, $value)
  {
    
    $value = htmlspecialchars(addslashes($value));
    
    // try to update the DB
    $sql = "UPDATE user SET $field='$value' WHERE uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
  
    // clear user cache
    $GLOBALS['UserCache']->RemoveFromCache($uid);
    return true;
  }

  /*
  * Sets the given $field to the given state in forum database
  *
  * @return bool
  */
  function UpdateForumUserColumn($uid, $field, $value)
  {
    
    $value = htmlspecialchars(addslashes($value));
    
    // try to update the DB
    $GLOBALS['Db']->SelectDb(FORUM_DATABASE);
    $sql = "UPDATE ".FORUM_DATABASE.".GDN_User SET $field='$value' WHERE UserID='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    $GLOBALS['Db']->SelectDb(DATABASE);
  
    // clear user cache
    $GLOBALS['UserCache']->RemoveFromCache($uid);
    return true;
  }
  
  /*
  * Sets the given $field to the given $value in game_xref
  *
  * @return bool
  */
  function UpdateUserGameColumn($gid, $uid, $field, $value)
  {
    
    $value = htmlspecialchars(addslashes($value));
    
    // try to update the DB
    $sql = "UPDATE game_xref SET $field='$value' WHERE uid='$uid' && gid='$gid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
  
    // Clear caches
    $cache_id = $uid.'_game';
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    $cache_id = 'game_'.$gid.'_playercount';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
    $cache_id = 'game_'.$gid.'_playercount_brokendown';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
    return true;
  }
  
  /**
   * Generates a random hash based on time and IP for pw reset
   *
   * @return  array
   */
  function GenerateRandomHash($email)
  {
  
    $t = date("U");
    $ip = $_SERVER['REMOTE_ADDR'];
    return md5($this->salt.$t.$ip.$email);
    
  }


  /*
  * Checks to see if a user is approved
  *
  * @return bool
  */
  function UserApproved($uid)
  {
    $sql = "SELECT aid FROM user_approval WHERE uid='$uid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (count($results) > 0)
    {
      // user exists in table, not approved
      return false;
    }
    
    return true;
    
  }

  /*
  * Grabs all users that need approval from database
  *
  * @return array
  */
  function GetUsersToApprove()
  {
    $sql = "SELECT * FROM user_approval WHERE 1";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      return $results;
    }
    
    return null;
    
  }

  /*
  * Marks a user as account pending if not already in table
  *
  * @return bool
  */
  function MarkUserApprovalPending($uid)
  { 
  
    if (!$this->UserApproved($uid))
      return true;
    
    // user doesn't exist, need to add them
    $sql = "INSERT INTO user_approval (uid) VALUES('$uid')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    return true;
    
  }
  
  /*
  * Removes a user from the approval table if they're there
  *
  * @return bool
  */
  function MarkUserApproved($uid)
  {
  
    // delete user
    $sql = "DELETE FROM user_approval WHERE uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    return true;
    
  }

  /*  $img_base = base directory structure for thumbnail images
  *   $w_dst = maximum width of thumbnail
  *   $h_dst = maximum height of thumbnail
  *   $n_img = new thumbnail name
  *   $o_img = old thumbnail name
  */
  function ConvertUploadedPhoto($img_base, $w_dst, $h_dst, $n_img, $o_img, $create_thumbnail=false, $thumb_base, $thumbnail_scaling_factor)
  {
     @unlink($img_base.$n_img);         //  remove old images if present
     @unlink($img_base.$o_img);
     $new_img = $img_base.$n_img;
       
     $file_src = $img_base.$n_img."_tmp.jpg";  //  temporary safe image storage
     @unlink($file_src);
     move_uploaded_file($_FILES['photo']['tmp_name'], $file_src);
                
     list($w_src, $h_src, $type) = getimagesize($file_src);     // create new dimensions, keeping aspect ratio
     $ratio = $w_src/$h_src;
     if ($w_dst/$h_dst > $ratio) {$w_dst = floor($h_dst*$ratio);} else {$h_dst = floor($w_dst/$ratio);}

     switch ($type)
       {case 1:   //   gif -> jpg
          $img_src = imagecreatefromgif($file_src);
          break;
        case 2:   //   jpeg -> jpg
          $img_src = imagecreatefromjpeg($file_src); 
          break;
        case 3:  //   png -> jpg
          $img_src = imagecreatefrompng($file_src);
          break;
       }
     $img_dst = imagecreatetruecolor($w_dst, $h_dst);  //  resample
     
     imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $w_dst, $h_dst, $w_src, $h_src);
     imagejpeg($img_dst, $new_img);    //  save new image

     if ($create_thumbnail)
     {
       $img_dst = imagecreatetruecolor(floor($w_dst/$thumbnail_scaling_factor), floor($h_dst/$thumbnail_scaling_factor));  //  resample
       $new_img = $thumb_base.$n_img;
       imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, floor($w_dst/$thumbnail_scaling_factor), floor($h_dst/$thumbnail_scaling_factor), $w_src, $h_src);
       imagejpeg($img_dst, $new_img);    //  save new image
     }

     @unlink($file_src);  //  clean up image storage
     imagedestroy($img_src);        
     imagedestroy($img_dst);
  }
  
  
  /*
  * Adds a user to the game_xref for a given gid
  *
  */
  function JoinGame($gid, $uid, $secret)
  {
  
    // First check to see if user already joined this game
    $xrefs = $this->GetUserFromGame($uid);
    if (is_array($xrefs))
    {
      foreach ($xrefs as $xref)
      {
        if ($xref['gid'] == $gid)
        {
          return false;
        }
      }
    }

    $secret = strtolower($secret);
    
    $cache_id = 'game_'.$gid.'_playercount';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
    $cache_id = 'game_'.$gid.'_playercount_brokendown';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
    $cache_id = $uid;
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    $cache_id = $uid.'_game';
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    $cache_id = $uid.'_gameAll';
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    
    $sql = "INSERT INTO game_xref (gid, uid, secret, oz_pool) VALUES ('$gid', '$uid', '$secret', '0')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    $this->AddForumRoleHuman($uid);

    $sql = "UPDATE user SET active_game='1' WHERE uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    return true;
  }
  
  /*
  * Gets an array of player data paged and for the given gid
  *
  *
  
  function GetPlayerlist($gid, $pageBy=null, $page=null, $sortBy=null, $filterBy=null)
  {
    if (!$pageBy)
      $pageBy = 20;
    
    if (!$page)
      $page = 1;
      
    if (!$sortBy)
      $sortBy = 'name';
    
    if (!$filterBy)
      $filterBy = 'all';
    
    $pageBy = addslashes($pageBy);
    $page = addslashes($page);
    $sortBy = addslashes($sortBy);
    $filterBy = addslashes($filterBy);

    $limitSql = '';
    switch ($pageBy)
    {
      case "all":
        break;
      
      default:
        //$upperLimit = ($page * $pageBy) - 1;
        $lowerLimit = ($page * $pageBy) - $pageBy;
        $limitSql = "LIMIT $lowerLimit, $pageBy";
        break;
    }
    
    $sortSql = '';
    switch ($sortBy)
    {      
      case "kills":
        $sortSql = 'ORDER BY gx.zombie_kills DESC';
        break;
        
      case "starve_time":
        $sortSql = 'ORDER BY gx.zombie_feed_timer ASC';
        break;
        
      case "name":
      default:
        $sortSql = 'ORDER BY u.name ASC';
        break;
    }

    $filterSql = '';
    switch ($filterBy)
    {      
      case "humans":
        $sortSql = "AND status='human'";
        break;
     
      case "zombies":
        $sortSql = "AND status='zombie'";
        break;
      
      case "deceased":
        $sortSql = "AND status='deceased'";
        break;
        
      case "all":
      default:
        $filterSql = '';
        break;
    }
    
    $sql = "SELECT 
              gx.uid, 
              gx.status, 
              gx.oz, 
              gx.oz_pool, 
              gx.zombie_kills, 
              gx.zombied_time, 
              gx.zombie_feed_timer,
              u.name, 
              u.email,
              u.fb_id, 
              u.using_fb,
              u.squad_name
            FROM game_xref gx LEFT JOIN user u ON gx.uid = u.uid
            WHERE 1 $filterSql
            $sortSql
            $limitSql;";
    
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      return $results;
    }
    else
    {
      return null;
    }
    
  }
  */
  
  /*
  * Gets an array of player data paged and for the given gid
  *
  *
  */
  function GetAccounts($pageBy=null, $page=null, $sortBy=null, $filterBy=null)
  {
    if (!$pageBy)
      $pageBy = 20;
    
    if (!$page)
      $page = 1;
      
    if (!$sortBy)
      $sortBy = 'name';
    
    if (!$filterBy)
      $filterBy = 'all';
    
    $pageBy = addslashes($pageBy);
    $page = addslashes($page);
    $sortBy = addslashes($sortBy);
    $filterBy = addslashes($filterBy);

    $limitSql = '';
    switch ($pageBy)
    {
      case "all":
        break;
      
      default:
        //$upperLimit = ($page * $pageBy) - 1;
        $lowerLimit = ($page * $pageBy) - $pageBy;
        $limitSql = "LIMIT $lowerLimit, $pageBy";
        break;
    }
    
    $sortSql = '';
    switch ($sortBy)
    {              
      case "name":
      default:
        $sortSql = 'ORDER BY u.name ASC';
        break;
    }

    $filterSql = '';
    switch ($filterBy)
    {    

      case "users":
        $filterSql = "AND admin='0'";
        break;
     
      case "admins":
        $filterSql = "AND admin='1'";
        break;
        
      case "notapproved":
        $filterSql = "AND approved='0'";
        break;
        
      case "all":
        $filterSql = '';
        break;
        
      case "approved":
      default:
        $filterSql = "AND approved='1'";
        break;
    }
    
    $sql = "SELECT
              u.uid,
              u.name, 
              u.email,
              u.fb_id, 
              u.using_fb,
              u.admin,
              u.privileges,
              u.liability_waiver,
              u.approved,
              u.squad_name
            FROM user u
            WHERE 1 $filterSql
            $sortSql
            $limitSql;";
    
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      return $results;
    }
    else
    {
      return null;
    }
    
  }

  /*
  * Checks to see if a passed AID is valid and if so, returns a corresponding uid
  *
  */
  function CheckValidApproval($aid)
  {
    
    $sql = "SELECT
              uid
            FROM user_approval
            WHERE aid='$aid'";
              
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      return $results[0]['uid'];
    }
    else
    {
      return false;
    }
    
  }
  
  /*
  * Gets an array of accounts for approvel (20)
  *
  */
  function GetAccountsForApproval()
  {
    
    $sql = "SELECT
              u_a.aid,
              u.uid,
              u.name, 
              u.email,
              u.fb_id, 
              u.using_fb,
              u.admin,
              u.privileges,
              u.liability_waiver,
              u.approved
            FROM user_approval u_a LEFT JOIN user u ON u_a.uid = u.uid
            WHERE 1
            ORDER BY u.created ASC
            LIMIT 0, 20;";
    
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      return $results;
    }
    else
    {
      return null;
    }
    
  }
  
  /*
  * Approves a user account
  *
  */
  function ApproveAccount($aid, $uid)
  {
    // Need to remove row from user_approval table corresponding to aid
    $sql = "DELETE FROM user_approval WHERE aid='$aid' AND uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    
    // Need to set user appoval flag in user table to true
    $sql = "UPDATE user SET approved='1' WHERE uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    
    // Clear caches
    $cache_id = $uid;
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    $cache_id = $uid.'_game';
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    $cache_id = $uid.'_gameAll';
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    
    return true;
  }

  /*
  * Denies a user account
  *
  */
  function DenyAccount($aid, $uid)
  {
    // Need to remove row from user_approval table corresponding to aid
    $sql = "DELETE FROM user_approval WHERE aid='$aid' AND uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    
    // But since the user table still has approved = false, the user will have to complete that setup step again

    // Remove any waiver information for this account, make them re-enter it
    // Need to remove row from user_approval table corresponding to aid
    $sql = "UPDATE user SET liability_waiver='' WHERE uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    
    // Clear caches
    $cache_id = $uid;
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    $cache_id = $uid.'_game';
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    $cache_id = $uid.'_gameAll';
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    
    return true;
  }
  
  /**
  *
  *  Clears all user cache files in /cache/user/ directory
  *  Also deletes game_*_playercount and game_*_playercount_brokendown
  *
  */
  function ClearAllUserCache()
  {
   // Clear pattern * (all) from /cache/user/ dir
   $path = $GLOBALS['UserCache']->_CacheDirPath;
   $match = '*';
   static $deld = 0, $dsize = 0;
   $dirs = glob($path."*");
   $files = glob($path.$match);
   foreach($files as $file)
   {
    if(is_file($file))
    {
       $dsize += filesize($file);
       @unlink($file);
       $deld++;
    }
   }

   // Clear pattern game_* from /cache/ dir
   $path = $GLOBALS['Cache']->_CacheDirPath;
   $match = 'game_*';
   static $deld = 0, $dsize = 0;
   $dirs = glob($path."*");
   $files = glob($path.$match);
   foreach($files as $file)
   {
    if(is_file($file))
    {
       $dsize += filesize($file);
       @unlink($file);
       $deld++;
    }
   }

   return true;

  }

  /*
  * Mark all user accounts as not having an active_game
  *
  */
  function MarkAllUsersNotActiveGame()
  {
    $sql = "UPDATE user SET active_game='0' WHERE 1";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    
    // Clear caches
    $this->ClearAllUserCache();
    
    return true;
  }
  
  /*
  *
  * Returns bool wether user is playing in current game
  *
  */
  function IsPlayingCurrentGame($uid)
  {
    if (!$GLOBALS['state'])
      return false;
      
    $gid = $GLOBALS['state']['gid'];
    
    $sql = "SELECT
            uid
            FROM game_xref
            WHERE gid='$gid' AND uid='$uid'";
              
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      // player current playing
      return true;
    }
    else
    {
      return false;
    }
    
    return false;
    
  }
  
  /*
  * Takes an fb uid and sees if the user is already linked to a profile in database
  *
  */
  function CheckFacebookUserExists($fb_id)
  {
  
    $sql = "SELECT
            uid
            FROM user
            WHERE fb_id='$fb_id'";
              
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      // facebook uid exists
      return true;
    }
    else
    {
      return false;
    }
    
    return false;
    
  }
  
  /*
  * Removes a UID from the zombie forum role and adds them to the human role
  *
  */
  function AddForumRoleHuman($uid)
  {
    // add the roll
    $GLOBALS['Db']->SelectDb(FORUM_DATABASE);
    $this->RemoveStatusForumRoll($uid);
    $sql = "INSERT INTO ".FORUM_DATABASE.".GDN_UserRole (UserID, RoleID) VALUES('$uid', '33')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error creating user.');
    }
    $GLOBALS['Db']->Commit();

    // update the forum permissions
    $GLOBALS['Db']->SelectDb(FORUM_DATABASE);
    $sql = "UPDATE ".FORUM_DATABASE.".GDN_User SET Permissions = '' WHERE UserID = '$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error creating user.');
    }
    $GLOBALS['Db']->Commit();
    
    $GLOBALS['Db']->SelectDb(DATABASE);
  }

  /*
  * Removes a UID from the human forum role and adds them to the zombie role
  *
  */
  function AddForumRoleZombie($uid)
  {
    // add the roll
    $GLOBALS['Db']->SelectDb(FORUM_DATABASE);
    $this->RemoveStatusForumRoll($uid);
    $sql = "INSERT INTO ".FORUM_DATABASE.".GDN_UserRole (UserID, RoleID) VALUES('$uid', '34')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error creating user.');
    }
    $GLOBALS['Db']->Commit();

    // update the forum permissions
    $GLOBALS['Db']->SelectDb(FORUM_DATABASE);
    $sql = "UPDATE ".FORUM_DATABASE.".GDN_User SET Permissions = '' WHERE UserID = '$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error creating user.');
    }
    $GLOBALS['Db']->Commit();
    
    $GLOBALS['Db']->SelectDb(DATABASE);
  }

  /*
  * Removes a UID from the zombie and human forum role
  *
  */
  function RemoveStatusForumRoll($uid)
  {
    // Remove roll
    $GLOBALS['Db']->SelectDb(FORUM_DATABASE);
    $sql = "DELETE FROM ".FORUM_DATABASE.".GDN_UserRole WHERE UserID = '$uid' AND (RoleID = '33' OR RoleID = '34')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error creating user.');
    }
    $GLOBALS['Db']->Commit();

    // update the forum permissions
    $GLOBALS['Db']->SelectDb(FORUM_DATABASE);
    $sql = "UPDATE ".FORUM_DATABASE.".GDN_User SET Permissions = '' WHERE UserID = '$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error creating user.');
    }
    $GLOBALS['Db']->Commit();
    
    $GLOBALS['Db']->SelectDb(DATABASE);
  }
  
  /*
  * Returns an array of matched friends based on inputs
  *
  *
  */ 
  function GetPlayerMatchesOnSearch($search, $firstOnly = false)
  {
    $game = $GLOBALS['Game']->GetState();
    $gid = $game['gid'];    
    $sql = "SELECT user.name, user.email, user.uid, game_xref.secret FROM game_xref LEFT JOIN user ON game_xref.uid = user.uid WHERE game_xref.attended_orientation='0' AND gid='{$gid}'";
    $results = $GLOBALS['Db']->GetRecords($sql);
     
    $s = $search;
    $matches = array(); 
    if(strlen($s) > 1) 
    { 
      $i = 0;
      if (is_array($results))
      {
        foreach ($results as $result)
        {
          $pos = strpos(strtolower(trim($result['name'])), strtolower(trim($s)));
          if ($pos !== false)
          {
            // str found
            $matches[$i] = $result['name'] . ', ' . $result['email'] . ', ' . $result['uid']. ', ' . $result['secret'];
            $i++;
          }
        }
      }
    }

    // Case-insensitive sort 
    $matches_lowercase = array_map('strtolower', $matches); 
    array_multisort($matches_lowercase, SORT_ASC, SORT_STRING, $matches); 

    if ($firstOnly)
    {
      if (isset($matches[0]))
      {
        $return[0] = $matches[0];
      }
      else
      {
        $return = null;
      }
    }
    else
    {
      $return = $matches;
    }
    
    return $return;
  }
  
  
  /*
  * Set anyone who did not attend orientation as deceased
  *
  */
  function DidNotAttendOrientation()
  {
    $game = $GLOBALS['Game']->GetState();
    $gid = $game['gid'];   
    $sql = "SELECT
            uid
            FROM game_xref
            WHERE attended_orientation='0' AND gid='{$gid}'";
              
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      // loop through these IDs and mark deceased, remove forum roles
      foreach ($results as $result)
      {
        $uid = $result['uid'];
        $this->UpdateUserGameColumn($gid, $uid, 'status', 'deceased');
        $this->UpdateUserGameColumn($gid, $uid, 'zombie_feed_timer', '0');

        $GLOBALS['UserCache']->RemoveFromCache($uid);
        $GLOBALS['UserCache']->RemoveFromCache($uid.'_game');
        $GLOBALS['UserCache']->RemoveFromCache($uid.'_gameAll');
        
        $this->RemoveStatusForumRoll($uid);
      }
    }

    return;
    
  }
  
  
}
?>
