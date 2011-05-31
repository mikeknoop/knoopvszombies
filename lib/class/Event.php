<?php
/**  
 * Facebook Event Class
 * 
 * Handles all facebook event related activities
 * 	
 * @access		public
 */
 
class Event {

  /**
   * Reads upcoming events off of a Facebook page and saves them to cache
   * Ideally called via CRON
   * 
   * @return  array
   */
  function GenerateEventCache()
  {
      
    $cache_id = 'recent_posts';

    if (!isset($GLOBALS['Facebook']))
    {
      $GLOBALS['Facebook'] = new Facebook(array(
      'appId'  => FB_APP_ID,
      'secret' => FB_SECRET,
      'cookie' => true,
      ));
    }
    
    $graph_url = FB_PAGE_NAME.'/feed';
    $posts = $GLOBALS['Facebook']->api($graph_url);
    $posts = $posts['data'];
    
    // get hidden posts
    $hidden_posts = $this->GetHiddenPosts();
    
    if (is_array($posts))
    {
      $i = 0;
      foreach ($posts as $post)
      {
        if ($post['from']['id'] == FB_PAGE_ID)
        {
        
          $is_hidden = false;
          
          foreach ($hidden_posts as $hidden_post)
          {
            if ($GLOBALS['Misc']->StringWithin($hidden_post['fb_id'], $post['id']))
            {
              $is_hidden = true;
            }
          }
          
          if (!$is_hidden)
          {
         
            // If the post container hashtag #imp, show it prominently on the homepage
            if (isset($post['message']) && $GLOBALS['Misc']->StringWithin('#imp', $post['message']))
            {
              $post['message'] = str_replace('#imp', '', $post['message']);
              $GLOBALS['Cache']->WriteToCache('recent_posts_imp', $post);
            }
            
            $page_posts[$i] = $post;
          
          }
          
        }
        $i++;
      }
    }
    
    $GLOBALS['Cache']->WriteToCache($cache_id, $page_posts);
  }
  
  /**
   * Parses posts array from API for type, message, time, id
   * 
   * @return  array
   */
  function ParseEvents($content)
  {
    if (is_array($content))
    {
      $i = 0;
      foreach($content as $post)
      {
        if (!isset($post['type']))
        {
          $post['type'] = '';
        }

        if (!isset($post['message']))
        {
          $post['message'] = '';
        }

        if (!isset($post['created_time']))
        {
          $post['created_time'] = date("U");
        }
        
        $return[$i]['type'] = $post['type'];
        $return[$i]['message'] = $post['message'];
        $return[$i]['time'] = strtotime($post['created_time']);
        
        // Id is in format [pageid]_[postid], we want to return only [postid]
        $return[$i]['id'] = str_replace(FB_PAGE_ID.'_', '', $post['id']);
        $i++;
      }
      return $return;
    }
    else
    {
      return null;
    }
  
  }

  /**
   * Adds an fb_id for a facebook event to hidden_fb_events table
   * 
   * @return  bool
   */
  function HideEvent($fb_id)
  {
  
    // Save to DB
    $sql = "INSERT INTO hidden_fb_events (fb_id) VALUES('$fb_id')";
    
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error hiding event.');
    }
    $GLOBALS['Db']->Commit();  
    
    return true;
  
  }
  
  /**
   * Returns an array of fb_id for posts not to display/save
   * 
   * @return  array
   */
  function GetHiddenEvents()
  {
    $sql = "SELECT fb_id FROM hidden_fb_events WHERE 1";
    $results = $GLOBALS['Db']->GetRecords($sql);
    
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
}
?>