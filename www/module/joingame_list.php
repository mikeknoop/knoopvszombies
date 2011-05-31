  <div id="joingame_title">
    <span class="accent_color">Current and Upcoming</span> HvZ Mizzou Games
  </div>

  <div class="joingame_header">
    <p>Below is a list of current and upcoming Humans vs. Zombies games at Mizzou. To participate in a game you must join it and receive your secret game ID. Note you can only join games which are not already in progress. If you don't see any games to join, check back shortly and we will add a game for next semester.</p>
  </div>

  <div class="joingame_content">

      <div class="game_row row_heading">
        <div class="row_name row_heading_label">
        Game
        </div>
        <div class="row_start_time row_heading_label">
        Begins on
        </div>
        <div class="row_players row_heading_label">
        Players
        </div>
        <div class="row_status row_heading_label">
        Status
        </div>
        <div class="row_action row_heading_label">
        Join
        </div>
        <div class="clearfix"></div> 
      </div> 
      
    <?php $i = 0; ?>
    <?php foreach ($games as $game): ?>
    
      <div class="game_row">
        <div class="row_name">
          <?php if ($game['name'] != ''): ?>
            <?php echo $game['name'] ?>
          <?php else: ?>
            (New Game)
          <?php endif; ?>
          
        </div>
        <div class="row_start_time">
          <?php if ($game['start_time'] != '0'): ?>
            <?php echo date("F d, Y", $game['start_time']); ?>
          <?php else: ?>
            (not decided yet)
          <?php endif; ?>
        </div>
        <div class="row_players">
          <?php echo $GLOBALS['Game']->GetPlayerCount($game['gid']); ?>
        </div>
        <div class="row_status">
          <?php if (isset($user_joined_game[$game['gid']]) && $user_joined_game[$game['gid']]): ?>
            Joined
          <?php elseif (!$game['registration_open']): ?>
            Registration Closed
          <?php elseif (!$game['active']): ?>
            Joinable
          <?php else: ?>
            In progress
          <?php endif; ?>
        </div>
        <div class="row_action">
          <?php if (isset($user_joined_game[$game['gid']]) && $user_joined_game[$game['gid']]): ?>
            (already joined)
          <?php elseif (!$game['registration_open']): ?>
            (registration closed)
          <?php elseif (!$game['active']): ?>
                
            <a class="joingame_button_link" href="http://<?php echo DOMAIN; ?>/joingame/<?php echo $game['gid'];?>">
              <span class="joingame_button">
              Join Game
              </span>
            </a>
                
          <?php else: ?>
            (game already started)
          <?php endif; ?>
        </div>
        <div class="clearfix"></div> 
      </div>   
      
    <?php $i++; ?>
    <?php endforeach ?>
    
    <?php if ($i == 0) { echo "There are no games to join, check back soon!"; } ?>
    
  </div>