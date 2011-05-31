<div id="signup_title">
  Sign up <span class="accent_color">completed!</span>
  </div>
  
<div class="signup_header_text">
  Congratulations! Your Mizzou Humans vs. Zombies account is setup and approved. Now, to actually join a game for the upcoming semester, click the link below.
</div>

<div class="signup_header_text">
  <a class="accent_color bold" href="http://<?php echo DOMAIN; ?>/joingame">Join a Game</a>
</div>

<div class="signup_header_text">
  IMPORTANT: Sometimes email from us gets marked as spam. To make sure this does not happen, please WHITELIST our email account (mailer@muzombies.org) to make sure you get all important emails! Check your spam folder often.
</div>

  <?php if (isset($_GET['state'])): ?>
  <div id="signup_status">
    <?php
      switch ($_GET['state'])
      {
        case 'slowdown':
          echo 'The server is very busy. Please wait a few seconds and try again.';
        break;
          
        default:
          echo 'An unknown error occured. Please try again.';
        break;
      }
    ?>
  </div>
  <?php endif ?>