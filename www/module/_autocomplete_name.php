<?php 

    require '../../knoopvszombies.ini.php';
    require DOCUMENT_ROOT.'/lib/class/SqlConnection.php';
    require DOCUMENT_ROOT.'/lib/class/CacheEngine.php';
    require DOCUMENT_ROOT.'/lib/class/Game.php';
    require DOCUMENT_ROOT.'/lib/class/User.php';
     
    // Create general cache object
    $GLOBALS['Cache'] = new CacheEngine(DOCUMENT_ROOT.'/cache/');
    // Create user cache object
    $GLOBALS['UserCache'] = new CacheEngine(DOCUMENT_ROOT.'/cache/user/');
    // Create rate limit cache object
    $GLOBALS['RateCache'] = new CacheEngine(DOCUMENT_ROOT.'/cache/rate/');
    $GLOBALS['Db'] = new SqlConnection();
    $GLOBALS['Game'] = new Game();
    $GLOBALS['User'] = new User();

    if (!isset($_REQUEST['s']))
    {
      $_REQUEST['s'] = '';
    }
    
    if (!isset($_REQUEST['firstOnly']))
    {
      $_REQUEST['firstOnly'] = false;
    }
    
    $matches = $GLOBALS['User']->GetPlayerMatchesOnSearch($_REQUEST['s'], $_REQUEST['firstOnly']);
     
    $type = 'text/xml'; 
    $response = ''; 
     
    ob_clean(); 
     
    switch($_REQUEST['m']) 
    { 
        case 'json': 
            $type = "text/plain"; 
            // 
            // You don't have to do both, but Prototype has automatic 
            // evaluation support if you use the X-JSON header instead of the body. 
            // 
            $response = json_encode($matches); 
            header("X-JSON: $response"); 
            break; 
         
        case 'text': 
            $type = "text/plain"; 
            $response = join("\r\n", $matches); 
            break; 
             
        case 'xml': 
        default: 
            $type = "application/xml"; 
             
            $dom = new DOMDocument('1.0'); 
            $root = $dom->createElement('Suggestions'); 
            for($i = 0; $i < count($matches); $i++) 
            { 
                $e = $dom->createElement('suggestion', $matches[$i]); 
                $root->appendChild($e); 
            } 
            $dom->appendChild($root); 
            $response = $dom->saveXML(); 
            break;         
    } 

    header("Content-Type: $type"); 
    echo $response; 
    exit; 

?>