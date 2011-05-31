<?php

  ini_set('display_errors',1);
  error_reporting(E_ALL|E_STRICT);

  $page_title = 'About Us';
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
            <div>The first game of Humans vs. Zombies was played at Mizzou in the Spring of 2009. Since then, the week long game has been played every semester. Currently, Humans vs. Zombies at Mizzou has over 400 players each semester including students, faculty, and visitors from nearby universities.</div>
            
            <div>Humans vs. Zombies at Mizzou was founded by Sarah Hirner who hand picked the original Moderator team. Members included Lauren Miles and Kimi Nolte along with many others whose time and effort made the game possible at Mizzou. The Spring 2009 game used the Dormwire HvZ engine which was later replaced by the HvZSource game engine for the Fall 2009 and Spring 2010 games.</div>
            
            <div>A new generation of Moderators came to power for the Spring 2010 game. This new Moderator team was headed by Joe Myers, Chris Camey, and Mike Knoop. It was their intention to work through the game mechanics which has been problematic in the past and improve Moderator communication with players. For the Fall 2010 game, a new website and game engine were developed by Mike Knoop.</div>
            
            <div>There are two ways to get ahold of your moderators. We ask that you please email us first at <a href="//<?php echo DOMAIN; ?>/mailto:muzombies+web@gmail.com">muzombies@gmail.com</a> and if you cannot get ahold of us that way or if you have a time sensitive issue, call the HvZ Help line at (573) 833-0385.</a></div>
            
            <div>Below are your current Head Moderators:</div>
                                    
          </div> <!-- even -->
          
          <div class="odd">

            <div class="about_picture_container">
              <img src="img/mods/joe.png" class="about_picture" />
            </div>
            
            <div class="about_text_container">
              <a target="_new" href="//www.facebook.com/blacktiereverie">
              <div class="about_name">
              Joe Myers
              </div>
              </a>
              
              <div class="about_text">
              The head moderator for Humans vs. Zombies at Mizzou, Joe is in charge of running the moderation team and is the official liaison when it comes to any issues regarding the police or administration. He is almost never seen without a tie.
              </div>
            </div>
             
            <div class="clearfix"></div>  
              
          </div> <!-- odd -->
          
          <div class="even">

            <div class="about_picture_container">
              <img src="img/mods/chris.png" class="about_picture" />
            </div>
            
            <div class="about_text_container">
              <a target="_new" href="//www.facebook.com/profile.php?id=1304460205">
              <div class="about_name">
              Chris Camey
              </div>
              </a>
              <div class="about_text">              
              Chris is the number-two man of the Mod Squad. Acting as the voice to the people, Chris can usually be found wearing a trucker hat and a BullShifters shirt sorting out problems whenever and wherever they arise.
              </div>
            </div>
             
            <div class="clearfix"></div>  
              
          </div> <!-- even -->

          <div class="odd">

            <div class="about_picture_container">
              <img src="img/mods/mike.png" class="about_picture" />
            </div>
            
            <div class="about_text_container">
              <a target="_new" href="//www.facebook.com/mikeknoop">
              <div class="about_name">
              Mike Knoop
              </div>
              </a>
              <div class="about_text">
              Mike is the man in charge of the tech side of HvZ, ensuring that the main game engine is running smoothly, altering and changing character data disputes as necessary, and establishing the HvZ help line.
              </div>
            </div>
             
            <div class="clearfix"></div>  
              
          </div> <!-- odd -->

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
