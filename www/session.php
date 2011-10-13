<?php

  $page_title = 'Session';
  $require_login = false;
  
  require '../muzombies.ini.php';
  require 'module/includes.php';

  $GLOBALS['Session']->InitSession();
  
  // If a type is not specified, redirect to main
  if (!isset($_GET['type']))
  {
      header('Location: //'.DOMAIN);
      
      // stop the script
      exit;
  }
  
  if ($_GET['type'] == 'logout')
  {
      $GLOBALS['Session']->DestroySession();
      
      header('Location: //'.DOMAIN);
      
      // stop the script
      exit;
  }
  
  if ($_GET['type'] == 'login')
  {
      // First, see if we have data to check
      if (!isset($_POST['email']) || !isset($_POST['email']))
      {
        header('Location: //'.DOMAIN.'/login/tryagain');
        exit;
      }

      // check the username/pass combo
      try
      {
        $check = $GLOBALS['User']->CheckLogin($_POST['email'], $_POST['password']);
        if (!$check['valid'])
        {
          // wrong user/pass combo
          header('Location: //'.DOMAIN.'/login/tryagain');
          exit;
        }
      }
      catch (Exception $e)
      {
        echo $e->getMessage();
        // unknown error, try again
        header('Location: //'.DOMAIN.'/login/tryagain');
        exit;
      }
      
      // User passed all checks, grant them a session
      $uid = $check['uid'];
      $GLOBALS['Session']->RefreshSession($uid);
      
      // Done, redirect back to referral is specified, index otherwise
      if (isset($_POST['ref']))
      {
        $ref = addslashes(strip_tags($_POST['ref']));
        header('Location: //'.DOMAIN.'/'.$ref);
      }
      else
      {
        header('Location: //'.DOMAIN);
      }
      exit;
  }
  
  if ($_GET['type'] == 'impersonate')
  {
    // check to see if param (impersonated uid) is valid
    if (isset($_GET['param']) && $GLOBALS['User']->IsValidUser($_GET['param']))
    {
      // make sure current user is a mod and has accounts perm
      if ($_SESSION['admin'] && $GLOBALS['Misc']->StringWithin('accounts', $_SESSION['privileges']))
      {
        // make sure the user to impersonate isn't the same as logged in user, and that no impersonation is going on
        if ($_SESSION['uid'] != $_GET['param'] && (!isset($_SESSION['impersonate']) || (isset($_SESSION['impersonate']) && $_SESSION['impersonate'] == 0))) {
          // user is a mod and has permission. Do the impersonation
          $GLOBALS['Session']->ImpersonateCurrentSessionWith($_GET['param']);
        }
      }
    }
 
    header('Location: //'.DOMAIN);
    exit;
  }

  if ($_GET['type'] == 'unimpersonate')
  {
  
  // user wants to unimpersonate. This is fine for all cases as long as the user has a valid session
    if (isset($_SESSION) && isset($_SESSION['uid']))
    {
      $GLOBALS['Session']->UnimpersonateCurrentSession();
    }
 
    header('Location: //'.DOMAIN);
    exit;
  }
  
    // something should have caught the request by now but if not...
    header('Location: //'.DOMAIN);

?>
Problem loading page... <a href="//<?php echo DOMAIN; ?>//">please click here</a>.