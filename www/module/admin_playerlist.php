<?php if (isset($_GET['action']) && ($_GET['action'] == 'edit' || $_GET['action'] == 'save') && isset($_GET['target']) && $_GET['target'] != ''): ?>

  <?php
    if (!$GLOBALS['User']->IsValidUser($_GET['target']))
    {
      exit;
    }
   
    if ($_GET['action'] == 'save')
    {
    
      $user = $GLOBALS['User']->GetUser($_GET['target']);
      $user_game = $GLOBALS['User']->GetUserFromGame($_GET['target'], $GLOBALS['state']['gid']);
      
      // validate and save the user form
      $save = array();
      $email_changes = array();
 
      
      // Special validation cases //
      
      if (isset($_POST['oz_pool']) && $_POST['oz_pool'] == 'on')
      {
        $_POST['oz_pool'] = '1';
      }
      else
      {
        $_POST['oz_pool'] = '0';
      }  

      if (isset($_POST['attended_orientation']) && $_POST['attended_orientation'] == 'on')
      {
        $_POST['attended_orientation'] = '1';
      }
      else
      {
        $_POST['attended_orientation'] = '0';
      }  
      
      if ($_POST['status'] == 'human')
      {
        // When setting to a human, make sure we clear out zombie fields
        $_POST['zombie_killed_by'] = '0';
        $_POST['zombied_time'] = '0000-00-00 00:00:00';
        $_POST['zombie_feed_timer'] = '0000-00-00 00:00:00';
        
        if ($user_game['oz'])
        {
          // user is an OZ, need to mark them not an OZ
          $GLOBALS['Game']->RemoveOZ($GLOBALS['state']['gid'], $user['uid']);
        }
      }
      
      if ($_POST['status'] == 'zombie')
      {
      
        $test_value = strtotime($_POST['zombie_feed_timer']);
        if (!$test_value)
        {
          $_POST['zombie_feed_timer'] = date('Y-m-d H:i:s');
        }
        
        $test_value = strtotime($_POST['zombied_time']);
        if (!$test_value)
        {
          $_POST['zombied_time'] = date('Y-m-d H:i:s');
        }
        
      }

      // General validation
      if (is_array($_POST))
      {
        foreach ($_POST as $key => $value)
        {
          switch ($key)
          {
            case 'status':
              if ($value == 'human' || $value == 'zombie' || $value == 'deceased')
              {
                $save[$key] = $value;
                if ($user_game[$key] != $value)
                {
                  $email_changes['Status'] = $value;
                  
                  // Need to update this persons status role on the forums
                  switch ($value)
                  {
                    case "human":
                      $GLOBALS['User']->AddForumRoleHuman($user['uid']);
                      break;
                    
                    case "zombie":
                      $GLOBALS['User']->AddForumRoleZombie($user['uid']);
                      break;
                    
                    case "deceased":
                      $GLOBALS['User']->RemoveStatusForumRoll($user['uid']);
                      break;
                  }
                  
                  
                }
              }
              break;
              
            case 'zombie_kills':
              if (is_numeric($value))
              {
                $save[$key] = $value;
                if ($user_game[$key] != $value)
                  $email_changes['Zombie Kills'] = $value;
              }
              break;
              
            case 'zombie_killed_by':
              if ($GLOBALS['User']->IsValidUser($value))
              {
                $save[$key] = $value;
                $killed_by_user = $GLOBALS['User']->GetUser($value);
                if ($user_game[$key] != $value)
                  $email_changes['Killed By'] = $killed_by_user['name'];
              }
              elseif ($value == '0')
              {
                $save[$key] = $value;
                if ($user_game[$key] != $value)
                  $email_changes['Killed By'] = '(no one)';
              }
              break;
              
            case 'zombied_time':
              
              if ($value != '0000-00-00 00:00:00')
              {
                $test_value = strtotime($value);
                if ($test_value)
                {
                  $save[$key] = $test_value;                
                    if ($user_game[$key] != $test_value)
                      $email_changes['Killed Time'] = date('Y-m-d H:i:s', $test_value);
                }
              }
              if ($value == '0000-00-00 00:00:00')
              {
                $save[$key] = '0';
                  if ($user_game[$key] != '0')
                    $email_changes['Killed Time'] = '(no kill time)';
              }
              break;
              
            case 'zombie_feed_timer':
              
              if ($value != '0000-00-00 00:00:00')
              {
                $test_value = strtotime($value);
                if ($test_value)
                {
                  $save[$key] = $test_value;
                    if ($user_game[$key] != $test_value)
                      $email_changes['Last Feed Time'] = date('Y-m-d H:i:s', $test_value);
                }
              }
              elseif ($value == '0000-00-00 00:00:00')
              {
                $save[$key] = '0';
                  if ($user_game[$key] != '0')
                    $email_changes['Last Feed Time'] = '(no feed time)';
              }
              break;
              
            case 'new_secret':
              if ($value == 'on')
              {
                $new_secret = $GLOBALS['Game']->GenerateSecret($GLOBALS['state']['gid']);
                $save['secret'] = strtolower($new_secret);
                $save['old_secret'] = $user_game['old_secret'].$user_game['secret'];
                $email_changes['Secret Game ID'] = $new_secret;
              }
              break;
            
            case 'oz_pool':
              $save[$key] = $value;
              if ($user_game[$key] != $value)
              {
                if ($value)
                {
                  $email_changes['In Oz Pool'] = 'Yes';
                }
                else
                {
                  $email_changes['In Oz Pool'] = 'No';
                }
              }
              break;

            case 'attended_orientation':
              $save[$key] = $value;
              if ($user_game[$key] != $value)
              {
                if ($value)
                {
                  $email_changes['Attended Orientation'] = 'Yes';
                }
                else
                {
                  $email_changes['Attended Orientation'] = 'No';
                }
              }
              break;
          }
        }
      }

      $saved = array();
      foreach ($save as $key => $value)
      {
        // $save is sanitized, validated input
        if ($user_game[$key] != $value)
        {
          $GLOBALS['User']->UpdateUserGameColumn($GLOBALS['state']['gid'], $user['uid'], $key, addslashes($value));
          $saved[$key] = $value;
        }
      }
      
      if (count($saved) > 0 )
      {
        // Mail user at email address
        $to = $user['email'];
        $subject = "".UNIVERSITY." HvZ Game Account Updated";
        $body = "Hello,\rYour ".UNIVERSITY." HvZ game account information was recently modified by a moderator. If you are unsure why or think this is a mistake, please email a moderator.\nThe following changes were made:\n\r";
        
        foreach ($email_changes as $key => $value)
        {
          $body .= "$key: $value\n";
        }
        $body .= "\nYou can log into your account to further review the changes and see them live on the website.\r";
                 
        $GLOBALS['Mail']->SimpleMail($to, $subject, $body, false);
        
      }
    }  
   
    $user = $GLOBALS['User']->GetUser($_GET['target']);
    $user_game = $GLOBALS['User']->GetUserFromGame($_GET['target'], $GLOBALS['state']['gid']);
  
  ?>

  <div id="admin_title">
  Edit Player <span class="accent_color">(<a class="accent_color" href="http://<?php echo DOMAIN; ?>/account/<?php echo $user['uid']; ?>"><?php echo $user['name'] ?></a>) (<?php echo $user['uid'] ?>)</span>
  </div>
  
  <?php if ($_GET['action'] == 'save'): ?>
  <div class="admin_status">
    The following database fields were updated: 
    <?php
      $i = 1;
      foreach ($saved as $key => $value)
      {
        echo $key;
        if ($i < count($saved))
          echo ', ';
        $i++;
      }
      
      if (count($saved) == 0)
      {
        echo '(none)';
      }
      else
      {
        echo '<br />The user has been emailed of these changes.';
      }
    ?>
  </div>
  <?php endif ?>
  
  <!--
  <div class="admin_playerlist_edit_picture">
    <?php 
      if ($user['using_fb'])
      {
        $view_account_img_src = 'http://graph.facebook.com/'.$user['fb_id'].'/picture?type=large';
      }
      else
      {
        $view_account_img_src = '//'.DOMAIN.'/img/user/u'.$user['uid'].'.jpg';
      }
    ?>
    <img src="<?php echo $view_account_img_src ?>" />
  </div>

  <div class="clearfix"></div>
  -->
  
  <form class="playerlist_edit_form" name="playerlist_edit_form" action="http://<?php echo DOMAIN; ?>/admin/playerlist/save/<?php echo $user['uid']; ?>" method="POST">

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Email Address:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <?php echo $user['email'] ?>
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Status:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <select name="status">
        <option value="human" <?php if ($user_game['status'] == 'human') echo 'selected'; ?>>human</option>
        <option value="zombie" <?php if ($user_game['status'] == 'zombie') echo 'selected'; ?>>zombie</option>
        <option value="deceased" <?php if ($user_game['status'] == 'deceased') echo 'selected'; ?>>deceased</option>
      </select>
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    &nbsp;
    </div>
    <div class="admin_playerlist_edit_row_form">
      Note: If you change Status to Zombie, be sure to also <br />
      update "Killed Time" and "Last Feed Time" to "Now". <br />
      Likewise, if you change Status to Human, "Clear" both.
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    OZ Pool:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="checkbox" name="oz_pool" <?php if ($user_game['oz_pool']) echo 'checked'; ?> />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Attended Orientation:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="checkbox" name="attended_orientation" <?php if ($user_game['attended_orientation']) echo 'checked'; ?> />
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Secret Game ID:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <?php echo $user_game['secret'] ?>
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Create New Secret:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="checkbox" name="new_secret" />
    </div>
    <div class="admin_playerlist_edit_row_caption">
    (Check box and press Save Changes)
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Zombie Kills:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="text" name="zombie_kills" value="<?php echo $user_game['zombie_kills']; ?>" />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Killed By:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <?php
        $playerArray = $GLOBALS['Game']->GetPlayers($GLOBALS['state']['gid'], 'all', 'name');
      ?>
      <select name="zombie_killed_by">
        <option value="0"></option>
        <?php
          if (is_array($playerArray))
          {
            foreach ($playerArray as $player)
            {
              $sel = '';
              if ($user_game['zombie_killed_by'] == $player['uid'])
                $sel = 'selected';
                
              echo "<option value='{$player['uid']}' $sel>{$player['name']} ({$player['uid']})</option>";
            }
          }       
        ?>
      </select>
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Killed Time:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input id='zombied_time_form' type="text" name="zombied_time" value="<?php if ($user_game['zombied_time'] == 0) { echo '0000-00-00 00:00:00'; } else { echo date('Y-m-d H:i:s', $user_game['zombied_time']); } ?>" />
    </div>
    <div class="admin_playerlist_edit_row_caption">
      <input class="button" type="submit" value="Now" onclick="document.getElementById('zombied_time_form').value='<?php echo date('Y-m-d H:i:s'); ?>'; return false;" />
      <input class="button" type="submit" value="Clear" onclick="document.getElementById('zombied_time_form').value='0000-00-00 00:00:00'; return false;" />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Last Feed Time:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input id='zombie_feed_timer_form' type="text" name="zombie_feed_timer" value="<?php if ($user_game['zombie_feed_timer'] == 0) { echo '0000-00-00 00:00:00'; } else { echo date('Y-m-d H:i:s', $user_game['zombie_feed_timer']); } ?>" />
    </div>
    <div class="admin_playerlist_edit_row_caption">
      <input class="button" type="submit" value="Now" onclick="document.getElementById('zombie_feed_timer_form').value='<?php echo date('Y-m-d H:i:s'); ?>'; return false;" />
      <input class="button" type="submit" value="Clear" onclick="document.getElementById('zombie_feed_timer_form').value='0000-00-00 00:00:00'; return false;" />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    &nbsp;
    </div>
    <div class="admin_playerlist_edit_row_form">
      (YYYY:MM:DD HH:MM:SS, 24hr format)
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container admin_playerlist_edit_submit_row_container">
    <div class="admin_playerlist_edit_row_label">
    &nbsp;
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input class="button" type="submit" value="Save Changes"></input> <a class="button" href="http://<?php echo DOMAIN; ?>/admin/playerlist/">Cancel</a>
    </div>
  </div>

  <!--
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
      &nbsp;
    </div>
    <div class="admin_playerlist_edit_row_form">
      &nbsp;
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    &nbsp;
    </div>
    <div class="admin_playerlist_edit_row_form">
      Note: If "Killed Time" or "Last Feed Time" is Cleared and<br />
      the player is marked as a zombie, that field will be set to "Now"<br />
      when you Save Changes.
    </div>
  </div>
  -->
  
  </form>
  
<?php else: ?>

  <div id="admin_title">
  Edit <span class="accent_color">Current Players</span>
  </div>

  <div class="admin_title">
    Orientation Tool:
  </div>
  
  <?php 
  
  $attended_orientation_save_success = false;
  $error = false;
  if(isset($_GET['action']) && $_GET['action'] == 'attendedorientation' && isset($_POST['playerlist_orientation_name']))
  {
    $attended_orientation_save_success = true;
    $player_name_attended_orientation = "test";
    $user_in = $_POST['playerlist_orientation_name'];
    
    // if user_in contains commas, it matches a choice exactly
    $user_in = explode(', ', $user_in);

    if (is_array($user_in) && count($user_in) > 1)
    {
      // all the info we need is contained in the user array    
    }
    else
    {
      // only a piece of a Name was submitted. look it up to get the rest of the info
      $user_in = $GLOBALS['User']->GetPlayerMatchesOnSearch($user_in[0], true);
      $user_in = explode(', ', $user_in[0]);
    }
    
    if (is_array($user_in) && count($user_in) > 1)
    {
      $player_name_attended_orientation = trim($user_in[0]);
      $player_uid_attended_orientation = trim($user_in[2]);
      $player_secret_attended_orientation = trim($user_in[3]);
      
      if ($GLOBALS['User']->IsValidUser($player_uid_attended_orientation))
      {
        $user = $GLOBALS['User']->GetUser($player_uid_attended_orientation);
        // valid UID, go ahead and mark them having attended orientation and send an email
        $email_changes['Attended Orientation'] = 'Yes';
        $GLOBALS['User']->UpdateUserGameColumn($GLOBALS['state']['gid'], $user['uid'], 'attended_orientation', addslashes('1'));

        // Mail user at email address
        $to = $user['email'];
        $subject = "".UNIVERSITY." HvZ Game Account Updated";
        $body = "Hello,\rYour ".UNIVERSITY." HvZ game account information was recently modified by a moderator. If you are unsure why or think this is a mistake, please email a moderator.\nThe following changes were made:\n\r";
        
        foreach ($email_changes as $key => $value)
        {
          $body .= "$key: $value\n";
        }
        $body .= "\nYou can log into your account to further review the changes and see them live on the website.\r";
                 
        $GLOBALS['Mail']->SimpleMail($to, $subject, $body, false);
      }
      else
      {
        // uh-oh! Error
        $error = true;
      }
    }
    else
    {
      $error = true;
    }

    $i = 0;
    if (is_array($user_in))
    {
      foreach ($user_in as $row)
      {
        $user[$i] = trim($row);
        $i++;
      }
    }
  }
  
  ?>

  <script type="text/javascript" src="//<?php echo DOMAIN; ?>/js/prototype.js"></script>
  <script type="text/javascript" src="//<?php echo DOMAIN; ?>/js/autocomplete.js"></script>

  <form action="http://<?php echo DOMAIN; ?>/admin/playerlist/attendedorientation" method="POST">
  
  <div class="playerlist_orientation_container">
  
    <?php if ($attended_orientation_save_success && !$error): ?>
      <div class="playerlist_orientation_title_success">
        Success. "<?php echo $player_name_attended_orientation; ?>" attended orientation. Secret ID: <?php echo $player_secret_attended_orientation; ?>
      </div>
    <?php endif ?>

    <?php if ($error): ?>
      <div class="playerlist_orientation_title_error">
        Something went wrong. Please try again.
      </div>
    <?php endif ?>
    
    <div class="playerlist_orientation_title">
      Type a player name to mark the player having attended orientation.
    </div>
    
    <div class="playerlist_orientation_input_container">
      <input type="text" class="playerlist_orientation_input" name="playerlist_orientation_name" id="playerlist_orientation_name" value="" autocomplete="off" />
    </div>
    
    <div class="playerlist_orientation_button_container">
      <input class="button playerlist_orientation_button" type="submit" value="Attended Orientation"></input>
    </div>
    
    <div class="clearfix"></div>
    
    <script type="text/javascript">
      <?php if(isset($_GET['action']) && $_GET['action'] == 'attendedorientation'): ?>
        document.getElementById("playerlist_orientation_name").focus();
      <?php endif ?>
      
      new AutoComplete('playerlist_orientation_name', 'http://<?php echo DOMAIN; ?>/module/_autocomplete_name.php?m=text&s=', {
        delay: 0.125,
        resultFormat: AutoComplete.Options.RESULT_FORMAT_TEXT
      });
    </script>
  </div>
  
  </form>
      
  <div class="admin_title">
    View/Edit Players in the Current Game:
  </div>
    
  <?php if ($GLOBALS['state']): ?>
  
    <?php
    if (isset($_GET['gid']) && $_GET['gid'] != '')
      $gid = $_GET['gid'];
    else
      $gid = $GLOBALS['state']['gid'];

      
    if (isset($_GET['p']) && $_GET['p'] != '')
      $page = $_GET['p'];
    else
      $page = 1;
    
    if (isset($_GET['pageBy']) && $_GET['pageBy'] != '')
      $pageBy = $_GET['pageBy'];
    else
      $pageBy = 500;

    if (isset($_GET['sortBy']) && $_GET['sortBy'] != '')
      $sortBy = $_GET['sortBy'];
    else
      $sortBy = 'name';

    if (isset($_GET['filterBy']) && $_GET['filterBy'] != '')
      $filterBy = $_GET['filterBy'];
    else
      $filterBy = 'all';
      
    if ($GLOBALS['state'])
    {
      $playerCount = $GLOBALS['Game']->GetPlayerCount($GLOBALS['state']['gid']);
      $playerCounts = $GLOBALS['Game']->GetBrokenDownPlayerCount($GLOBALS['state']['gid']);
      //$playerArray = $GLOBALS['User']->GetPlayerlist($GLOBALS['state']['gid'], $pageBy, $page, $sortBy, $filterBy);
      //$playerArrayFilteredTotal = $GLOBALS['User']->GetPlayerlist($GLOBALS['state']['gid'], 'all', 1, $sortBy, $filterBy);
      $admin = true;
      $playerArray = $GLOBALS['Game']->GetPlayers($GLOBALS['state']['gid'], $pageBy, $page, $sortBy, $filterBy, $admin);
      $playerArrayFilteredTotal = $GLOBALS['Game']->GetPlayers($GLOBALS['state']['gid'], 'all', 1, $sortBy, $filterBy, $admin);
    }
    else
    {
      $playerArray = array();
      exit;
    }

  // Figure which page numbers to show. Want to show at least last 2 pages and up to next 2
    $pageDisplay = array();
    $maxPage = ceil(count($playerArrayFilteredTotal) / $pageBy);
    
    switch ($page)
    {
      case 1:
        $pageDisplay[0] = 1;
        break;
        
      case 2:
        $pageDisplay[0] = 1;
        $pageDisplay[1] = 2;
        break;
      
      case 3:
        $pageDisplay[0] = 1;
        $pageDisplay[1] = 2;
        $pageDisplay[2] = 3;
        break;
        
      default:
        $pageDisplay[0] = $page - 3;
        $pageDisplay[1] = $page - 2;
        $pageDisplay[2] = $page - 1;
        break;
        
    }

    $index = count($pageDisplay) - 1;
    $pageIndex = $pageDisplay[$index];
    $pageIndex++;
    $index++;
    $afterCurrentIndex = $index;
    $afterCurrentMax = 5;

    
    while ($pageIndex <= $maxPage && $afterCurrentIndex < $afterCurrentMax)
    {
      $pageDisplay[$index] = $pageIndex;
      $pageIndex++;
      $index++;
      $afterCurrentIndex++;
    }
    
    ?>
    
    <div id="playerlist_header">
    
    <style>
      .playerlist_display_options_label
      {
        width:    150px;
      }
      .playerlist_display_options_container
      {
        margin-top: 2px;
        margin-bottom: 2px;
      }
      .playerlist_table
      {
        font-size:  14px;
      }
      .playerlist_table_row
      {
        height:     40px;
      }
    </style>
      
      <div id="playerlist_display_options">
        <form name="playerlist_display_options_form" action="http://<?php echo DOMAIN; ?>/admin/playerlist" type="GET">
          <div class="playerlist_display_options_container">
            <select class="playerlist_display_options_select" name="filterBy">
              <option value="" <?php if (!isset($filterBy) || $filterBy == '') echo "selected"; ?> >Filter By</option>
              <option value="all" <?php if (isset($filterBy) && $filterBy == 'all') echo "selected"; ?> >All</option>
              <option value="humans" <?php if (isset($filterBy) && $filterBy == 'humans') echo "selected"; ?> >Humans</option>
              <option value="zombies" <?php if (isset($filterBy) && $filterBy == 'zombies') echo "selected"; ?> >Zombies</option>
              <option value="deceased" <?php if (isset($filterBy) && $filterBy == 'deceased') echo "selected"; ?> >Deceased</option>
              <option value="notattendedorientation" <?php if (isset($filterBy) && $filterBy == 'notattendedorientation') echo "selected"; ?> >No Orientation</option>
            </select>
          </div>
          <div class="playerlist_display_options_container">
            <select class="playerlist_display_options_select" name="sortBy">
              <option value="" <?php if (!isset($sortBy) || $sortBy == '') echo "selected"; ?> >Sort By</option>
              <option value="name" <?php if (isset($sortBy) && $sortBy == 'name') echo "selected"; ?> >Name</option>
              <option value="kills" <?php if (isset($sortBy) && $sortBy == 'kills') echo "selected"; ?> >Kills</option>
              <option value="starve_time" <?php if (isset($sortBy) && $sortBy == 'starve_time') echo "selected"; ?> >Starve Time</option>
            </select>
          </div>
          <div class="playerlist_display_options_container">
            <select class="playerlist_display_options_select" name="pageBy">
              <option value="" <?php if (!isset($pageBy) || $pageBy == '') echo "selected"; ?> >Players Per Page</option>
              <option value="100" <?php if (isset($pageBy) && $pageBy == '100') echo "selected"; ?> >100</option>
              <option value="500" <?php if (isset($pageBy) && $pageBy == '500') echo "selected"; ?> >500</option>
              <option value="1000" <?php if (isset($pageBy) && $pageBy == '1000') echo "selected"; ?> >1000</option>
            </select>
          </div>
          <div class="playerlist_display_options_container">
            <input class="button" type="submit" value="Update" class="playerlist_display_options_submit"></input>
          </div>
          
        </form>
        <div class="clearfix"></div>
      </div>
      
      <div class="playerlist_pagination">
        <?php if (count($pageDisplay) > 0): ?>
          <?php foreach ($pageDisplay as $row): ?>
            <?php if ($row == $page): ?>
             <div class="playerlist_header_pagination_page accent_color">
              <?php echo $row; ?>
             </div>
            <?php else: ?>           
             <div class="playerlist_header_pagination_page">
              <a class="playerlist_header_pagination_page_link" href="http://<?php echo DOMAIN; ?>/admin/playerlist?p=<?php echo $row; if (isset($_GET['pageBy'])) echo "&pageBy={$_GET['pageBy']}"; if (isset($_GET['sortBy'])) echo "&sortBy={$_GET['sortBy']}"; if (isset($_GET['filterBy'])) echo "&filterBy={$_GET['filterBy']}";       ?>"><?php echo $row; ?></a>
             </div>
            <?php endif ?>
          <?php endforeach ?>
        <?php endif ?>
      </div>
      
      <div class="playerlist_right_text">
        Click on a user picture or name to edit. 
      </div>
      <div class="clearfix"></div>
      <div class="playerlist_right_text">
        <?php if ($GLOBALS['state']): ?>
                  &nbsp; Humans: <?php echo $playerCounts['humans']?>, &nbsp; Zombies: <?php echo $playerCounts['zombies']?>, &nbsp; Deceased: <?php echo $playerCounts['deceased']?>
       <?php endif ?>       
      </div>
      
      <div class="clearfix"></div>
      
    </div>

    <div id="playerlist_table_container">

      <table class="playerlist_table">
        <tr class="playerlist_table_row_headerfooter">
          <!--<td class="playerlist_table_cell playerlist_table_cell_picture">Picture</td>-->
          <td class="playerlist_table_cell playerlist_table_cell_name">Name</td>
          <td class="playerlist_table_cell playerlist_table_cell_status">Status</td>
          <td class="playerlist_table_cell playerlist_table_cell_zombiekills">Kills</td>
          <!--<td class="playerlist_table_cell playerlist_table_cell_lastfeed">Last Feed</td>-->
          <td class="playerlist_table_cell playerlist_table_cell_gameid">Game ID</td>
        </tr>
        
        <?php if (count($playerArray) > 0): ?>
          <?php foreach ($playerArray as $player): ?>
            <tr class="playerlist_table_row">
              <!--<td class="playerlist_table_cell table_cell_center">
              <a href="http://<?php echo DOMAIN; ?>/admin/playerlist/edit/<?php echo $player['uid']; ?>" class="accent_color"><img class="playerlist_table_cell_img" src="<?php     
                  if ($player['using_fb'])
                  {
                    echo 'http://graph.facebook.com/'.$player['fb_id'].'/picture?type=small';
                    
                  }
                  else
                  {
                    echo '//'.DOMAIN.'/img/user/thumb/u'.$player['uid'].'.jpg';
                  }
                ?>"></img></a>
              </td>-->
              <td class="playerlist_table_cell">
                <a href="http://<?php echo DOMAIN; ?>/admin/playerlist/edit/<?php echo $player['uid']; ?>" class="accent_color"><?php echo $player['name']; ?></a> (<?php echo $player['uid']; ?>)
              </td>
              <td class="playerlist_table_cell">
                <?php
                
                  echo $player['status'];
                  if ($player['oz'])
                  {
                    echo " (oz)";
                  }      
                 
                ?>
              </td>
              <td class="playerlist_table_cell">
                <?php
                  if ($player['status'] == 'human')
                    echo "n/a";
                  else
                    echo $player['zombie_kills'];
                ?>
              </td>
              <!--<td class="playerlist_table_cell table_cell_center"><?php
                  if ($player['status'] == 'human' || $player['zombie_feed_timer'] == 0)
                    echo "n/a";
                  else
                    echo date("D m/d, g:iA", $player['zombie_feed_timer']);
                ?></td>-->
              <td class="playerlist_table_cell">
                <?php
                  echo $player['secret'];
                ?>
              </td>
            </tr>
          <?php endforeach ?>
          
        <?php else: ?>
          <tr class="playerlist_table_row_noplayers">
            <td colspan="5" class="playerlist_table_cell table_cell_center">There are no players to display</td>
          </tr>
        <?php endif ?>
        
        <tr class="playerlist_table_row_headerfooter">
          <td class="playerlist_table_cell playerlist_table_cell_picture"></td>
          <td class="playerlist_table_cell playerlist_table_cell_name"></td>
          <td class="playerlist_table_cell playerlist_table_cell_status"></td>
          <td class="playerlist_table_cell playerlist_table_cell_zombiekills"></td>
          <!--<td class="playerlist_table_cell playerlist_table_cell_lastfeed"></td>-->
          <td class="playerlist_table_cell playerlist_table_cell_gameid"></td>
        </tr>
        
      </table>
    </div>

    <div id="playerlist_footer">
      <div class="playerlist_pagination">
        <?php if (count($pageDisplay) > 0): ?>
          <?php foreach ($pageDisplay as $row): ?>
            <?php if ($row == $page): ?>
             <div class="playerlist_header_pagination_page accent_color">
              <?php echo $row; ?>
             </div>
            <?php else: ?>           
             <div class="playerlist_header_pagination_page">
              <a class="playerlist_header_pagination_page_link" href="http://<?php echo DOMAIN; ?>/admin/playerlist?p=<?php echo $row; if (isset($_GET['pageBy'])) echo "&pageBy={$_GET['pageBy']}"; if (isset($_GET['sortBy'])) echo "&sortBy={$_GET['sortBy']}"; if (isset($_GET['filterBy'])) echo "&filterBy={$_GET['filterBy']}";       ?>"><?php echo $row; ?></a>
             </div>
            <?php endif ?>
          <?php endforeach ?>
        <?php endif ?>
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>
  
  <?php else: ?>
  There is no current game to show players for.
  <?php endif ?>
  
  
<?php endif ?>