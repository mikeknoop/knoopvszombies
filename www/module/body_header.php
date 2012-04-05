  <div id="body_header">
    <div id="body_header_page_title">
    <?php
    echo $page_title;
    $account_complete = $GLOBALS['User']->AccountComplete();
    ?>
    </div>
    
    <div id="body_header_nav_container">

      <?php if ($_SESSION && $_SESSION['admin']): ?>
      <span class="body_header_nav_option">
        <a class="body_header_navigation" href="http://<?php echo DOMAIN; ?>/admin">Admin</a>
      </span>
      <?php endif ?>

      <?php if ($_SESSION && !$GLOBALS['User']->IsPlayingCurrentGame($_SESSION['uid']) && $account_complete): ?>
      <span class="body_header_nav_option">
        <a class="body_header_navigation" href="http://<?php echo DOMAIN; ?>/joingame">Join a Game</a>
      </span>
      <?php endif ?>

      <?php if ($GLOBALS['state'] && !$GLOBALS['state']['active'] && (!$GLOBALS['state']['archive'])): ?>
      <span class="body_header_nav_option">
        <a class="body_header_navigation" href="http://<?php echo DOMAIN; ?>/orientations">Orientations</a>
      </span>
      <?php endif ?>
      
      <?php if ($GLOBALS['state'] && $GLOBALS['state']['active'] && $_SESSION && $GLOBALS['User']->IsPlayingCurrentGame($_SESSION['uid']) && $account_complete): ?>
      <span class="body_header_nav_option">
        <a class="body_header_navigation" href="http://<?php echo DOMAIN; ?>/report">Report a Kill</a>
      </span>
      <?php endif ?>
      
      <?php if ($GLOBALS['state']): ?>
      <span class="body_header_nav_option">
        <a class="body_header_navigation" href="http://<?php echo DOMAIN; ?>/playerlist">Player List</a>
      </span>
      <?php endif ?>
      
      <?php if ($_SESSION && $_SESSION['name'] != ''): ?>
      <span class="body_header_nav_option">
        <a class="body_header_navigation" href="http://<?php echo DOMAIN; ?>/account"><?php echo $_SESSION['name']; ?></a>
      </span>
      <?php endif ?>
      
      <?php if (!$_SESSION): ?>
      <span class="body_header_nav_option">
        <a class="body_header_navigation" href="http://<?php echo DOMAIN; ?>/signup">Sign Up</a>
      </span>
      <?php endif ?>
      
      <?php if (!$_SESSION): ?>
      <span class="body_header_nav_option">
        <a class="body_header_navigation" href="http://<?php echo DOMAIN; ?>/login">Login</a>
      </span>
      <?php endif ?>
      
      <?php if ($_SESSION): ?>
      <span class="body_header_nav_option">
        <a class="body_header_navigation" href="http://<?php echo DOMAIN; ?>/logout">Logout</a>
      </span>
      <?php endif ?>
      
    </div>

    <?php if ($_SESSION && !$account_complete): ?>

      <div id="body_header_message">
      Your account (<?php echo $_SESSION['email']; ?>) signup is not complete.
      <?php if ($page_title != 'Signup'): ?>
        <a href="http://<?php echo DOMAIN; ?>/signup">Finish signing up by clicking here</a>.
      <?php endif ?>
      </div>
    
    <?php elseif($_SESSION && !$GLOBALS['User']->IsPlayingCurrentGame($_SESSION['uid']) && $account_complete): ?>
    
      <div id="body_header_message">
      You have not yet <a href="http://<?php echo DOMAIN; ?>/joingame">joined a game</a>. You must <a href="http://<?php echo DOMAIN; ?>/joingame">join a game</a> to participate! <a class="accent_color" href="http://<?php echo DOMAIN; ?>/joingame">Join a game here</a>.
      </div>
    
    <?php else: ?>

      <div id="body_header_message">
      Need to get ahold of a Moderator? <a href="mailto:muzombies@gmail.com">Contact us via email at muzombies@gmail.com</a>
      </div>
    
    <?php endif ?>
  
  </div>
  

