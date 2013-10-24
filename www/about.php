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
                                    
            <div><strong>Keirnan Buddendeck</strong> (Fearless Leader - First game: Fall 2011): As fearless leader, Keirnan is in charge of organizing all of the executive mods, planning the broad scope of the game, insuring that everything remains on track, as well as making the final call on any major decision.</div>
            <div><strong>Max Majdecki</strong> (Rules Head - First game: Spring 2010): As rules head, Max is in charge of setting and maintaining the rules of HvZ, as well as making the final decision on any gameplay dispute. He is a Senior going for a B.S. in psychology with a minor in sociology. "My favorite HvZ memory was when we placed Luke, Drew Blood, inside of a large dog kennel and pulled him around campus on a little red wagon. I also enjoy playing pokemon, reading a variety of books, and watching movies (I am currently up to having watched 411 movies)."</div>
            <div><strong>Pieter Waldenmaier</strong> (Missions Head - First game: Spring 2012): As missions head, Pieter is in charge of running the missions committee for planning and designing the games missions, mechanics, the OZ's, team points, and is in charge of organizing and running the missions during the game. He is a 3rd year graduate student going for a Ph.D. in organic chemistry. "My favorite HvZ memory was being the OZ in fall 2012. It was so much fun to be so powerful and so evil!"</div>
            <div><strong>Briana Gellner</strong> (Plot Head - First game: Fall 2011): As plot head, Briana is in charge of running the plot committee for planning and designing the story of the game, prop construction, as well as casting characters and keeping the story current and relevant as the game progresses. She is a Senior going for a B.S. in Environmental Science, Land-Air Interaction Option. Favorite HvZ memory: "Getting stuck with two other mods in the creepy basement of StAg for two hours. Those three zombies camping us were terrifying."</div>
            <div><strong>Tom Nath</strong> (Admin Head - First game: Spring 2011): As admin head, Tom is in charge of bookkeeping, game prep logistics, orientation, mod interviews, mod-public interface, mod recruiting, and post game review. He is a senior going for a B.A. in English. Favorite HvZ Memory: "I survived my first game until the last minutes of the final mission. I died standing next to the final objective."</div>
            <div><strong>Alex Huckey</strong> (Public Relations Head - First game: Fall 2009): As PR head, Alex is in charge of game promotion, game visibility, and communication with the non-player public. He is a senior going for a B.S. in industrial-manufacturing engineering. Favorite HvZ Memory: "There has been three occasions where I have saved fellow mods with my trusty Buzzbee double shot. Wielding a raider/rampage is fine, but a drum full of darts won't save you from lack of awareness!"</div>
            <div><strong>Elizabeth Kaney</strong> (Tech. Communications Head - First game: Fall 2011): As Tech. Comm. head, Elizabeth is in charge of online communication between players and mods, game stats, email, facebook, and the forums. She is a Junior going for a B.S. in Biology. "My goal is to become a genetic researcher. My favorite HvZ memory would be when Pieter, Brianna and I were pinned in StAg by a bunch of zombies after an emergency mod meeting. Essentially we were camped for 2.5 hours and hid in a creepy basement until we were rescued."</div>
            <div><strong>Lars Paulson</strong> (Webmaster - First game: Fall 2011): As webmaster, Lars is in charge of running and maintaining the game website, as well as dealing with any technical issues. He is a junior studying for a B.S. in chemistry.</div>
            <div><strong>Will Valiant</strong> (Treasurer - First game: Fall 2011): As treasurer, Will is in charge of game funds, fundraising, t-shirt contests, raffles, and giveaways. He is a junior going for a B.S. in microbiology. "My favorite HvZ memory was taunting the entirety of the resistance with a cardboard square as they hopelessly attempted to catch me. Then I went on to kill 16 people that game, which was pretty cool too."</div>
          </div>
          <div class="even">
            <span class="about_header">Moderators</span>
            <div><strong>Megan Smith</strong> (First game: Fall 2010): Megan is a Senior going for a B.S. in biology. Favorite HvZ Memory: "Anything involving NPC interactions between Lance (Keirnan) and Sweet D. Bone (me) during Spring '12 game. I also created the zombie mating call of 'Heeeeyyyyyy Zombieeee'. You're welcome." </div>
            <div><strong>Joseph Cronise</strong> (First game: Spring 2011): Joseph is a Senior going for a B.S. in computer science, and a minor in business and entrepreneurship. "My favorite HvZ memory was surviving being camped inside arnold dining center by 5 zombies with only a single dart."</div>
            <div><strong>Tom Riley</strong> (First game: Spring 2010 @ Ohio State): Tom is a 3rd year graduate student going for a M.S./Ph.D. in nuclear engineering. "I yelled really loud; Scared the pants off a human; He fled in terror. (It's a Haiku, and a bad one). I'm loud, deal with it. You'll learn to love me for it."</div>
            <div><strong>Jacob Huegel</strong> (First game: Fall 2011): Jacob is a Junior going for an Honors B.S. in Biochemistry and Biophysics. Favorite HvZ Memory: "Narrowly escaping an ambush set up for me outside of Kelly."</div>
            <div><strong>Jackie Scholtz</strong> (First game: Fall 2011): Jackie is a Senior going for a B.S. in geology. Favorite HvZ Memory: "We once set up an ambush for another ambush resulting in mass chaos and total surprise. BRAIINNNZZZZZZZZZZ!!!!"</div>
            <div><strong>Jacob McCarthy</strong> (First game: Fall 2012): Jacob is Sophomore going for a B.S. in ECE. "My favorite memory of HvZ was hiding outside Milam with about 5 other zombies. We didn't get any kills that night, but the way we hid in those bushes was fantastic."</div>
            <div><strong>Lucas Bengtson</strong> (First game: Fall 2011): Lucas is a Junior going for a B.S. in computer science. "My favorite HVZ memory is the final mission of the spring 2012 game where the humans won for the first time."</div>
            <div><strong>Andrew Wilson</strong> (First game: Fall 2012): Andrew is a sophomore going for a B.S in Biology with a minor in Japanese Language. Favorite HvZ Memory: "Standing outside Milam, surrounded by Hidden zombies, I was talking to a guy sitting inside, scared to go out. Finally, I said 'Screw it, I have class to get to' and walked away to hide behind a wall. He bolts out, hidden zeds run after him. He made eye contact with me, his eyes full of hate.</div>
            <div><strong>Karen Zhen</strong> Karen is a Sophomore going for a B.S. in chemical engineering. Favorite HvZ memory: "After I became a zombie, my zombie buddies and I would set up traps for humans."</div>
            <div><strong>Tim Gillespie</strong> (First game: Fall 2010): Tim is a Senior going for a B.S. in Exercise and Sport Science, EXSS: Physical Education Teacher Ed. option. Favorite HvZ Memory: "On the spring '13 game Monday mission when there was only me and one other who continued the mission and we were victorious. Also, I'm the Chicken Hat Guy."</div>
            <div><strong>Evan Steele</strong> (First game: Fall 2012): Evan is a Sophmore going for a B.S. in computer science. Favorite HvZ memory: "running across campus from a horde while out of ammo at night near the end of the game."</div>
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
