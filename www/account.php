<?php

  $page_title = 'Account';
  $require_login = true;
  $require_complete_account = true;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';
  
  $viewing_self = false;
  
  if (isset($_GET['id']) && $_GET['id'] == $_SESSION['uid'])
  {
    unset($_GET['id']);
  }
  
  if (isset($_GET['id']))
  {
    if ($GLOBALS['User']->IsValidUser($_GET['id']))
    {
      $viewing_self = false;
      $user = $GLOBALS['User']->GetUser($_GET['id']);
      $historical = $GLOBALS['User']->GetHistorical($_GET['id']);
    }
    else
    {
      $user = $_SESSION;
      $viewing_self = true;
      $historical = $GLOBALS['User']->GetHistorical($_SESSION['uid']);
      $secret = $GLOBALS['Game']->GetSecret($GLOBALS['state']['gid'], $user['uid']);
    }
  }
  else
  {
    $user = $_SESSION;
    $viewing_self = true;
    $historical = $GLOBALS['User']->GetHistorical($_SESSION['uid']);
    if ($GLOBALS['User']->IsPlayingCurrentGame($user['uid']) && $GLOBALS['state'])
    {
      $secret = $GLOBALS['Game']->GetSecret($GLOBALS['state']['gid'], $user['uid']);
    }
  }
  
  // Do some processing to get displayable values for this page
    $view_date_created = date("F Y", $user['created']);
    $view_squad = '';

    // If user is in a game, we need to add historical to current game stats
    $view_active = 'No';
    if ($GLOBALS['User']->IsPlayingCurrentGame($user['uid']) && $GLOBALS['state'])
    {
      //$game = $GLOBALS['Game']->GetGame($GLOBALS['state']['gid']);
      $game_xref = $GLOBALS['User']->GetUserFromGame($user['uid'], $GLOBALS['state']['gid']);
      $view_active = 'Yes';
    }
    elseif ($_SESSION)
    {
      if ($_SESSION['uid'] == $user['uid'])
      $view_active = 'No (<a class="accent_color" href="//'.DOMAIN.'/joingame">Join a Game</a>)';
    }

		// OZ Pool
		$show_oz_pool = false;
		$in_oz_pool = false;
		if ($viewing_self && $GLOBALS['User']->IsPlayingCurrentGame($user['uid']) && $GLOBALS['state']) {
			$show_oz_pool = true;
			$oz_pool = $GLOBALS['Game']->GetOZPool($GLOBALS['state']['gid']);
			if (is_array($oz_pool)) {
				foreach ($oz_pool as $oz) {
					if ($oz['uid'] == $user['uid']) {
						$in_oz_pool = true;
					}
				}
			}
			if ($in_oz_pool) {
				$oz_pool_status = 'Yes (<a class="accent_color" href="//'.DOMAIN.'/toggleozpool">Toggle</a>)';
			} else {
				$oz_pool_status = 'No (<a class="accent_color" href="//'.DOMAIN.'/toggleozpool">Toggle</a>)';
			}
    }
    
    if (isset($historical['zombie_kills']))
      $view_zombie_kills = $historical['zombie_kills'];
    else
      $view_zombie_kills = 0;
      
    if (isset($game_xref))
    {
      // only add current kills if the game is not archived and is set current
      // otherwise kills and timealive get double counted when game is archived but no new one has been created yet.
      if ($GLOBALS['state'] && !$GLOBALS['state']['archive'] && $GLOBALS['state']['current'])
      {
        // if the person is an oz and oz hidden, dont add their kills
        if ($GLOBALS['state'] && (($GLOBALS['state']['oz_hidden'] && !$game_xref['oz']) || !$GLOBALS['state']['oz_hidden']))
        {
          $view_zombie_kills = $view_zombie_kills + $game_xref['zombie_kills'];
        }
      }
    }
    
    if (isset($historical['time_alive']))
    {
      $ta_totaltime = $historical['time_alive'];
    }
    else
    {
      $ta_totaltime = 0;
    }
    
    $curr_totaltime = 0;
    if (isset($game_xref))
    {
      if ($GLOBALS['state'] && $GLOBALS['state']['active'] && !$GLOBALS['state']['archive'] && $GLOBALS['state']['current'])
      {
        // Three cases:
        // 1. Player is an OZ
        // 2. Player is now a zombie or deceased
        // 3. Player is still a human
        if ($game_xref['oz'])
        {
          // Two cases:
          // 1. OZs are hidden
          // 2. OZs are NOT hidden
          if ($GLOBALS['state']['oz_hidden'])
          {
            // Fake add up their time so people think they are human
            $curr_totaltime = date("U") - $GLOBALS['state']['start_time'];
          }
          else
          {
            // Okay now they are like a regular zombie, add up their time
            // (ie, do not add up their time. They were never alive this game)
          }
        }
        elseif ($game_xref['status'] == 'zombie' || $game_xref['status'] == 'deceased')
        {
          $curr_totaltime = $game_xref['zombied_time'] - $GLOBALS['state']['start_time'];
        }
        elseif ($game_xref['status'] == 'human')
        {
          $curr_totaltime = date("U") - $GLOBALS['state']['start_time'];
        }
      }
      
    // Add up the current game time with the historical time
    $ta_totaltime = $ta_totaltime + $curr_totaltime;
    }
    
    $ta_days = floor($ta_totaltime / (60*60*24));
      if ($ta_totaltime - (60*60*24*$ta_days) >= 0)
      $ta_totaltime = $ta_totaltime - (60*60*24*$ta_days);

    $ta_hours = floor($ta_totaltime / (60*60));
      if ($ta_totaltime - (60*60*$ta_hours) >= 0)
      $ta_totaltime = $ta_totaltime - (60*60*$ta_hours);

    $ta_minutes = floor($ta_totaltime / (60));
    
    if ($ta_days >= 0)
      $view_time_alive = "$ta_days days, $ta_hours hours and $ta_minutes minutes";
    else
      $view_time_alive = "0 days, 0 hours and 0 minutes";
    
    if ($user['using_fb'])
    {
      $view_account_img_src = '//graph.facebook.com/'.$user['fb_id'].'/picture?type=large';
    }
    else
    {
      $view_account_img_src = '//'.DOMAIN.'/img/user/u'.$user['uid'].'.jpg';
    }
    
    if ($user['squad_name'] == '')
    {
      $squad = '(none)';
    }
    else
    {
      $squad = $user['squad_name'];
    }
    
?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/page/account.css" rel="stylesheet" type="text/css"/>
  
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

          <div id="account_picture">
            <img src="<?php echo $view_account_img_src ?>" />
          </div>
                    
          <div id="account_container">
            <div id="account_title">
                <?php echo $user['name']; ?> <?php if ($_SESSION['admin']) echo '('.$user['uid'].')'; ?> <?php if ($user['using_fb']) echo '<a class="accent_color" href="//www.facebook.com/profile.php?id='.$user['fb_id'].'">(View Facebook Profile)</a>'; ?>
            </div>

            <div class="account_content">
              
              <?php require 'module/account_overview.php'; ?>
              
            </div>

          </div> <!-- account_container -->  

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