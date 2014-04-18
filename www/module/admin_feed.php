<?php 
  $message = false;
  if (isset($_GET['action']) && $_GET['action'] == 'save') {
    $number = addslashes($_POST['number']);
    $hours  = addslashes($_POST['time']);
    $expiry = addslashes($_POST['expiry']);
    $kill   = (isset($_POST['kill'])) ? '1' : '0';
  
    if ($number > 500) {
      $message = 'Max 500 cards at once';
      goto error;
    }
    $hours = floor($hours * 3600);

    if ($expiry != '' && !$expiry = strtotime($expiry)){ //this is far too clever for my own good
      $message = 'Invalid expiration date';
      goto error;
    }
    
    $ids = $GLOBALS['Game']->AddFeedCards($GLOBALS['state']['gid'], $number, $hours, $expiry, $kill);
    foreach ($ids as $id) {
      echo $id."<br>";
    }
    return;
  }
  
  if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['target'])) {
  	$GLOBALS['Game']->DeleteFeedCard($GLOBALS['state']['gid'], $_GET['target']);
  	$message = 'Feed card deleted';
  }
  
  error:
?>

  <div id="admin_title">
  Feed Cards
  </div>
  <?php if ($message): ?>
  <div class="admin_status">
  <?php
        echo($message);
  ?>
  </div>
  <?php endif ?> 
  <div class="gameplay_block_title">
  Create:
  </div> 

  
  <form class="playerlist_add_form" name="playerlist_add_form" action="http://<?php echo DOMAIN; ?>/admin/feed/save" method="POST">
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Number of Cards:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="text" name="number" value="20" />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Hours:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="text" name="time" value="60" />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Expiration:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="text" name="expiry" />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    &nbsp;
    </div>
    <div class="admin_playerlist_edit_row_form">
   (YYYY:MM:DD HH:MM:SS, 24hr format. Blank for no expiration)
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Kill:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="checkbox" name="kill" checked="true"> 
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    &nbsp;
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input class="button" type="submit" value="Generate"></input> <a class="button" href="http://<?php echo DOMAIN; ?>/admin/feed/">Cancel</a>
    </div>
  </div>
    
  </form>
  
  <?php
    $feedcards = $GLOBALS['Game']->GetFeedCards($GLOBALS['state']['gid']);
  ?>

  <div class="gameplay_block_title">
  View/Change Feed Cards:
  </div>
  
  <div id="feed_table_container">

    <table class="feed_table">
      <tr class="feed_table_row_headerfooter">
        <td class="feed_table_cell feed_table_cell_id">Code</td>
        <td class="feed_table_cell feed_table_cell_time">Hours</td>
        <td class="feed_table_cell feed_table_cell_kill">Kill</td>
        <td class="feed_table_cell feed_table_cell_expiry">Expiry</td>
        <td class="feed_table_cell feed_table_cell_used">Used</td>
        <td class="feed_table_cell feed_table_cell_delete">Delete</td>
      </tr>
      
      <?php if (count($feedcards) > 0): ?>
        <?php foreach ($feedcards as $fc): ?>
          <tr class="feed_table_row">
            <td class="feed_table_cell">
              <?php 
                  echo $fc['secret'];
              ?>
            </td>
            <td class="feed_table_cell">
              <?php 
                  echo $fc['feedtime']/3600;
              ?>
            </td>
            </td>
            <td class="feed_table_cell">
              <?php
                  $kill = ($fc['kl']) ? 'yes' : 'no';
                  echo $kill;
              ?>
            </td>
            <td class="feed_table_cell">
              <?php 
                  $expire = ($fc['expiration']) ? date('Y-m-d H:i:s', $fc['expiration']) : 'none';
                  echo $expire;
              ?>
            </td>
            <td class="feed_table_cell">
              <?php
                  $used = ($fc['used_by']) ? $fc['used_by'] : 'unused';
                  echo $used;
              ?>
            </td>
            <td class="feed_table_cell">
              <a class="button" href="http://<?php echo DOMAIN; ?>/admin/feed/delete/<?php echo $fc['fid']; ?>" class="accent_color">Delete</a>
            </td>
          </tr>
        <?php endforeach ?>
        
      <?php else: ?>
        <tr class="feed_table_row_noplayers">
          <td colspan="5" class="feed_table_cell table_cell_center">There are no feedcards to display</td>
        </tr>
      <?php endif ?>
    </table>
  </div>
