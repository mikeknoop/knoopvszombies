<?php
/**  
 * Session class
 * 
 * Handles session activity
 * 	
 * @access		public
 */
 
class Session {


   /**
   * Initializes a session
   *
   * @return  bool
   */
  function InitSession()
  {
    // Init session
    session_start();
    
    return true;
    
  }
  	
  /**
   * Creates a session based on a validated uid
   *
   * @return  bool
   */
  function RefreshSession($uid)
  {
   
    $user = $GLOBALS['User']->GetUser($uid);
    
    if (is_array($user))
    {
      foreach ($user as $key => $prop)
      {
        $_SESSION[$key] = $prop;
      }
    }
    else
    {
      return false;
    }   
    
    return true;
    
  }

  /**
   * Adds the impersonation flag and params to the current $_SESSION
   *
   * @return  bool
   */
  function ImpersonateCurrentSessionWith($uid)
  {
   
    $tmp_SESSION = $_SESSION;
    
    $user = $GLOBALS['User']->GetUser($uid);
    
    if (is_array($user))
    {
      foreach ($user as $key => $prop)
      {
        $_SESSION[$key] = $prop;
      }
      
      // now save the true identity
      $_SESSION['impersonate'] = 1;
      $_SESSION['true_identity'] = $tmp_SESSION;
    }
    else
    {
      return false;
    }   
    
    return true;
    
  }

  /**
   * Removes impersonation for current session
   *
   * @return  bool
   */
  function UnimpersonateCurrentSession()
  {
    
    if ($_SESSION['impersonate'] == 1)
    {
      // Need to swap the "original" back
      $_SESSION = $_SESSION['true_identity'];
      $_SESSION['impersonate'] = 0;
      $_SESSION['true_identity'] = array();
    }

  }
  
   /**
   * Destroys current user session, forcing a relogin
   *
   * @return  bool
   */
  function DestroySession()
  {
  
    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
    
    return true;
    
  }
 
  
}
?>