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
  
  <div class="reportakill_row">
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
        <option value="g">G</option>
        <option value="h">H</option>
        <option value="i">I</option>
        <option value="j">J</option>
        <option value="k">K</option>
        <option value="l">L</option>
        <option value="m">M</option>
        <option value="n">N</option>
        <option value="o">O</option>
        <option value="p">P</option>
        <option value="q">Q</option>
        <option value="r">R</option>
        <option value="s">S</option>
        <option value="t">T</option>
        <option value="u">U</option>
        <option value="v">V</option>
        <option value="w">W</option>
        <option value="x">X</option>
        <option value="y">Y</option>
        <option value="z">Z</option>
        <option value="aa">AA</option>
        <option value="bb">BB</option>
        <option value="cc">CC</option>
        <option value="dd">DD</option>
        <option value="ee">EE</option>
        <option value="ff">FF</option>
        <option value="gg">GG</option>
      </select>
      <select class="reportakill_form_location_input" name="location_y">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        <option value="13">13</option>
        <option value="14">14</option>
        <option value="15">15</option>
        <option value="16">16</option>
        <option value="17">17</option>
        <option value="18">18</option>
        <option value="19">19</option>
        <option value="20">20</option>
        <option value="21">21</option>
        <option value="22">22</option>
        <option value="23">23</option>
        <option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>        
      </select>
    </div>
    <div class="reportakill_form_location_input">
      <a class="accent_color" href="http://<?php echo DOMAIN; ?>/img/campus_map.jpg" target="_new">View Map</a>
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