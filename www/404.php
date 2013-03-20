<?php
    
  $page_title = 'Page Not Found';
  $require_login = false;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';

?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/page/404.css" rel="stylesheet" type="text/css"/>
  
</head>

<body>

  <div id="body_container">
  
    <?php
      require 'module/header.php';
    ?>
    
    <div class="content_column">
      <div id="content">
      
        <div id="content_top_border">
            <?php
              require 'module/body_header.php';
            ?>
        </div>

        <div id="body_content">
          <div id="notfound_title">
          Sorry, but the page you requested has been devoured by a zombie.
          </div>
          
          <div id="notfound_subtext">
          (404 Page Not Found)
          </div>
        </div>

      </div> <!-- content -->
    </div>  <!-- content_column -->
    
    
    <div id="footer_push"></div>
  </div> <!-- body_container -->

  <?php
    require 'module/footer.php';
  ?>


</body>

</html>
