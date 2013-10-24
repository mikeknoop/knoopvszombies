<?php
/**  
 * Facebook Wall Class
 * 
 * Handles all facebook wall related activities
 * 	
 * @access		public
 */
 
class Wall {

  /**
   * Returns recent posts by the Facebook Page as saved in cache
   * 
   * @return  mixed
   */
  function GetPostsByPage()
  {
      
    $cache_id = 'recent_posts';
    if ($cache = $GLOBALS['Cache']->GetFromCache($cache_id, $Seconds=0, $IsObject=true)) {
      return $cache;
    }
    
    return null;
    
  }
  
  /**
   * Reads recent posts off of a Facebook wall and saves them to cache
   * Ideally called via CRON
   * 
   * @return  array
   */
  function GenerateWallCache()
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
    
    $page_posts = array();
    $next_page = '';

    $GLOBALS['Cache']->RemoveFromCache('recent_posts_imp');
    $last_imp_time = 0;
    $now = date("U");
    $i = 0;

    // get hidden posts
    $hidden_posts = $this->GetHiddenPosts();
      
    while (!is_array($page_posts) || count($page_posts) < 3)
    {
    
      if ($next_page == '')
      {
        $graph_url = FB_PAGE_NAME.'/feed';
      }
      else
      {
        $graph_url = str_replace('https://graph.facebook.com/', '', $next_page);
        $graph_url = str_replace('http://graph.facebook.com/', '', $graph_url);
      }

      sleep(1);
      
      $raw = $GLOBALS['Facebook']->api($graph_url);
      $posts = $raw['data'];
      
      if (is_array($posts))
      {
      
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
                // this makes sure we're only storing the most recent #imp
                // and also makes sure it's within the last 2 days
                if (($last_imp_time < strtotime($post['created_time'])) && (strtotime($post['created_time']) >= ($now - (60*60*24*2))))
                {
                  $post['message'] = str_replace('#imp', '', $post['message']);
                  $GLOBALS['Cache']->WriteToCache('recent_posts_imp', $post);
                  $last_imp_time = strtotime($post['created_time']);
                }
              }
              
              $page_posts[$i] = $post;
              $i++;
            }
            
          }
          
        }
        
        if (!is_array($page_posts) || count($page_posts) < 3)
        {
          $next_page = $raw['paging']['next'];
        }
        
      }

    }
    
    $GLOBALS['Cache']->WriteToCache($cache_id, $page_posts);
    
  }
  
  /**
   * Parses posts array from API for type, message, time, id
   * 
   * @return  array
   */
  function ParsePosts($content)
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
   * Adds an fb_id for a facebook post to hidden_fb_posts table
   * 
   * @return  bool
   */
  function HidePost($fb_id)
  {
  
    // Save to DB
    $sql = "INSERT INTO hidden_fb_posts (fb_id) VALUES('$fb_id')";
    
    if (!$GLOBALS['Db']->Execute($sql))
    {
      throw new Exception('Error hiding post.');
    }
    $GLOBALS['Db']->Commit();  
    
    return true;
  
  }
  
  /**
   * Returns an array of fb_id for posts not to display/save
   * 
   * @return  array
   */
  function GetHiddenPosts()
  {
    $sql = "SELECT fb_id FROM hidden_fb_posts WHERE 1";
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
