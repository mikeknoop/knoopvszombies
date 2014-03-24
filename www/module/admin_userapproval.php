  <?php
    if (isset($_GET['action']) && !$GLOBALS['User']->CheckValidApproval($_GET['target']))
    {
      exit;
    }
   
    if (isset($_GET['action']) && $_GET['action'] == 'approve')
    {
      $uid = $GLOBALS['User']->CheckValidApproval($_GET['target']);
      if (!$GLOBALS['User']->ApproveAccount($_GET['target'], $uid))
      {
        echo "Error approving account, please go back and try again.";
        exit;
      }
      
      $user = $GLOBALS['User']->GetUser($uid);
      
      // Mail user at email address
      $to = $user['email'];
      $subject = "".UNIVERSITY." HvZ Account Approved";
      $html = "Hello,<br>Your ".UNIVERSITY." HvZ account was recently approved by a moderator. You may now join a game on the website.<br>To complete your account setup, you can log in to the website or follow this link: <a href='http://".DOMAIN."/signup/6'>http://".DOMAIN."/signup/6</a><br>";
      $text = "Hello,\r\nYour ".UNIVERSITY." HvZ account was recently approved by a moderator. You may now join a game on the website.\r\nTo complete your account setup, you can log in to the website or follow this link: http://".DOMAIN."/signup/6\r\n";     
    
      $GLOBALS['Mail']->HTMLMail($to, $subject, $html, $text);      

      // Refresh details
      $users_to_approve = $GLOBALS['User']->GetUsersToApprove();
      $users_to_approve_count = count($users_to_approve);
      
    }

    if (isset($_GET['action']) && $_GET['action'] == 'deny')
    {
      $uid = $GLOBALS['User']->CheckValidApproval($_GET['target']);
      if (!$GLOBALS['User']->DenyAccount($_GET['target'], $uid))
      {
        echo "Error denying account, please go back and try again.";
        exit;
      }
      
      $user = $GLOBALS['User']->GetUser($uid);
      
      // Mail user at email address
      $to = $user['email'];
      $subject = "".UNIVERSITY." HvZ Account Denied";
      $html = "Hello,<br>Your ".UNIVERSITY." HvZ account was recently denied by a moderator. This may have occured for one of the following reasons:<br>1. You did not use your real name.<br>2. You did not use a photo of yourself.<br>3. Your waiver information did not match your name.<br>Please note that you may log into the website and re-fill in your waiver, name, and photo and submit again for approval. You can do so here: http://".DOMAIN."/signup<br>Remember, you can connect with your Facebook account on the Profile Information step for automatic approval.<br>";
      $text = "Hello,\r\nYour ".UNIVERSITY." HvZ account was recently denied by a moderator. This may have occured for one of the following reasons:\r\n1. You did not use your real name.\r\n2. You did not use a photo of yourself.<br>3. Your waiver information did not match your name.\r\nPlease note that you may log into the website and re-fill in your waiver, name, and photo and submit again for approval. You can do so here: http://".DOMAIN."/signup\r\mRemember, you can connect with your Facebook account on the Profile Information step for automatic approval.\r\n";  
    
      $GLOBALS['Mail']->HTMLMail($to, $subject, $html, $text);  
      
      // Refresh details
      $users_to_approve = $GLOBALS['User']->GetUsersToApprove();
      $users_to_approve_count = count($users_to_approve);
       
    }
    
  ?>

  <div id="admin_title">
  User <span class="accent_color">Approval</span>
  </div>
  
  <?php if (isset($_GET['action']) && $_GET['action'] == 'approve'): ?>
  <div class="admin_status">
    <?php echo $user['name'] ?> was approved. An email notification was sent.
  </div>
  <?php endif ?> 

  <?php if (isset($_GET['action']) && $_GET['action'] == 'deny'): ?>
  <div class="admin_status">
    <?php echo $user['name'] ?> was denied. An email notification was sent.
  </div>
  <?php endif ?> 
  
  <?php

  $approvalArray = $GLOBALS['User']->GetAccountsForApproval();

  ?>

  <style>
    #playerlist_table_container
    {
      margin-top: 40px;
    }
    
    .playerlist_display_options_label
    {
      width:    150px;
    }
    .playerlist_display_options_container
    {
      margin-top: 2px;
      margin-bottom: 2px;
    }
    .playerlist_table
    {
      font-size:  14px;
    }
    .playerlist_table_row
    {
      height:     80px;
    }
  </style>


  <div class="playerlist_header_text">
    <p>The following accounts manually entered their name and uploaded a photo. We should do our best job to verify these are real players and that they uploaded a photo of themselves. Once you approve/deny, they are sent a notification email.</p>
  </div>

  <div class="playerlist_header_text">
    <p>If a user is denied, that user will be allowed to re-enter their name and re-upload a new photo.</p>
  </div>
  
  <div class="playerlist_header_text">
    <p>Important! Deny any account where the name column does not match the waiver column.</p>
  </div>

  <div class="playerlist_header_text">
    <p>Click on a user's picture or name to get a larger view of their profile.</p>
  </div>
  
  <div id="playerlist_table_container">

    <table class="playerlist_table">
      <tr class="playerlist_table_row_headerfooter">
        <td class="playerlist_table_cell playerlist_table_cell_picture">Picture</td>
        <td class="playerlist_table_cell playerlist_table_cell_name">Name</td>
        <td class="playerlist_table_cell playerlist_table_cell_email">Email</td>
        <td class="playerlist_table_cell playerlist_table_cell_waiver">Waiver</td>
        <td class="playerlist_table_cell playerlist_table_cell_approve">Approve</td>
        <td class="playerlist_table_cell playerlist_table_cell_deny">Deny</td>
      </tr>
      
      <?php if (count($approvalArray) > 0): ?>
        <?php foreach ($approvalArray as $player): ?>
          <tr class="playerlist_table_row">
            <td class="playerlist_table_cell table_cell_center">
            <a href="http://<?php echo DOMAIN; ?>/account/<?php echo $player['uid']; ?>" class="accent_color" target="_new"><img class="playerlist_table_cell_img" src="<?php     
                if ($player['using_fb'])
                {
                  echo 'http://graph.facebook.com/'.$player['fb_id'].'/picture?type=small';
                  
                }
                else
                {
                  echo '//'.DOMAIN.'/img/user/thumb/u'.$player['uid'].'.jpg';
                }
              ?>"></img></a>
            </td>
            <td class="playerlist_table_cell">
              <a href="http://<?php echo DOMAIN; ?>/account/<?php echo $player['uid']; ?>" class="accent_color" target="_new"><?php echo $player['name']; ?></a>
            </td>
            <td class="playerlist_table_cell">
              <?php echo $player['email']; ?>
            </td>
            <td class="playerlist_table_cell">
              <?php echo $player['liability_waiver']; ?>
            </td>
            <td class="playerlist_table_cell">
              <a class="button" href="http://<?php echo DOMAIN; ?>/admin/userapproval/approve/<?php echo $player['aid']; ?>">Approve</a>
            </td>
            <td class="playerlist_table_cell">
              <a class="button" href="http://<?php echo DOMAIN; ?>/admin/userapproval/deny/<?php echo $player['aid']; ?>">Deny</a>
            </td>
          </tr>
        <?php endforeach ?>
        
      <?php else: ?>
        <tr class="playerlist_table_row_noplayers">
          <td colspan="5" class="playerlist_table_cell table_cell_center">There are no accounts to approve at this time</td>
        </tr>
      <?php endif ?>
      
      <tr class="playerlist_table_row_headerfooter">
        <td class="playerlist_table_cell playerlist_table_cell_picture"></td>
        <td class="playerlist_table_cell playerlist_table_cell_name"></td>
        <td class="playerlist_table_cell playerlist_table_cell_email"></td>
        <td class="playerlist_table_cell playerlist_table_cell_waiver"></td>
        <td class="playerlist_table_cell playerlist_table_cell_approve"></td>
        <td class="playerlist_table_cell playerlist_table_cell_deny"></td>
      </tr>
      
    </table>
  </div>


  <div class="clearfix"></div>
