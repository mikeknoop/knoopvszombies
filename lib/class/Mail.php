<?php
/**  
 * Mail class
 * 
 * Handles mail activity
 * 	
 * @access		public
 */
 
class Mail {
			
  /**
   * Sends a simple mail message to $to, with $body as the body
   * and $subject as the subject
   *
   * @return  bool
   */
  function SimpleMail($to, $subject, $body, $attachFooter = true, $bcc = false)
  {
   
   $from = "{UNIVERSITY} Humans vs. Zombies <{EMAIL}>";
   $sig = "\r\nThanks,\n{UNIVERSITY} Humans vs. Zombies";
   
    // $to can be single email or comma seperated
    // $bcc = false;
    
    if ($bcc)
    {
      $headers = '';
      $headers .= 'From: '.$from . "\r\n";
      $headers .= 'Reply-To: '.EMAIL.'' . "\r\n";
      $headers .= 'Bcc: '.$to . "\r\n";
      $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";

      if ($attachFooter)
      {
        $body = $body.$sig;
      }
      
      if (mail(ARCHIVE_EMAIL, $subject, $body, $headers))
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      $headers = '';
      $headers .= 'From: '.$from . "\r\n";
      $headers .= 'Reply-To: '.EMAIL.'' . "\r\n";
      $headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";

      if ($attachFooter)
      {
        $body = $body.$sig;
      }
      
      if (mail($to, $subject, $body, $headers))
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    
  }
  
  /*
  *   Validates an email address per PHP standard
  *
  *   @return bool
  */
  function ValidateEmailAddr($email)
  {
    if ( filter_var($email, FILTER_VALIDATE_EMAIL)  == TRUE) {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  /*
  *   Returns an array of email addresses matching the $type
  *
  */
  function GetEmailAddresses($type)
  {
    switch ($type)
    {
      case "currentplayers":
        if ($GLOBALS['state'])
        {
          $sql = "SELECT u.email FROM game_xref g_x LEFT JOIN user u ON g_x.uid = u.uid WHERE g_x.gid='{$GLOBALS['state']['gid']}'";
        }
        else
        {
          return array();
        }
        break;
        
      case "currenthumans":
        if ($GLOBALS['state'])
        {
          $sql = "SELECT u.email FROM game_xref g_x LEFT JOIN user u ON g_x.uid = u.uid WHERE g_x.gid='{$GLOBALS['state']['gid']}' AND status='human'";
        }
        else
        {
          return array();
        }
        break;

      case "currentzombies":
        if ($GLOBALS['state'])
        {
          $sql = "SELECT u.email FROM game_xref g_x LEFT JOIN user u ON g_x.uid = u.uid WHERE g_x.gid='{$GLOBALS['state']['gid']}' AND status='zombie'";
        }
        else
        {
          return array();
        }
        break;

      case "currentdeceased":
        if ($GLOBALS['state'])
        {
          $sql = "SELECT u.email FROM game_xref g_x LEFT JOIN user u ON g_x.uid = u.uid WHERE g_x.gid='{$GLOBALS['state']['gid']}' AND status='deceased'";
        }
        else
        {
          return array();
        }
        break;

      case "notattendedorientation":
        if ($GLOBALS['state'])
        {
          $sql = "SELECT u.email FROM game_xref g_x LEFT JOIN user u ON g_x.uid = u.uid WHERE g_x.gid='{$GLOBALS['state']['gid']}' AND attended_orientation='0'";
        }
        else
        {
          return array();
        }
        break;
        
      case "allusers":
        $sql = "SELECT u.email FROM user u WHERE 1";
        break;
    }
    
    
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    $return = null;
    if (is_array($results) && count($results) > 0)
    {
      $i = 0;
      foreach ($results as $key => $val)
      {
        $return[$i] = $val['email'];
        $i++;
      }
      
      return $return;
    }
    else
    {
      return array();
    }
    
    
  }
}
?>