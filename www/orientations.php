<?php

  $page_title = 'Orientations';
  $require_login = false;
  
  require '../knoopvszombies.ini.php';
  
  require 'module/includes.php';
  
  require 'module/general.php';
  
  if (!isset($_GET['gid']))
  {
    if ($GLOBALS['state'])
    {
      $_GET['gid'] = $GLOBALS['state']['gid'];
    }
    else
    {
      header('Location: //'.DOMAIN);
      exit;
    }
  }
  
  $playerCounts = $GLOBALS['Game']->GetBrokenDownPlayerCount($GLOBALS['state']['gid']);
  $game = $GLOBALS['Game']->GetGame($_GET['gid']);
  $orientations = $GLOBALS['Game']->GetOrientations($_GET['gid']);
  
?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/countdown.css" rel="stylesheet" type="text/css"/>
  <link href="//<?php echo DOMAIN; ?>/css/page/orientations.css" rel="stylesheet" type="text/css"/>
  
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

          <?php 
            if ($GLOBALS['state'] && $GLOBALS['state']['countdown'] && $GLOBALS['state']['start_time'] != 0 && $GLOBALS['state']['start_time'] != '')
            {
              require 'module/countdown.php';
            }
          ?>

          <div id="orient_container">

            <div class="orient_title">
              Orientations <span class="accent_color"><?php echo $game['name']; ?></span>
            </div>

            <div class="orient_header">
              <p>Below are orientation sessions listed for the <?php echo $game['name']; ?> game. All players must attend at least one of the following orientation sessions. These sessions aquaint players with new rules, gameplay and getting ready for the game. If you cannot make it to any of the listed orientation sessions, please contact a moderator. Contact information can be found on the "About Us" page.</p> 
            </div>
  
            <table class="orient_table">
              <tr class="orient_table_row_headerfooter">
                <td class="orient_table_cell orient_table_cell_number">Number</td>
                <td class="orient_table_cell orient_table_cell_location">Location</td>
                <td class="orient_table_cell orient_table_cell_time">Date and Time</td>
              </tr>
              
              <?php if (count($orientations) > 0): ?>
                <?php $i = 1; foreach ($orientations as $orientation): ?>
                  <tr class="orient_table_row">
                    <td class="orient_table_cell">
                      #<?php echo $i; $i++; ?>
                    </div>
                    <td class="orient_table_cell">
                      <?php echo $orientation['location']; ?>
                    </div>
                    <td class="orient_table_cell">
                      <?php echo date("D m/d, g:iA", $orientation['time']); ?>
                    </div>
                  </tr>
                <?php endforeach ?>
                
              <?php else: ?>
                <tr class="orient_table_row_noplayers">
                  <td colspan="5" class="orient_table_cell table_cell_center">There are no orientations to display (dates still undecided).</td>
                </tr>
              <?php endif ?>
              
              <tr class="orient_table_row_headerfooter">
                <td class="orient_table_cell orient_table_cell_picture"></td>
                <td class="orient_table_cell orient_table_cell_name"></td>
                <td class="orient_table_cell orient_table_cell_status"></td>
              </tr>
              </tr>
              
            </table>
          </div>
          
          <div class="clearfix"></div>
          
        </div> <!-- body_content -->     
        

      </div> <!-- content -->
    </div>  <!-- content_column -->
    
    
    <div id="footer_push"></div>
  </div> <!-- body_container -->

  <?php
    require 'module/footer.php';
  ?>


</body>

</html>
