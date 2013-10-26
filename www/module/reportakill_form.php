 <form id="reportakill" name="reportakill" action="http://<?php echo DOMAIN; ?>/report/submit" method="POST">
  
  <?php
  $playerArray = $GLOBALS['Game']->GetPlayers($GLOBALS['state']['gid'], 'all', null, 'starve_time');

  ?>
  
  <div class="reportakill_row">
    <div class="reportakill_label">
      Enter a Secret Game ID:
    </div>

    <div class="reportakill_form">
        <input type="text" name="secret" class="reportakill_form_input" />
    </div>
    <div class="clearfix"></div>
  </div>
  
  <div class="reportakill_row">
    <div class="reportakill_label">
      Zombie to Feed (#1):
    </div>
              
    <div class="reportakill_form">
      <select name="feed1" class="reportakill_form_select">
        <option value="">Choose Player</option>
        <?php
          if (is_array($playerArray))
          {
            foreach ($playerArray as $player)
            {
              if ($player['status'] == 'zombie' && $player['uid'] != $_SESSION['uid'])
              {
                if (($GLOBALS['state']['oz_hidden'] && !$player['oz']) || !$GLOBALS['state']['oz_hidden'])
                {
                  $now = date("U");
                  $starve_time = $player['zombie_feed_timer'] + (60*60*48);
                  $hours_left = ceil(($starve_time - $now) / (60*60));
                  $kills = $player['zombie_kills'];
                  
                  echo "<option value='{$player['uid']}'>{$player['name']} ($hours_left hours left, $kills kills)</option>";
                }
              }
            }
          }       
        ?>
      </select>
    </div>
    <div class="clearfix"></div>
  </div>
  
  <!-- <div class="reportakill_row">
    <div class="reportakill_label">
      Zombie to Feed (#2):
    </div>
              
    <div class="reportakill_form">
      <select name="feed2" class="reportakill_form_select">
        <option value="">Choose Player</option>
        <?php
          if (is_array($playerArray))
          {
            foreach ($playerArray as $player)
            {
              if ($player['status'] == 'zombie' && $player['uid'] != $_SESSION['uid'])
              {
                if (($GLOBALS['state']['oz_hidden'] && !$player['oz']) || !$GLOBALS['state']['oz_hidden'])
                {
                  $now = date("U");
                  $starve_time = $player['zombie_feed_timer'] + (60*60*48);
                  $hours_left = ceil(($starve_time - $now) / (60*60));
                  
                  echo "<option value='{$player['uid']}'>{$player['name']} ($hours_left hours left)</option>";
                }
              }
            }
          }       
        ?>
      </select>
    </div>
    <div class="clearfix"></div>
  </div>
  -->
  <div class="reportakill_row">
    <div class="reportakill_label">
      Where did the kill occur?
    </div>     
    <div class="reportakill_form">
      <select class="reportakill_form_location_input" name="location_x">
        <option value="a">A</option>
        <option value="b">B</option>
        <option value="c">C</option>
        <option value="d">D</option>
        <option value="e">E</option>
        <option value="f">F</option>
      </select>
      <select class="reportakill_form_location_input" name="location_y">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
      </select>
    </div>
    <div class="reportakill_form_location_input">
      <a class="accent_color" href="http://<?php echo DOMAIN; ?>/img/campus_map.png" target="_new">View Map</a>
    </div>
    <div class="reportakill_caption">
      (Optional)
    </div>
    <div class="clearfix"></div>
  </div>
  
  <div class="reportakill_row">
    <div class="reportakill_label">
      &nbsp
    </div>
              
    <div class="reportakill_form">
        <input type="submit" value="Report Kill" class="reportakill_form_submit" />
    </div>
    <div class="clearfix"></div>
  </div>
  
</form>
