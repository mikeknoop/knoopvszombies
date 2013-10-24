<?php

  $page_title = 'Squads';
  $require_login = true;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';
  
  $message = '';
  $error = false;

  if (isset($_GET['action']) && $_GET['action'] == 'submit' && isset($_POST['squad_name']))
  {
    // cap to 30 chars
    $squad_name = addslashes(substr(strip_tags($_POST['squad_name']), 0, 30));
    // Update user database column
    $GLOBALS['User']->UpdateUserColumn($_SESSION['uid'], 'squad_name', $squad_name);
    
    // update session
    $_SESSION['squad_name'] = $squad_name;
    
    $message = 'Your Squad was successfully updated.';
  }
  
?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/page/squad.css" rel="stylesheet" type="text/css"/>
  
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

          <div id="squad_container">
          
            <div class="squad_title">
              Edit your <span class="accent_color">Squad</span>
            </div>

            <?php if ((isset($_GET['action']) && $_GET['action'] == 'submit') || $error): ?>
            <div class="squad_header <?php if ($error) echo "squad_error"; elseif (!$error) echo "squad_message"; ?>">
              <p><?php echo $message; ?></p>
            </div>
            <?php endif ?>
            
            <div class="squad_header">
              <p>Until the squad system is built out, you may use the simple form below to let everyone know what squad you are in. Your squad shows up next to your name in various places on the website.</p>
              <br />
              <p>There is a 30 character limit on your squad name.</p>
            </div>
            
            <div class="squad_content">

             <form id="squad" name="squad" action="//<?php echo DOMAIN; ?>/squad/submit" method="POST">

              <div class="squad_row">
                <div class="squad_label">
                  Squad Name:
                </div>
                          
                <div class="squad_form">
                    <input maxlength="30" type="text" name="squad_name" value="<?php echo $_SESSION['squad_name']; ?>" class="squad_form_input" />
                </div>
                <div class="clearfix"></div>
              </div>
                           
              <div class="squad_row">
                <div class="squad_label">
                  &nbsp
                </div>
                          
                <div class="squad_form">
                    <input type="submit" value="Save Changes" class="squad_form_submit" />
                </div>
                <div class="clearfix"></div>
              </div>
              
            </form>

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
