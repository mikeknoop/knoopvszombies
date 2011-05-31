
  <div id="lostpassword_title">
  Lost <span class="accent_color">Password</span>
  </div>
  
  <div class="lostpassword_header_text">
    Enter your email address below and we'll send you a link to reset your password.
  </div>

  <?php if ($_GET['state']): ?>
  <div id="lostpassword_status">
    <?php
      echo $status;
    ?>
  </div>
  <?php endif ?>
            
  <?php if (!($_GET['state'] == 'sendsuccess' || $_GET['state'] == 'success')): ?>
  <form id="lostpassword_form" name="lostpassword" action="http://<?php echo DOMAIN; ?>/lostpassword" method="POST">
  
    <div class="lostpassword_row_container">
      <div class="lostpassword_row_label">
        Email
      </div>
      <div class="lostpassword_row_textbox">
        <input id="email" name="email" type="textbox" class="lostpassword_textbox" />
      </div>
      <div class="clearfix"></div>
    </div>

    <div id="lostpassword_submit_container">
      <div id="lostpassword_submit_label">
      </div>
      <div id="lostpassword_submit_button">
        <input type="submit" class="lostpassword_button" value="Request Reset Link" />
      </div>
      <div class="clearfix"></div>
    </div>
  
  </form>
  <?php endif ?>
        
  <div class="lostpassword_footer_text">
    Need an account? <a href="http://<?php echo DOMAIN; ?>/signup"><span class="accent_color">Sign up</span></a>
  </div>