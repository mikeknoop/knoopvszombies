<?php

  $page_title = 'Toggle OZ Pool';
  $require_login = true;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';

	if ($GLOBALS['User']->IsPlayingCurrentGame($_SESSION['uid']) && $GLOBALS['state']) {
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'submit' && isset($_REQUEST['set_oz_pool'])) {
			// receiving request to toggle to the "in_oz_pool" value
			if ($_GET['set_oz_pool'] == 'true') {
				$GLOBALS['Game']->AddToOzPool($GLOBALS['state']['gid'], $_SESSION['uid']);
				} else {
				$GLOBALS['Game']->RemoveFromOzPool($GLOBALS['state']['gid'], $_SESSION['uid']);
			}
		} else {
			// Look up current state then redirect back to self to toggle new state
			$in_oz_pool = false;
			$oz_pool = $GLOBALS['Game']->GetOZPool($GLOBALS['state']['gid']);
			if (is_array($oz_pool)) {
				foreach ($oz_pool as $oz) {
					if ($oz['uid'] == $_SESSION['uid']) {
						$in_oz_pool = true;
					}
				}
			}
			if ($in_oz_pool) {
				header('Location: //'.DOMAIN.'/toggleozpool/submit/false');
				exit;
			} else {
				header('Location: //'.DOMAIN.'/toggleozpool/submit/true');
				exit;
			}
		}
	}

	header('Location: //'.DOMAIN.'/account');
	exit;
		
?>