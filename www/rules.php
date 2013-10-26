<?php

  $page_title = 'HvZ rules';
  $require_login = false;

  require '../knoopvszombies.ini.php';
  
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
            <div>(last update, September 29, 2013)</div>
            <div>Humans vs. Zombies (HvZ) is a game of tag of epic proportions. There are two teams, the Human Resistance, and the Zombie Horde. All players begin as Humans, except one who is randomly chosen to be the Original Zombie (Players can opt out of being chosen as the Original Zombie). The Original Zombie tags Human players, turning them into Zombies. The Zombies must "feed" on a Human every 48 hours, by tagging them, or they starve to death and are out of the game. The Humans can defend themselves from the Zombies with various game Nerf devices, such as Nerf blasters.</div>
          </div>

          <div class="even">

            <div><span class="rules_heading">New Rules and Rule Changes for this semester</span></div>
             <div><OL class="rules">
                <LI>No new rules yet for this semester.</LI>
             </OL></div>
  
              
          </div>
          
          <div class="odd">
             <div><span class="rules_heading">Objectives</span></div>
             <div> The Zombies win when all Human players have been tagged and turned into Zombies, or by preventing the Humans from completing the final mission.</div>
             <div> The Humans win by surviving long enough for all of the Zombies to starve, or by completing the final mission.</div>
          </div>
          
          <div class="even">
            <div><span class="rules_heading">Eligibility</span></div>
            <div>To be eligible to play, players must be able to spend an adaquate amount of time on campus (1-3hrs per day) during the game week. Violation of any rules may result in a ban from the game. You must register at the OSU HVZ website to play. You must also agree to the OSU OSUndead Humans vs. Zombies Agreement (when you register on this website) and complete, sign, and return the liability waiver at orientation.  You MUST attend ONE orientation out of the dates specified on the front page, and if you cannot make one of these dates email us at mods@osundead.com to arrange a separate one.</div>
            <div>You will start as deceased if you do not attend an orientation AND return the liability waiver.  (Plus, you won't get an armband if you don't.)</div>
            <div>One-on-one orientations can be done before the start of the game on request by emailing the Mod email at Mods@osundead.com</div>
          </div>

          <div class="odd">
             <div><span class="rules_heading">Safety Rules</span></div>
             
             <div><OL class="rules">
                <LI>Rules created for the safety of all players are strictly enforced. Violation of safety rules may result in a removal and ban from the game, even on the first occurrence and without prior warning.
                <LI>No realistic looking weaponry. All Nerf devices must be inspected by a mod before the game. Approved devices will be marked with a zip-tie as proof they've been inspected. Using a Nerf device that hasn't been inspected will result in removal from the game.
                <LI>Game devices may not be visible inside of academic buildings or jobs on campus (i.e. Nerf Devices). Make sure they are tucked away entirely, with no handles showing, etc.
                <LI>Nerf markers must not hurt on impact. (If you're not sure about this, ask a moderator).
                <LI>Common Sense. If something seems excessively dangerous, don't do it.
                <LI>Stairs are safe for humans only. Zombies can be stunned on stairs, humans can not be tagged as long as they have at least one foot on the stairs. To count as stairs, there must be three vertical faces.
                <LI>With doorways, if a human has at least one foot inside a door he/she is safe, however a zombie must have both feet inside the doorway to be considered safe.
                <LI>Vehicles: Players on/in vehicles are outside of the game. They cannot be attacked, and cannot attack.  Players on roller blades are always safe because a push will cause them to move. (Please don't ride bikes, skateboards, or rollerblades at missions. You may use them to get to and from the mission location, but using them during the mission falls under DBAD).
             </OL></div>


          </div>

          <div class="even">
            <div><span class="rules_heading">Equipment</span></div>
            <div><OL class="rules">
              <LI>HvZ Bandana - to identify people as participants in HvZ. This will be provided to all players.
              <LI>2 Index Cards - to identify players uniquely for the purpose of Zombie feeding. Write your Player ID on your 2 index cards as a human. You can find your player ID under "My Account" at the top.
              <LI>Game approved Nerf blaster(s) - For Human players only. See section on Nerf devices.
            </OL></div>
          </div>  
            
          
          <div class="odd">
            <div><span class="rules_heading">SAFE ZONES</span></div>
            <div>Players that are in safe zones cannot be shot or tagged in these places. Human players can however fire from within a safe zone to clear exits.</div>
            <div><OL class="rules">
              <LI>Residence Halls. Humans may not shoot out of windows or from fire escapes, either.
              <LI>Bathrooms
              <LI>All Buildings (four walls and a ceiling)
              <LI>Stairs are safe for humans only.
              <LI>Dining Halls
              <LI>Reser Stadium (inside, not on the plaza waiting for tickets)
              <LI>Personal Tents
              <LI>Bus Stops (ONLY when there is a bus or shuttle present)
              <LI>Anywhere else needed due to safety or as declared by a mod.
            </OL></div>
 
          </div>

          <div class="even">
            <div><span class="rules_heading">No-Play Zones</span></div>
            <div>No-Play Zones are places where your safety outweighs the context of the game.  The game is not to be played in these areas and if you are in one you should be trying to do nothing but get out.</div>
            <div><OL class="rules">
              <LI>The area surrounding buses and shuttles (not bus stops). Busses are and Shuttles count as vehicles; players on them are safe.
              <LI>Crosswalks:  If you enter a cross walk you must cross to the other side.  You may not shoot into or out of a crosswalk.  Zombies may not tag Humans that are crossing a crosswalk
              <LI>The Parking Garage
              <LI>Construction Zones
              <LI>Fire Escapes (you may not fire out of fire escapes)
              <LI>During fire drills (when there are people sent out side to wait the group is in a No-Play Zone until everybody has dispersed)
              <LI>Around emergency vehicles
              <LI>Off Campus
              <LI>Around cultural and diversity centers.  (Do not camp outside of these buildings, it's not cool!)
              <LI>Jobs, Labs, Outside classes (Take your head/armband off so as to not interrupt the class.)
              <LI>Anywhere else as declared by a mod.
            </OL></div>

          </div>

          <div class="odd">
            <div><span class="rules_heading">Locations</span></div>
            <div>Areas on campus that are safe to play in and not listed as a Safe Zone or No-Play Zone are fair game.</div>
            <div>Staying on campus: OSU has been quarantined by the international community due to a zombie outbreak, and as such Humans must stay in or near the play area. If you need to leave campus for longer than 48 hours, you are considered rescued, and are out of the game.</div>
                
          </div>

          <div class="even">
            <div><span class="rules_heading">Identification</span></div>
            <div>I.D. Number: Humans must keep two index cards with their unique identification number on them at all times, to be used for identification purposes and for Zombie feeding. Zombies must carry one card, simply for identification purposes.</div>
          </div>

          <div class="odd">
            <div><span class="rules_heading">Game Mechanics</span></div>
            <div>Stunning a Zombie: Humans may stun a Zombie for 15 minutes by shooting them with a Nerf marker, throwing a sock at them, or landing a hit with a marshmallow.  A stunned zombie must place his/her headband around his neck.</div>
            <div>When Tagged By a Zombie: When tagged by a Zombie, a Human is required to give the Zombie one of their ID cards, which the Zombie will use to register the tag.  The player is now a Stunned Zombie and will become an unstunned Zombie fifteen minutes after being tagged.</div>
            <div>Wearing an Armband: Humans must wear provided bandanna around their bicep to identify at all times that they are in a game-on zone to identify them as Humans players in the game. (This will come in handy when you become a Zombie!) Zombies must wear the bandanna on their head, OVER hoodies, hats, hair, etc. so that it is visible at all times from all angles.</div>
            <div>Time keeping: Players must be able to keep track of time, such as with a watch or cell phone.</div>
            <div>Zombies must "feed" every 48 hours. A Zombie feeds by reporting their tag to the website, within 2 hours of the tag. If a Zombie does not feed, every 48 hours, they "starve", and are out of the game. When a Zombie feeds, this 48 hour timer is reset.</div>
            <div>Wearing Your Headband: Zombies must wear the bandanna around their head at all times while playing. Again, make sure it is over hats, hoods, hair, etc.</div>
            <div>A tag is a firm touch to a Human. (Keep in mind where an appropriate place to tag a Human is. Use good judgment; any violation of this rule is against game policy as well as being incredibly disrespectful, and will result in removal from the game at the very least). After tagging a Human the Zombie must collect one of the Human's ID card, and must report their tag to get credit for feeding.</div>
            <div>Getting Tagged: When hit with a Human Nerf device, a Zombie is stunned for 15 minutes. A stunned Zombie may not interact with the game in any way. This includes shielding other Zombies from bullets, continuing to run toward a Human, or providing information to the Horde. If shot while already stunned, the Zombie's stun timer is not reset back to 15 minutes.</div>
            <div>If a stunned Zombie encounters human players, they should raise one hand and identify themselves as stunned. Stunned zombies should not stalk human players, as this can sway the game, and isn't very sportsmanly. A good rule is to stay out of nerf dart range from humans when stunned.</div>
          </div>

          <div class="even">
            <div><span class="rules_heading">Original Zombies</span></div>
            <div>The Original Zombies are randomly chosen at the beginning of the game. (You can opt-out if you want when you register.) They identify as a Human for a few days (the Original Zombie period). This means that they wear the bandanna on their arm. They tote Nerf blasters, they carry socks, marshmallows, whatever. They can even stun Zombies if they want. For all intents and purposes, they are Human. Except that they can tag Humans to turn them into Zombies. At the end of the Original Zombie period, the Original Zombie becomes a normal Zombie, and must follow the Zombie Rules.</div>
            <div>An email from the mods will be sent when the Original Zombie period ends.</div>
          </div>

          <div class="odd">
            <div><span class="rules_heading">Nerf Devices</span></div>
            <div>The only Nerf devices allowed are:</div>
            <div><OL class="rules">
              <LI>Nerf or other similar foam launching toy blasters.
              <LI>Blow guns firing nerf darts.  (Blow guns must be lung powered, and may not shoot velcro darts.)
              <LI>Balled up socks
              <LI>Regular Marshmallows (No jumbo or mini)
            </OL></div>
            <div><UL class="rules">
              NO MEELE WEAPONS, NO EXCEPTIONS
            </UL></div>
        
            <div>Nerf devices must not look realistic. Federal law requires that toy blasters have a brightly colored tip. We require blasters to be obviously brightly colored - if we think it's too realistic looking, it can't be used. If you're in doubt, ask a mod ahead of time. Please don't paint blasters completely black or other colors found on realistic weaponry. We'll have spray-paint at the orientations to help you make sure your nerf blasters meet standards. All devices except socks and marshmallows must be approved by a Moderator prior to use. Approved devices will be marked as such by a zip-tie.  Projectiles must not hurt on impact.</div>
            <div>Nerf blasters cannot fire anything except foam projectiles such as darts or balls. Socks must be clean. Socks must be thrown; they can be modified, but only by adding more socks, not by cutting or by adding anything but socks. Marshmallows must be thrown and cannot shot with blow guns.
</dev>
            <div>Only commercially available, off-the-shelf darts may be used in nerf blasters. For safety reasons, darts may not be modified to affect their flight performance in any way.</div>
            <div>All ammunition must be cleaned up by whoever fired it. Don't leave darts and marshmallows and socks lying around. Be respectful of campus - ours is a beautiful one, let's keep it that way.</div>
            <div>If a moderator says a Nerf device is not allowed, then it is not allowed. Moderators do not need to cite a rule to ban Nerf devices. If you have a problem with this, you can appeal to another moderator.</div>
            <div>DO NOT under any circumstances attempt to tag someone who isn't clearly marked as a player. Doing so will result in immediate removal from the game.</div>
            
          </div>
          
          <div class="even">
            <div><span class="rules_heading">Missions</span></div>
            <div>Through the week, there will be various missions posed to both teams. By completing these missions, you earn benefits for your team, or detriments for your opposition. Failure to complete mission may have negative consequences for your team, or positive consequences for the other team. Missions are, of course, completely optional, but highly recommended, because they are fun. The final mission on the last day will determine the winner of the game, if it is not already over. The missions are supposed to add some depth to the game, suspense to events, and to give the Humans a reason to get out of the safe zones where the Zombies can tag them.</div>
            <div>Special mission rules:</div>
            <div><OL class="rules">
              <LI>No vehicles at mission!  Vehicles may be used to get to or from missions, but their use during missions to complete mission objectives or help with the mission in any way is banned.
              <LI>Buildings may not be used as cover or passage during missions.
              <LI>Stairs may not be used as a play zone unless specifically told by a mod for the purpose of moving from one location to the other.
            </OL></div>
          </div>

          <div class="odd">
            <div><span class="rules_heading">Costumes</span></div>
            <div>  Costumes are permitted (and encouraged!), but they must not be alarming to the public.  For safety reasons, the following rules will be enforced:</div>
            <div><OL class="rules">
              <LI>Camouflage may not be worn in bushes. No FULL camo is allowed either.
              <LI>Ghillie suits may not be worn at all.
              <LI>Costumes may not conceal the face at night.
              <LI>The costume may not contain banned weaponry or devices, even for looks.
            </OL></div>
          </div>

          <div class="even">
            <div><span class="rules_heading">Other Rules</span></div>
            <div>A mod does not need to cite a rule to make a ruling during game.</div>
            <div>The mod squad will never use Facebook, twitter, etc. to distribute mission details.</div>
            <div>Tagging non-players is a bannable offense. And a rude move. Don't do it.</div>
            <div>People who are not part of the game cannot interact with it. This includes spying or bringing supplies to barricaded Humans.</div>
            <div>Zombies must have both feet outside a safe zone to tag a Human.</div>
            <div>Shields are not allowed. Neither are melee weapons.  A tag on a backpack is considered a tag on the player (otherwise the backpack would be a shield, which is not allowed).</div>
            <div>Athletes during practices or games are safe.</div>
            <div>Anyone participating in official or required events, such as jobs or meetings, is safe.</div>
            <div>Humans may stun Zombies from inside safe zones to clear exits.</div>
            <div>Those that are required to wear a uniform, such as players in ROTC, are not required to wear the headband during that time. This effectively removes them from the game for that amount of time; as such, they cannot be tagged.</div>
            <div>Unless you're in a sanctioned activity, please don't remove yourself from the game. Taking off your bandanna to walk to class falls under DBAD.</div>
            <div>If there is a real emergency, call 911.  For game-related, non-emergency help please try to find a mod (wearing a pink arm/headband) or email mods@osundead.com.</div>
            <div>Finally, the overall rule is: DBAD - Don't be a douche. If at any time you think you are violating this rule, stop and think about it. If something seems unfair, it probably is. If it seems un-fun, then something is probably wrong. This is a game, and games are meant to be fun. Try and play the game in a way that makes it good for everyone involved. Don't be selfish. And lastly, HAVE FUN!</div>
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
