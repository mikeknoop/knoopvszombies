<div id="signup_title">
  Sign up <span class="accent_color">confirm your email</span>
  </div>

<div class="signup_header_large">
  An email was sent to the address you provided. Please click on the confirmation link within the email to continue the signup process.
</div>

<div class="signup_header_large">
  If you haven't gotten the email, <span class="bold">first check your spam folder</span>. Emails may take several minutes to be delivered. You can also resend the confirmation email by clicking <a href="http://<?php echo DOMAIN; ?>/emailconfirm/resend"><span class="accent_color">here</span></a>.
</div>

<div class="signup_header_large">
  We strongly recommend you whitelist our email address, mailer@muzombies.org so that we can send you email without going to your spam box.
</div>

<div class="signup_header_large">
  For your convienence, here are links to common email providers:
  <ul>
  <li><a class="accent_color" href="http://mail.missouri.edu">University of Missouri Webmail</a></li>
  <li><a class="accent_color" href="https://mail.google.com/mail/">Gmail</a></li>
  <li><a class="accent_color" href="http://mail.yahoo.com/">Yahoo Mail</a></li>
  </ul>
</div>

  <?php if (isset($_GET['state'])): ?>
  <div id="signup_status">
    <?php
      switch ($_GET['state'])
      {
        case 'emailconfirmsent':
          echo 'Confirmation email was sent. Please check your email.';
        break;
        
        case 'invalid':
          echo 'The confirmation link is invalid. You may need to <a href="http://'.DOMAIN.'/emailconfirm/resend"><span class="accent_color">resend</span></a> the email.';
        break;
        
        case 'sendsuccess':
          echo 'A new confirmation email has been sent to your email address.';
        break;
        
        case 'slowdown':
          echo 'Please wait a few minutes before requesting another confirmation email. Check your email and try again in about 5 minutes.';
        break;
          
        default:
          echo 'An unknown error occured. Please try again.';
        break;
      }
    ?>
  </div>
  <?php endif ?>