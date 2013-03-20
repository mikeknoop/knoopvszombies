<?php

  $page_title = 'Home';
  $require_login = false;
  require '../knoopvszombies.ini.php';

  require 'module/includes.php';
  
  require 'module/general.php';

  if ($GLOBALS['state'])
    $playerCounts = $GLOBALS['Game']->GetBrokenDownPlayerCount($GLOBALS['state']['gid']);
  else
    $playerCounts = array();
    
  if (isset($_GET['action']))
  {
    if ($_GET['action'] == 'hidepost')
    {
    
      if (isset($_GET['target']) && (isset($_SESSION) && $_SESSION['admin'] && $GLOBALS['Misc']->StringWithin('email', $_SESSION['privileges'])))
      {
        $GLOBALS['Wall']->HidePost($_GET['target']);
        $GLOBALS['Cache']->RemoveFromCache('recent_posts');
        $GLOBALS['Wall']->GenerateWallCache($_GET['action']);
      }
    
    }
  }
    
?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/countdown.css" rel="stylesheet" type="text/css"/>
  <link href="//<?php echo DOMAIN; ?>/css/page/index.css" rel="stylesheet" type="text/css"/>
  
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

          <?php 
            if ($GLOBALS['state'] && $GLOBALS['state']['countdown'] && $GLOBALS['state']['start_time'] != 0 && $GLOBALS['state']['start_time'] != '')
            {
              require 'module/countdown.php';
            }
          ?>

          <?php 
            if ($imp_post = $GLOBALS['Cache']->GetFromCache('recent_posts_imp', $Seconds=0, $IsObject=true)) {
              require 'module/index_imp.php';
            }
          ?>
      
          <?php if (!$_SESSION): ?>
          <div id="group_signup_container">
          
            <div id="group_container">              
              <div class="caption">
              
                <a class="caption_link" href="//<?php echo DOMAIN; ?>/signup">
                <div class="caption_text">
                  <?php
                  if ($GLOBALS['state'] && $GLOBALS['state']['active'] && !$GLOBALS['state']['archive'] && $GLOBALS['state']['name'] != '')
                  {
                    echo "The {$GLOBALS['state']['name']} is happening now";
                    $subtext = "Sign up for next semester will be available soon!";
                  }
                  elseif ($GLOBALS['state'] && !$GLOBALS['state']['archive'] && $GLOBALS['state']['name'] != '' && $GLOBALS['state']['start_time'] != '' && $GLOBALS['state']['start_time'] != '0')
                  { 
                    echo "The {$GLOBALS['state']['name']} game begins ".date("F j", $GLOBALS['state']['start_time']);
                    $subtext = "Sign up today!";
                  }
                  else
                  {
                    echo "Humans vs. Zombies at Mizzou holds a game every semester";
                    $subtext = "Sign up today!";
                  }
                  ?>
                </div> <!-- group_caption_text -->
                <div class="caption_subtext">
                  <?php echo $subtext; ?>
                </div> <!-- group_caption_subtext -->
                </a>
               
              </div> <!-- caption -->
            </div> <!-- group_container -->
            
            
            <div id="signup_container">
              <?php
                if ($GLOBALS['state'] && $GLOBALS['state']['active'])
                {
                  require 'module/login_small.php';
                }
                else
                {
                  require 'module/signup_incent_small.php';
                }
              ?>
            </div> 
          
          <div class="clearfix"></div>    
          </div> <!-- group_signup_container -->
          <?php endif ?>
          
          <div id="what_is_container">
          
            <div id="what_is_title">
            What is <span class="accent_color">Humans vs. Zombies</span>
            </div>
            
            <div id="what_is">
            <p>Humans vs. Zombies (HvZ) is a week long, 24/7 game of moderated tag commonly played on college campuses. A group of human players attempts to survive a “zombie outbreak” by outsmarting a growing group of zombie players.</p>
            
            <p>Human players must remain vigilant and defend themselves with socks and Nerf guns to avoid being tagged by the growing zombie horde. Currently, Humans vs. Zombies is played at over 600 campuses across the United States!</p>
            
            <p>Not convinced yet? Check out the <span class="accent_color bold">epic</span> documentary:</p>
            
            <div id="what_is_video">
            <object width="370" height="225"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="//vimeo.com/moogaloop.swf?clip_id=1956330&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=59a5d1&amp;fullscreen=1" /><embed src="//vimeo.com/moogaloop.swf?clip_id=1956330&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=59a5d1&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="370" height="225" /></object>
            </div>
            
            <p>(note: we recommend watching it full screen)</p>
            
            </div>
            
          </div>
        
          <div id="page_posts_container">
            <?php           
              require 'module/page_posts.php';
            ?>
          </div> <!-- page_posts_containre -->

          <!--
          <div class="index_header_message">
          Mizzou Humans vs. Zombies is supported by VAMortgageCenter.com <a class="accent_color" href="//www.vamortgagecenter.com/careers/">who is always hiring bright, talented people</a>
          </div>
          -->
          
          <div class="clearfix"></div>
          
        </div> <!-- bod_content -->     
        

      </div> <!-- content -->
    </div>  <!-- content_column -->
    
    
    <div id="footer_push"></div>
  </div> <!-- body_container -->

  <?php
    require 'module/footer.php';
  ?>


</body>

</html>
