
  <div id="lostpassword_title">
  Reset <span class="accent_color">Password</span>
  </div>
  
  <div class="lostpassword_header_text">
    To reset your password, enter a new password in both boxes below.
  </div>

  <?php if ($_GET['state']): ?>
  <div id="lostpassword_status">
    <?php
      echo $status;
    ?>
  </div>
  <?php endif ?>
            

  <form id="newpassword_form" name="newpassword" action="http://<?php echo DOMAIN; ?>/lostpassword" method="POST">
    
    <input type="hidden" id="reset" name="reset" value="<?php echo $_GET['reset'] ?>" />
  
    <div class="lostpassword_row_container">
      <div class="lostpassword_email_label">
        New<br />Password
      </div>
      <div class="lostpassword_row_textbox">
        <input id="new_pass" name="new_pass" type="password" class="lostpassword_textbox" />
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="lostpassword_row_container">
      <div class="lostpassword_email_label">
        Retype<br />Password
      </div>
      <div class="lostpassword_row_textbox">
        <input id="new_pass_confirm" name="new_pass_confirm" type="password" class="lostpassword_textbox" />
      </div>
      <div class="clearfix"></div>
    </div>
    
    <div id="lostpassword_submit_container">
      <div id="lostpassword_submit_label">
      </div>
      <div id="lostpassword_submit_button">
        <input type="submit" class="lostpassword_button" value="Reset Password" />
      </div>
      <div class="clearfix"></div>
    </div>
  
  </form>