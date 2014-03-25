  <div id="admin_tool_title">
  Admin <span class="accent_color">Tools</span>
  </div><!-- signup_title -->
  
  <ol>
  
    <?php /* playerlist shown to all admins */ if (true): ?>
    <a class="admin_tool_link" href="http://<?php echo DOMAIN; ?>/admin/playerlist"><li <?php if (isset($_GET['view'])) { if ($_GET['view'] == 'playerlist') { echo "class=\"admin_tool_highlight\""; } } else { echo "class=\"admin_tool_highlight\""; } ?>>Edit Current Players</li></a>
    <?php endif ?>

    <?php if ($GLOBALS['Misc']->StringWithin('accounts', $_SESSION['privileges'])): ?>
    <a class="admin_tool_link" href="http://<?php echo DOMAIN; ?>/admin/accounts"><li <?php if (isset($_GET['view'])) { if ($_GET['view'] == 'accounts') { echo "class=\"admin_tool_highlight\""; } }?>>Edit User Accounts</li></a>
    <?php endif ?>
    
    <?php if ($GLOBALS['Misc']->StringWithin('userapproval', $_SESSION['privileges'])): ?>
    <a class="admin_tool_link" href="http://<?php echo DOMAIN; ?>/admin/userapproval"><li <?php if (isset($_GET['view'])) { if ($_GET['view'] == 'userapproval') { echo "class=\"admin_tool_highlight\""; } }?>>User Approval (<?php echo $users_to_approve_count ?>)</li></a>
    <?php endif ?>

    <?php if ($GLOBALS['Misc']->StringWithin('gameplay', $_SESSION['privileges'])): ?>
    <a class="admin_tool_link" href="http://<?php echo DOMAIN; ?>/admin/gameplay"><li <?php if (isset($_GET['view'])) { if ($_GET['view'] == 'gameplay') { echo "class=\"admin_tool_highlight\""; } }?>>Gameplay Progress</li></a>
    <?php endif ?>

    <?php if ($GLOBALS['Misc']->StringWithin('email', $_SESSION['privileges'])): ?>
    <a class="admin_tool_link" href="http://<?php echo DOMAIN; ?>/admin/email"><li <?php if (isset($_GET['view'])) { if ($_GET['view'] == 'email') { echo "class=\"admin_tool_highlight\""; } }?>>Send Email</li></a>
    <?php endif ?>

    <?php if ($GLOBALS['Misc']->StringWithin('htmlemail', $_SESSION['privileges'])): ?>
    <a class="admin_tool_link" href="http://<?php echo DOMAIN; ?>/admin/htmlemail"><li <?php if (isset($_GET['view'])) { if ($_GET['view'] == 'htmlemail') { echo "class=\"admin_tool_highlight\""; } }?>>Send Email(HTML)</li></a>
    <?php endif ?>

    <?php if ($GLOBALS['Misc']->StringWithin('game', $_SESSION['privileges'])): ?>
    <a class="admin_tool_link" href="http://<?php echo DOMAIN; ?>/admin/game"><li <?php if (isset($_GET['view'])) { if ($_GET['view'] == 'game') { echo "class=\"admin_tool_highlight\""; } }?>>Edit/Create Games</li></a>
    <?php endif ?>
    
  </ol>
  
