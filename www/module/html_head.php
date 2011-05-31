  <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
  <meta name="author" content="<?php echo UNIVERSITY; ?> Humans vs. Zombies" />
  <meta name="keywords" content="<?php echo UNIVERSITY; ?> Humans vs. Zombies, HvZ, HVZ, Humans, Zombies, Humans vs. Zombies, Humans vs Zombies" />
  <meta name="description" content="MU Humans vs. Zombies" />
  <meta name="robots" content="all" />

  <title><?php echo UNIVERSITY; ?> Humans vs. Zombies</title>

  <link rel="icon" href="http://<?php echo DOMAIN; ?>/favicon.ico"/>
  <link href="http://<?php echo DOMAIN; ?>/css/reset.css" rel="stylesheet" type="text/css"/>
  <link href="http://<?php echo DOMAIN; ?>/css/general.css" rel="stylesheet" type="text/css"/>
  
  <?php
    require 'module/google_analytics.php';
  ?>
  
  <?php
  // If the user is logged in and impersonating a session, show the title bar
  if (isset($_SESSION) && isset($_SESSION['impersonate']) && $_SESSION['impersonate']):  
  ?>
  <a href="http://<?php echo DOMAIN; ?>/session/unimpersonate">
  <div class="impersonation_bar">
    You are logged in as <?php echo $_SESSION['true_identity']['name']; ?> and impersonating <?php echo $_SESSION['name']; ?>. To stop impersonation, click here.
  </div>
  </a>
  <?php endif; ?>