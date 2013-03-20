<?php

  $page_title = 'Admin';
  $require_login = true;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';
  
  /*
  if (!isset($_GET['state']))
    $_GET['state'] = null;
` */

  // Define the admin views
  $views = array('playerlist',
                  'userapproval',
                  'gameplay',
                  'email',
                  'game');

  if (!isset($_GET['view']))
  {
    $_GET['view'] = $views[0];
  }
             
  // Check user is an admin, and that they have privledges for the view they're on (all admins get to see playerlist)
  if (!$_SESSION['admin'])
  {
    header('Location: //'.DOMAIN);
    exit;
  }
  
  if ($_GET['view'] == '' || ($_GET['view'] != 'playerlist' && !$GLOBALS['Misc']->StringWithin($_GET['view'], $_SESSION['privileges'])))
  {
    header('Location: //'.DOMAIN);
    exit;
  }
  
  // Specific details for the views
  // get number of pending users
  $users_to_approve = $GLOBALS['User']->GetUsersToApprove();
  $users_to_approve_count = count($users_to_approve);
  
?>

<!DOCTYPE html>


<html>

<head>

<?php
  require 'module/html_head.php';
?>
  
  <link href="//<?php echo DOMAIN; ?>/css/page/admin.css" rel="stylesheet" type="text/css"/>
  <link href="//<?php echo DOMAIN; ?>/css/fb.css" rel="stylesheet" type="text/css"/>
  <link href="//<?php echo DOMAIN; ?>/css/page/playerlist.css" rel="stylesheet" type="text/css"/>

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
                     
          <div id="admin_container">
          
            <?php
              
              switch ($_GET['view'])
              {
                case 'playerlist':
                  require 'module/admin_playerlist.php';
                break;

                case 'accounts':
                  require 'module/admin_accounts.php';
                break;
                
                case 'userapproval':
                  require 'module/admin_userapproval.php';
                break;

                case 'gameplay':
                  require 'module/admin_gameplay.php';
                break;
                
                case 'email':
                  require 'module/admin_email.php';
                break;
                
                case 'game':
                  require 'module/admin_game.php';
                break;

                default:
                  require 'module/admin_playerlist.php';
                break;
                
              }
              
            ?>
            
          </div>
        
          <div id="admin_tool_container">
            <?php
              require 'module/admin_tools.php';
            ?>
          </div> <!-- admin_tool_container -->
          
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