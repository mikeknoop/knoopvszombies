<?php
/**  
 * Facebook Photos Class
 * 
 * Handles all facebook photo related activities
 * 	
 * @access		public
 */
 
class Photo {

  /**
   * Returns random footer photos
   * 
   * @return  array
   */
  function GetRandomFooter() {
      
    $cache_id = 'footer_random_photos';
    if ($cache = $GLOBALS['Cache']->GetFromCache($cache_id, $Seconds=0, $IsObject=true)) {
      return $cache;
    }

    return null;
    
  }
  
    /**
   * Generate random footer images and save them to cache
   * Ideally called by a cron
   * 
   * @return  void
   */
  function GenerateFooterImageCache() {
      
    $how_many = 5;  
    $cache_id = 'footer_random_photos';

    if (!isset($GLOBALS['Facebook']))
    {
      $GLOBALS['Facebook'] = new Facebook(array(
      'appId'  => FB_APP_ID,
      'secret' => FB_SECRET,
      'cookie' => true,
      ));
    }
    
    $graph_url = FB_PAGE_NAME.'/albums';
    $pageData = $GLOBALS['Facebook']->api($graph_url);
    $pageData = $pageData['data'];

    $i = 0;
    if (is_array($pageData))
    {
      foreach ($pageData as $pageRow)
      {
          
          $graph_url = $pageRow['id'].'/photos';
          $albumData = $GLOBALS['Facebook']->api($graph_url);
          $albumData = $albumData['data'];
          
          if (is_array($albumData))
          {
            foreach ($albumData as $albumRow)
            {
              $pictures[$i] = array("id" => $albumRow['id'],
                                    "picture" => $albumRow['picture'],
                                    "link" => $albumRow['link']);    
                  
              $i++;
            }
          }
        
      }
    }
    else
    {
      return null;
    }
    
    if (count($pictures) > $how_many)
    {
      $rand = rand(0, (count($pictures) - $how_many));
      $i = 0;
      while ($i < $how_many)
      {
        $return[$i] = $pictures[$rand+$i];
        $i++;
      }
    }
    else
    {
      $i = 0;
      while ($i <= count($pictures))
      {
        $return[$i] = $pictures[$i];
        $i++;
      }
    }
    
    $GLOBALS['Cache']->WriteToCache($cache_id, $return);
  }
  
  
}
?>