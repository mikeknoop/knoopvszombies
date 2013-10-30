  <div class="content_row">
    <div class="content_row_label">
      Account created:
    </div>
    <div class="content_row_data">
      <?php echo $view_date_created ?>
    </div>
    <div class="clearfix"></div>
  </div>

  <?php if ($viewing_self): ?>
  <div class="content_row">
    <div class="content_row_label">
      Email address:
    </div>
    <div class="content_row_data">
      <?php echo $_SESSION['email'] ?>
    </div>
    <div class="clearfix"></div>
  </div>
  <?php endif ?>

  <div class="content_row">
    <div class="content_row_label">
      Playing this/upcoming game:
    </div>
    <div class="content_row_data">
      <?php echo $view_active ?>
    </div>
    <div class="clearfix"></div>
  </div>

	<?php if ($show_oz_pool): ?>
  <div class="content_row">
    <div class="content_row_label">
      In OZ pool this/upcoming game:
    </div>
    <div class="content_row_data">
      <?php echo $oz_pool_status ?>
    </div>
    <div class="clearfix"></div>
  </div>
  <?php endif; ?>
  
  <div class="content_row">
    <div class="content_row_label">
      Squad:
    </div>
    <div class="content_row_data">
      <?php echo $squad; ?>
      <?php if ($viewing_self): ?>
        <span class="accent_color">(<a href="http://<?php echo DOMAIN; ?>/squad" class="accent_color">edit</a>)</span>
      <?php endif ?>
    </div>
    <div class="clearfix"></div>
  </div>
  
  <?php if ($viewing_self && ($GLOBALS['User']->IsPlayingCurrentGame($user['uid'])) && (isset($GLOBALS['state']['active']))): ?>
  <div class="content_row">
    <div class="content_row_label">
      Secret Game ID:
    </div>
    <div class="content_row_data secret">
      <?php echo $secret ?>
    </div>
    <div class="clearfix"></div>
  </div>
  <?php endif ?>

  <!--
  <div class="content_row">
    <div class="content_row_label">
      Current squad:
    </div>
    <div class="content_row_data">
      <a class="accent_color" href="http://<?php echo DOMAIN; ?>/#">None</a>
    </div>
    <div class="clearfix"></div>
  </div>
  -->
  <?php if ($viewing_self && ($GLOBALS['User']->IsPlayingCurrentGame($user['uid'])) && (isset($GLOBALS['state']['active']) && $game_xref['status'] == 'zombie')): ?>
  <div class="content_row">
    <div class="content_row_label">
      Time until starve:
    </div>
    <div class="content_row_data">
      <?php 
        $time = $GLOBALS['User']->GetUserFromGame($user['uid']);
        $time = $time['zombie_feed_timer']; 
        $seconds = $time + 172800 - date("U");
         $hours = floor($seconds / 3600);
         $mins = floor(($seconds - ($hours*3600)) / 60);
         echo $hours.":".$mins;
      ?>
    </div>
    <div class="clearfix"></div>
  </div>
  <?php endif ?>
  <div class="content_row">
    <div class="content_row_label">
      Lifetime kills as zombie:
    </div>
    <div class="content_row_data">
      <?php echo $view_zombie_kills ?>
    </div>
    <div class="clearfix"></div>
  </div>

  <div class="content_row">
    <div class="content_row_label">
      Lifetime time-alive as human:
    </div>
    <div class="content_row_data">
      <?php echo $view_time_alive ?>
    </div>
    <div class="clearfix"></div>
  </div>
  
  <?php if ($viewing_self): ?>
  <div class="content_row">
    <div class="content_row_label">
      Change Profile Picture:
    </div>
    <div class="content_row_data">
      <span class="accent_color">(<a href="http://<?php echo DOMAIN; ?>/changepicture" class="accent_color">edit</a>)</span>
    </div>
    <div class="clearfix"></div>
  </div>
  <?php endif; ?>
