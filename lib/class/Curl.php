<?php
/**  
 * Curl class
 * 
 * Handles Curl Faceboook Graph API related activities
 * 	
 * @access		public
 */
 
class Curl {

  /*
  * Takes a $uri and CURLs the request to Facebook's Graph API servers
  *
  * return @mixed
  */
  function GetContents($uri, $json_decode=true)
  {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uri);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $returnData = curl_exec($ch);
    curl_close($ch);
    
    if ($json_decode)
      $return = json_decode($returnData, true);
    else
      $return = $returnData;
  
    return $return;  
  }
  
}
?>