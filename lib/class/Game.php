<?php
/**  
 * Game database class
 * 
 * Handles Game related methods
 * 	
 * @access		public
 */
 
class Game {

  /**
   * Returns state of the current game
   * 
   * @return  array
   */
  function GetState()
  {
      
    $cache_id = 'game_current_state';
    try
    {
      if ($cache = $GLOBALS['Cache']->GetFromCache($cache_id, $Seconds=(60*60*1), $IsObject=true)) {
        return $cache;
      }
    }
    catch (Exception $e)
    {
      // cache file was empty (0 bytes)
        return null;
    }
    
    $sql = "SELECT * FROM game WHERE current='1'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    $return = null;
    if (is_array($results) && count($results) > 0)
    {
      $return = $results[0];
    }
    else
    {
      $return = array();
    }

    $GLOBALS['Cache']->WriteToCache($cache_id, $return);
    return $return;
    
  }

    /**
   * Returns array of all joinable games (not archived)
   * 
   * @return  array
   */
  function GetJoinable()
  {
    $cache_id = 'games_joinable';
    try
    {
      if ($cache = $GLOBALS['Cache']->GetFromCache($cache_id, $Seconds=(60*60*1), $IsObject=true)) {
        return $cache;
      }
    }
    catch (Exception $e)
    {
      // cache file was empty (0 bytes)
        return null;
    }
    
    $sql = "SELECT * FROM game WHERE NOT archive='1'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    $return = null;
    if (is_array($results))
    {
      $return = $results;
    }

    $GLOBALS['Cache']->WriteToCache($cache_id, $return);
    return $return;
  }
  
    /**
   * Returns number of players for a given gid
   * 
   * @return  array
   */
  function GetPlayerCount($gid)
  {
    $cache_id = 'game_'.$gid.'_playercount';
    try
    {
      if ($cache = $GLOBALS['Cache']->GetFromCache($cache_id, $Seconds=(60*60*1), $IsObject=false)) {
        return $cache;
      }
    }
    catch (Exception $e)
    {
      // cache file was empty (0 bytes)
    }
    
    $sql = "SELECT count(uid) FROM game_xref WHERE gid='$gid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    $return = null;
    if (is_array($results))
    {
      $return = $results[0]['count(uid)'];
    }
    $GLOBALS['Cache']->WriteToCache($cache_id, $return);
    return $return;
  }
  
  /**
   * Returns all database cols of a given gid
   * 
   * @return  array
   */
  function GetGame($gid=null, $all=false)
  {
    if (!$gid && !$all)
    {
      return null;
    }
    
    if (!$all)
    {  
      $gid = addslashes($gid);
      $cache_id = 'game_'.$gid;
      $where_sql = 'gid='.$gid;
    }
    else
    {
      $cache_id = 'games_all';
      $where_sql = '1';
    }
    
    try
    {
      if ($cache = $GLOBALS['Cache']->GetFromCache($cache_id, $Seconds=(60*60*1), $IsObject=true)) {
        return $cache;
      }
    }
    catch (Exception $e)
    {
      // cache file was empty (0 bytes)
        return null;
    }
    
    $sql = "SELECT * FROM game WHERE $where_sql";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    $return = null;
    if (is_array($results) && count($results) > 0 && !$all)
    {
      $return = $results[0];
    }
    elseif (is_array($results) && count($results) > 0 && $all)
    {
      $return = $results;
    }
    else
    {
      return $return;
    }

    $GLOBALS['Cache']->WriteToCache($cache_id, $return);
    return $return;
    
  }
  
  
  /**
  *
  * Generates a secret word to be used as the players ID card
  *
  *
  */
  function GenerateSecret($gid)
  {
    $words = file(DOCUMENT_ROOT.'/lib/wordlist.txt');
    
    $word1 = trim($words[(rand(0, count($words)))]);
    $word2 = trim($words[(rand(0, count($words)))]);
    $int1 = rand(1000,9999);
    
    $secret = ucfirst($word1).ucfirst($word2).$int1;
    
    $sql = "SELECT * FROM game_xref WHERE secret='$secret' AND gid='$gid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    $return = null;
    if (is_array($results) && count($results) > 0)
    {
      // already exists, get another
      return $this->GenerateSecret($gid);
    }
    else
    {
      return $secret;
    }
    
  }
  
  /**
  *
  * Gets the secret ID of a player
  *
  */
  function GetSecret($gid, $uid)
  {
    $sql = "SELECT secret FROM game_xref WHERE gid='$gid' AND uid='$uid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      $secret = $results[0]['secret'];
    }
    else
    {
      // secret doesn't exist
      return false;
    }
    
    return $secret;
  }
  
  /**
  * 
  * For a given game, sees if there is player with given secret. If checkIsHuman, 
  * only return valid if the player is a human and can be "killed"
  *
  */
  function CheckSecretValid($gid, $secret, $checkIsHuman=false)
  {
    $secret = strtolower(trim(addslashes($secret)));
    
    $sql = "SELECT game_xref.uid, game_xref.status, game_xref.zombied_time, user.name FROM game_xref LEFT JOIN user ON game_xref.uid = user.uid WHERE secret='$secret' AND gid='$gid'";
    
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    if (is_array($results) && count($results) > 0)
    {
      // Row exists
      if ($results[0]['status'] == 'human')
      {
        // Everything is good
        $return[0] = true;
        $return[1] = 'Success. You have just turned '.$results[0]['name'].' into a zombie! Your kill count has also been increased by one.';
      }
      else
      {
        if ($results[0]['zombied_time'] != '')
        {
        // Row exists, which means user is likely trying to enter an ID of a person more than 3 hours later. But it could be the owner of the ID is giving out their old ID
        $date = date("l M j, g:iA", $results[0]['zombied_time']);
        $return[0] = false;
        $return[1] = 'The secret game ID belongs to '.$results[0]['name'].' but they have already been turned into a zombie (or deceased) on '.$date.'. If you think is in error, <a class="accent_color" href="mailto:'.EMAIL.'">contact a moderator</a> and send them the secret game ID.';
        }
        else
        {
        // Row exists but the user has no zombied_time! They were likely automatically shifted around by a mod or the automated orientation attendance deceased function
        $return[0] = false;
        $return[1] = 'The secret game ID belongs to '.$results[0]['name'].' but they have already been turned into a zombie (or deceased). If you think is in error, <a class="accent_color" href="mailto:'.EMAIL.'">contact a moderator</a> and send them the secret game ID.';
        }
      }
      
    }
    else
    {
      // ID wasnt matched. Lets see if it matches old_secret (secret gets appended to old_Secret when a player receives a new game ID)
      $sql = "SELECT game_xref.uid, game_xref.status, game_xref.zombied_time, user.name FROM game_xref LEFT JOIN user ON game_xref.uid = user.uid WHERE old_secret LIKE '%$secret%' AND gid='$gid'";
      
      $results = $GLOBALS['Db']->GetRecords($sql);
      
      if (is_array($results) && count($results) > 0)
      {
        if ($results[0]['status'] != 'human')
        {
          // Row exists, but the user the ID belongs to is already a zombie.
          $date = date("l M j, g:iA", $results[0]['zombied_time']);
          $return[0] = false;
          $return[1] = 'The secret game ID belonged to '.$results[0]['name'].' but they have already been turned into a zombie on '.$date.'. A moderator has been notified.';
        }
        else
        {
          // Row exists, which means user is likely trying to enter an ID of a person more than 3 hours later. But it could be the owner of the ID is giving out their old ID
          $return[0] = false;
          $return[1] = 'The secret game ID belonged to '.$results[0]['name'].' but they received a new secret from the moderators. Your tag has not been counted and '.$results[0]['name'].' is still human. This is likely due to you taking too long to enter the secret game ID. Remember, all tags must be reported within 3 hours. If you think is in error, <a class="accent_color" href="mailto:'.EMAIL.'">contact a moderator</a> and send them the secret game ID.';
        }
      }
      else
      {
      $return[0] = false;
      $return[1] = 'The secret game ID "'.$secret.'" does not belong to any player this game. If you believe this is in error, <a class="accent_color" href="mailto:'.EMAIL.'">contact a moderator</a> and send them the secret game ID.';
      }
    }
    
    return $return;
  }
  
  
  /**
  *
  * Opts a player out of the OZ pool for a given game
  *
  */
  function RemoveFromOzPool($gid, $uid)
  {
    // First check to see if user already joined this game
    $joined = false;
    $xref = $GLOBALS['User']->GetUserFromGame($uid, $gid);

    if (isset($xref['gid']) && $xref['gid'] == $gid)
    {
      $joined = true;
    }

    if (!$joined)
    {
      return false;
    }
    
    $sql = "UPDATE game_xref SET oz_pool='0' WHERE gid='$gid' AND uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();

    $cache_id = $uid.'_game';
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);

    return true;
  }

  /**
  *
  * Opts a player in to the OZ pool for a given game
  *
  */
  function AddToOzPool($gid, $uid)
  {
    // First check to see if user already joined this game
    $joined = false;
    $xref = $GLOBALS['User']->GetUserFromGame($uid, $gid);

    if (isset($xref['gid']) && $xref['gid'] == $gid)
    {
      $joined = true;
    }

    if (!$joined)
    {
      return false;
    }
    
    $sql = "UPDATE game_xref SET oz_pool='1' WHERE gid='$gid' AND uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();

    $cache_id = $uid.'_game';
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);

    return true;
  }
  
  /**
  *
  * Removes a player from a game
  *
  */
  function RemoveFromGame($gid, $uid)
  {
  
    $sql = "SELECT uid FROM game_xref WHERE uid='$uid' AND gid='$gid'";
    
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    if (is_array($results) && count($results) > 0)
    {
    }
    else
    {
      return false;
    }
      
    $sql = "DELETE FROM game_xref WHERE gid='$gid' AND uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();

    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid);
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid.'_playercount');
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid.'_playercount_brokendown');
    $GLOBALS['Cache']->RemoveFromCache('game_current_state');

    return true;
  }
  
  /**
  *
  * Returns broken down player count (human/zombie/deceased) for a given gid
  *
  */
  function GetBrokenDownPlayerCount($gid)
  {
    $cache_id = 'game_'.$gid.'_playercount_brokendown';
    try
    {
      if ($cache = $GLOBALS['Cache']->GetFromCache($cache_id, $Seconds=(60*60*1), $IsObject=true)) {
        return $cache;
      }
    }
    catch (Exception $e)
    {
      // cache file was empty (0 bytes)
    }

    $return = null;
    $game = $this->GetGame($gid);
    $oz_hidden = $game['oz_hidden'];
    
    $sql = "SELECT count(uid) FROM game_xref WHERE (status='human' OR (status='zombie' AND oz='1' AND $oz_hidden)) AND gid='$gid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results))
    {
      $return['humans'] = $results[0]['count(uid)'];
    }
    else
    {
      $return['humans'] = 0;
    }

    $sql = "SELECT count(uid) FROM game_xref WHERE (status='zombie' AND (oz='0' OR NOT $oz_hidden)) AND gid='$gid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results))
    {
      $return['zombies'] = $results[0]['count(uid)'];
    }
    else
    {
      $return['zombies'] = 0;
    }
    
    $sql = "SELECT count(uid) FROM game_xref WHERE status='deceased' AND gid='$gid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results))
    {
      $return['deceased'] = $results[0]['count(uid)'];
    }
    else
    {
      $return['deceased'] = 0;
    }
    
    $GLOBALS['Cache']->WriteToCache($cache_id, $return);
    return $return;
  }
  
  /*
  * Gets an array of player data paged and for the given gid
  *
  *
  */
  function GetPlayers($gid, $pageBy=null, $page=null, $sortBy=null, $filterBy=null, $admin=false)
  {
    if (!$pageBy)
      $pageBy = 20;
    
    if (!$page)
      $page = 1;
      
    if (!$sortBy)
      $sortBy = 'name';
    
    if (!$filterBy)
      $filterBy = 'all';
    
    $pageBy = addslashes($pageBy);
    $page = addslashes($page);
    $sortBy = addslashes($sortBy);
    $filterBy = addslashes($filterBy);

    $limitSql = '';
    switch ($pageBy)
    {
      case "all":
        break;
      
      default:
        //$upperLimit = ($page * $pageBy) - 1;
        $lowerLimit = ($page * $pageBy) - $pageBy;
        $limitSql = "LIMIT $lowerLimit, $pageBy";
        break;
    }
    
    $sortSql = '';
    
    switch ($sortBy)
    {      
      case "kills":
        $filterBy = 'zombies';
        $sortSql = "ORDER BY gx.zombie_kills DESC";
        break;
        
      case "starve_time":
        $filterBy = 'zombies';
        $sortSql = "ORDER BY gx.zombie_feed_timer ASC";
        break;
      
      case "squad":
        $filterBy = 'in_squad';
        $sortSql = "ORDER BY u.squad_name ASC";
        break;
        
      case "name":
      default:
        $sortSql = "ORDER BY u.name ASC";
        break;
    }

    $filterSql = '';
    switch ($filterBy)
    {      
      case "humans":
        if ($GLOBALS['state'] && $GLOBALS['state']['oz_hidden'] && !$admin)
        {
          $filterSql = "AND (status='human' OR (status='zombie' AND oz='1'))";
        }
        else
        {
          $filterSql = "AND status='human'";
        }
        break;
     
      case "zombies":
        if ($GLOBALS['state'] && $GLOBALS['state']['oz_hidden'] && !$admin)
        {
          $filterSql = "AND status='zombie' and oz='0'";
        }
        else
        {
          $filterSql = "AND status='zombie'";
        }      
        break;
      
      case "deceased":
        $filterSql = "AND status='deceased'";
        break;

      case "notattendedorientation":
        $filterSql = "AND attended_orientation='0'";
        break;
        
      case "in_squad":
        $filterSql = "AND NOT u.squad_name=''";
        break;
        
      case "all":
      default:
        $filterSql = '';
        break;
    }
    
    $sql = "SELECT 
              gx.uid, 
              gx.secret,
              gx.status,
              gx.oz, 
              gx.oz_pool, 
              gx.zombie_kills, 
              gx.zombied_time, 
              gx.zombie_feed_timer,
              u.name, 
              u.email,
              u.fb_id, 
              u.using_fb,
              u.squad_name
            FROM game_xref gx LEFT JOIN user u ON gx.uid = u.uid
            WHERE gid='$gid'
            $filterSql
            $sortSql
            $limitSql;";
            
            
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      return $results;
    }
    else
    {
      return null;
    }
    
  }
  
  /**
  *
  * Registers a zombie as having killed a target by given secret. Also feeds feed1 and feed2
  *
  *
  */
  function RegisterKill($gid, $zombie_uid, $targetSecret, $feed1=null, $feed2=null, $location_x=null, $location_y=null)
  {
    $zombie_uid = addslashes($zombie_uid);
    $targetSecret = strtolower(trim(addslashes($targetSecret)));
    $feed1 = addslashes($feed1);
    $feed2 = addslashes($feed2);
    $location_x = addslashes($location_x);
    $location_y = addslashes($location_y);
    
    $time = date("U");
  
    // First, update game_xref for target
    // Need to get the UID of the target
    $sql = "SELECT uid FROM game_xref WHERE secret='$targetSecret'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0)
    {
      $target_uid = $results[0]['uid'];
      $target_user = $GLOBALS['User']->GetUser($target_uid);
    }
    else
    {
      return false;
    }
    
    // update status, zombied_time, zombie_feed_timer, zombie_killed_by
    $sql = "UPDATE game_xref SET status='zombie', zombied_time='$time', zombie_feed_timer='$time', zombie_killed_by='$zombie_uid', zombied_where_x='$location_x', zombied_where_y='$location_y' WHERE gid='$gid' AND uid='$target_uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    // Now update zombie
    // update zombie_kills, zombie_feed_timer
    $sql = "UPDATE game_xref SET zombie_kills=zombie_kills+1, zombie_feed_timer='$time' WHERE gid='$gid' AND uid='$zombie_uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    // Check that feed1 is a player
    if ($GLOBALS['User']->IsValidUser($feed1))
    {
      // Now mark them as fed
      $sql = "UPDATE game_xref SET zombie_feed_timer='$time' WHERE gid='$gid' AND uid='$feed1'";
      if (!$GLOBALS['Db']->Execute($sql))
      {
        return false;
      }
      $GLOBALS['Db']->Commit();
    }
    
    // Check that feed2 is a player
    if ($GLOBALS['User']->IsValidUser($feed2))
    {
      // Now mark them as fed
      $sql = "UPDATE game_xref SET zombie_feed_timer='$time' WHERE gid='$gid' AND uid='$feed2'";
      if (!$GLOBALS['Db']->Execute($sql))
      {
        return false;
      }
      $GLOBALS['Db']->Commit();
    }

    // Send an email to the person turned into a zombie
    $to = $target_user['email'];
    $subject = "".UNIVERSITY." HvZ You are now a Zombie!";
    $body = "Hello,\n\rYou were just turned into a Zombie on the ".UNIVERSITY." HvZ website (Someone entered your Secret Game ID)! You can now start tagging humans and reporting their Secret Game IDs on the website as well. Don't forget to wear you bandanna around your head.\n\r";

    $GLOBALS['Mail']->SimpleMail($to, $subject, $body);
    
    // Set the person who got turned into a zombie as a zombie role on forum
    $GLOBALS['User']->AddForumRoleZombie($target_uid);
    
    // Twitter integration
    $sql = "SELECT name FROM user WHERE uid='{$target_uid}'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0) {
      $human = $results[0]['name'];
    }
    $sql = "SELECT name FROM user WHERE uid='{$zombie_uid}'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (is_array($results) && count($results) > 0) {
      $zombie = $results[0]['name'];
    }
    
    if (isset($GLOBALS['state']['oz_hidden']) && $GLOBALS['state']['oz_hidden']) {
			// OZs hidden
			$sql = "SELECT oz FROM game_xref WHERE uid='$zombie_uid' AND gid='$gid'";
			$results = $GLOBALS['Db']->GetRecords($sql);
			if (is_array($results) && count($results) > 0) {
				$oz = $results[0]['oz'];
      }
      if ($oz) {
				$GLOBALS['Twitter']->send("{$human} has been infected by an OZ.");
			} else {
				$GLOBALS['Twitter']->send("{$human} has been infected by {$zombie}");
			}
    } else {
			// OZs not hidden
			$GLOBALS['Twitter']->send("{$human} has been infected by {$zombie}");    
    }
    
    // Clear caches
    $cache_id = $target_uid.'_game';
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    $cache_id = $zombie_uid.'_game';
    $GLOBALS['UserCache']->RemoveFromCache($cache_id);
    $cache_id = 'game_'.$gid.'_playercount';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
    $cache_id = 'game_'.$gid.'_playercount_brokendown';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
    
    // Check the user counts. If there are no humans left, pause the countdown and set end_time
    $sql = "SELECT uid FROM game_xref WHERE gid='$gid' && status='human'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (!is_array($results))
    {
      // some sort of error with the db call
      return true;
    }
    
    if (count($results) > 0)
    {
      // there is still a human left
      return true;
    }
    else
    {

      // no humans left, pause the countdown
      $sql = "UPDATE game SET countdown_paused='1' WHERE gid='$gid'";
      if (!$GLOBALS['Db']->Execute($sql))
      {
        return false;
      }
      $GLOBALS['Db']->Commit();
    }
    
  }
  
  /**
  * Returns an array of orientation sessions for a given gid
  *
  */
  function GetOrientations($gid)
  {
  
    $cache_id = 'game_'.$gid.'_orientations';
    try
    {
      if ($cache = $GLOBALS['Cache']->GetFromCache($cache_id, $Seconds=(60*60*1), $IsObject=true)) {
        return $cache;
      }
    }
    catch (Exception $e)
    {
    }
    
    $sql = "SELECT oid, gid, location, time FROM orientations WHERE gid='$gid' ORDER BY time ASC";
    $results = $GLOBALS['Db']->GetRecords($sql);
    if (!is_array($results))
    {
      return false;
    }
    
    $GLOBALS['Cache']->WriteToCache($cache_id, $results);
    return $results;
  }
  
  /*
  * Add an orientation to the db
  *
  */
  function AddOrientation($gid, $location, $time)
  {
    $location = addslashes($location);
    $time = addslashes($time);

    $sql = "INSERT INTO orientations (gid, location, time) VALUES('$gid', '$location', '$time')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    $cache_id = 'game_'.$gid.'_orientations';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
  }

  /*
  * bs an orientation from the db
  *
  */
  function RemoveOrientation($oid)
  {
    $sql = "SELECT gid FROM orientations WHERE oid='$oid'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    $return = null;
    if (is_array($results) && count($results) > 0)
    {
      $gid = $results[0]['gid'];
    }
    else
    {
      return false;
    }
    
    $sql = "DELETE FROM orientations WHERE oid='$oid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    $cache_id = 'game_'.$gid.'_orientations';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
    
    return $gid;
  }


  /*
  * Sets the given $field to the given $bool state
  *
  * @return bool
  */
  function UpdateGameColumn($gid, $field, $value)
  {
    
    $value = addslashes($value);
    
    // try to update the DB
    $sql = "UPDATE game SET $field='$value' WHERE gid='$gid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
  
    // clear game cache
    $GLOBALS['Cache']->RemoveFromCache('games_all');
    $GLOBALS['Cache']->RemoveFromCache('game_joinable');
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid);
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid.'_orientations');
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid.'_playercount');
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid.'_playercount_brokendown');
    $GLOBALS['Cache']->RemoveFromCache('game_current_state');
    return true;
  }

  /**
   * Returns all database cols for games
   * 
   * @return  array
   */
  function GetAllGames()
  {

    $sql = "SELECT * FROM game WHERE 1";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    $return = null;
    if (is_array($results) && count($results) > 0)
    {
      $return = $results;
    }
    else
    {
      return $return;
    }

    return $return;
    
  }

  /**
   * Returns all player game_xref rows for OZs
   * 
   * @return  array
   */
  function GetOZs($gid)
  {

    $sql = "SELECT 
              gx.uid,
              u.name, 
              u.email,
              u.fb_id, 
              u.using_fb
            FROM game_xref gx LEFT JOIN user u ON gx.uid = u.uid
            WHERE gid='$gid' AND oz='1'";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    $return = null;
    if (is_array($results) && count($results) > 0)
    {
      $return = $results;
    }
    else
    {
      $return = array();
    }

    return $return;
    
  }

  /**
   * Returns all player game_xref rows for people in the OZ Pool for a given game
   * 
   * @return  array
   */
  function GetOZPool($gid)
  {

    $sql = "SELECT 
              gx.uid,
              u.name
            FROM game_xref gx LEFT JOIN user u ON gx.uid = u.uid
            WHERE gid='$gid' AND oz_pool='1' AND NOT oz='1'
            ORDER BY u.name ASC";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    $return = null;
    if (is_array($results) && count($results) > 0)
    {
      $return = $results;
    }
    else
    {
      $return = array();
    }

    return $return;
    
  }
  
  /**
  *
  *  Clears all game chache files (game*)
  *
  */
  function ClearAllGameCache()
  {
   // Clear pattern * (all) from /cache/user/ dir
   $path = $GLOBALS['Cache']->_CacheDirPath;
   $match = 'game*';
   static $deld = 0, $dsize = 0;
   $dirs = glob($path."*");
   $files = glob($path.$match);
   foreach($files as $file)
   {
    if(is_file($file))
    {
       $dsize += filesize($file);
       unlink($file);
       $deld++;
    }
   }

   return true;

  }
  
  /*
  * Creates a blank game and returns the new ID
  *
  */
  function CreateNew()
  {

    $now = date("U");
    
    $sql = "INSERT INTO game (current, active, countdown, countdown_paused, oz_hidden, archive, created) VALUES('0','0','1','0','1','0', '$now')";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();

    $sql = "SELECT gid FROM game WHERE 1 ORDER BY gid DESC";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
    $return = null;
    if (is_array($results) && count($results) > 0)
    {
      $gid = $results[0]['gid'];
    }
    else
    {
      return $gid;
    }
  }

  /*
  * Deletes a game by gid
  *
  */
  function DeleteGame($gid)
  {
    
    $sql = "DELETE FROM game WHERE gid='$gid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();

    $GLOBALS['Cache']->RemoveFromCache('games_all');
    $cache_id = 'game_'.$gid;
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
    $cache_id = 'game_'.$gid.'_orientations';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
    $cache_id = 'game_'.$gid.'_playercount';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
    $cache_id = 'game_'.$gid.'_playercount_brokendown';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
    $cache_id = 'game_current_state';
    $GLOBALS['Cache']->RemoveFromCache($cache_id);
  }
  
  /*
  * Removes a UID from the OZ group for a given GID
  *
  */
  function RemoveOZ($gid, $uid)
  {
    $uid = addslashes($uid);

    $sql = "UPDATE game_xref SET oz='0', status='human', zombied_time='0', zombie_feed_timer='0' WHERE gid='$gid' AND uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();

    $GLOBALS['UserCache']->RemoveFromCache($uid);
    $GLOBALS['UserCache']->RemoveFromCache($uid.'_game');
    $GLOBALS['UserCache']->RemoveFromCache($uid.'_gameAll');
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid.'_playercount');
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid.'_playercount_brokendown');
    
    return true;    
  }

  /*
  * Adds a UID from the OZ group for a given GID
  *
  */
  function AddOZ($gid, $uid)
  {
    $uid = addslashes($uid);
    
    // If the game has started, mark the timers as $now, otherwise mark timers as game start time
    $now = date("U");
    
    $game = $this->GetGame($gid);
    if ($game['active'])
    {
      $timer = $now;
    }
    else
    {
      $timer = $game['start_time'];
    }    

    $sql = "UPDATE game_xref SET oz='1', status='zombie', zombied_time='$timer', zombie_feed_timer='$timer' WHERE gid='$gid' AND uid='$uid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();
    
    
    $GLOBALS['UserCache']->RemoveFromCache($uid);
    $GLOBALS['UserCache']->RemoveFromCache($uid.'_game');
    $GLOBALS['UserCache']->RemoveFromCache($uid.'_gameAll');
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid.'_playercount');
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid.'_playercount_brokendown');
    
    return true;    
  }
  
  /*
  * Changes the registration_open field for a given GID
  *
  */
  function ChangeRegStatus($gid, $newStatus)
  {
    if ($newStatus == 'open')
    {
      $registration_open = '1';
    }

    if ($newStatus == 'closed')
    {
      $registration_open = '0';
    }

    $sql = "UPDATE game SET registration_open='$registration_open' WHERE gid='$gid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();

    $GLOBALS['Cache']->RemoveFromCache('games_all');
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid);
    $GLOBALS['Cache']->RemoveFromCache('game_current_state');
    $GLOBALS['Cache']->RemoveFromCache('games_joinable');
    
    return true;   
    
  }

  /*
  * Changes OZ Visibility for a given GID to shown or hidden
  *
  */
  function ChangeOZVisibility($gid, $newVisibility)
  {
    $ozs = $this->GetOZs($gid);
    
    if ($newVisibility == 'hidden')
    {
      $oz_hidden = '1';
      
      // Need to accurately update the OZs forum visibilities
      foreach ($ozs as $oz)
      {
        $GLOBALS['User']->RemoveStatusForumRoll($oz['uid']);
        $GLOBALS['User']->AddForumRoleHuman($oz['uid']);
      }
    }

    if ($newVisibility == 'revealed')
    {
      $oz_hidden = '0';

      // Need to accurately update the OZs forum visibilities
      foreach ($ozs as $oz)
      {
        $GLOBALS['User']->RemoveStatusForumRoll($oz['uid']);
        $GLOBALS['User']->AddForumRoleZombie($oz['uid']);
      }
    }

    $sql = "UPDATE game SET oz_hidden='$oz_hidden' WHERE gid='$gid'";
    if (!$GLOBALS['Db']->Execute($sql))
    {
      return false;
    }
    $GLOBALS['Db']->Commit();

    $GLOBALS['Cache']->RemoveFromCache('games_all');
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid);
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid.'_playercount_brokendown');
    $GLOBALS['Cache']->RemoveFromCache('game_current_state');
    $GLOBALS['Cache']->RemoveFromCache('games_joinable');
    
    return true;   
    
  }
  
  /*
  *  Check to see if any games need to be marked active (now > start_time)
  *       => If so, mark database column as active
  *       => Email all original zombies that they were chosen
  *
  *
  */
  function CheckStartGame()
  {
    $now = date("U");
    $gameArray = $this->GetGame(null, true);
    
    if (is_array($gameArray))
    {
      foreach ($gameArray as $game)
      {
      
        // If a game isnt the current game but has a start_time passed, reset it back to 0 so it doesn't cause issues if it gets marked current. Only do this is the game is not archives
        if (!$game['current'] && ($now > $game['start_time']) && !$game['archive'])
        {
          // mark start_time as 0
          $this->UpdateGameColumn($game['gid'], 'start_time', '0');

          $GLOBALS['Cache']->RemoveFromCache('games_all');
          $GLOBALS['Cache']->RemoveFromCache('game_'.$game['gid']);
          $GLOBALS['Cache']->RemoveFromCache('game_current_state');
          $GLOBALS['Cache']->RemoveFromCache('games_joinable');
    
        }
        
        if ($game['current'] && !$game['active'] && !$game['archive'] && ($now >= $game['start_time']) && $game['start_time'] != 0)
        {
        
          // First mark all people who did not attend an orientation as deceased
          $GLOBALS['User']->DidNotAttendOrientation();
        
          // Get all the OZs for this game
          $ozArray = $this->GetOZs($game['gid']);
          if (is_array($ozArray))
          {
            $to = '';
            foreach ($ozArray as $oz)
            {
              $to .= $oz['email'].',';
            }
          }
          
          // Now send them an email
          $subject = "".UNIVERSITY." HvZ You Are An Original Zombie!";
          $body = "Hello,\n\rYou were randomly chosen to be an Original Zombie for the {$game['name']} game! This means that you start off as a zombie and can immediately begin tagging humans.\n\rRemember, Original Zombies DO NOT have to wear their bandanna on their head for the first 24 hours of the game. You may disguise yourself as a human!\n\rGood luck hunting! If there is a problem and you cannot be an Original Zombie, please contact the moderators immediately via the HvZ Mizzou Help Line (573.833.0385)\n\r";
   
          $attachFooter = true;
          $bcc = true;
          $GLOBALS['Mail']->SimpleMail($to, $subject, $body, $attachFooter, $bcc);
          
          
          // Now we need to email everyone that the game has officially begun
          $allPlayers = $this->GetPlayers($game['gid'], 'all', null, null, null);
          if (is_array($allPlayers))
          {
            $to = '';
            foreach ($allPlayers as $player)
            {
              $to .= $player['email'].',';
            }
          }
          
          // Now send them an email
          $subject = "".UNIVERSITY." HvZ {$game['name']} Has Officially Begun!";
          $body = "Hello,\n\rThis email is to inform you that the Humans vs. Zombies {$game['name']} has officially begun! Remember you must carry your Secret Game ID and bandanna with you at all times.\n\rYou have received a seperate email if you are an Original Zombie -- If you have not received it then you are a human.\n\rGood luck! If you have any questions or concerns please contact a moderator.\n\r";
             
          $GLOBALS['Mail']->SimpleMail($to, $subject, $body, true, false);
          
          // mark game active
          $this->UpdateGameColumn($game['gid'], 'active', '1');
          
        }
        

      }
    }
    

  }

  /*
  *  Check to see if any zombies of the current game need to be deceased (now > zombie_feed_timer +
  *  ZOMBIE_MAX_FEED_TIMER)
  *       => If so, mark that zombie as decease. Send an email
  *
  *
  */
  function CheckFeedTimers()
  {
    $now = date("U");

    // Get all the zombies of the current game and check their zombie_feed_timers
    $allZombies = $this->GetPlayers($GLOBALS['state']['gid'], 'all', null, null, 'zombies');
    
    if (is_array($allZombies))
    {
      $to = '';
      foreach ($allZombies as $zombie)
      {
      
        if ($now > ($zombie['zombie_feed_timer'] + ZOMBIE_MAX_FEED_TIMER))
        {
          // Zombie has starved, mark them as starved in the database, deceased them, send an email
          $GLOBALS['User']->UpdateUserGameColumn($GLOBALS['state']['gid'], $zombie['uid'], 'status', 'deceased');
          $GLOBALS['User']->UpdateUserGameColumn($GLOBALS['state']['gid'], $zombie['uid'], 'zombie_feed_timer', '0');

          $GLOBALS['UserCache']->RemoveFromCache($zombie['uid']);
          $GLOBALS['UserCache']->RemoveFromCache($zombie['uid'].'_game');
          $GLOBALS['UserCache']->RemoveFromCache($zombie['uid'].'_gameAll');
          
          $to .= $zombie['email'].',';
          
          // Mark them as not a zombie or human role on forums
          $GLOBALS['User']->RemoveStatusForumRoll($zombie['uid']);
        }
      
      }
    }
    
    if ($to != '')
    {
      // Now send them an email
      $subject = "".UNIVERSITY." HvZ You Have Starved!";
      $body = "Hello,\n\rBecause you have not fed on a human for 48 hours, you have starved! This means you are no longer a zombie and cannot register kills on the website. Thank you for playing! We hope you'll play again next semester.\n\r";
         
      $GLOBALS['Mail']->SimpleMail($to, $subject, $body);
    }

  }
  
  /*
  *   Marks certain columns to end the game in the game table
  *
  */
  function EndGame($gid)
  {
    $now = date("U");
    $this->UpdateGameColumn($gid, 'end_time', $now);
    $this->UpdateGameColumn($gid, 'active', '0');
    $this->UpdateGameColumn($gid, 'countdown_paused', '1');
    $this->UpdateGameColumn($gid, 'oz_hidden', '0');
    $this->UpdateGameColumn($gid, 'archive', '1');
    
    $GLOBALS['Cache']->RemoveFromCache('games_all');
    $GLOBALS['Cache']->RemoveFromCache('game_'.$gid);
    $GLOBALS['Cache']->RemoveFromCache('game_current_state');
    $GLOBALS['Cache']->RemoveFromCache('games_joinable');
    
    return true;
  }
  
  /*
  * Takes all the player kill counts and times alive for a given ID and updates historical table with new info
  *
  */
  function ArchivePlayerData($gid)
  {
    // First task, get all the players for current game
    $allPlayers = $this->GetPlayers($gid, 'all');
    
    // Grab the info about the game we're looking at
    $game = $this->GetGame($gid);
    
    
    if (is_array($allPlayers))
    {
      foreach ($allPlayers as $player)
      {
        // for each player, we need to calculate their time alive as a human in seconds and their total zombie kills
        $total_zombie_kills = $player['zombie_kills'];
        
        if ($player['zombied_time'] == 0 || $player['zombied_time'] == '')
        {
          // Indicates player was never turned into a zombie
          $player['zombied_time'] = $game['end_time'];
        }
        
        $total_seconds_alive = $player['zombied_time'] - $game['start_time'];
        
        if ($total_seconds_alive <= 0)
        {
          $total_seconds_alive = 0;
        }
        
        // Now that we have $total_zombie_kills and $total_seconds_alive, add these values to historical for this user
        
        $sql = "UPDATE historical SET zombie_kills=zombie_kills+'$total_zombie_kills', time_alive=time_alive+'$total_seconds_alive' WHERE uid='{$player['uid']}'";
        if ($GLOBALS['Db']->Execute($sql))
        {
					$GLOBALS['Db']->Commit();
        }
        
        // Everything is updated, remove one cache file
        $GLOBALS['UserCache']->RemoveFromCache($player['uid'].'_historical');
        
        // Update the game_Xref row to indicate those stats have been archived
        $GLOBALS['User']->UpdateUserGameColumn($gid, $player['uid'], 'archived', '1');
        
        // Finally remove them from the forums
        $GLOBALS['User']->RemoveStatusForumRoll($player['uid']);
        
        // Done with one player!
        
      }
    }

  }
  
}
  
?>