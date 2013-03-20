<?php

  $page_title = 'Change Picture';
  $require_login = true;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';
  
  $message = '';
  $error = false;

  if (isset($_GET['action']) && $_GET['action'] == 'submit' && !$_SESSION['using_fb'])
  {
		// form was submitted. First thing is to check if a photo was sent
		// if not, it means user didnt upload one or it got size-blocked by server
		if (count($_FILES) == 0)
		{
			//no image uploadsd
			header('Location: //'.DOMAIN.'/changepicture/invalid');
			exit;
		}
		
		if (!is_uploaded_file($_FILES['photo']['tmp_name']))
		{
			// bad file uploaded
			header('Location: //'.DOMAIN.'/changepicture/invalid');
			exit;
		}
		
		// check and see if the user uploaded an IMAGE file
		$acceptable_filetypes = "/^\.(jpg|jpeg|gif|png|JPG|JPEG|GIF|PNG){1}$/i"; 
		$safe_filename = preg_replace(array("/\s+/", "/[^-\.\w]+/"), array("_", ""), trim($_FILES['photo']['name']));
		if (!preg_match($acceptable_filetypes, strrchr($safe_filename, '.')))
		{
			header('Location: //'.DOMAIN.'/changepicture/invalid');
			exit;
		}
		
		// we can start processin now. This converts and saves the picture appropriately
		// facebook photos are usually max 200x600, we try to match that
		$GLOBALS['User']->ConvertUploadedPhoto(DOCUMENT_ROOT.'/www/img/user/', 200, 600, 'u'.$_SESSION['uid'].'.jpg', 'u'.$_SESSION['uid'].'.jpg', true, DOCUMENT_ROOT.'/www/img/user/thumb/', 4);

		// Update the forum with picture URL since they did it manually
		$GLOBALS['User']->UpdateForumUserColumn($_SESSION['uid'], 'Photo', 'http://'.DOMAIN.'/img/user/u'.$_SESSION['uid'].'.jpg');
		

    $message = 'Your Profile Picture was successfully updated.';
  }

  if (isset($_GET['action']) && $_GET['action'] == 'invalid')
  {
		$error = true;
		$message = 'That photo is invalid (too big or wrong filetype). Please try a different picture.';
  }
  
?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/page/squad.css" rel="stylesheet" type="text/css"/>
  
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

        <div id="body_content">

          <div id="squad_container">
          
            <div class="squad_title">
              Change your <span class="accent_color">Profile Picture</span>
            </div>

            <?php if ((isset($_GET['action']) && $_GET['action'] == 'submit') || $error): ?>
            <div class="squad_header <?php if ($error) echo "squad_error"; elseif (!$error) echo "squad_message"; ?>">
              <p><?php echo $message; ?></p>
            </div>
            <?php endif ?>
            
            <?php if (!$_SESSION['using_fb']): ?>
            <div class="squad_header">
              <p>Upload a photo of yourself for use on the site. Please note your picture must be an actual photo of your face (for player identification purposes).</p>
            </div>
            
            <div class="squad_content">

             <form id="squad" name="changepicture" action="//<?php echo DOMAIN; ?>/changepicture/submit" method="POST" enctype="multipart/form-data">

              <div class="squad_row">
                <div class="squad_label">
                  New Profile Picture:
                </div>

                <div class="squad_form">
                    <input id="photo" name="photo" type="file" />
                </div>
                <div class="clearfix"></div>
              </div>
              <br />
              <div class="squad_row">
                <div class="squad_label">
                  &nbsp
                </div>
                          
                <div class="squad_form">
                    <input type="submit" value="Save Profile Picture" class="squad_form_submit" />
                </div>
                <div class="clearfix"></div>
              </div>
              
            </form>

            </div>
            <?php else: ?>
            <div class="squad_header">
              <p>Your account is tied to a Facebook account. Change your account picture by changing your profile picture on facebook.com.</p>
            </div>
            <?php endif; ?>
            
          
          </div> <!-- body_container -->
          
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
