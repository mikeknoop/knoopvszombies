<?php

  $page_title = 'Signup';
  $require_login = false;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';
  
  if (!isset($_GET['state']))
    $_GET['state'] = null;
  

  if ($_SESSION)
  {
      // If user has a session, find out what step their account signup process is on
      // if it's completed, redirect them to their account page
      if (!$GLOBALS['User']->AccountComplete())
      {
        // account not complete, redirect user to the step they are on
        $step = $GLOBALS['User']->AccountStep();
        
        // but only if they aren't already there
        if (isset($_GET['step']))
        {
          if ($_GET['step'] != $step)
          {
              header('Location: //'.DOMAIN.'/signup/'.$step);
              exit;
          }
        }
        else
        {
          // user navigated directly to url.tld/signup so always redirect them since they have a session
          // and shouldnt be allowed to sign up for a new account
          header('Location: //'.DOMAIN.'/signup/'.$step);
          exit;
        }
        
      }
      else
      {
        // user is done. if they are accessing step 5, redirect to step 6
        if ($_GET['step'] == 5)
        {
          header('Location: //'.DOMAIN.'/signup/6');
          exit;
        }
        
        // user is done, if user tries to access last step (6), let them
        if (isset($_GET['step']))
        {
          if ($_GET['step'] != 6)
          {
            // account is completed
            header('Location: //'.DOMAIN.'/account');
            exit;
          }
          else
          {
            $step = 6;
            // carry on with the script
          }
        }
        else
        {
          // account is completed
          header('Location: //'.DOMAIN.'/account');
          exit;
        }

      }
     
  }
  
  // This block contains the logic for each account signup step
  if (isset($_GET['step']))
  {
              
    switch ($_GET['step'])
    {
      case 1:
        // create account
        // Check and see if the form was submitted
        if (isset($_POST['email']) || isset($_POST['new_password']) || isset($_POST['new_password_confirm']))
        {
          // Form was submitted
          // Check to make sure all fields were filled out
          if ($_POST['email'] == '' || $_POST['new_password'] == '' || $_POST['new_password_confirm'] == '')
          {
            // Form is missing fields
            header('Location: //'.DOMAIN.'/signup/1/incomplete');
            exit;
          }
          
          // Limits rate of new user signups from a single IP address (database access, mailer)
          if (!$GLOBALS['User']->RateLimit(1))
          {
            header('Location: //'.DOMAIN.'/signup/1/slowdown');
            exit;
          }
    
          // check to make sure the password and confirmation match
          if ($_POST['new_password'] != $_POST['new_password_confirm'])
          {
            // passwords don't match
            header('Location: //'.DOMAIN.'/signup/1/passdontmatch');
            exit;
          }
          
          // Validate password matches rules
          if (!$GLOBALS['User']->PasswordRuleCheck($_POST['new_password']))
          {
            // passwords doesn't match rules
            header('Location: //'.DOMAIN.'/signup/1/poorpassword');
            exit;
          }
          
          // validate email address is proper form
          if (!$GLOBALS['Mail']->ValidateEmailAddr($_POST['email']))
          {
            // bad email address
            header('Location: //'.DOMAIN.'/signup/1/invalidemail');
            exit;
          }
          
          // Check to make sure email doesn't already exist
          if ($GLOBALS['User']->CheckValidEmail($_POST['email']))
          {
            // email exists
            header('Location: //'.DOMAIN.'/signup/1/emailexists');
            exit;
          }
          
          // Okay all is good, create the user, also sends the confirmatio email
          $check = $GLOBALS['User']->CreateUser($_POST['email'], $_POST['new_password']);
          if ($check['valid'])
          {
            // User successfully created, grant user a session
            $uid = $check['uid'];
            $GLOBALS['Session']->RefreshSession($uid);
            
            // Redirect to step 2
            header('Location: //'.DOMAIN.'/signup/2/emailconfirmsent');
            exit;
          }
          
          
          // catch all case, uknown error
          header('Location: //'.DOMAIN.'/signup/1/unknownerror');
          exit;
        }
        
      break;
      
      case 2:
        // Email confirmation
        /*
        // Either we need a session or $_GET['confirm'] hash set
        if (!(isset($_GET['confirm']) || $_SESSION))
        {
          // login required
          print('Location: '.DOMAIN.'/login/required');
          exit;
        }
        */
        
        if (isset($_GET['confirm']))
        {
          // link was clicked from an email or link was clicked to resend
          if ($_GET['confirm'] == 'resend')
          {
            // link was clicked to resend
            // We need a session to do this
            if (!$_SESSION)
            {
              // redirect to get one
              header('Location: //'.DOMAIN.'/login/required');
              exit;
            }
            
            // Limits rate of sending email confirmation (db access and mailer)
            if (!$GLOBALS['User']->RateLimit(60*5, 'ec_'.$_SESSION['uid']))
            {
              header('Location: //'.DOMAIN.'/signup/2/slowdown');
              exit;
            }
            
            // Okay go ahead and resend the confirmation email
            if (!$GLOBALS['User']->SendEmailConfirmation($_SESSION['uid']))
            {
              header('Location: //'.DOMAIN.'/signup/2/unknownerror');
              exit;
            }
            
            // sent successfully
            header('Location: //'.DOMAIN.'/signup/2/sendsuccess');
            exit;

          }
          else
          {
            // link was clicked from email to confirm, supposedly $_GET['confirm'] is the hash
            $check = $GLOBALS['User']->ConfirmEmail($_GET['confirm']);
            if (!$check['valid'])
            {
              // confirmation hash was invalid
              header('Location: //'.DOMAIN.'/signup/2/invalid');
              exit;
            }
            
            // email confirmed and updated in db, go to next step
            // if the user doesnt have a session, grant one
            if (!$_SESSION)
            {
              $uid = $check['uid'];
              $GLOBALS['Session']->RefreshSession($uid);
            }
            else
            {
              // update the users session to have the confirmed email address
              $_SESSION['email_confirmed'] = 1;
            }

            header('Location: //'.DOMAIN.'/signup/3');
            exit;

          }
          
        }
        
      break;
      
      case 3:
        // code of conduct page
        // require a session from the user
        
        if (!$_SESSION)
        {
            // redirect to get one
            header('Location: //'.DOMAIN.'/login/required');
            exit;
        }
        
        if (isset($_GET['state']))
        {
          if ($_GET['state'] == 'agree')
          {
            // code of conduct was agreed to, update DB and session
            if ($GLOBALS['User']->UpdateUserColumn($_SESSION['uid'], 'code_of_conduct', 1))
            {
              // DB was updated, cache was cleared. Now update session
              $_SESSION['code_of_conduct'] = 1;
              header('Location: //'.DOMAIN.'/signup/4');
              exit;
            }
            else
            {
              // unknown error saving cc
              header('Location: //'.DOMAIN.'/signup/3/uknownerror');
              exit;
            
            }
          }
        }
        
      break;
      
      case 4:
        // liability waiver
        // require a session
        
        if (!$_SESSION)
        {
            // redirect to get one
            header('Location: //'.DOMAIN.'/login/required');
            exit;
        }

        if (isset($_GET['state']))
        {
          if ($_GET['state'] == 'submit')
          {
          
            if (!isset($_POST['waiver_name']))
            {
              // Name wasnt entered
              header('Location: //'.DOMAIN.'/signup/4/incomplete');
              exit;
            }
            
            // makes the assumption a full name is more than 4 letters
            if (strlen($_POST['waiver_name']) < 5)
            {
              // Name is too short
              header('Location: //'.DOMAIN.'/signup/4/invalidname');
              exit;
            }

            // code of conduct was agreed to, update DB and session
            if ($GLOBALS['User']->UpdateUserColumn($_SESSION['uid'], 'liability_waiver', $_POST['waiver_name']))
            {
              // DB was updated, cache was cleared. Now update session
              $_SESSION['liability_waiver'] = addslashes($_POST['waiver_name']);
              header('Location: //'.DOMAIN.'/signup/5');
              exit;
            }
            else
            {
              // unknown error saving cc
              header('Location: //'.DOMAIN.'/signup/4/uknownerror');
              exit;
            
            }
          }
        }        
        
      break;
      
      case 5:
        // profile info
        // require a session
        if (!$_SESSION)
        {
            // redirect to get one
            header('Location: //'.DOMAIN.'/login/required');
            exit;
        }
        
        // was the form submitted?
        if (isset($_GET['state']))
        {
          // yes, was it submitted by facebook due to user authorizing our app?
          if ($_GET['state'] == 'auth')
          {
            if (isset($_GET['error_reason']))
            {
              if ($_GET['error_reason'] == 'user_denied')
              {
                  header('Location: //'.DOMAIN.'/signup/5/denied');
                  exit;
              }
              
            }
            
            // user is authing app so lets try and get their ID
            if (isset($_GET['code']))
            {
                try
                {
                  $code = $_GET['code'];
                  // feed this code back to FB to get a token key for user
                  $uri = 'https://graph.facebook.com/oauth/access_token?client_id='.FB_APP_ID.'&redirect_uri=http://muzombies.org/oauth/init&client_secret='.FB_SECRET.'&code='.$code;
                  $json_decode = false;               
                  $return = $GLOBALS['Curl']->GetContents($uri, $json_decode);                  
                }
                catch (Exception $e)
                {
                  header('Location: //'.DOMAIN.'/signup/5/uknownerror');
                  exit;
                }

                // now we have an access token for the user. Make a call to FB and get their uid
                try
                {
                  $uri = 'https://graph.facebook.com/me?'.$return;          
                  $return = $GLOBALS['Curl']->GetContents($uri);
                }
                catch (Exception $e)
                {
                  header('Location: //'.DOMAIN.'/signup/5/uknownerror');
                  exit;
                }
                
                // finally have a uid to store into the DB
                $fb_id = $return['id'];
                $name = $return['name'];
                
                // Check and see if this UID already exists in the database. If so, return an error
                if ($GLOBALS['User']->CheckFacebookUserExists($fb_id))
                {
                  header('Location: //'.DOMAIN.'/signup/5/fbexists');
                  exit;
                }
                
                if (($GLOBALS['User']->UpdateUserColumn($_SESSION['uid'], 'fb_id', $fb_id)) && ($GLOBALS['User']->UpdateUserColumn($_SESSION['uid'], 'name', $name)))
                {
                  // Update the forum with username
                  $GLOBALS['User']->UpdateForumUserColumn($_SESSION['uid'], 'Name', $name);
                  // Update the forum with picture URL since they are using FB
                  $GLOBALS['User']->UpdateForumUserColumn($_SESSION['uid'], 'Photo', 'https://graph.facebook.com/'.$fb_id.'/picture');
                
                  if (!$GLOBALS['User']->MarkUserApproved($_SESSION['uid']))
                  {
                    // Some sort of error saving to the db...
                    header('Location: //'.DOMAIN.'/signup/5/uknownerror');
                    exit;
                  }

                  if (!$GLOBALS['User']->UpdateUserColumn($_SESSION['uid'], 'using_fb', 1))
                  {
                    // Some sort of error saving to the db...
                    header('Location: //'.DOMAIN.'/signup/5/uknownerror');
                    exit;
                  }
                  
                  if (!$GLOBALS['User']->UpdateUserColumn($_SESSION['uid'], 'approved', 1))
                  {
                    // Some sort of error saving to the db...
                    header('Location: //'.DOMAIN.'/signup/5/uknownerror');
                    exit;
                  }
            
                  // DB was updated, cache was cleared. Now update session
                  $_SESSION['fb_id'] = $fb_id;
                  $_SESSION['using_fb'] = 1;
                  $_SESSION['name'] = $name;
                  $_SESSION['approved'] = 1;
                  header('Location: //'.DOMAIN.'/signup/6');
                  exit;


                }
                else
                {
                  // unknown error saving
                  header('Location: //'.DOMAIN.'/signup/5/uknownerror');
                  exit;
                }
                
            }
            else
            {
              // state was passed as auth but no "code" string from fb was found
              header('Location: //'.DOMAIN.'/signup/5/uknownerror');
              exit;
            }
            
          }
          
          // form was submitted, was is due to a manually form upload?
          if ($_GET['state'] == 'save')
          {
            // form was submitted. First thing is to check if a photo was sent
            // if not, it means user didnt upload one or it got size-blocked by server
            if (count($_FILES) == 0)
            {
              //no image uploadsd
              header('Location: //'.DOMAIN.'/signup/5/invalidphoto');
              exit;
            }
            
            if (!is_uploaded_file($_FILES['photo']['tmp_name']))
            {
              // bad file uploaded
              header('Location: //'.DOMAIN.'/signup/5/invalidphoto');
              exit;
            }
            
            // file was uploaded, see if user gave us a name
            if (!isset($_POST['name']))
            {
              header('Location: //'.DOMAIN.'/signup/5/invalidname');
              exit;
            }
            
            if (strlen($_POST['name']) < 4)
            {
              header('Location: //'.DOMAIN.'/signup/5/invalidname');
              exit;
            }
            
            // check and see if the user uploaded an IMAGE file
            $acceptable_filetypes = "/^\.(jpg|jpeg|gif|png|JPG|JPEG|GIF|PNG){1}$/i"; 
            $safe_filename = preg_replace(array("/\s+/", "/[^-\.\w]+/"), array("_", ""), trim($_FILES['photo']['name']));
            if (!preg_match($acceptable_filetypes, strrchr($safe_filename, '.')))
            {
              header('Location: //'.DOMAIN.'signup/5/invalidphoto');
              exit;
            }
            
            // we can start processin now. This converts and saves the picture appropriately
            // facebook photos are usually max 200x600, we try to match that
            $GLOBALS['User']->ConvertUploadedPhoto(DOCUMENT_ROOT.'/www/img/user/', 200, 600, 'u'.$_SESSION['uid'].'.jpg', 'u'.$_SESSION['uid'].'.jpg', true, DOCUMENT_ROOT.'/www/img/user/thumb/', 4);

            // Update the forum with picture URL since they did it manually
            $GLOBALS['User']->UpdateForumUserColumn($_SESSION['uid'], 'Photo', 'http://'.DOMAIN.'/img/user/u'.$_SESSION['uid'].'.jpg');
            
            // file is uploaded, update appropriate user database columns
            if (!$GLOBALS['User']->UpdateUserColumn($_SESSION['uid'], 'using_fb', 0))
            {
              // Some sort of error saving to the db...
              header('Location: //'.DOMAIN.'/signup/5/uknownerror');
              exit;
            }
            
            if (!$GLOBALS['User']->UpdateUserColumn($_SESSION['uid'], 'approved', 0))
            {
              // Some sort of error saving to the db...
              header('Location: //'.DOMAIN.'/signup/5/uknownerror');
              exit;
            }
            
            if (!$GLOBALS['User']->MarkUserApprovalPending($_SESSION['uid']))
            {
              // Some sort of error saving to the db...
              header('Location: //'.DOMAIN.'/signup/5/uknownerror');
              exit;
            }
            
            if (!$GLOBALS['User']->UpdateUserColumn($_SESSION['uid'], 'name', $_POST['name']))
            {                  
              // Some sort of error saving to the db...
              header('Location: //'.DOMAIN.'/signup/5/uknownerror');
              exit;
            }

            // go ahead and update the forum with the new user name. In the case it is denied by
            // an admin, the user will be prompted to give a new name which will overwrite the old one.
            // Additionally, the user cannot post on the forums until their account is approved.
            $GLOBALS['User']->UpdateForumUserColumn($_SESSION['uid'], 'Name', $_POST['name']);
              
            $_SESSION['name'] = addslashes($_POST['name']);
            $_SESSION['using_fb'] = 0;
            $_SESSION['approved'] = 0;
            header('Location: //'.DOMAIN.'/signup/5/pending');
            exit;
            
          }
          
        }
        else
        {
          if (!$_SESSION['approved'] && !$GLOBALS['User']->UserApproved($_SESSION['uid']))
          {
            // not approved in user table (which could still be the default "not approved" state)
            // and not approved based on user_approval table which means they exist in that table
            // so redirect them to pending approval page
            header('Location: //'.DOMAIN.'/signup/5/pending');
            exit;
          }
          
          if ($_SESSION['approved'] && $GLOBALS['User']->UserApproved($_SESSION['uid']))
          { 
            header('Location: //'.DOMAIN.'/signup/6');
            exit;
          }
        }
        
      break;
      
      default:
      break;
      
    }
  }
  
?>

<!DOCTYPE html>


<html>

<head>

<?php
  require 'module/html_head.php';
?>
  
  <link href="//<?php echo DOMAIN; ?>/css/page/signup.css" rel="stylesheet" type="text/css"/>
  <link href="//<?php echo DOMAIN; ?>/css/fb.css" rel="stylesheet" type="text/css"/>
  
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
                     
          <div id="signup_container">
          
            <?php
              // Need to show the appropriate step to the user
              // 1: Create an account using email and password+confirmation
              // 2: Confirm email address
              // 3: Code of conduct (I agree / disagree)
              // 4: Liability release (signed)
              // 5: Connect with Facebook
              // 6: Misc Info (Phone nuber registration?)
              
              if (isset($_GET['step']))
              {
                $step = $_GET['step'];
              }
              else
              {
                $step = 1;
              }
              
              
              switch ($step)
              {
                case 1:
                  require 'module/signup_create.php';
                break;

                case 2:
                  require 'module/signup_email_confirm.php';
                break;
                                
                case 3:
                  require 'module/signup_code_of_conduct.php';
                break;
                
                case 4:
                  require 'module/signup_liability_waiver.php';
                break;
                
                case 5:
                  require 'module/signup_profile.php';
                break;
                
                case 6:
                  require 'module/signup_misc.php';
                break;
                
                default:
                  require 'module/signup_create.php';
                break;
                
              }
              
            ?>
            
          </div>
        
          <div id="signup_process_container">
            <?php
              require 'module/signup_process.php';
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