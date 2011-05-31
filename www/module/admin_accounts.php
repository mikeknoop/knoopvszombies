<?php if (isset($_GET['action']) && ($_GET['action'] == 'edit' || $_GET['action'] == 'save') && isset($_GET['target']) && $_GET['target'] != ''): ?>

  <?php
    if (($_GET['action'] == 'save' || $_GET['action'] == 'edit') && !$GLOBALS['User']->IsValidUser($_GET['target']))
    {
      exit;
    }
   
    if ($_GET['action'] == 'save')
    {
    
      $forum_privileges = null;
      $user = $GLOBALS['User']->GetUser($_GET['target']);
      
      // Special validation cases
      if (isset($_POST['admin']) && $_POST['admin'] == 'on')
      {
        $_POST['admin'] = '1';
      }
      else
      {
        $_POST['admin'] = '0';
      }

      if (isset($_POST['approved']) && $_POST['approved'] == 'on')
      {
        $_POST['approved'] = '1';
      }
      else
      {
        $_POST['approved'] = '0';
      }

      if (isset($_POST['delete_from_game']) && $_POST['delete_from_game'] == 'on')
      {
        $_POST['delete_from_game'] = '1';
      }
      else
      {
        $_POST['delete_from_game'] = '0';
      }

      if (isset($_POST['add_to_game']) && $_POST['add_to_game'] == 'on')
      {
        $_POST['add_to_game'] = '1';
      }
      else
      {
        $_POST['add_to_game'] = '0';
      }
      
      if (!$_POST['admin'])
      {
        $_POST['privilege'] = '';
      }
      
      // validate and save the user form
      $save = array();
      $saved = array();
      $email_changes = array();
      if (is_array($_POST))
      {
        foreach ($_POST as $key => $value)
        {
          switch ($key)
          {
            case 'name':
              $save[$key] = $value;
              if ($user[$key] != $value)
              {
                $email_changes['Name'] = $value;
                
                // need to update name in forum database too
                $GLOBALS['Db']->SelectDb(FORUM_DATABASE);
                $sql = "UPDATE ".FORUM_DATABASE.".GDN_User SET name = '{$value}' WHERE UserID = '{$user['uid']}'";
                if (!$GLOBALS['Db']->Execute($sql))
                {
                  throw new Exception('Error updating user.');
                }
                $GLOBALS['Db']->Commit();
                $GLOBALS['Db']->SelectDb(DATABASE);
              }
              break;

            case 'email':
              if (filter_var($value, FILTER_VALIDATE_EMAIL, FILTER_FLAG_SCHEME_REQUIRED))
              {
                $save[$key] = $value;
                if ($user[$key] != $value)
                {
                  $email_changes['Email'] = $value;
                  
                  $GLOBALS['Db']->SelectDb(FORUM_DATABASE);
                  // need to update name in forum database too
                  $sql = "UPDATE ".FORUM_DATABASE.".GDN_User SET email = '{$value}' WHERE UserID = '{$user['uid']}'";
                  if (!$GLOBALS['Db']->Execute($sql))
                  {
                    throw new Exception('Error updating user.');
                  }
                  $GLOBALS['Db']->Commit();
                  $GLOBALS['Db']->SelectDb(DATABASE);
                
                }
              }
              break;

            case 'squad_name':
              $save[$key] = $value;
              if ($user[$key] != $value)
              {
                if ($value == '')
                {
                  $email_changes['Squad Name'] = '(none)';
                }
                else
                {
                  $email_changes['Squad Name'] = $value;
                }
              }
              break;
              
            case 'admin':
              $save[$key] = $value;
              if ($user[$key] != $value)
              {
                if ($value == '1')
                  $email_changes['Admin'] = 'Yes';
                else
                  $email_changes['Admin'] = 'No';
              }
              break;
              
            case 'privileges':
              $save[$key] = $value;
              if ($user[$key] != $value)
              {
                if ($value == '')
                  $email_changes['Admin Privileges'] = '(no privileges)';
                else
                  $email_changes['Admin Privileges'] = $value;
              }
              break;

            case 'forum_privileges':
              $save[$key] = $value;
              if ($user[$key] != $value)
              {           
                switch ($value)
                {
                  case "admin":
                    $email_text = "Administrator";
                    $new_role_ids = array('8', '16');
                    //$perms = 'a:32:{i:0;s:22:"Garden.Settings.Manage";i:1;s:20:"Garden.Routes.Manage";i:2;s:26:"Garden.Applications.Manage";i:3;s:21:"Garden.Plugins.Manage";i:4;s:20:"Garden.Themes.Manage";i:5;s:19:"Garden.SignIn.Allow";i:6;s:26:"Garden.Registration.Manage";i:7;s:24:"Garden.Applicants.Manage";i:8;s:19:"Garden.Roles.Manage";i:9;s:16:"Garden.Users.Add";i:10;s:17:"Garden.Users.Edit";i:11;s:19:"Garden.Users.Delete";i:12;s:20:"Garden.Users.Approve";i:13;s:22:"Garden.Activity.Delete";i:14;s:20:"Garden.Activity.View";i:15;s:20:"Garden.Profiles.View";i:16;s:23:"Vanilla.Settings.Manage";i:17;s:25:"Vanilla.Categories.Manage";i:18;s:19:"Vanilla.Spam.Manage";i:19;s:19:"Plugins.Poll.Manage";i:20;s:17:"Plugins.Poll.View";i:21;s:19:"Plugins.Poll.Delete";s:24:"Vanilla.Discussions.View";a:6:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"6";i:3;s:1:"7";i:4;s:1:"9";i:5;s:2:"10";}s:23:"Vanilla.Discussions.Add";a:6:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"6";i:3;s:1:"7";i:4;s:1:"9";i:5;s:2:"10";}s:24:"Vanilla.Discussions.Edit";a:6:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"6";i:3;s:1:"7";i:4;s:1:"9";i:5;s:2:"10";}s:28:"Vanilla.Discussions.Announce";a:6:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"6";i:3;s:1:"7";i:4;s:1:"9";i:5;s:2:"10";}s:24:"Vanilla.Discussions.Sink";a:6:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"6";i:3;s:1:"7";i:4;s:1:"9";i:5;s:2:"10";}s:25:"Vanilla.Discussions.Close";a:6:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"6";i:3;s:1:"7";i:4;s:1:"9";i:5;s:2:"10";}s:26:"Vanilla.Discussions.Delete";a:6:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"6";i:3;s:1:"7";i:4;s:1:"9";i:5;s:2:"10";}s:20:"Vanilla.Comments.Add";a:6:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"6";i:3;s:1:"7";i:4;s:1:"9";i:5;s:2:"10";}s:21:"Vanilla.Comments.Edit";a:6:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"6";i:3;s:1:"7";i:4;s:1:"9";i:5;s:2:"10";}s:23:"Vanilla.Comments.Delete";a:6:{i:0;s:1:"3";i:1;s:1:"4";i:2;s:1:"6";i:3;s:1:"7";i:4;s:1:"9";i:5;s:2:"10";}}';
                    break;

                  case "moderator":
                    $email_text = "Moderator";
                    $new_role_ids = array('8', '32');
                    //$perms = 'a:25:{i:0;s:19:"Garden.SignIn.Allow";i:1;s:20:"Garden.Activity.View";i:2;s:20:"Garden.Profiles.View";i:3;s:25:"Vanilla.Categories.Manage";i:4;s:19:"Vanilla.Spam.Manage";i:5;s:24:"Vanilla.Discussions.View";i:6;s:23:"Vanilla.Discussions.Add";i:7;s:24:"Vanilla.Discussions.Edit";i:8;s:28:"Vanilla.Discussions.Announce";i:9;s:24:"Vanilla.Discussions.Sink";i:10;s:25:"Vanilla.Discussions.Close";i:11;s:26:"Vanilla.Discussions.Delete";i:12;s:20:"Vanilla.Comments.Add";i:13;s:21:"Vanilla.Comments.Edit";i:14;s:23:"Vanilla.Comments.Delete";s:24:"Vanilla.Discussions.View";a:1:{i:0;s:1:"1";}s:23:"Vanilla.Discussions.Add";a:1:{i:0;s:1:"1";}s:24:"Vanilla.Discussions.Edit";a:1:{i:0;s:1:"1";}s:28:"Vanilla.Discussions.Announce";a:1:{i:0;s:1:"1";}s:24:"Vanilla.Discussions.Sink";a:1:{i:0;s:1:"1";}s:25:"Vanilla.Discussions.Close";a:1:{i:0;s:1:"1";}s:26:"Vanilla.Discussions.Delete";a:1:{i:0;s:1:"1";}s:20:"Vanilla.Comments.Add";a:1:{i:0;s:1:"1";}s:21:"Vanilla.Comments.Edit";a:1:{i:0;s:1:"1";}s:23:"Vanilla.Comments.Delete";a:1:{i:0;s:1:"1";}}';
                    break;
                    
                  case "member":
                  default:                 
                    $email_text = "Member";
                    $new_role_ids = array('8');
                    //$perms = 'a:6:{i:0;s:19:"Garden.SignIn.Allow";i:1;s:20:"Garden.Activity.View";i:2;s:20:"Garden.Profiles.View";s:24:"Vanilla.Discussions.View";a:1:{i:0;s:1:"1";}s:23:"Vanilla.Discussions.Add";a:1:{i:0;s:1:"1";}s:20:"Vanilla.Comments.Add";a:1:{i:0;s:1:"1";}}';
                    break;
                }
                
                // Do the DB transactions here, remove the permission row, it will get updated next time they login
              
              $GLOBALS['Db']->SelectDb(FORUM_DATABASE);
              $sql = "UPDATE ".FORUM_DATABASE.".GDN_User SET Permissions = '' WHERE UserID = '{$user['uid']}'";
              if (!$GLOBALS['Db']->Execute($sql))
              {
                throw new Exception('Error updating user.');
              }
              

              // Delete all roles
              $sql = "DELETE FROM ".FORUM_DATABASE.".GDN_UserRole WHERE UserID = '{$user['uid']}' AND (RoleID = '8' OR RoleID = '16' OR RoleID = '32')";
              if (!$GLOBALS['Db']->Execute($sql))
              {
                throw new Exception('Error creating user.');
              }
              
              // Insert the new roles
              foreach ($new_role_ids as $new_role_id)
              {
                $sql = "INSERT INTO ".FORUM_DATABASE.".GDN_UserRole (UserID, RoleID) VALUES('{$user['uid']}', '$new_role_id')";
                if (!$GLOBALS['Db']->Execute($sql))
                {
                  throw new Exception('Error creating user.');
                }
              }
              
              // Finally commit all changes to forum DB
              $GLOBALS['Db']->Commit();
              
              // Change back to production for continuity in script
              $GLOBALS['Db']->SelectDb(DATABASE);
    
                $email_changes['Forum Privileges'] = $email_text;
              }
              break;
              
            case 'liability_waiver':
              $save[$key] = $value;
              /* Don't email for waiver changes
              if ($user[$key] != $value)
                $email_changes['Waiver'] = $value;
              */
              break;

            case 'approved':
              $save[$key] = $value;
              if ($user[$key] != $value)
              {
                if ($value == '1')
                  $email_changes['Approved'] = 'Yes';
                else
                  $email_changes['Approved'] = 'No';
              }
              break;

            case 'delete_from_game':
              if ($value)
              {
                // Remove from game is in current game
                if ($GLOBALS['state'])
                {
                  $current_gid = $GLOBALS['state']['gid'];
                  
                  if ($GLOBALS['Game']->RemoveFromGame($current_gid, $user['uid']))
                  {
                    $email_changes['Removed From Game'] = 'Yes';
                    $saved['delete_from_game'] = 'Yes';
                  }
                }
                
                // Clear the cache of this user
                $GLOBALS['User']->ClearAllUserCache();                
              }
              break;

            case 'add_to_game':
              if ($value)
              {
                // Remove from game is in current game
                if ($GLOBALS['state'])
                {
                  $current_gid = $GLOBALS['state']['gid'];
                  
                  $secret = $GLOBALS['Game']->GenerateSecret($current_gid);
                  if ($GLOBALS['User']->JoinGame($current_gid, $user['uid'], $secret))
                  {
                    $joined_game = $GLOBALS['Game']->GetGame($current_gid);
                    $join_success = true;
                    
                    // Mail user at email address
                    $to = $user['email'];
                    $subject = "{UNIVERSITY} HvZ Game Joined";
                    $body = "Hello,\n\n Your {UNIVERSITY} HvZ account succesfully joined the {$joined_game['name']} game. Your Secret Game ID for this game is: $secret\n\rWrite down this Secret Game ID and your full name on an index card and carry this card with you at all times! If you are unfamiliar with the rules, please read http://".DOMAIN."/rules and make sure to come to an orientation session.\n\rOrientation times and dates are posted on the website at http://".DOMAIN."/rules \n";

                    $GLOBALS['Mail']->SimpleMail($to, $subject, $body);

                    $email_changes['Added To Game'] = 'Yes';
                    $saved['add_to_game'] = 'Yes';
                    
                  }
                  
                }
              }
              break;
              
          }
        }
      }

      foreach ($save as $key => $value)
      {
        // $save is sanitized, validated input
        if ($user[$key] != $value)
        {
          $GLOBALS['User']->UpdateUserColumn($user['uid'], $key, addslashes($value));
          $saved[$key] = $value;
        }
      }
      
      if (count($saved) > 0 || isset($email_changes['Removed From Game']))
      {
        // Mail user at email address
        $to = $user['email'];
        if (isset($saved['email']))
        {
          $to .= ','.$saved['email'];
        }
        $subject = "{UNIVERSITY} HvZ Account Updated";
        $body = "Hello,\n\nYour {UNIVERSITY} HvZ account information was recently modified by a moderator. If you are unsure why or think this is a mistake, please email a moderator.\n\n";
        
        if (is_array($email_changes) && count($email_changes) > 0)
        {
          $body .= "The following changes were made:\n\r";
        }       
        
        foreach ($email_changes as $key => $value)
        {
          $body .= "$key: $value\n";
        }
        $body .= "\nYou can log into your account to further review the changes and see them live on the website.\n\n";
                 
        $GLOBALS['Mail']->SimpleMail($to, $subject, $body);
      }
    }
   
    $user = $GLOBALS['User']->GetUser($_GET['target']);

  ?>

  <div id="admin_title">
  Edit Account <span class="accent_color">(<a class="accent_color" href="http://<?php echo DOMAIN; ?>/account/<?php echo $user['uid']; ?>"><?php echo $user['name'] ?></a>) (<?php echo $user['uid'] ?>)</span>
  </div>
  
  <?php if ($_GET['action'] == 'save'): ?>
  <div class="admin_status">
    The following database fields were updated: 
    <?php
      $i = 1;
      foreach ($saved as $key => $value)
      {
        echo $key;
        if ($i < count($saved))
          echo ', ';
        $i++;
      }
      
      if (count($saved) == 0 && !isset($email_changes['Removed From Game']))
      {
        echo '(none)';
      }
      else
      {
        echo '<br />The user has been emailed of these changes.';
      }
    ?>
  </div>
  <?php endif ?> 
  
  <form class="playerlist_edit_form" name="playerlist_edit_form" action="http://<?php echo DOMAIN; ?>/admin/accounts/save/<?php echo $user['uid']; ?>" method="POST">
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Name:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="text" name="name" value="<?php echo $user['name']; ?>" />
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Email:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="text" name="email" value="<?php echo $user['email']; ?>" />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Squad:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="text" name="squad_name" value="<?php echo $user['squad_name']; ?>" />
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Remove From Game:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="checkbox" name="delete_from_game" />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Add to Game:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="checkbox" name="add_to_game" />
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Admin:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="checkbox" name="admin" <?php if ($user['admin']) echo "checked=true"; ?> />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Admin Privileges:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="text" id="privileges_form" name="privileges" value="<?php echo $user['privileges']; ?>" />
    </div>
    <div class="admin_playerlist_edit_row_caption">
      <input class="button" type="submit" value="Regular Mod" onclick="document.getElementById('privileges_form').value='playerlist,userapproval,'; return false;" />
      <input class="button" type="submit" value="Head Mod" onclick="document.getElementById('privileges_form').value='playerlist,accounts,userapproval,gameplay,email,game,'; return false;" />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Forum Privileges:
    </div>
    <div class="admin_playerlist_edit_row_form">
    <select id="forum_privileges" name="forum_privileges" class="admin_playerlist_edit_row_select">
      <option value="member" <?php if ($user['forum_privileges'] == 'member') echo "selected"; ?>>Member</option>
      <option value="moderator" <?php if ($user['forum_privileges'] == 'moderator') echo "selected"; ?>>Moderator</option>
      <option value="admin" <?php if ($user['forum_privileges'] == 'admin') echo "selected"; ?>>Admin</option>
    </select>
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Waiver:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="text" name="liability_waiver" value="<?php echo $user['liability_waiver']; ?>" />
    </div>
  </div>

  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    Approved:
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input type="checkbox" name="approved" <?php if ($user['approved']) echo "checked=true"; ?> />
    </div>
  </div>
  
  <div class="admin_playerlist_edit_row_container">
    <div class="admin_playerlist_edit_row_label">
    &nbsp;
    </div>
    <div class="admin_playerlist_edit_row_form">
      <input class="button" type="submit" value="Save Changes"></input> <a class="button" href="http://<?php echo DOMAIN; ?>/admin/accounts/">Cancel</a>
    </div>
  </div>
  
  </form>
  
<?php else: ?>

  <?php
  
    if (isset($_GET['action']) && $_GET['action'] == 'clearcache')
    {
      $GLOBALS['User']->ClearAllUserCache();
    }
    
  ?>  
  <div id="admin_title">
  Edit <span class="accent_color">Accounts</span>
  </div>

  <?php if (isset($_GET['action']) && $_GET['action'] == 'clearcache'): ?>
  <div class="admin_status">
    All user cache files were successfully deleted.
  </div>
  <?php endif ?>
  
  <?php
    
  if (isset($_GET['p']) && $_GET['p'] != '')
    $page = $_GET['p'];
  else
    $page = 1;
  
  if (isset($_GET['pageBy']) && $_GET['pageBy'] != '')
    $pageBy = $_GET['pageBy'];
  else
    $pageBy = 1000;

  if (isset($_GET['sortBy']) && $_GET['sortBy'] != '')
    $sortBy = $_GET['sortBy'];
  else
    $sortBy = 'name';

  if (isset($_GET['filterBy']) && $_GET['filterBy'] != '')
    $filterBy = $_GET['filterBy'];
  else
  {
    $filterBy = 'approved';
  }
    

  $playerArray = $GLOBALS['User']->GetAccounts($pageBy, $page, $sortBy, $filterBy);
  $playerArrayFilteredTotal = $GLOBALS['User']->GetAccounts('all', 1, $sortBy, $filterBy);
  $playerCount = count($playerArrayFilteredTotal);


// Figure which page numbers to show. Want to show at least last 2 pages and up to next 2
  $pageDisplay = array();
  $maxPage = ceil($playerCount / $pageBy);
  
  switch ($page)
  {
    case 1:
      $pageDisplay[0] = 1;
      break;
      
    case 2:
      $pageDisplay[0] = 1;
      $pageDisplay[1] = 2;
      break;
    
    case 3:
      $pageDisplay[0] = 1;
      $pageDisplay[1] = 2;
      $pageDisplay[2] = 3;
      break;
      
    default:
      $pageDisplay[0] = $page - 3;
      $pageDisplay[1] = $page - 2;
      $pageDisplay[2] = $page - 1;
      break;
      
  }

  $index = count($pageDisplay) - 1;
  $pageIndex = $pageDisplay[$index];
  $pageIndex++;
  $index++;
  $afterCurrentIndex = $index;
  $afterCurrentMax = 5;

  
  while ($pageIndex <= $maxPage && $afterCurrentIndex < $afterCurrentMax)
  {
    $pageDisplay[$index] = $pageIndex;
    $pageIndex++;
    $index++;
    $afterCurrentIndex++;
  }
  
  ?>
  
  <div id="playerlist_header">
  
  <style>
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
      height:     40px;
    }
  </style>
    
    <div id="playerlist_display_options">
      <form name="playerlist_display_options_form" action="http://<?php echo DOMAIN; ?>/admin/accounts/" type="GET">
        <div class="playerlist_display_options_container">
          <select class="playerlist_display_options_select" name="filterBy">
            <option value="" <?php if (!isset($filterBy) || $filterBy == '') echo "selected"; ?> >Filter By</option>
            <option value="approved" <?php if (isset($filterBy) && $filterBy == 'approved') echo "selected"; ?> >Approved</option>
            <option value="notapproved" <?php if (isset($filterBy) && $filterBy == 'notapproved') echo "selected"; ?> >Not Approved</option>
            <option value="all" <?php if (isset($filterBy) && $filterBy == 'all') echo "selected"; ?> >All</option>
            <option value="admins" <?php if (isset($filterBy) && $filterBy == 'admins') echo "selected"; ?> >Admins</option>
            <option value="users" <?php if (isset($filterBy) && $filterBy == 'users') echo "selected"; ?> >Users</option>
          </select>
        </div>
        <div class="playerlist_display_options_container">
          <select class="playerlist_display_options_select" name="sortBy">
            <option value="" <?php if (!isset($sortBy) || $sortBy == '') echo "selected"; ?> >Sort By</option>
            <option value="name" <?php if (isset($sortBy) && $sortBy == 'name') echo "selected"; ?> >Name</option>
          </select>
        </div>
        <div class="playerlist_display_options_container">
          <select class="playerlist_display_options_select" name="pageBy">
            <option value="" <?php if (!isset($pageBy) || $pageBy == '') echo "selected"; ?> >Players Per Page</option>
            <option value="100" <?php if (isset($pageBy) && $pageBy == '100') echo "selected"; ?> >100</option>
            <option value="500" <?php if (isset($pageBy) && $pageBy == '500') echo "selected"; ?> >500</option>
            <option value="1000" <?php if (isset($pageBy) && $pageBy == '1000') echo "selected"; ?> >1000</option>
          </select>
        </div>
        <div class="playerlist_display_options_container">
          <input class="button" type="submit" value="Update" class="playerlist_display_options_submit"></input>
        </div>
        
      </form>
      <div class="clearfix"></div>
    </div>
    
    <div class="playerlist_pagination">
      <?php if (count($pageDisplay) > 0): ?>
        <?php foreach ($pageDisplay as $row): ?>
          <?php if ($row == $page): ?>
           <div class="playerlist_header_pagination_page accent_color">
            <?php echo $row; ?>
           </div>
          <?php else: ?>           
           <div class="playerlist_header_pagination_page">
            <a class="playerlist_header_pagination_page_link" href="http://<?php echo DOMAIN; ?>/admin/accounts/?p=<?php echo $row; if (isset($_GET['pageBy'])) echo "&pageBy={$_GET['pageBy']}"; if (isset($_GET['sortBy'])) echo "&sortBy={$_GET['sortBy']}"; if (isset($_GET['filterBy'])) echo "&filterBy={$_GET['filterBy']}"; ?>"><?php echo $row; ?></a>
           </div>
          <?php endif ?>
        <?php endforeach ?>
      <?php endif ?>
    </div>
    
    <div class="playerlist_right_text">
      Click on a user picture or name to edit. <?php echo $playerCount ?> total accounts. 
    </div>    
    <div class="clearfix"></div>
    
  </div>

  <div id="playerlist_table_container">

    <table class="playerlist_table">
      <tr class="playerlist_table_row_headerfooter">
        <!--<td class="playerlist_table_cell playerlist_table_cell_picture">Picture</td>-->
        <td class="playerlist_table_cell playerlist_table_cell_name">Name</td>
        <td class="playerlist_table_cell playerlist_table_cell_email">Email</td>
        <td class="playerlist_table_cell playerlist_table_cell_impersonate">Impersonate</td>
        <td class="playerlist_table_cell playerlist_table_cell_waiver">Waiver</td>
        <td class="playerlist_table_cell playerlist_table_cell_approved">Approved</td>
      </tr>
      
      <?php if (count($playerArray) > 0): ?>
        <?php foreach ($playerArray as $player): ?>
          <tr class="playerlist_table_row">
            <!--<td class="playerlist_table_cell table_cell_center">
            <a href="http://<?php echo DOMAIN; ?>/admin/accounts/edit/<?php echo $player['uid']; ?>" class="accent_color"><img class="playerlist_table_cell_img" src="<?php     
                if ($player['using_fb'])
                {
                  echo 'http://graph.facebook.com/'.$player['fb_id'].'/picture?type=small';
                }
                else
                {
                  echo '//'.DOMAIN.'img/user/thumb/u'.$player['uid'].'.jpg';
                }
              ?>"></img></a>
            </td>-->
            <td class="playerlist_table_cell">
              <a href="http://<?php echo DOMAIN; ?>/admin/accounts/edit/<?php echo $player['uid']; ?>" class="accent_color">
                  <?php 
                  if (isset($player['name']) && $player['name'] != '')
                  {
                    echo $player['name']; 
                  }
                  else
                  {
                    echo "n/a";
                  }
                  ?>
              </a>
            </td>
            <td class="playerlist_table_cell">
              <?php 
              if (isset($player['email']) && $player['email'] != '')
              {
                echo $player['email']; 
              }
              else
              {
                echo "n/a";
              }
              ?>
            </td>
            <td class="playerlist_table_cell">
              <a href="http://<?php echo DOMAIN; ?>/session/impersonate/<?php echo $player['uid']; ?>"><img src="//<?php echo DOMAIN; ?>/img/person-icon.gif" border=0/></a>
              <?php /*
                if (!$player['admin'])
                {
                  echo "--";
                }
                else
                {
                  echo "Yes";
                }
               */ ?>
            </td>
            <td class="playerlist_table_cell">
              <?php echo $player['liability_waiver']; ?>
            </td>
            <td class="playerlist_table_cell">
              <?php 
                if (!$player['approved'])
                {
                  echo "No";
                }
                else
                {
                  echo "Yes";
                }
                
              ?>
            </td>
          </tr>
        <?php endforeach ?>
        
      <?php else: ?>
        <tr class="playerlist_table_row_noplayers">
          <td colspan="5" class="playerlist_table_cell table_cell_center">There are no accounts to display</td>
        </tr>
      <?php endif ?>
      
      <tr class="playerlist_table_row_headerfooter">
        <td class="playerlist_table_cell playerlist_table_cell_picture"></td>
        <td class="playerlist_table_cell playerlist_table_cell_name"></td>
        <td class="playerlist_table_cell playerlist_table_cell_email"></td>
        <td class="playerlist_table_cell playerlist_table_cell_admin"></td>
        <td class="playerlist_table_cell playerlist_table_cell_waiver"></td>
        <td class="playerlist_table_cell playerlist_table_cell_approved"></td>
      </tr>
      
    </table>
  </div>

  <div id="playerlist_footer">
    <div class="playerlist_pagination">
      <?php if (count($pageDisplay) > 0): ?>
        <?php foreach ($pageDisplay as $row): ?>
          <?php if ($row == $page): ?>
           <div class="playerlist_header_pagination_page accent_color">
            <?php echo $row; ?>
           </div>
          <?php else: ?>           
           <div class="playerlist_header_pagination_page">
            <a class="playerlist_header_pagination_page_link" href="http://<?php echo DOMAIN; ?>/admin/accounts/?p=<?php echo $row; if (isset($_GET['pageBy'])) echo "&pageBy={$_GET['pageBy']}"; if (isset($_GET['sortBy'])) echo "&sortBy={$_GET['sortBy']}"; if (isset($_GET['filterBy'])) echo "&filterBy={$_GET['filterBy']}";       ?>"><?php echo $row; ?></a>
           </div>
          <?php endif ?>
        <?php endforeach ?>
      <?php endif ?>
    </div>
    <div class="clearfix"></div>
  </div>

  <div class="clearfix"></div>

  <div class="admin_playerlist_manual_id">
    <a class="button" href="http://<?php echo DOMAIN; ?>/admin/accounts/clearcache/all">Clear User Cache Files</a>
  </div>
  
<?php endif ?>