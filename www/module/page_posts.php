<div id="page_posts_title">
Recent <span class="accent_color">Updates</span>
</div>

<?php
  $page_posts = $GLOBALS['Wall']->GetPostsByPage();
  $wall = $GLOBALS['Wall']->ParsePosts($page_posts);
  
  if (is_array($wall))
  {
    $i = 0;
    $max = 3;
    foreach ($wall as $post)
    {
      if ($i < $max)
      {
        if ($post['type'] == "photo" || $post['type'] == "video")
        {
          switch ($post['type'])
          {
            case 'photo':
              if (!isset($post['message']) || $post['message'] == '')
              {
                $post['message'] = 'Photos were uploaded.';
              }
                $post['message'] = $post['message'] . ' <a target="_new" href="http://www.facebook.com/'.FB_PAGE_NAME.'?story_fbid='.$post['id'].'">[view '.$post['type'].'s]</a>';
              break;
            
            case 'video':
              if (!isset($post['message']) || $post['message'] == '')
              {
                $post['message'] = 'Videos were uploaded.';
              }
              $post['message'] = $post['message'] . ' <a target="_new" href="http://www.facebook.com/'.FB_PAGE_NAME.'?story_fbid='.$post['id'].'">[view '.$post['type'].']</a>';
              break;
            
          }

        }
        
        echo '
              <div class="page_post_container">
                <div class="page_post_header">            
                  <div class="page_post_time">
                  '.date("F j, Y", $post['time']).'
                  </div>
                  <div class="page_post_comment">
                  <a class="page_post_comment_link" href="http://www.facebook.com/'.FB_PAGE_NAME.'?story_fbid='.$post['id'].'">[Click to Comment]</a>';
                  
        if (isset($_SESSION) && $_SESSION['admin'] && $GLOBALS['Misc']->StringWithin('email', $_SESSION['privileges']))
        {
          echo ' <a class="page_post_hide_link" href="http://'.DOMAIN.'/home/hidepost/'.$post['id'].'">[Hide Post]</a>';
        }
                  
        echo '
                  </div>
                </div>
                
                <div class="page_post_message">
                  '.$post['message'].'
                </div>
              </div>
              ';
      }
      $i++;
    }
  }
?>

<div id="page_posts_more">
  <a target="_new" href="http://www.facebook.com/<?php echo FB_PAGE_NAME;?>">Vew more updates...</a>
</div>