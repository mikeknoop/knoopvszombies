  <div id="joingame_title">
    <span class="accent_color">Current and Upcoming</span> HvZ Games
  </div>

  <div class="joingame_header">
    <p>Congratulations! You have joined an upcoming Humans vs. Zombies game at Oregon State. Below is your secret ID valid for THIS GAME ONLY! Write this down on a notecard (also listed on profile). You will need to give your game secret to the zombie who tags you. <span class="accent_color">Grab an index card and write down the following information:</span></p> 
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
  
  <br />
  
  <div class="joingame_header">
    <p><span style="font-size: 16px;" class="bold">OZ POOL</span>: We randomly select the original zombies from this pool. You may opt-into the original zombie pool <a class="accent_color" href="http://<?php echo DOMAIN; ?>/joingame/ozoptin/<?php echo $game['gid'];?>">by clicking here</a>. What is an original zombie? They are players who start the game as zombie, and on the first day of the game, they get to disguise themselves as humans! Original zombies take great pleasure infecting as many players as possible on day one.</p> 
  </div>

  <div class="joingame_header">
    <p><span style="font-size: 16px;" class="bold">ORIENTATIONS</span>: we have orientation meetings setup. You must attend at least one orientation session! If you do not attend at least one orientation, <span class="bold">you will be deceased at the beginning of the game.</span> These will aquaint you with rules, gameplay and get you geared up for the game. <a class="accent_color" href="http://<?php echo DOMAIN; ?>/orientations/<?php echo $joined_game['gid'] ?>">Click here to view a list of the orientation sessions for the <?php echo $joined_game['name'] ?> game.</a></p> 
  </div>
  
  <div class="joingame_header">
    <p>You are now ready to play! Grab your Nerf Blaster and your socks and get ready to take on the zombie horde! We will have email announcments closer to game time so stay tuned.</p> 
  </div>
  

  
  <div class="joingame_content">    
  </div>
