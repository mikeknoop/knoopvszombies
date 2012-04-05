<div id="signup_title">
  Sign up <span class="accent_color">create an account</span>
  </div>

<div class="signup_header_text">
  To play Humans vs. Zombies at Mizzou, you will need to sign up for an account. With this account you can then join the game for the current semester.
</div>

<div class="signup_header_text">
  You only need to create this account once. For future semesters, your account will persist between semesters allowing you to keep track of your lifetime HvZ statistics. You will need to revist the website each semester to join that semester's game (but you won't have to go through this setup process again).
</div>

<div class="signup_header_text">
  To get started, please fill out the form below with a valid email address and create a password for your account. We strongly recommend using your <span class="accent_color bold">university email address</span>. We send critical game updates while the game is in progress and may periodically send you updates regarding future semester games.
</div>
  
  <?php if (isset($_GET['state'])): ?>
  <div id="signup_status">
    <?php
      switch ($_GET['state'])
      {
        case 'emailexists':
          echo 'That email address already exists. If you have forgotten your password, <a href="http://'.DOMAIN.'/lostpassword"><span class="accent_color">you may reset it</span></a>.';
          break;
          
        case 'poorpassword':
          echo 'The password you provided is too simple. Please make sure<br />
                 passwords are at least 6 characters long.';
          break;
          
        case 'invalidemail':
          echo'The email address you provided is not a valid email address. Please try again.';
        break;
      
        case 'passdontmatch':
          echo 'The passwords you provided do not match. Carefully try again.';
        break;

        case 'incomplete':
          echo 'Some fields were empty. All fields are required. Please try again.';
        break;
                 
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


  <form id="signup_form" name="signup" action="http://<?php echo DOMAIN; ?>/signup/1" method="POST">
  
    <div class="signup_row_container">
      <div class="signup_row_label">
        Email
      </div>
      <div class="signup_row_textbox">
        <input id="email" name="email" type="textbox" class="signup_textbox" />
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="signup_row_container">
      <div class="signup_row_label">
        Create Password
      </div>
      <div class="signup_row_textbox">
        <input id="new_password" name="new_password" type="password" class="signup_textbox" />
      </div>
      <div class="clearfix"></div>
    </div>
    
     <div class="signup_row_container">
      <div class="signup_row_label">
        Retype Password
      </div>
      <div class="signup_row_textbox">
        <input id="new_password_confirm" name="new_password_confirm" type="password" class="signup_textbox" />
      </div>
      <div class="clearfix"></div>
    </div>

    <div id="signup_submit_container">
      <div id="signup_submit_label">
      </div>
      <div id="signup_submit_button">
        <input type="submit" class="signup_button" value="Create Account" />
      </div>
      <div class="clearfix"></div>
    </div>
    
  </form>


  <div class="signup_footer_text">
    Have an account but forgot your password? <a href="http://<?php echo DOMAIN; ?>/lostpassword"><span class="accent_color">Reset your password</span></a>
  </div>