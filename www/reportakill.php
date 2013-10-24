<?php

  $page_title = 'Report a Kill';
  $require_login = true;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';
  
  $message = '';
  $error = false;
  $is_zombie = false;
  
  if ($GLOBALS['state'])
  {
    
    if ($GLOBALS['state']['active'])
    {
      $user_game = $GLOBALS['User']->GetUserFromGame($_SESSION['uid'], $GLOBALS['state']['gid']);
      if ($user_game['status'] == 'zombie' || $user_game['oz'])
      {
      
        // user is a zombie
        $is_zombie = true;
        
        if (isset($_GET['submit']) && $_GET['submit'] == 'true' && isset($_POST['secret']))
        {
          if ($GLOBALS['User']->RateLimit(1))
          {
            // check and see if the id is valid
            $checkIsHuman = true;
            $check = $GLOBALS['Game']->CheckSecretValid($GLOBALS['state']['gid'], $_POST['secret'], $checkIsHuman);
            
            if ($check[0])
            {
              // All is okay, go ahead and register the kill
              $zombie = '';
              $targetSecret = '';
              $feed1 = '';
              $feed2 = '';
              $location_x = '';
              $location_y = '';
              
              $zombie = $_SESSION['uid'];
              $targetSecret = $_POST['secret'];
              
              if (isset($_POST['feed1']))
                $feed1 = $_POST['feed1'];
              if (isset($_POST['feed2']))
                $feed2 = $_POST['feed2'];
              if (isset($_POST['location_x']) && isset($_POST['location_y']))
              {
                $location_x = $_POST['location_x'];
                $location_y = $_POST['location_y'];
              }
                
              $GLOBALS['Game']->RegisterKill($GLOBALS['state']['gid'], $zombie, $targetSecret, $feed1, $feed2, $location_x, $location_y);
              $error = false;
            }
            else
            {
              $error = true;
            }
 
            $message = $check[1];
          }
          else
          {
            // rate check failed
            $error = true;
            $message = 'Please slow down. Try again in a few minutes.';
          }
        }
      }
      else
      {
        $is_zombie = false;
        $error = true;
        $message = 'You must be marked as a zombie to enter tags.';
      }
    }
    else
    {

      // Game isnt active
      header('Location: //'.DOMAIN);
      exit;

    }
    
    $playerCounts = $GLOBALS['Game']->GetBrokenDownPlayerCount($GLOBALS['state']['gid']);
    
  }
  else
  {
    // Fallback, game doesnt exist
    header('Location: //'.DOMAIN);
    exit;
  }
  
?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/countdown.css" rel="stylesheet" type="text/css"/>
  <link href="//<?php echo DOMAIN; ?>/css/page/reportakill.css" rel="stylesheet" type="text/css"/>
  
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

        <div id="body_content">

          <?php 
            if ($GLOBALS['state'] && $GLOBALS['state']['countdown'])
            {
              require 'module/countdown.php';
            }
          ?>

          <div id="reportakill_container">
          
            <div class="reportakill_title">
              Report a <span class="accent_color">Kill</span>
            </div>

            <?php if ((isset($_GET['submit']) && $_GET['submit'] == 'true') || $error): ?>
            <div class="reportakill_header <?php if ($error) echo "reportakill_error"; elseif (!$error) echo "reportakill_message"; ?>">
              <p><?php echo $message; ?></p>
            </div>
            <?php endif ?>
            
            <div class="reportakill_header">
              <p>As a zombie, it is your task to feed on humans by tagging them. Every human you tag will hand you their secret game ID card which is a code to enter below. Entering a Human's Secret Game ID below will turn that player into a zombie on the website.</p>
            </div>
                       
            <div class="reportakill_header">
              <p>Remember, every zombie must feed once every 48 hours otherwise they starve. You can share your kill with two other zombies to reset their feed timers. If the secret game ID you received does not work, contact a moderator. Secret Game IDs are <span class="bold">not</span> case sensitive.</p>
            </div>

            <div class="reportakill_header">
              <p>Optionally you may include where the kill occured. We may use this data at the end of the game to make an interesting kill "heat map".</p>
            </div>
            
            <div class="reportakill_content">

              <?php
                if ($is_zombie)
                {
                  require 'module/reportakill_form.php';
                }
              ?>

            </div>
          
          </div> <!-- body_container -->
          
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
