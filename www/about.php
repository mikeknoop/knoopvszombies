<?php

  ini_set('display_errors',1);
  error_reporting(E_ALL|E_STRICT);

  $page_title = 'About Us';
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
  
  <link href="//<?php echo DOMAIN; ?>/css/page/about.css" rel="stylesheet" type="text/css"/>
  
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
        
        <div id="about">


          <div class="even">

            <div class="about_header">Our <span class="accent_color">History</span></div>
            <div>The first OSU HVZ game was played at Wilson Hall in the spring of 2008. It spread across campus soon after.</div>
            
            <div>To get a hold of us, email <a href="mods@osundead.com">mods@osundead.com</a></div>
            
         </div>
         <div class="odd">
            <span class="about_header">Executive moderators</span>
                                    
	    <div><strong>Tom Nath</strong> (Fearless Leader - First game: Spring 2011): As fearless leader, Tom is in charge of organizing all of the executive mods, planning the broad scope of the game, insuring that everything remains on track, as well as making the final call on any major decision. He is a senior going for a B.A. in English. Favorite HvZ Memory: "I survived my first game until the last minutes of the final mission. I died standing next to the final objective."</div>
            <div><strong>Tom Riley</strong> (Public Relations - First game: Spring 2010 @ Ohio State): As PR head, Tom is in charge of game promotion, game visibility, and communication with the non-player public. He is a 3rd year graduate student going for a M.S./Ph.D. in nuclear engineering. "I yelled really loud; Scared the pants off a human; He fled in terror. (It's a Haiku, and a bad one). I'm loud, deal with it. You'll learn to love me for it."</div>
            <div><strong>Pieter Waldenmaier</strong> (Rules - First game: Spring 2012):  As rules head, Pieter is in charge of setting and maintaining the rules of HvZ, as well as making the final decision on any gameplay dispute. He is a 3rd year graduate student going for a Ph.D. in organic chemistry. "My favorite HvZ memory was being the OZ in fall 2012. It was so much fun to be so powerful and so evil!"</div>
            <div><strong>Andrew Wilson</strong> (Missions - First game: Fall 2012): As missions head, Andrew is in charge of running the missions committee for planning and designing the games missions, mechanics, team points, and is in charge of organizing and running the missions during the game. Andrew is a sophomore going for a B.S in Biology with a minor in Japanese Language. Favorite HvZ Memory: "Standing outside Milam, surrounded by Hidden zombies, I was talking to a guy sitting inside, scared to go out. Finally, I said 'Screw it, I have class to get to' and walked away to hide behind a wall. He bolts out, hidden zeds run after him. He made eye contact with me, his eyes full of hate.</div>
            <div><strong>Jacob Huegel</strong> (Plot - First game: Fall 2011): As plot head, Jacob is in charge of running the plot committee for planning and designing the story of the game, prop construction, as well as casting characters and keeping the story current and relevant as the game progresses. Jacob is a Junior going for an Honors B.S. in Biochemistry and Biophysics. Favorite HvZ Memory: "Narrowly escaping an ambush set up for me outside of Kelly."</div>
            <div><strong>Karen Zhen</strong> (Admin - First game: Fall 2012): As admin head, Karen is in charge of bookkeeping, game prep logistics, orientation, mod interviews, mod-public interface, mod recruiting, and post game review. She is a Sophomore going for a B.S. in chemical engineering. Favorite HvZ memory: "After I became a zombie, my zombie buddies and I would set up traps for humans."</div>
            <div><strong>Elizabeth Kaney</strong> (Tech. Communications - First game: Fall 2011): As Tech. Comm. head, Elizabeth is in charge of online communication between players and mods, game stats, email, facebook, and the forums. She is a Junior going for a B.S. in Biology. "My goal is to become a genetic researcher. My favorite HvZ memory would be when Pieter, Brianna and I were pinned in StAg by a bunch of zombies after an emergency mod meeting. Essentially we were camped for 2.5 hours and hid in a creepy basement until we were rescued."</div>
            <div><strong>Lars Paulson</strong> (Webmaster - First game: Fall 2011): As webmaster, Lars is in charge of running and maintaining the game website, as well as dealing with any technical issues. He is a junior studying for a B.S. in chemistry.</div>
            <div><strong>Will Valiant</strong> (Treasurer - First game: Fall 2011): As treasurer, Will is in charge of game funds, fundraising, t-shirt contests, raffles, and giveaways. He is a junior going for a B.S. in microbiology. "My favorite HvZ memory was taunting the entirety of the resistance with a cardboard square as they hopelessly attempted to catch me. Then I went on to kill 16 people that game, which was pretty cool too."</div>
          </div>
            <div class="clearfix"></div>  

          </div> <!-- about -->            
            
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
