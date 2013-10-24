<?php

  $page_title = 'Join a Game';
  $require_login = true;
  $require_complete_account = true;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';
  
  $games = $GLOBALS['Game']->GetJoinable();
  $join_success = false;
  $ozoptin_success = false;
  $valid_game = false;
  
  if (isset($_GET['join']) && !isset($_GET['ozoptin']))
  {
    foreach ($games as $game)
    {
      if ($game['gid'] == $_GET['join'])
      {
        if ($game['registration_open'])
        {
          $valid_game = true;
        }
      }
    }
  }

  $game_xref = $GLOBALS['User']->GetUserGameXrefAll($_SESSION['uid']);
  $user_joined_game = array();
  if (is_array($game_xref))
  {
    foreach ($game_xref as $xref)
    {
      $user_joined_game[$xref['gid']] = true;
    }
  }

  if ($valid_game)
  {
    $secret = $GLOBALS['Game']->GenerateSecret($_GET['join']);
    if ($GLOBALS['User']->JoinGame($_GET['join'], $_SESSION['uid'], $secret))
    {
      $joined_game = $GLOBALS['Game']->GetGame($_GET['join']);
      $join_success = true;
      $_SESSION['active_game'] = '1';
      
      // Mail user at email address
      $to = $_SESSION['email'];
      $subject = "".UNIVERSITY." HvZ Game Joined";
      $body = "Hello,\n\rYour ".UNIVERSITY." HvZ account succesfully joined the {$joined_game['name']} game. Your Secret Game ID for this game is: $secret\n\rWrite down this Secret Game ID and your full name on an index card and carry this card with you at all times! If you are unfamiliar with the rules, please read http://".DOMAIN."/rules and make sure to come to an orientation session.\n\rOrientation times and dates are posted on the website at http://".DOMAIN."/rules \nYou must attend at least one orientation! These will aquaint you with rules, gameplay, and more. Please email the moderators if you cannot attend any of the orientations.\r";

      $GLOBALS['Mail']->SimpleMail($to, $subject, $body);
      
    }
  }
  
  if (isset($_GET['ozoptin']) && isset($_GET['join']))
  {
    if ($GLOBALS['Game']->AddToOzPool($_GET['join'], $_SESSION['uid']))
    {
      $ozoptin_success = true;
      $joined_game = $GLOBALS['Game']->GetGame($_GET['join']);
    }
  }
  
?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/page/joingame.css" rel="stylesheet" type="text/css"/>
  
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

          <div id="joingame_container">

            <?php
              if (isset($_GET['join']) && $ozoptin_success)
              {
                require 'module/joingame_ozoptin.php';
              }
              elseif (isset($_GET['join']) && $join_success)
              {
                require 'module/joingame_join.php';
              }
              else
              {
                require 'module/joingame_list.php';
              }
            ?>

          </div> <!-- joingame_container -->  

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
