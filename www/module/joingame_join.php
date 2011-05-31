  <div id="joingame_title">
    <span class="accent_color">Current and Upcoming</span> HvZ Mizzou Games
  </div>

  <div class="joingame_header">
    <p>Congratulations! You have joined an upcoming Humans vs. Zombies game at Mizzou. Below is your secret ID valid for THIS GAME ONLY! Write this down on a notecard (also listed on My Account). You will need to give your game secret to the zombie who tags you. <span class="accent_color">Grab an index card and write down the following information:</span></p> 
  </div>
  
  
  <div id="joingame_cardfront">
    <div class="joingame_cardsubtitle">
      Secret Game ID (front)
    </div>
    <div class="joingame_cardtext">
      <span class="bold"><?php echo $secret ?></span>
    </div>
  </div>

  <div id="joingame_cardback">
    <div class="joingame_cardsubtitle">
      Your Name (back)
    </div>
    <div class="joingame_cardtext">
      <span class="bold"><?php echo $_SESSION['name'] ?></span>
    </div>
  </div>
  
  <div class="clearfix"></div>

  <div class="joingame_header joingame_header_important">
  TWO IMPORTANT THINGS:
  </div>
  
  <div class="joingame_header">
    <p>One, You have been automatically put into the original zombie pool. We randomly select the original zombies from this pool. You may opt-out of the original zombie pool <a class="accent_color" href="http://<?php echo DOMAIN; ?>/joingame/ozoptout/<?php echo $game['gid'];?>">by clicking here</a>.</p> 
  </div>

  <div class="joingame_header">
    <p>Two, we have orientation meetings setup for Humans vs. Zombies at Mizzou. You must attend at least one orientation session! If you do not attend at least one orientation, <span class="bold">you will be deceased at the beginning of the game.</span> These will aquaint you with rules, gameplay and get you geared up for the game. <a class="accent_color" href="http://<?php echo DOMAIN; ?>/orientations/<?php echo $joined_game['gid'] ?>">Click here to view a list of the orientation sessions for the <?php echo $joined_game['name'] ?> game.</a></p> 
  </div>
  
  <div class="joingame_header">
    <p>You are now ready to play! Grab your Nerf Gun and your socks and get ready to take on the zombie horde! We will have email announcments closer to game time so stay tuned.</p> 
  </div>
  

  
  <div class="joingame_content">    
  </div>