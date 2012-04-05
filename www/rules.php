<?php

  $page_title = 'HvZ: Mizzou Style';
  $require_login = false;

  require '../muzombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';


?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/page/rules.css" rel="stylesheet" type="text/css"/>
  
</head>

<body>

  <div id="body_container">
  
    <?php
      require 'module/header.php';
    ?>
    
    <div class="content_column">
      <div id="content">
      
        <div id="content_top_border">
        
          <?php
            require 'module/body_header.php';
          ?>
          
        </div>
        
        <div id="body_content">
        
        <div id="rules">
                 
          <div class="odd">
            <div class="rules_header">Game <span class="accent_color">Rules</span></div>
            <div>(last update, April 6, 2011)</div>
            <div>Humans vs. Zombies is a week long, 24/7 game of tag.  All players begin as humans, and one or more is randomly chosen to be the "Original Zombie."  The Original Zombie tags human players and turns them into zombies.  The zombie must tag and "feed" on a human every 48 hours or he/she starves to death and is out of the game. As a human, you can be tagged at any time when you are outside. Be aware of your surroundings! The game always begins at MIDNIGHT on the first day of the game.</div>
            <div>If you have not already registered, go do so now (at <a href="//<?php echo DOMAIN; ?>/signup">muzombies.org/signup</a>). Make sure to write your secret Game ID on an index card (Make sure to do so accurately!). Also, write your name on the backside. This ID card helps keep track of who is a human and who is a zombie.</div>
            
          </div>

          <div class="even">

            <div><span class="rules_heading">New Rules and Rule Changes for this semester</span></div>
             <div><OL class="rules">
                <LI>No new rules yet for this semester.</LI>
             </OL></div>
  
              
          </div>
          
          <div class="odd">
             <div><span class="rules_heading">Quick Rule List</span></div>
             
             <div><OL class="rules">                
<LI><span class="bold">DON’T BE A DICK!</span><br /> Be a dude. Be courteous, respectful of others, and responsible.
<LI><span class="bold">ATTEND THE MISSIONS</span><br /> Missions move the game along and are a ton of fun. Remember, buildings are offlimits during missions.
<LI><span class="bold">WEAR YOUR BANDANA!</span><br /> Humans: worn around the arm, above the elbow. Zombies: worn “ninja” style, around your head
<LI><span class="bold">CARRY YOUR CORRECT ID AT ALL TIMES!</span><br />	If a zombie tags you, you need to hand it over to them.
<LI><span class="bold">READ YOUR EMAIL/CHECK FACEBOOK OFTEN</span><br /> Game sensitive information will be sent via these channels, so why put off doing something we all know you do anyway?
<LI><span class="bold">USE NERF GUNS/DARTS OR BALLED UP SOCKS FOR DEFENSE</span><br />	The use of realistic looking weaponry (i.e. Airsoft/paintball guns) is strictly forbidden for both safety and consideration issues.
<LI><span class="bold">TAG HUMANS ON THEIR PERSON</span><br />	Bag tags and gun tags do not count
<LI><span class="bold">BE A SMART PLAYER</span><br />	Staying in the know about rules and other information makes the game fun
<LI><span class="bold">HIDE YOUR WEAPONS IN CLASS</span><br />	That hot girl or guy is not gonna be impressed with your modded longshot, so put it away and avoid distractions. Also, its against university policy to have weapons out in any academic building.
<LI><span class="bold">LISTEN TO THE MODERATORS</span><br />	There is a reason they are in charge.  Listen to them and do as they say, since they are the ones who are responsible for making the game run smoothly.
             </OL></div>

          </div>
          
          <div class="even">

            <div>Humans vs. Zombies is an official organization now at Mizzou!</div>
            <div class="highlight">THE GOLDEN RULE OF HUMANS VS. ZOMBIES IS: <b>DON'T BE A DICK</b>.</div>
            <div>Trust us, the game isn't fun if players become dicks. We've seen it happen every semester. We'll try to moderate a fair game, but in the end it's the players who make the game.</div>
            <div class="highlight">THE SILVER RULE OF HUMANS VS. ZOMBIES IS: <b>BE A SMART PLAYER</b>.</div>
            <div>The rules here are not overly complicated, please read through them and email us if you have any concerns. There should be very few times you should need to call the HvZ Help Line (see below). Try to sort out problems amongst yourselves.</div>
              
          </div>

          <div class="odd">
             <div><span class="rules_heading">SAFETY RULES (ie, Instant Bannable Offenses)</span></div>
             
             <div><OL class="rules">
                <LI>No realistic looking weaponry (Don't paint your Nerf guns!)
                <LI>Do NOT modify your darts (modding Nerf guns is okay, though)
                <LI>Nerf guns must NOT be visible inside academic buildings or jobs on campus.
                <LI>Nerf Swords may NOT be used.
                <LI>Players may NOT use any sort of wheeled device (car, bike, skateboard, etc.) on campus to move. The exception to this rule is if you cannot make it to your job/work/class normally on time without wheels. Remove your bandana if you must do this!
                <LI>Do NOT shoot/tag non-players.
             </OL></div>

          </div>

          <div class="even">
            <div><span class="rules_heading">BANDANNA ETIQUETTE</span></div>
            <div>All players involved in Humans vs. Zombies must wear a bandanna at outlined below while the game is in progress (excluding work, practice, etc.)</div>
            <div>
            <UL class="rules">
              <LI>  
                COLOR:
              </UL>
              <OL class="rules">  
              <LI>The following two colors are reserved: WHITE and ORANGE.
              <LI>White is reserved for Moderators.
              <LI>Orange is reserved for "NPC" characters during missions.
              <LI>Persons in multiple categories with layer their bandannas. For example, a Moderator who is also an NPC will have an Orange AND White Bandanna.
              <LI>Humans and Zombies may wear any other color other than WHITE and ORANGE. we will enforce this.
            </OL></div>
            
            <div><UL class="rules">
              <LI>  
                HUMANS:
              </UL>
              <OL class="rules">
              <LI>Humans must wear their bandannas around their upper arms (above the elbow).
              <LI>Bandannas must not hidden and must be clearly visible from 50+ feet.
            </OL></div>
            
            <div><UL class="rules">
              <LI>  
                ZOMBIES:
              </UL>
              <OL class="rules">
              <LI>Zombies must wear their bandanna around their forehead "ninja style" and must be visible from 50+ feet away (not under your hair, in a banana suit, or headband style). <a href="//www.facebook.com/photo.php?pid=3884883&id=321382063537" class="accent_color">SEE EXAMPLE</a>
              <LI>Zombies must move their bandanna to their neck immediately upon being stunned by a human.
              <LI>Bandannas must be worn around your forehead for at least 30 seconds before tagging a human.
              <LI>IMPORTANT, the Original Zombie(s) do not need to wear a bandana around their head for the first 24 hours of the game. However they do have to wear it around their arm as if they were a human. After the 24 hours the original zombie must wear the bandana around their head. Any zombie tagged by an Original Zombie must obey normal bandanna etiquette.
              </OL></div>

          </div>
          
          <div class="odd">
            <div><span class="rules_heading">OFF LIMITS</span></div>
             <div><UL class="rules">
                <LI>
                  Due to certain factors, we cannot have players in (or cutting through) certain areas.
                <LI>These off limit areas will be enforced VERY STRICTLY. Players will receive LIFETIME BANS for offenses as you are jeopardizing the game for everyone else here at MU.  
                <LI>We have had the police called on us in the past, and fines may be imposed if players are found cutting through/in:
             </UL></div>
             
             <div><OL class="rules">  
                <LI>Parking Garages (Do not cut through, either. GO AROUND. Police have been called in the past.)
                <LI>Stankowski Field (MU HvZ must pay fines if you cut through. AVOID AND GO AROUND)
             </OL></div>
            
          </div>

          <div class="even">
            <div><span class="rules_heading">HUMANS</span></div>
            <div>Objective: Survive the game, and complete missions in order to ensure your survival.</div>
            <div><OL class="rules">  
                <LI>Make sure you are carrying your CORRECT ID card with your number at all times. You will hand this over to the zombie in the event you are tagged. If there is a conflict, call us at the HvZ Help Line (see below) but realize we may decide to flip and coin to decide your fate or immediately decide to zombify you.
                <LI>DURING THE DAY: In the event you are tagged, you must wait 10 minutes before you are allowed to tag anyone as a zombie. Move your armband to your neck (ie, stunned zombie) for 10 minutes. Then you may move it to your forehead and proceed with tagging 30 seconds after your headband is around your head (see ZOMBIES section below).
                <LI>DURING MISSIONS: In the event you are tagged, move your bandanna to your forehead to indicate you are tagged and stunned. Then make your way to the zombie respawn point for that mission (ask a zombie if you are unsure where it is for that mission). Once you reach the respawn point, you are now officially a zombie.
                <LI>If you have not been marked as zombie within THREE (3) HOURS of being tagged, contact the HvZ Help Line (see below). You will remain a human, and will get a new ID. Note, any kills you got during those 3 hours STILL COUNT and their IDs should be given to the moderator when you call. It is your responsibility to contact us at the 3 Hour mark. Until you receive a new secret game ID from a moderator, you can still be turned into a zombie on the website. 
                <LI>Please also note during missions, the 3 hour timer starts when the mission is officially over (zombies need time to get to computers).
                <LI>Getting tagged on your backpack or weapon is NOT a valid tag.
                <LI>Humans may not be tagged while inside safe zones (see SAFE ZONES below)
                <LI>Humans may shoot and stun zombies from both safe and non-safe zones. The stun time is the same.
                <LI>Humans may be tagged while off campus (such as walking around downtown)! However you are safe inside buildings off campus as usual. Please be respectful of others and their property when off campus.
                <LI>If you use a Walkie Talkie do not go onto Channels 5 and 6. These are reserved channels. Any human found/heard on this channel will be zombied.
                <LI>Face-masks are not allowed (players concealing their identities). This includes full face masks and bandannas coverering mouth/nose, etc. You may still wear face paint, sunglasses and eye protection if you so choose. If in doubt, ask a mod ahead of time.
            </OL></div>

          </div>

          <div class="odd">
            <div><span class="rules_heading">ZOMBIES</span></div>
            <div>Objective: Tag and devour as many humans as possible. Your goal is complete and utter zombification. Prevent humans from succeeding on missions.</div>

            <div><UL class="rules">
              <LI>  
                GENERAL:
              </UL>
              <OL class="rules">
              <LI>If you use a Walkie Talkie do not go onto Channels 5 and 6. These are reserved channels. Any human found/heard on this channel will be zombied.
              <LI>Face-masks are not allowed (players concealing their identities). This includes full face masks and bandannas coverering mouth/nose, etc. You may still wear face paint, sunglasses and eye protection if you so choose. If in doubt, ask a mod ahead of time.
            </OL></div>
            
            <div><UL class="rules">
              <LI>  
                BEING STUNNED:
              </UL>
              <OL class="rules">
              <LI>When shot with a Nerf gun or hit with a sock/nerf dart (throwing Nerf darts is NOT allowed), a zombie is stunned.
              <LI>Humans may not throw darts to stun a zombie. A dart must be fired from a blow gun or blaster.
              <LI>During the Day: When a zombie is stuned, they are stunned for 10 minutes. A stunned zombie may not interact with the game in any way.
              <LI> During Missions: Zombies will have respawn points instead of stun timers. You will need to visit a respawn point to become unstunned.
              <LI>When stunned, do NOT shield other zombies, follow humans, communicate with fellow zombies, etc. Move 20 feet away from the nearest player to ensure 
this. Moderators may remove you from the game if you do not follow this rule.
              <LI>One exception is if a zombie is stunned when the zombie is inside a safe zone. The stun timer is only one minute in this case.
              <LI>When stunned, move your headband around your neck to indicate you are stunned. Move it back after you are unstunned.
              <LI>Head shots count! You are stunned if hit in the head by a Nerf Dart/Sock.
              <LI>Ricocheting darts/socks are "dead" and cannot stun a zombie. 
              <LI>If a zombie swats/catches socks/darts, they are stunned.
              <LI>Zombies are considered stunned if they maliciously pick up ammunition of humans. You may pick up darts to compile or throw them back to humans HOWEVER if a human requests you give him/her a dart which belongs to them, and you do not comply, you are considered stunned. So, best case is to just leave ammo on the ground.
              
            </OL></div>
            
            <div><UL class="rules">
                <LI>  
                  TAGGING HUMANS:
                </UL>
                <OL class="rules">
                <LI>When a zombie tags a human, collect their ID Card. If there is dispute over a rule, you may use the HvZ Help Line for clarification. Otherwise, please work it out amongst yourselves.
                <LI>A zombie may only tag TWO humans at a time (ie, one for each hand). During a mission, you may tag again after you collect the ID cards from the zombies (make sure to register the kills on the website within 3 hours!). When missions are not happening, zombies may only carry TWO ID cards at any given time (you need to register them on the website before getting more kills.). Call the HvZ Help Line (see below) if you are not near a computer.
                <LI>Zombies have THREE (3) HOURS to report kills through the website. If you cannot make it to a computer, call the HvZ Help Line (see below) and we can report the kill for you.
                <LI>If you do not report a kill within 3 hours, the player will remain human (subject to them getting a new Secret Game ID immediately, see above, humans).
                <LI>Zombies must get a tag (feed) every 48 hours to remain alive! This is regulated by the online system. If you become deceased, any tags you get after the fact will be invalidated.
                <LI>Tags must be purposeful (not accidental) and must be tagged by hand.
                </OL></div>
                
          </div>

          <div class="even">
            <div><span class="rules_heading">SAFE ZONES</span></div>
            <div>Safe zones are places and scenarios where humans may not be tagged and turned into a zombie. These safe zones are only valid during the day. Safe Zones during missions are to be determined during the game. Daytime safe zones include:</div>
            <div><OL class="rules">
                <LI>Inside any building (res hall, rec center, library, dining hall, etc).
                <LI>Inside any building off campus.
                <LI>Attending any class (including outdoor classes, class ends when the instructor dismisses).
                <LI>When a human has two feet inside any safe zone (even if they are leaning outside of the safe zone, see below SPECIAL NOTE AROUND DOORS)
                <LI>Inside parking garages and inside cars during the day. (Note: parking garages are off limits during missions)
                </OL></div>
                
            <div><UL class="rules">
                <LI>
                  SPECIAL NOTE AROUND DOORS:
                </UL>
                <OL class="rules">
                <LI> 
                  Doors have been a considerable problem in the past. As a human, you are safe for 5 seconds once you touch a door handle. This allows you to get through the door safely (the key card swipers count as door handles). If you are not inside within 5 seconds, you may be tagged. You may not "re touch" the door handle to gain another 5 seconds.
                <LI>You must have BOTH feet inside the building to be considered safe. If any part of your body touches the ground outside the building, you may be tagged until both feet are grounded again inside the building. 
                <LI>As a human, when coming out of the building, you are safe for 5 seconds or 5 feet, whichever comes first.
                <LI>The door rules are in place to ensure safe (physical safety) entering and exitting buildings. If players are found exploiting these rules on either team, do not expect Moderators to rule in your favor.
                <LI>Zombies may not enter buildings during missions.
                </OL></div>
               
            <div><UL class="rules">
                <LI>
                  SPECIAL NOTE AROUND PARKING GARAGES:
                </UL>
                <OL class="rules">
                <LI>
                  As noted, parking garages are safe zones during the day (consider them a building) and off limits during missions for security reasons. Parking garages don't have well defined "exits", but imagine an imaginary plane across the openings. If any part of your body touches the ground outside the plane, you may be tagged.
                </OL></div>

            <div>All buildings are off limits during Missions for both teams. Entering a building will result in being turned into a zombie or deceased.</div>
            <div><OL class="rules">
                <LI>Humans will have the ability to earn safe zones during missions.
                <LI>Unless otherwise stated, safe zones earned last the duration of the game.
                <LI>Safe zones earned during missions are not safe during the day.
                </OL></div>
                
          </div>

          <div class="odd">
            <div><span class="rules_heading">MISSIONS</span></div>
            <div>Missions are necessary to get humans out of buildings, and to make the game more fun.</div>
            <div>Mission details will be released closer to game time, but be aware there will likely be a mission EVERY DAY! Attendance will not be taken before or after missions, however there will be very clear, defined, winning conditions for the humans. In other words, you will know exactly what you need to do to survive the week of HvZ. The game may end before a week if humans are unable to complete the required missions.</div>
            <div>Humans may not leave the following square area when formal missions are happening:</div>
            <div>College/Stadium/Providence/Elm-University</div>
            <div>A mission will be failed if humans are found to have left this area with objectives.</div>
            <div>In many cases, humans will have a starting point and time via email and facebook. At this location and time, there will be a ring of orange cones. Humans are safe inside this ring, and cannot be tagged while inside the ring. </div>
            <div>During all missions, BUILDINGS ARE OFFLIMITS. Players entering buildings will be turned into zombies or kicked from the game. Safe Zones will be established during the game (SEE SAFE ZONES ABOVE).</div>  
          </div>

          <div class="even">
            <div><span class="rules_heading">SPECIAL CASES</span></div>
            <div><OL class="rules">
                <LI>People who are not registered to participate may not interact with the game in any way. This includes bringing food to humans, spying/passing ANY information to either team, etc.
                <LI>If a kill is not reported within 3 hours, that player remains human. They will be assigned a new ID. Contact the HvZ Help Line (see below) to get your new ID. Note, any kills this human got during the 3 hours STILL COUNT and should be given to the moderator while receiving your new ID. This rule is simply to make sure we don't start a chain reaction of people calling the Help Line asking for new IDs (because we have a limited amount of new ones).
                <LI>Problematic players will be banned from the game for the rest of the semester, and their names may be reported to MU.
                </OL></div>

          </div>

          <div class="odd">
            <div><span class="rules_heading">HvZ MIZZOU HELP LINE</span></div>
            <div>Only use this number to get help as a last resort. Please try to work it out amongst yourselves before calling us, us mods have lives too. If your problem/cocern is less urgent, consider emailing us at muzombies@gmail.com</div>
            <div>(573) 833-0385</div>
            <div>Note: We don't have text messages enabled, but feel free to leave us a voicemail if no one answers (AND LEAVE A CALLBACK NUMBER)</div>
            <div>HAVE A GREAT GAME! Remember, be respectful, don't be a dick, and HAVE FUN!</div>

          </div>


          </div> <!-- rules -->   
            
        </div> <!-- body_content -->

      </div> <!-- content -->
    </div>  <!-- content_column -->
    
    
    <div id="footer_push"></div>
  </div> <!-- body_container -->

  <?php
    require 'module/footer.php';
  ?>


</body>

</html>
