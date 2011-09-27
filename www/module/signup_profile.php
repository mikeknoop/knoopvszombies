<?php
  $title = 'link your profile';
  if ($_GET['state'] == 'pending')
  {
    $title = 'account approval pending';
  }
?>


  <div id="signup_title">
  Sign up <span class="accent_color"><?php echo $title?></span>
  </div>


  <?php if (isset($_GET['state'])): ?>
  <div id="signup_status">
    <?php
      switch ($_GET['state'])
      {      

        case 'fbexists':
          echo 'The person who is signed into Facebook is already connected with an HvZ account. <a class="accent_color" href="http://www.facebook.com" target="_new">Go to Facebook</a> and log in with your correct account.';
        break;
        
        case 'pending':
          echo 'Your information was saved and your account approval is now pending. You will receive an email once your account has been approved.';
        break;
        
        case 'invalidphoto':
          echo 'You must upload a photo (jpg, gif, png) and it must be under 2MB large. Please try again.';
        break;
        
        case 'invalidname':
          echo 'The name you entered is invalid. Please try again.';
        break;
        
        case 'denied':
          echo 'You must authorize our application (for name and photo) to continue. Please try again.';
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
  
<?php if ($_GET['state'] != 'pending'):?>
  
  <div class="signup_header_text">
  Humans vs. Zombies at Mizzou requires all players to link their accounts with a <span class="accent_color bold">real photo and name</span> before they may join a game. This helps deter player conflicts and serves as a great identity system to recognize fellow teammates. Name and photo are only shown to other players. There are two methods.
  </div>

	<div class="signup_header_text bold">
	Method 1: Facebook
	</div>

  <div class="signup_header_text">
  This will automatically connect your new Mizzou Zombies account with whomever is currently logged into Facebook on this computer. You will be asked to authorize our Facebook application so we can access your username and photo. Before you proceed, make sure <span class="bold">you</span> are logged into Facebook and not someone else.
  </div>
  
  <div class="signup_header_text">
    <div class="signup_header_text">
      <div class="fb_button fb_button_medium">
        <a class="fb_button_link" href="https://graph.facebook.com/oauth/authorize?client_id=<?php echo FB_APP_ID?>&redirect_uri=http://muzombies.org/oauth/init">
            <span class="fb_button_text">Connect with Facebook</span>
        </a>
      </div>
    </div>
  </div>
	
	<div class="signup_header_text" style="font-weight: bold;">
	<br />Method 2: Manual
	</div>

  <div class="signup_header_text">
      <span class="accent_color bold">If you don't have a Facebook account</span>, or <span class="accent_color bold">don't want to use Facebook</span>, you can manually enter your name and upload a photo for your account. If you choose to do so, your account must be manually approved by a Moderator before you may join a game. Remember, you must use a real photo of yourself and your real name to be approved. <a href="http://<?php echo DOMAIN; ?>/#" onclick="document.getElementById('signup_profile_manual').style.display='block'; return false;" class="accent_color bold"><span>Click here to enter your profile information manually.</span></a>
  </div>  
  
  <div id="signup_profile_manual" class="signup_header_text">
    <form id="signup_profile_manual_form" name="manual_form" action="http://<?php echo DOMAIN; ?>/signup/5/save" method="POST" enctype="multipart/form-data">
      <div class="signup_row_container">
        <div class="signup_row_label">
          Your Full Name
        </div>
        <div class="signup_row_textbox">
          <input id="name" name="name" type="textbox" class="signup_textbox" />
        </div>
        <div class="clearfix"></div>
      </div>

      <div class="signup_row_container">
        <div class="signup_row_label">
          Upload a Photo
        </div>
        <div class="signup_row_textbox">
          <input id="photo" name="photo" type="file" class="signup_textbox" />
        </div>
        <div class="clearfix"></div>
      </div>

      <div id="signup_submit_container">
        <div id="signup_submit_label">
        </div>
        <div id="signup_submit_button">
          <input type="submit" class="signup_button" value="Submit for Approval" />
        </div>
        <div class="clearfix"></div>
      </div>
      
    </form>
  </div> 
  <?php endif ?>
  
  
  <?php if ($_GET['state'] == 'pending'): ?>
  
  <div class="signup_header_text">
    Your account status is currently pending approval. A Moderator will soon review your account and approve it. You will receive an email once your account is approved. Note that cannot join a game until your account is approved. If you don't want to wait, you can link your account with Facebook to receive automatic approval.
  </div>
  
  <div class="signup_header_text">
    <div class="signup_header_text signup_header_2col_left">
      <div class="signup_header_fb_button fb_button fb_button_medium">
        <a class="fb_button_link" href="https://graph.facebook.com/oauth/authorize?client_id=<?php echo FB_APP_ID?>&redirect_uri=http://muzombies.org/oauth/init">
            <span class="fb_button_text">Connect with Facebook</span>
        </a>
      </div>
    </div>
    <div class="signup_header_text signup_header_2col_right">
      The <span class="accent_color bold">automatic</span> way to link your name and photo is to connect with your Facebook account. You can click the Connect button to bypass account approval.
    </div>
    <div class="clearfix"></div>
  </div>
  
  <div class="signup_header_text">
    * This will connect automatically with whomever is currently logged into Facebook on this computer. You will be asked to authorize our Facebook application so we can access your username and photo.
  </div>
  
  <?php endif ?>
  
