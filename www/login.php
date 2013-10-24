<?php

  $page_title = 'Login';
  $require_login = false;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';
  
?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/page/login.css" rel="stylesheet" type="text/css"/>
  
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
        
        <div class="clearfix"></div>
        
        <div id="body_content">
                     
          <div id="login_container">
          
            <div id="login_title">
            Log<span class="accent_color">in</span>
            </div>
          
            <?php if (isset($_GET['state'])): ?>
            <div id="login_status">
              <?php
                switch ($_GET['state'])
                {
                  case 'tryagain':
                    echo 'The email and password combination could<br />
                           not be found. Please try again.';
                    break;
                  
                  case 'slowdown':
                    echo 'Please wait a few seconds and try again.';
                    break;
                  
                  case 'required':
                    echo 'The page you attempted to access<br />
                          requires you to login.';
                    break;
                    
                  default:
                    echo 'An unknown error occured. Please try again.';
                    break;
                }
              ?>
            </div>
            <?php endif ?>
          
          
            <form id="login_form" name="login" action="//<?php echo DOMAIN; ?>/session/login" method="POST">
            
              <input id="ref" name="ref" type="hidden" value="<?php if (isset($_GET['ref'])) echo $_GET['ref']; ?>" />
              
              <div class="login_row_container">
                <div class="login_row_label">
                  Email
                </div>
                <div class="login_row_textbox">
                  <input id="email" name="email" type="textbox" class="login_textbox" />
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="login_row_container">
                <div class="login_row_label">
                  Password
                </div>
                <div class="login_row_textbox">
                  <input id="password" name="password" type="password" class="login_textbox" />
                </div>
                <div class="clearfix"></div>
              </div>

              <div id="login_submit_container">
                <div id="login_submit_label">
                </div>
                <div id="login_submit_button">
                  <input type="submit" class="login_button" value="Login" />
                </div>
                <div class="clearfix"></div>
              </div>
              
            </form>


            <div class="login_footer_text">
              Forgot your password? <a href="//<?php echo DOMAIN; ?>/lostpassword"><span class="accent_color">Reset your password</span></a>
            </div>
                  
            <div class="login_footer_text">
              Need an account? <a href="//<?php echo DOMAIN; ?>/signup"><span class="accent_color">Sign up</span></a>
            </div>
            

          </div>
        
          <div id="signup_container">
            <?php
              require 'module/signup_incent_large.php';
            ?>
          </div> <!-- signup_container -->
          
          <div class="clearfix"></div>
          
        </div> <!-- body_content -->     
        

      </div> <!-- content -->
    </div>  <!-- content_column -->
    
    
    <div id="footer_push"></div>
  </div> <!-- body_container -->

  <?php
    require 'module/footer.php';
  ?>


</body>

</html>
