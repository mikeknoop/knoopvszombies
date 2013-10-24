<?php 

if (isset($_GET['action']) && ($_GET['action'] == 'create'))
{

  // Create new game
  $new_game = $GLOBALS['Game']->CreateNew();

  // set the view to edit that game
  $_GET['action'] = 'edit';
  $_GET['target'] = $new_game;

}

?>

<?php if (isset($_GET['action']) && ($_GET['action'] == 'edit' || $_GET['action'] == 'save') && isset($_GET['target']) && $_GET['target'] != ''): ?>

  <?php
   
    if ($_GET['action'] == 'save')
    {

      if (!$game = $GLOBALS['Game']->GetGame($_GET['target']))
      {
        echo "Invalid Game ID";
        exit;
      }
      
      // Special validation cases
      if (isset($_POST['current']) && $_POST['current'] == 'on') //  && !$game['active']
      {
        $_POST['current'] = '1';
      }
      else
      {
        $_POST['current'] = '0';
      }

      if (isset($_POST['countdown']) && $_POST['countdown'] == 'on')
      {
        $_POST['countdown'] = '1';
      }
      else
      {
        $_POST['countdown'] = '0';
      }

      if (isset($_POST['delete']) && $_POST['delete'] == 'on')
      {
				if ((isset($GLOBALS['state']['active']) && !$GLOBALS['state']['active']) || !isset($GLOBALS['state']['active'])) {
        // delete game, redirect back to /admin/game/
        $GLOBALS['Game']->DeleteGame($_GET['target']);
        print 'Game deleted. <a href="http://'.DOMAIN.'/admin/game" class="accent_color">Click here to go back</a>.';
        exit;
        }
      }
      
      // validate and save the user form
      $save = array();
      if (is_array($_POST))
      {
        foreach ($_POST as $key => $value)
        {
          switch ($key)
          {
            case 'name':
              if (!$game['archive'])
              {
                $save[$key] = $value;
              }
              break;
              
            case 'start_time':
              if (!$game['archive'])
              {
                if ($value != '0000-00-00 00:00:00')
                {
                  $test_value = strtotime($value);
                  if ($test_value)
                  {
                     if ($test_value > date("U"))
                     {
                      // start_time must be sometime in the future
                      $save[$key] = $test_value;
                     }
                  }
                }
                if ($value == '0000-00-00 00:00:00')
                {
                  $save[$key] = '0';
                }
              }
              break;

            case 'current':
              if ($value == '1')
              {
                if (!$GLOBALS['state'] && !$game['current'])
                  $save[$key] = $value;
              }
              else
              {
                // Game is being unmarked as current. We need to mark all users active_game = '0'
                // $GLOBALS['User']->MarkAllUsersNotActiveGame();
                $save[$key] = $value;
              }
              break;

            case 'countdown':
              $save[$key] = $value;
              break;
              
          }
        }
      }

      $saved = array();
      foreach ($save as $key => $value)
      {
        // $save is sanitized, validated input
        if ($game[$key] != $value)
        {
          $GLOBALS['Game']->UpdateGameColumn($_GET['target'], $key, addslashes($value));
          $saved[$key] = $value;
        }
      }
      
    }
   
    if (!$game = $GLOBALS['Game']->GetGame($_GET['target']))
    {
      echo "Game ID Invalid";
      exit;
    }

  ?>

  <div id="admin_title">
  Edit Game <span class="accent_color">(<?php if ($game['name'] == '') echo "New Game"; else echo $game['name']; ?>)</span>
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
    
    ?>
  </div>
  <?php endif ?> 
  
  <form class="playerlist_edit_form" name="playerlist_edit_form" action="http://<?php echo DOMAIN; ?>/admin/game/save/<?php echo $game['gid']; ?>" method="POST">
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Name:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="text" name="name" value="<?php echo $game['name']; ?>" <?php if ($game['archive']) echo 'disabled'; ?> />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Start Time:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input id='zombied_time_form' type="text" name="start_time" value="<?php if ($game['start_time'] == 0) { echo '0000-00-00 00:00:00'; } else { echo date('Y-m-d H:i:s', $game['start_time']); } ?>" <?php if ($game['archive']) echo 'disabled'; ?> />
    </div>
    <?php if (!$game['archive']): ?>
    <div class="admin_playerlist_edit_row_caption">
      <input class="button" type="submit" value="Clear" onclick="document.getElementById('zombied_time_form').value='0000-00-00 00:00:00'; return false;" />
    </div>
    <?php endif ?>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    &nbsp;
    </div>
    <div class="admin_playerlist_edit_row_form">
   (YYYY:MM:DD HH:MM:SS, 24hr format)
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Current Game:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="checkbox" name="current" <?php if ($game['current']) echo "checked=true"; ?> <?php if ($GLOBALS['state']['current'] && !$game['current']) echo "disabled"; ?> <?php if ($GLOBALS['state']['active']) echo "disabled"; ?> />
    </div>
    <div class="admin_playerlist_edit_row_caption">
    (Read below for more information)
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Show Countdown:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="checkbox" name="countdown" <?php if ($game['countdown']) echo "checked=true"; ?> />
    </div>
  </div>

  <?php if ((date("U") <= ($game['created'] + (60*60))) && !$game['archive']): ?>
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Delete Game:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="checkbox" name="delete" <?php if ($game['active'] || $game['archive']) echo "disabled"; ?> />
    </div>
    <div class="admin_playerlist_edit_row_caption">
    (Read below for more information)
    </div>
  </div>
  <?php endif ?>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    &nbsp;
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input class="button" type="submit" value="Save Changes"></input> <a class="button" href="http://<?php echo DOMAIN; ?>/admin/game/">Cancel</a>
    </div>
  </div>
    
  <div class="admin_playerlist_edit_footer_text">
    <?php if ($game['archive']): ?>
    <div>
      <span class="bold">This game is archived:</span><br />
      This game has permanently ended. To create a new game, do so from the "Edit/Create Game" Admin Tool.
    </div>
    <br />
    <?php endif ?>
  
    <div>
      <span class="bold">Note regarding "Current Game" checkbox:</span><br />
      Only one game at a time can be marked "Current Game". The game must be in the "Pre-game" or "Post-game" stage to uncheck the box. You can advance the game forward on the "Gameplay Progress" Admin Tool.
    </div>
    <br />
        
    <?php if ((date("U") <= ($game['created'] + (60*60))) && !$game['archive']): ?>
    <div>
      <span class="bold">Note regarding "Delete Game" checkbox:</span><br />
      You can delete a game up to one hour after it is created. Also, the game must be in the "Pre-game" stage to delete. To delete a game older than one hour or not in "Pre-game", contact someone with database access. 
    </div>
    <?php endif ?>
  </div>



  
  </div>
    
  </form>
  
<?php elseif (isset($_GET['action']) && ($_GET['action'] == 'vieworientation' || $_GET['action'] == 'deleteorientation' || $_GET['action'] == 'addorientation') && isset($_GET['target']) && $_GET['target'] != ''): ?>
  
  <?php
  
    if (($_GET['action'] == 'vieworientation' || $_GET['action'] == 'addorientation') && (!$game = $GLOBALS['Game']->GetGame($_GET['target'])))
    {
      echo "Invalid Game ID";
      exit;
    }
    
    if ($_GET['action'] == 'addorientation')
    {
      $location = $_POST['location'];
      $test_time = null;
      $time = '';
      if ($_POST['time'] != '0000-00-00 00:00:00' && $_POST['time'] != '')
      {
        $test_time = strtotime($_POST['time']);
        if ($test_time)
        {
          $time = $test_time;
        }
      }
      if ($location != '' && $time != '')
      {
        // add orient
        $GLOBALS['Game']->AddOrientation($game['gid'], $location, $time);
      }
      
    }

    if ($_GET['action'] == 'deleteorientation')
    {

      if ($_GET['target'] != '')
      {
        // delete orient
        $gid = $GLOBALS['Game']->RemoveOrientation($_GET['target']);
        $game = $GLOBALS['Game']->GetGame($gid);
      }
      
    }
    
  ?>
  
  <?php
    $orientationArray = $GLOBALS['Game']->GetOrientations($game['gid']);
  ?>

  <div id="admin_title">
  View/Change Orientations <span class="accent_color">(<?php if ($game['name'] == '') echo "New Game"; else echo $game['name']; ?>)</span>
  </div>
  
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
      height:     80px;
    }
    .playerlist_table_cell_location
    {
      width:      200px;
    }
    .playerlist_table_cell_time
    {
      width:      200px;
    }
    .playerlist_table_cell_delete
    {
      width:      200px;
    }
    
  </style>
    
  </div>

  <div id="playerlist_table_container">

    <table class="playerlist_table">
      <tr class="playerlist_table_row_headerfooter">
        <td class="playerlist_table_cell playerlist_table_cell_location">Location</td>
        <td class="playerlist_table_cell playerlist_table_cell_time">Time</td>
        <td class="playerlist_table_cell playerlist_table_cell_delete">Delete</td>
      </tr>
      
      <?php if (count($orientationArray) > 0): ?>
        <?php foreach ($orientationArray as $orientation): ?>
          <tr class="playerlist_table_row">
            <td class="playerlist_table_cell">
              <?php 
                if ($orientation['location'] == '')
                {
                  echo "(no location)";
                }
                else
                {
                  echo $orientation['location'];
                }
              ?>
            </td>
            <td class="playerlist_table_cell">
              <?php 
                if ($orientation['time'] == 0)
                {
                  echo "(no time)";
                }
                else
                {
                  echo date('Y-m-d H:i:s', $orientation['time']);
                }
              ?>
            </td>
            <td class="playerlist_table_cell">
              <a class="button" href="http://<?php echo DOMAIN; ?>/admin/game/deleteorientation/<?php echo $orientation['oid']; ?>" class="accent_color">Delete</a>
            </td>
          </tr>
        <?php endforeach ?>
        
      <?php else: ?>
        <tr class="playerlist_table_row_noplayers">
          <td colspan="5" class="playerlist_table_cell table_cell_center">There are no orientations to display</td>
        </tr>
      <?php endif ?>
      
      <tr class="playerlist_table_row_headerfooter">
        <td class="playerlist_table_cell playerlist_table_cell_location"></td>
        <td class="playerlist_table_cell playerlist_table_cell_time"></td>
        <td class="playerlist_table_cell playerlist_table_cell_delete"></td>
      </tr>
      
    </table>
  </div>

  <div class="clearfix"></div>

  <form class="playerlist_edit_form" name="playerlist_edit_form" action="http://<?php echo DOMAIN; ?>/admin/game/addorientation/<?php echo $game['gid']; ?>" method="POST">
  
  Add an Orientation  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Location:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="text" name="location" value="" />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Time:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input id='zombied_time_form' type="text" name="time" value="0000-00-00 00:00:00" />
    </div>
    <div class="admin_playerlist_edit_row_caption">
      (YYYY-MM-DD HH:MM:SS, 24hr format)
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    &nbsp;
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input class="button" type="submit" value="Add Orientation"></input>
    </div>
  </div>
  
  </form>
  
  
<?php else: ?>

  <?php
  
    if (isset($_GET['action']) && $_GET['action'] == 'clearcache')
    {
      $GLOBALS['Game']->ClearAllGameCache();
    }
    
  ?>  
  <div id="admin_title">
  Edit/Create <span class="accent_color">Games</span>
  </div>

  <?php if (isset($_GET['action']) && $_GET['action'] == 'clearcache'): ?>
  <div class="admin_status">
    All game cache files were successfully deleted.
  </div>
  <?php endif ?>
  
  <?php
    $gameArray = $GLOBALS['Game']->GetAllGames();
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
      height:     80px;
    }
  </style>

    <div class="playerlist_right_text">
      Click on a game name to edit. 
    </div>    
    <div class="clearfix"></div>
    
  </div>

  <div id="playerlist_table_container">

    <table class="playerlist_table">
      <tr class="playerlist_table_row_headerfooter">
        <td class="playerlist_table_cell playerlist_table_cell_name">Name</td>
        <td class="playerlist_table_cell playerlist_table_cell_current">Current</td>
        <td class="playerlist_table_cell playerlist_table_cell_starttime">Start Time</td>
        <td class="playerlist_table_cell playerlist_table_cell_orientations">Orientations</td>
        <td class="playerlist_table_cell playerlist_table_cell_edit">Edit</td>
      </tr>
      
      <?php if (count($gameArray) > 0): ?>
        <?php foreach ($gameArray as $game): ?>
          <tr class="playerlist_table_row">
            <td class="playerlist_table_cell">
              <a href="http://<?php echo DOMAIN; ?>/admin/game/edit/<?php echo $game['gid']; ?>" class="accent_color">
              <?php 
                if ($game['name'] == '')
                {
                  echo "(New Game)";
                }
                else
                {
                  echo $game['name'];
                }
                
              ?>
              </a>
            </td>
            <td class="playerlist_table_cell">
              <?php 
                if (!$game['current'])
                {
                  echo "--";
                }
                else
                {
                  echo "Yes";
                }
              ?>
            </td>
            <td class="playerlist_table_cell">
              <?php 
                if ($game['start_time'] == '0')
                {
                  echo "--";
                }
                else
                {
                  echo date('Y-m-d H:i:s', $game['start_time']);
                }
              ?>
            </td>
            <td class="playerlist_table_cell">
              <a class="button" href="http://<?php echo DOMAIN; ?>/admin/game/vieworientation/<?php echo $game['gid']; ?>">View/Change</a>
            </td>
            <td class="playerlist_table_cell">
              <a class="button" href="http://<?php echo DOMAIN; ?>/admin/game/edit/<?php echo $game['gid']; ?>">Edit</a>
            </td>
          </tr>
        <?php endforeach ?>
        
      <?php else: ?>
        <tr class="playerlist_table_row_noplayers">
          <td colspan="5" class="playerlist_table_cell table_cell_center">There are no games to display</td>
        </tr>
      <?php endif ?>
      
      <tr class="playerlist_table_row_headerfooter">
        <td class="playerlist_table_cell playerlist_table_cell_name"></td>
        <td class="playerlist_table_cell playerlist_table_cell_current"></td>
        <td class="playerlist_table_cell playerlist_table_cell_starttime"></td>
        <td class="playerlist_table_cell playerlist_table_cell_orientations"></td>
        <td class="playerlist_table_cell playerlist_table_cell_delete"></td>
      </tr>
      
    </table>
  </div>

  <div class="clearfix"></div>
  
  <div class="admin_playerlist_manual_id">
    <a class="button" href="http://<?php echo DOMAIN; ?>/admin/game/clearcache/all">Clear Game Cache Files</a> <a class="button" href="http://<?php echo DOMAIN; ?>/admin/game/create">Create New Game</a>
  </div>

  
<?php endif ?>