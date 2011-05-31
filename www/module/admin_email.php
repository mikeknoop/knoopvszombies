  <?php
    if (isset($_GET['action']) && $_GET['action'] == 'send')
    {
      // validate mail, send it
      if ((isset($_POST['send_addresses']) && $_POST['send_addresses'] != '') && (isset($_POST['email_subject']) && $_POST['email_subject'] != '') && (isset($_POST['email_body']) && $_POST['email_body'] != ''))
      {
        $to = $_POST['send_addresses'];
        $subject = $_POST['email_subject'];
        $body = $_POST['email_body'];
        
        $send_error = null;
        try
        {
          $attachFooter = false;
          $GLOBALS['Mail']->SimpleMail($to, $subject, $body, $attachFooter);
        }
        catch (Exception $e)
        {
          $send_error = $e->getMessage();
        }  
      }
      

    }    
    
  ?>

  <div id="admin_title">
  Send <span class="accent_color">Email</span>
  </div>
  
  <?php if (isset($_GET['action']) && $_GET['action'] == 'send' && !$send_error): ?>
  <div class="admin_status">
    Email was successfully sent.
  </div>
  <?php endif ?>

  <?php if (isset($_GET['action']) && $_GET['action'] == 'send' && $send_error): ?>
  <div class="admin_status">
    Error sending email: <?php echo $send_error; ?>
  </div>
  <?php endif ?>
  
  <div class="email_block">
    <p>Use the form below to send an email out to players.</p>
  </div>
  
  <script type="text/javascript">
  <!--
    
    function UpdateEmailAddresses()
    {
      var type = document.getElementById('send_to_type').value;
      if (type != '')
      {
        document.getElementById('send_addresses').value = document.getElementById(type+'_email').value;
      }
    }
  
  -->
  </script>

  <form name="email_send_form" action="http://<?php echo DOMAIN; ?>/admin/email/send" method="POST">

    <input type="hidden" value="<?php echo implode(',', $GLOBALS['Mail']->GetEmailAddresses('currentplayers')); ?>" id="currentplayers_email" name="currentplayers_email" />
    <input type="hidden" value="<?php echo implode(',', $GLOBALS['Mail']->GetEmailAddresses('currenthumans')); ?>" id="currenthumans_email" name="currenthumans_email" />
    <input type="hidden" value="<?php echo implode(',', $GLOBALS['Mail']->GetEmailAddresses('currentzombies')); ?>" id="currentzombies_email" name="currentzombies_email" />
    <input type="hidden" value="<?php echo implode(',', $GLOBALS['Mail']->GetEmailAddresses('currentdeceased')); ?>" id="currentdeceased_email" name="currentdeceased_email" />
    <input type="hidden" value="<?php echo implode(',', $GLOBALS['Mail']->GetEmailAddresses('notattendedorientation')); ?>" id="notattendedorientation_email" name="notattendedorientation_email" />
    <input type="hidden" value="<?php echo implode(',', $GLOBALS['Mail']->GetEmailAddresses('allusers')); ?>" id="allusers_email" name="allusers_email" />

    <div class="email_block">
      <div class="email_form_label">Send to:</div>
      <div class="email_form">
        <select name="send_to_type" id="send_to_type" onchange="UpdateEmailAddresses();">
          <option value="">Enter Email Addresses Manually</option>
          <option value="currentplayers">Current Players</option>
          <option value="currenthumans">Current Humans</option>
          <option value="currentzombies">Current Zombies</option>
          <option value="currentdeceased">Current Deceased</option>
          <option value="notattendedorientation">Players Who Have Not Attended an Orientation</option>
          <option value="allusers">All User Accounts</option>
        </select>
      </div>
      <div class="clearfix"></div>
    </div>
    
    <div class="email_block">
      <div class="email_form_label">Email addresses:</div>
      <div class="email_form"><textarea class="email_form_addresses" id="send_addresses" name="send_addresses"></textarea></div>
      <div class="clearfix"></div>
    </div>

    <div class="email_block">
      <div class="email_form_label">Subject:</div>
      <div class="email_form"><input class="email_form_subject" type="textbox" name="email_subject" value="<?php echo UNIVERSITY; ?> HvZ" /></div>
      <div class="clearfix"></div>
    </div>

    <div class="email_block">
      <div class="email_form_label">Body:</div>
      <div class="email_form">
        <textarea class="email_form_body" name="email_body">Hello,





Thanks,
<?php echo UNIVERSITY; ?> Humans vs. Zombies</textarea>
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="email_block">
      <div class="email_form_label">&nbsp;</div>
      <div class="email_form"><input class="button" type="submit" value="Send Email" /></div>
      <div class="clearfix"></div>
    </div>
    

  </form>
  

  <div class="clearfix"></div>