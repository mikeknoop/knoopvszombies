<?php

$parse[0] = $imp_post;
$post = $GLOBALS['Wall']->ParsePosts($parse);
$post = $post[0];

if ($post['type'] == "photo" || $post['type'] == "video")
{
  switch ($post['type'])
  {
    case 'photo':
      $post['message'] = $post['message'] . ' <a target="_new" href="http://www.facebook.com/'.FB_PAGE_NAME.'?story_fbid='.$post['id'].'">[view '.$post['type'].'s]</a>';
      break;
    
    case 'video':
      $post['message'] = $post['message'] . ' <a target="_new" href="http://www.facebook.com/'.FB_PAGE_NAME.'?story_fbid='.$post['id'].'">[view '.$post['type'].']</a>';
      break;
    
  }

}

?>

<div class="imp_post_container">
  <div class="imp_post_header"> 
    <div class="imp_post_title">
      Important Message
    </div>
    <div class="imp_post_comment">
      <a class="imp_post_comment_link" href="http://www.facebook.com/<?php echo FB_PAGE_NAME; ?>?story_fbid=<?php echo $post['id']; ?>">Comment</a>
    </div>
    <div class="imp_post_time">
      <?php echo date("F j, Y", $post['time']); ?>
    </div>
    <div class="clearfix"></div>
  </div>
  
  <div class="imp_post_message">
    <?php echo $post['message']; ?>
  </div>
</div>
