<?php
  
  if (is_array($_REQUEST))
  {
    foreach ($_REQUEST as $key => $val)
    {
      if (is_string($val))
      {
        $_REQUEST[$key] = strip_tags($val);
      }
    }
  }
  
  $GLOBALS['Session']->InitSession();
  
  if (!isset($require_login))
  {
    $require_login = true;
  }

  if (!isset($page_uri))
  {
    $page_uri = '';
  }
  
  if (!isset($require_complete_account))
  {
    $require_complete_account = false;
  }

  if(isset($_SESSION['uid'])) 
  { 
      $_SESSION;
      $GLOBALS['Session']->RefreshSession($_SESSION['uid']);
  } 
  else 
  { 
      $_SESSION = null;
  }

  /* DEVELOPEMENT REDIRECT */
  if (isset($page_title) && $page_title == 'Home')
  {
    if (!$_SESSION)
    {
      //header('Location: http://www.facebook.com/muzombies');
    }
  }
 /* END DEVELOPEMENT REDIRECT */
  
  
  if ($require_login && !$_SESSION)
  {
    if ($page_uri != '') {
      header("Location: ../login/required/{$page_uri}");
    } else {
      header("Location: ../login/required");
    }
    
    // Ensure following code is not executed
    exit;
  }
  
  // User must have a completed account to access this page
  if ($require_complete_account && !$GLOBALS['User']->AccountComplete())
  {
     header("Location: ../signup");
     exit;
  }

  // Get Game State
  $GLOBALS['state'] = $GLOBALS['Game']->GetState();

?>