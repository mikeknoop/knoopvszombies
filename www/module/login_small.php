<div class="signup_title">
  Log<span class="accent_color">in</span>

  <div class="signup_subtitle">
  <a href="http://<?php echo DOMAIN; ?>/signup">or sign up</a>, <a href="http://<?php echo DOMAIN; ?>/lostpassword">lost password?</a>
  </div>
    
</div>


<form name="login" action="http://<?php echo DOMAIN; ?>/session/login" method="POST">

  <div id="signup_login_email_container">
    <div id="signup_login_email_label">
      Email
    </div>
    <div id="signup_login_email_textbox">
      <input id="email" name="email" type="textbox" class="signup_login_textbox" />
    </div>
  </div>

  <div class="clearfix"></div>

  <div id="signup_login_password_container">
    <div id="signup_login_password_label">
      Password
    </div>
    <div id="signup_login_password_textbox">
      <input id="password" name="password" type="password" class="signup_login_textbox" />
    </div>
  </div>

  <div class="clearfix"></div>

  <div id="signup_login_submit_container">
    <div id="signup_login_submit_label">
    </div>
    <div id="signup_login_submit_button">
      <input type="submit" class="signup_login_button" value="Login" />
    </div>
  </div>

</form>

<div class="clearfix"></div>