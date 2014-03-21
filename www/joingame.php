<?php

  $page_title = 'Join a Game';
  $require_login = true;
  $require_complete_account = true;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';
  
  $games = $GLOBALS['Game']->GetJoinable();
  
  $join_success    = false;
  $ozoptin_success = false;
  $valid_game      = false;
  $already_joined  = false;
  $game_id         = false;
 
  if (isset($_GET['join']) && !isset($_GET['ozoptin']))
  {
    foreach ($games as $game)
    {
      if ($game['gid'] == $_GET['join'])
      {
        if ($game['registration_open'])
        {
          $valid_game = true;
          $game_id = $_GET['join'];
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
      if ($xref['gid'] === $game_id) {
        $already_joined = true;
        $joined_game = $GLOBALS['Game']->GetGame($_GET['join']);
        $secret = $xref['secret'];
      }
    }
  }

  if ($valid_game && !$already_joined)
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
      $body = "Hello,<br>Your ".UNIVERSITY." HvZ account succesfully joined the {$joined_game['name']} game. Your Secret Game ID for this game is: $secret<br>Write down this Secret Game ID and your full name on two index cards and carry these cards with you at all times! If you are unfamiliar with the rules, please read <a href='http://".DOMAIN."/rules'>them</a> and make sure to come to an orientation session.<br>Orientation times and dates are posted on the website <a href='http://".DOMAIN."/orientations'>here</a> <br>You must attend at least one orientation! These will aquaint you with rules, gameplay, and more. Please email the moderators if you cannot attend any of the orientations.<br>";

      $footer = true;
      $bcc = false;
      $opt = array('o:campaign' => 'gj',); 
      $GLOBALS['Mail']->Resubscribe($to);
      $GLOBALS['Mail']->SimpleMail($to, $subject, $body, $footer, $bcc, $opt);
      
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
              elseif (isset($_GET['join']) && ($join_success || $already_joined))
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
