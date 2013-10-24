<?php if ($GLOBALS['state']): ?>
  <?php
    $show_message = false;
    $message = '';
        
    // Logic to determine which step game is on
    $stage = 'pregame';
    
    if (!$GLOBALS['state']['active'] && $GLOBALS['state']['archive'])
    {
      $stage = 'postgame';
    }
    
    if ($GLOBALS['state']['active'] && !$GLOBALS['state']['archive'])
    {
      $stage = 'ingame';
    }

    if ($GLOBALS['state']['active'] && $GLOBALS['state']['archive'])
    {
      $stage = 'error';
    }
    
    switch ($stage)
    {
      case "pregame":

        if (isset($_GET['action']) && $_GET['action'] != '')
        {
          switch ($_GET['action'])
          {
            case "removeoz":
              if (isset($_GET['target']) && $_GET['target'] != '')
              {
                $GLOBALS['Game']->RemoveOZ($GLOBALS['state']['gid'], $_GET['target']);
              }
              break;

            case "addoz":
              if (isset($_POST['add_oz']) && $_POST['add_oz'] != '')
              {
                $GLOBALS['Game']->AddOZ($GLOBALS['state']['gid'], $_POST['add_oz']);
              }
              break;
              
            case "changeregstatus":
              if (isset($_POST['reg_status']) && ($_POST['reg_status'] == 'open' || $_POST['reg_status'] == 'closed'))
              {
                $GLOBALS['Game']->ChangeRegStatus($GLOBALS['state']['gid'], $_POST['reg_status']);
              }
              break;
          }
        }
    
        break;

      case "ingame":

        if (isset($_GET['action']) && $_GET['action'] != '')
        {
          switch ($_GET['action'])
          {
            case "removeoz":
              if (isset($_GET['target']) && $_GET['target'] != '')
              {
                $GLOBALS['Game']->RemoveOZ($GLOBALS['state']['gid'], $_GET['target']);
              }
              break;

            case "addoz":
              if (isset($_POST['add_oz']) && $_POST['add_oz'] != '')
              {
                $GLOBALS['Game']->AddOZ($GLOBALS['state']['gid'], $_POST['add_oz']);
              }
              break;
              
            case "changeozvisibility":
              if (isset($_POST['oz_visibility']) && ($_POST['oz_visibility'] == 'hidden' || $_POST['oz_visibility'] == 'revealed'))
              {
                $GLOBALS['Game']->ChangeOZVisibility($GLOBALS['state']['gid'], $_POST['oz_visibility']);
              }
              break;

            case "feedallzombies":
              $GLOBALS['Game']->FeedAllZombies($GLOBALS['state']['gid']);
              break;
              
            case "endgame":
              if (isset($_POST['end_game']) && ($_POST['end_game'] == 'endgame'))
              {
                // Archive historical player data
                $GLOBALS['Game']->ArchivePlayerData($GLOBALS['state']['gid']);
                
                // End the game in the game table, mark columns affected
                $GLOBALS['Game']->EndGame($GLOBALS['state']['gid']);
                
                // advance the game onward!
                $stage = 'postgame';
                
              }
              break;
              
              
          }
        }
    
        break;
        
      case "postgame":

        if (isset($_GET['action']) && $_GET['action'] != '')
        {
        }
    
        break;
    }


  // Refresh Game State
  $GLOBALS['state'] = $GLOBALS['Game']->GetState();
    
  ?>

  <div id="admin_title">
  Gameplay Progress (<span class="accent_color"><?php echo $GLOBALS['state']['name'] ?></span>)
  </div>
  
  <?php if ($show_message): ?>
  <div class="admin_status">
    <?php echo $message ?>
  </div>
  <?php endif ?>
  
  <div class="gameflow_block">
    <span class="flow_header <?php if ($stage == 'pregame') echo 'flow_current'; ?>">1. Pre-game</span> <span class="flow_header <?php if ($stage == 'ingame') echo 'flow_current'; ?>">2. Game In Progress</span> <span class="flow_header <?php if ($stage == 'postgame') echo 'flow_current'; ?>">3. Post-game</span>
  </div>
  
  
  <?php if ($stage == 'pregame'): ?>
    
    <?php
    
    $playerArray = $GLOBALS['Game']->GetOZs($GLOBALS['state']['gid']);
    
    ?>
    
    <div class="gameplay_block">
    <?php if ($GLOBALS['state']['start_time'] != 0): ?>
			The game is in pre-game mode. The game will automatically advance to "Game In Progress" on <?php echo date('Y-m-d H:i:s', $GLOBALS['state']['start_time']) ?> as defined in the "Edit/Create Game" Admin Tool. Before then, select Original Zombie(s) below. You may also open/close registration below.
    <?php else: ?>
			The game is in pre-game mode. A start time has not been defined yet. Choose a start time in the "Edit/Create Game" Admin Tool. In the mean time, you can select Original Zombie(s) below. You may also open/close registration below.
    <?php endif; ?>
    </div>

    <div class="gameplay_table_container">
    
      <div class="gameplay_table_title">
      Original Zombie(s):
      </div>
    
      <table class="playerlist_table">
        <tr class="playerlist_table_row_headerfooter">
          <td class="playerlist_table_cell playerlist_table_cell_picture">Picture</td>
          <td class="playerlist_table_cell playerlist_table_cell_name">Name</td>
          <td class="playerlist_table_cell playerlist_table_cell_email">Email</td>
          <td class="playerlist_table_cell playerlist_table_cell_removeoz">Remove</td>
        </tr>
        
        <?php if (count($playerArray) > 0): ?>
          <?php foreach ($playerArray as $player): ?>
            <tr class="playerlist_table_row">
              <td class="playerlist_table_cell table_cell_center">
              <a href="http://<?php echo DOMAIN; ?>/account/<?php echo $player['uid']; ?>" class="accent_color"><img class="playerlist_table_cell_img" src="<?php     
                  if ($player['using_fb'])
                  {
                    echo 'http://graph.facebook.com/'.$player['fb_id'].'/picture?type=small';
                    
                  }
                  else
                  {
                    echo '/img/user/thumb/u'.$player['uid'].'.jpg';
                  }
                ?>"></img></a>
              </td>
              <td class="playerlist_table_cell">
                <a href="http://<?php echo DOMAIN; ?>/account/<?php echo $player['uid']; ?>" class="accent_color"><?php echo $player['name']; ?></a> (<?php echo $player['uid']; ?>)
              </td>
              <td class="playerlist_table_cell">
                <?php echo $player['email']; ?>
              </td>
              <td class="playerlist_table_cell">
                <a class="button" href="http://<?php echo DOMAIN; ?>/admin/gameplay/removeoz/<?php echo $player['uid']; ?>">Remove</a>
              </td>
            </tr>
          <?php endforeach ?>
          
        <?php else: ?>
          <tr class="playerlist_table_row_noplayers">
            <td colspan="5" class="playerlist_table_cell table_cell_center">There are no Original Zombies. Add people below.</td>
          </tr>
        <?php endif ?>
        
        <tr class="playerlist_table_row_headerfooter">
          <td class="playerlist_table_cell playerlist_table_cell_picture"></td>
          <td class="playerlist_table_cell playerlist_table_cell_name"></td>
          <td class="playerlist_table_cell playerlist_table_cell_email"></td>
          <td class="playerlist_table_cell playerlist_table_cell_removeoz"></td>
        </tr>
        
      </table>
      
      <div class="gameplay_block">
        <form action="http://<?php echo DOMAIN; ?>/admin/gameplay/addoz" method="POST">
          <?php
            $ozPoolArray = $GLOBALS['Game']->GetOZPool($GLOBALS['state']['gid']);
          ?>
        <select name="add_oz">
          <option value="">Choose Player From OZ Pool</option>
          <?php
            if (is_array($ozPoolArray))
            {
              foreach ($ozPoolArray as $ozPoolPlayer)
              {             
                echo "<option value='{$ozPoolPlayer['uid']}'>{$ozPoolPlayer['name']}</option>";
              }
            }       
          ?>
        </select>
        
        <input class="button" type="submit" value="Set Player as OZ" />
        
        </form>
        
        <?php if (is_array($ozPoolArray) && count($ozPoolArray) > 0): ?>
          <?php
            if (is_array($ozPoolArray) && count($ozPoolArray) > 0)
            {
              $rand_player = $ozPoolArray[rand(0, (count($ozPoolArray)-1))];
            }
          ?>
          
          <div class="gameplay_oz_random">
          Random person for consideration: <?php echo $rand_player['name']; ?>
          </div>
        <?php endif ?>
      </div>
      
    </div>

    <div class="gameplay_block">
      <div class="gameplay_block_title">
        Open/Close Game Registration:
      </div>
        <form id="gameplay_reg_status_form" action="http://<?php echo DOMAIN; ?>/admin/gameplay/changeregstatus" method="POST">
  
          Registration is currently &nbsp;
          
          <select name="reg_status">
            <option value="open" <?php if ($GLOBALS['state']['registration_open']) echo 'selected'; ?>>Open</option>
            <option value="closed" <?php if (!$GLOBALS['state']['registration_open']) echo 'selected'; ?>>Closed</option>
          </select>
          
          <input class="button" type="submit" value="Save Change" />
        
        </form>
    </div>
    
<?php elseif ($stage == 'ingame'): ?>
  
    <?php
    
    $playerArray = $GLOBALS['Game']->GetOZs($GLOBALS['state']['gid']);
    
    ?>
    
    <div class="gameplay_block">
      The game is in progress. Players may now report kills on the website. Use the tool below to reveal the Original Zombie(s). You can modify Original Zombies below. You may also end the game below.
    </div>
   
    <br />
    
    <div class="gameplay_block">
      <div class="gameplay_block_title">
        Hide/Reveal Original Zombies
      </div>
        <form id="gameplay_reveal_oz_form" action="http://<?php echo DOMAIN; ?>/admin/gameplay/changeozvisibility" method="POST">
  
          Original Zombies are currently &nbsp;
          
          <select name="oz_visibility">
            <option value="hidden" <?php if ($GLOBALS['state']['oz_hidden']) echo 'selected'; ?>>Hidden</option>
            <option value="revealed" <?php if (!$GLOBALS['state']['oz_hidden']) echo 'selected'; ?>>Revealed</option>
          </select>
          
          <input class="button" type="submit" value="Save Change" />
        </form>
    </div>
    
    <div class="gameplay_block">
      <div class="gameplay_block_title">
        Feed All Zombies
      </div>
        <form id="gameplay_feed_all_zombies_form" action="http://<?php echo DOMAIN; ?>/admin/gameplay/feedallzombies" method="POST">
  
          All alive zombies will be fed (feed timers reset)
          
          <input class="button" type="submit" value="Feed Them" />
        </form>
    </div>
    
    <div class="gameplay_table_container">
    
      <div class="gameplay_table_title">
      Original Zombie(s):
      </div>
    
      <table class="playerlist_table">
        <tr class="playerlist_table_row_headerfooter">
          <td class="playerlist_table_cell playerlist_table_cell_picture">Picture</td>
          <td class="playerlist_table_cell playerlist_table_cell_name">Name</td>
          <td class="playerlist_table_cell playerlist_table_cell_email">Email</td>
          <td class="playerlist_table_cell playerlist_table_cell_removeoz">Remove</td>
        </tr>
        
        <?php if (count($playerArray) > 0): ?>
          <?php foreach ($playerArray as $player): ?>
            <tr class="playerlist_table_row">
              <td class="playerlist_table_cell table_cell_center">
              <a href="http://<?php echo DOMAIN; ?>/account/<?php echo $player['uid']; ?>" class="accent_color"><img class="playerlist_table_cell_img" src="<?php     
                  if ($player['using_fb'])
                  {
                    echo 'http://graph.facebook.com/'.$player['fb_id'].'/picture?type=small';
                    
                  }
                  else
                  {
                    echo '/img/user/thumb/u'.$player['uid'].'.jpg';
                  }
                ?>"></img></a>
              </td>
              <td class="playerlist_table_cell">
                <a href="http://<?php echo DOMAIN; ?>/account/<?php echo $player['uid']; ?>" class="accent_color"><?php echo $player['name']; ?></a> (<?php echo $player['uid']; ?>)
              </td>
              <td class="playerlist_table_cell">
                <?php echo $player['email']; ?>
              </td>
              <td class="playerlist_table_cell">
                <a class="button" href="http://<?php echo DOMAIN; ?>/admin/gameplay/removeoz/<?php echo $player['uid']; ?>">Remove</a>
              </td>
            </tr>
          <?php endforeach ?>
          
        <?php else: ?>
          <tr class="playerlist_table_row_noplayers">
            <td colspan="5" class="playerlist_table_cell table_cell_center">There are no Original Zombies. Add people below.</td>
          </tr>
        <?php endif ?>
        
        <tr class="playerlist_table_row_headerfooter">
          <td class="playerlist_table_cell playerlist_table_cell_picture"></td>
          <td class="playerlist_table_cell playerlist_table_cell_name"></td>
          <td class="playerlist_table_cell playerlist_table_cell_email"></td>
          <td class="playerlist_table_cell playerlist_table_cell_removeoz"></td>
        </tr>
        
      </table>
      
      <div class="gameplay_block">
        <form action="http://<?php echo DOMAIN; ?>/admin/gameplay/addoz" method="POST">
          <?php
            $ozPoolArray = $GLOBALS['Game']->GetOZPool($GLOBALS['state']['gid']);
          ?>
        <select name="add_oz">
          <option value="">Choose Player From OZ Pool</option>
          <?php
            if (is_array($ozPoolArray))
            {
              foreach ($ozPoolArray as $ozPoolPlayer)
              {             
                echo "<option value='{$ozPoolPlayer['uid']}'>{$ozPoolPlayer['name']}</option>";
              }
            }       
          ?>
        </select>
        
        <input class="button" type="submit" value="Set Player as OZ" />
        
        </form>
        
        <?php if (is_array($ozPoolArray) && count($ozPoolArray) > 0): ?>
          <?php
            if (is_array($ozPoolArray) && count($ozPoolArray) > 0)
            {
              $rand_player = $ozPoolArray[rand(0, (count($ozPoolArray)-1))];
            }
          ?>
          
          <div class="gameplay_oz_random">
          Random person for consideration: <?php echo $rand_player['name']; ?>
          </div>
        <?php endif ?>
      </div>
      
    </div>

    <div class="gameplay_block">
      <div class="gameplay_block_title">
        End the Game
      </div>
        <form id="gameplay_end_game_form" action="http://<?php echo DOMAIN; ?>/admin/gameplay/endgame" method="POST">
  
          Game Status: &nbsp;
          
          <select name="end_game">
            <option value="">In Progress</option>
            <option value="endgame">End the Game Permanently</option>
          </select>
          
          <input class="button" type="submit" value="Save Change" />
        
        </form>
        
        After ending a game, no more kills can be registered, playercounts are frozen.
    </div>
    
  <?php elseif ($stage == 'postgame'): ?>

    <div class="gameplay_block">
      The game has been permanently ended! Player statistics have been archived.
    </div>
    
    <div class="gameplay_block">
    The playerlist and player counts for this game will still appear on the website until you unmark this game as the "Current Game" from the "Edit/Create Game" Admin Tool.
    </div>  
    
  <?php elseif ($stage == 'error'): ?>

    <div id="admin_title">
    Gameplay <span class="accent_color">Progress</span>
    </div>
    
    <div class="gameplay_block">
      <p>Something blew up. Contact a developer right away.</p>
    </div>
  
  <?php endif ?>
  

<?php else: ?>

  <div id="admin_title">
  Gameplay <span class="accent_color">Progress</span>
  </div>
  
  <div class="gameplay_block">
    <p>There is no current game to modify. Mark a game as current on the "Edit/Create Game" Admin Tool.</p>
  </div>
  
<?php endif ?>