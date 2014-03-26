<?php 
//Logic to handle submissions
  $message = false;  
?>

  <div id="admin_title">
  Feed Cards
  </div>
  <div class="gameplay_block_title">
  Create:
  </div> 
  <?php if ($message): ?>
  <div class="admin_status">
    <?php
        echo($message);
    ?>
  </div>
  <?php endif ?> 
  
  <form class="playerlist_add_form" name="playerlist_add_form" action="http://<?php echo DOMAIN; ?>/admin/feed/save/" method="POST">
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Number of cards:
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
      <input type="checkbox" name="current" checked="true"> 
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
        <td class="feed_table_cell feed_table_cell_id">id</td>
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
                  echo $fc['fid'];
              ?>
            </td>
            <td class="feed_table_cell">
              <?php 
                  echo 60 *  $fc['time'];
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
