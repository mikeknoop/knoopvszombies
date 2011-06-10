<div id="signup_title">
  Join a <span class="accent_color">Game</span>
  </div>
  
<div class="signup_header_text">
  The final step is to join the upcoming semesters' game in order to play. Click the "View Available Games" button to see a list of games you can join.
</div>

<div class="signup_header_view_available">
<a class="accent_color bold" href="http://<?php echo DOMAIN; ?>/joingame">View Available Games</a>
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