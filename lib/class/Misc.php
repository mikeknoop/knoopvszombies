<?php
/**  
 * misc function class
 * 
 * Handles misc application functions
 * 	
 * @access		public
 */
 
class Misc {

  /*
  * Generates a safe filename for UNIX environment
  *
  * @return string
  */
  function SafeFileName($filename)
  {
    $filename = strtolower($filename);
    $filename = str_replace("#","_",$filename);
    $filename = str_replace(" ","_",$filename);
    $filename = str_replace("'","",$filename);
    $filename = str_replace('"',"",$filename);
    $filename = str_replace("__","_",$filename);
    $filename = str_replace("&","and",$filename);
    $filename = str_replace("/","_",$filename);
    $filename = str_replace("\\","_",$filename);
    $filename = str_replace("?","",$filename);
     
    return $filename;
  }

  
	/**
  *  Checks to see if a string is contained within another string
  *
	*/
  function StringWithin($needle, $haystack) {

    $position = strpos($haystack, $needle);
    if ($position === false)
      return false;
      
    return true;
  }
  
}

?>