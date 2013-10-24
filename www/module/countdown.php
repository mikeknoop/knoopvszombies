<div id="countdown_container">
  <a href="http://<?php echo DOMAIN; ?>/playerlist">

  <div id="cd_timer_container">

    <div id="cd_timer_countdown">              
      <div id="cd_timer_days" class="cd_timer_value">
        00
      </div>
      <div id="cd_timer_days_title" class="cd_timer_subtitle">
        Days
      </div>

      <div id="cd_timer_hours" class="cd_timer_value">
        00
      </div>
      <div id="cd_timer_hours_title" class="cd_timer_subtitle">
        Hours
      </div>

      <div id="cd_timer_minutes" class="cd_timer_value">
        00
      </div>
      <div id="cd_timer_minutes_title" class="cd_timer_subtitle">
        Mins
      </div>
      
      <div id="cd_timer_seconds" class="cd_timer_value">
        00
      </div>
      <div id="cd_timer_seconds_title" class="cd_timer_subtitle">
        Secs
      </div>
    </div>
  </div> <!-- cd_timer_container -->

  <div id="cd_human_container">
    <div id="cd_humans_count" class="cd_player_value accent_color">
      <?php echo $playerCounts['humans']; ?>
    </div>
    <div id="cd_humans_title" class="cd_player_subtitle accent_color">
      Humans
    </div>
  </div> <!-- cd_human_container -->

  <div id="cd_zombie_container">
    <div id="cd_zombies_count" class="cd_player_value accent_color">
      <?php echo $playerCounts['zombies']; ?>
    </div>
    <div id="cd_zombies_title" class="cd_player_subtitle accent_color">
      Zombies
    </div>
  </div> <!-- cd_zombie_container -->
  
  <div id="cd_deceased_container">
    <div id="cd_deceased_count" class="cd_player_value accent_color">
      <?php echo $playerCounts['deceased']; ?>
    </div>
    <div id="cd_deceased_title" class="cd_player_subtitle accent_color">
      Deceased
    </div>
  </div> <!-- cd_deceased_container -->
  
  <div class="clearfix"></div> 
  <script type="text/javascript">
  <!--
    <?php
    // Grab the current game starting time
    $game = $GLOBALS['Game']->GetGame($GLOBALS['state']['gid']);
    // 30 second padding so that the CRON script can execute in BG
    $start_time = $game['start_time'] + 30;

    // Figure out the days/hours/minutes/seconds from now until $start_time, pass them to JS
    $end = date("U");

    if ($game['end_time'] != 0 && $game['end_time'] != '')
    {
      $end = $game['end_time'];
    }

    $time_diff = $start_time - $end;

    if ($time_diff <= 0)
    {
      // Game has started, we want to be counting up
      echo "var count_down = false;\n";
    }
    else
    {
      // Game has NOT started, we want to be counting down
      echo "var count_down = true;\n";
    }

    $time_diff = abs($time_diff);

    // Days
    $days = floor($time_diff / (60*60*24));
    $time_diff = $time_diff - (60*60*24*$days);

    // Hours
    $hours = floor($time_diff / (60*60));
    $time_diff = $time_diff - (60*60*$hours);

    // Minutes
    $minutes = floor($time_diff / (60));
    $time_diff = $time_diff - (60*$minutes);

    // Seconds
    $seconds = $time_diff;

    echo "var days = $days;\n var hours = $hours;\n var minutes = $minutes;\n var seconds = $seconds;\n";

    echo "var paused = false;\n";
    if ($GLOBALS['state'] && $GLOBALS['state']['countdown_paused'])
      echo "paused = true;\n";

    if ($GLOBALS['state'] && !$GLOBALS['state']['active'] && ($game['start_time'] <= (date("U"))))
      echo "paused = true;\n";
      
    ?>
  -->
  </script>
  <script type="text/javascript" src="js/countdown.js?<?php echo date("U"); ?>"></script>

  </a>
</div> <!-- group_countdown_container -->
