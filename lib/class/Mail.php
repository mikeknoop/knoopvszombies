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
  function SimpleMail($to, $subject, $body, $attachFooter = true, $bcc = false, $opt = false) {
   
   $mg_from = "".UNIVERSITY." Humans vs. Zombies <".EMAIL.">";
   $sig = "\r\nThanks,\n".UNIVERSITY." Humans vs. Zombies";
   $mg_api = MAILGUN_API_KEY;
   $mg_version = 'api.mailgun.net/v2/';
   $mg_domain = "osundead.com";
   $mg_reply_to_email = EMAIL_REPLY_TO;   
   $mg_message_url = "https://".$mg_version.$mg_domain."/messages"; 
    // $to can be single email or comma seperated
      
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   curl_setopt($ch, CURLOPT_USERPWD, 'api:' . $mg_api);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_URL, $mg_message_url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      
   $postfields = array(  'from'      => $mg_from,
                         'h:Reply-To'=> '<' . $mg_reply_to_email . '>',
                         'subject'   => $subject,
                         'text'      => $body,
            );
      if ($bcc) {
        $postfields["bcc"] = $to;
        $postfields["to"]  = ARCHIVE_EMAIL;
      } else {
        $postfields["to"] = $to;
      }

      if ($opt) {
        foreach ($opt as $option => $value){
        	$postfields[option] = $value;
        }
      }

      curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
      $result = curl_exec($ch);
      curl_close($ch);
      $res = json_decode($result,TRUE);
      return $res;
    
  }
  
  /*
  *   Validates an email address per PHP standard
  *
  *   @return bool
  */
  function ValidateEmailAddr($email) {
    if ( filter_var($email, FILTER_VALIDATE_EMAIL)  == TRUE) {
      return true;
    } else {
      return false;
    }
  }
  
  /*
  *   Returns an array of email addresses matching the $type
  *
  */
  function GetEmailAddresses($type) {
    switch ($type) {
      case "currentplayers":
        if ($GLOBALS['state']) {
          $sql = "SELECT u.email FROM game_xref g_x LEFT JOIN user u ON g_x.uid = u.uid WHERE g_x.gid='{$GLOBALS['state']['gid']}'";
        } else {
          return array();
        }
        break;
        
      case "currenthumans":
        if ($GLOBALS['state']) {
          $sql = "SELECT u.email FROM game_xref g_x LEFT JOIN user u ON g_x.uid = u.uid WHERE g_x.gid='{$GLOBALS['state']['gid']}' AND status='human'";
        } else {
          return array();
        }
        break;

      case "currentzombies":
        if ($GLOBALS['state']) {
          $sql = "SELECT u.email FROM game_xref g_x LEFT JOIN user u ON g_x.uid = u.uid WHERE g_x.gid='{$GLOBALS['state']['gid']}' AND status='zombie'";
        } else {
          return array();
        }
        break;

      case "currentdeceased":
        if ($GLOBALS['state']) {
          $sql = "SELECT u.email FROM game_xref g_x LEFT JOIN user u ON g_x.uid = u.uid WHERE g_x.gid='{$GLOBALS['state']['gid']}' AND status='deceased'";
        } else {
          return array();
        }
        break;

      case "notattendedorientation":
        if ($GLOBALS['state']) {
          $sql = "SELECT u.email FROM game_xref g_x LEFT JOIN user u ON g_x.uid = u.uid WHERE g_x.gid='{$GLOBALS['state']['gid']}' AND attended_orientation='0'";
        } else {
          return array();
        }
        break;
        
      case "allusers":
        $sql = "SELECT u.email FROM user u WHERE 1";
        break;
    }
    
    
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    $return = null;
    if (is_array($results) && count($results) > 0) {
      $i = 0;
      foreach ($results as $key => $val) {
        $return[$i] = $val['email'];
        $i++;
      }
      
      return $return;
    } else {
      return array();
    }
    
    
  }
}
?>
