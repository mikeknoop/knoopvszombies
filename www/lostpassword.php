<?php

  $page_title = 'Lost Password';
  $require_login = false;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';
  
  $new_password_form = false;

  // form was submitted
  if (isset($_POST['email']))
  {
    // Check the rate limit of the REMOTE_ADDR
    if (!$GLOBALS['User']->RateLimit(60*60, 'pwd_rst_'.$_POST['email']))
    {
      header('Location: //'.DOMAIN.'/lostpassword/slowdown');
      exit;
    }
    
    // User passed rate check, validate the email passed is in the db
    try
    {
      if (!$GLOBALS['User']->CheckValidEmail($_POST['email']))
      {
        // email wasn't found in the database
        header('Location: //'.DOMAIN.'/lostpassword/emailnotfound');
        exit;
      }
    }
    catch (Exception $e)
    {
      echo $e->getMessage();
      // unknown error, try again
      header('Location: //'.DOMAIN.'/lostpassword/unknownerror');
      exit;
    }
    
    // Email passes all checks, generate a reset hash, save to db, mail user
    if (!$GLOBALS['User']->ResetPasswordInit($_POST['email']))
    {
        header('Location: //'.DOMAIN.'/lostpassword/unknownerror');
        exit;
    }
    
    // Done, redirect user to success
    header('Location: //'.DOMAIN.'/lostpassword/sendsuccess');
    exit;
  }
  
  // Reset link was clicked from email
  if (isset($_GET['reset']))
  {
    
    // User passed rate check, validate the hash exists in the db
    try
    {
      if (!$GLOBALS['User']->CheckValidPasswordResetHash($_GET['reset']))
      {
        // hash wasn't found in the db
        header('Location: //'.DOMAIN.'/lostpassword/invalidlink');
        exit;
      }
    }
    catch (Exception $e)
    {
      echo $e->getMessage();
      // unknown error, try again
      header('Location: //'.DOMAIN.'/lostpassword/unknownerror');
      exit;
    }
    
    // Hash is valid, show the new password form
    $new_password_form = true;
    
  }
  
    // New password form was posted to this address
  if (isset($_POST['reset']))
  {
   
    // User passed rate check, make sure they posted both new pass and confirmation
    if (!isset($_POST['new_pass']) || !isset($_POST['new_pass_confirm']))
    {
      header('Location: //'.DOMAIN.'/lostpassword/reset/'.$_POST['reset'].'/incomplete');
      exit;
    }
    
    // Yes user did, validate the hash exists in the db
    try
    {
      if (!$GLOBALS['User']->CheckValidPasswordResetHash($_POST['reset']))
      {
        // hash wasn't found in the db
        header('Location: //'.DOMAIN.'/lostpassword/reset/'.$_POST['reset'].'/invalidlink');
        exit;
      }
    }
    catch (Exception $e)
    {
      echo $e->getMessage();
      // unknown error, try again
      header('Location: //'.DOMAIN.'/lostpassword/reset/'.$_POST['reset'].'/unknownerror');
      exit;
    }
    
    // Hash is valid, check to make sure the new password and confirmation match
    if ($_POST['new_pass'] != $_POST['new_pass_confirm'])
    {
      // passwords don't match
      header('Location: //'.DOMAIN.'/lostpassword/reset/'.$_POST['reset'].'/passdontmatch');
      exit;
    }
    
    // Input passes all checks, update the password in DB
    if ($GLOBALS['User']->UpdatePassFromHash($_POST['reset'], $_POST['new_pass']))
    {
      // destroy session since password was changed
      $GLOBALS['Session']->DestroySession();
      header('Location: //'.DOMAIN.'/lostpassword/success');
      exit;
    }
    
    // default error
    
    header('Location: //'.DOMAIN.'/lostpassword/reset/'.$_POST['reset'].'/unknownerror');
    exit;
  }
  
  $status = '';
  // generates the status string
  if (isset($_GET['state']))
  {
    switch ($_GET['state'])
    {
      case 'success':
        $status = 'Your password has been successfully reset<br />
                   to the one you specified.';
        break;
        
      case 'sendsuccess':
        $status = 'Check your email for further instructions.';
        break;
        
      case 'emailnotfound':
        $status = 'The email you entered could not be found<br />
               in our database. Please try again.';
        break;
      
      case 'slowdown':
        $status = 'A lost password can only be requested once per hour.<br />
                   Please try again later.';
        break;
        
      case 'invalidlink':
        $status = 'The reset link you requested is not valid.<br />
              To reset your password, please request another below.';
        break;
        
      case 'passdontmatch':
        $status = 'The new password does not match the confirmation.<br />
                   Carefully enter your new password again.';
        break;
      
      case 'incomplete':
        $status = 'Both the new password and password confirmation<br />
                   boxes must be completed. Please try again.';
        break;
                          
      default:
        $status = 'An unknown error occured. Please try again.';
        break;
    }
  }
  else
  {
    $_GET['state'] = null;
  }

?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/page/lostpassword.css" rel="stylesheet" type="text/css"/>
  
</head>

<body>

  <div id="body_container">
  
    <?php
      require 'module/header.php';
    ?>
    
    <div class="content_column">
      <div id="content">
      
        <div id="content_top_border">

            <?php
              require 'module/body_header.php';
            ?>
    
        </div>
        
        <div class="clearfix"></div>
        
        <div id="body_content">
                     
          <div id="lostpassword_container">
        
            <?php
            
              if ($new_password_form)
              {
                require 'module/lostpass_newpass.php';
              }
              else
              {
                require 'module/lostpass_init.php';
              }
            
            ?> 

          </div>
        
          <div id="signup_container">
            <?php
              require 'module/signup_incent_large.php';
            ?>
          </div> <!-- signup_container -->
          
          <div class="clearfix"></div>
          
        </div> <!-- body_content -->     
        

      </div> <!-- content -->
    </div>  <!-- content_column -->
    
    
    <div id="footer_push"></div>
  </div> <!-- body_container -->

  <?php
    require 'module/footer.php';
  ?>


</body>

</html>
