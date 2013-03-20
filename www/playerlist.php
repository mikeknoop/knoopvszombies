<?php

  $page_title = 'Playerlist';
  $require_login = false;
  
  require '../knoopvszombies.ini.php';

  require 'module/includes.php';
  
  require 'module/general.php';
  
  if (isset($_GET['p']))
    $page = $_GET['p'];
  else
    $page = 1;
  
  if (isset($_GET['pageBy']))
    $pageBy = $_GET['pageBy'];
  else
    $pageBy = 100;

  if (isset($_GET['sortBy']))
    $sortBy = $_GET['sortBy'];
  else
    $sortBy = 'name';

  if (isset($_GET['filterBy']))
    $filterBy = $_GET['filterBy'];
  else
    $filterBy = 'all';
    
  // Advanced filtering/sorting logic
  if ($sortBy == 'starve_time' || $sortBy == 'kills')
  {
    $filterBy = 'zombies';
  }
  
  if ($sortBy == 'squad')
  {
    $filterBy = 'in_squad';
  }
    
  if ($GLOBALS['state'])
  {
    $playerCount = $GLOBALS['Game']->GetPlayerCount($GLOBALS['state']['gid']);
    $playerCounts = $GLOBALS['Game']->GetBrokenDownPlayerCount($GLOBALS['state']['gid']);
    $playerArray = $GLOBALS['Game']->GetPlayers($GLOBALS['state']['gid'], $pageBy, $page, $sortBy, $filterBy);
    $playerArrayFilteredTotal = $GLOBALS['Game']->GetPlayers($GLOBALS['state']['gid'], 'all', 1, $sortBy, $filterBy);
  }
  else
  {
    $playercounts = array();
    exit;
  }
  
// Figure which page numbers to show. Want to show at least last 2 pages and up to next 2
  $pageDisplay = array();
  $maxPage = ceil(count($playerArrayFilteredTotal) / $pageBy);
  
  switch ($page)
  {
    case 1:
      $pageDisplay[0] = 1;
      break;
      
    case 2:
      $pageDisplay[0] = 1;
      $pageDisplay[1] = 2;
      break;
    
    case 3:
      $pageDisplay[0] = 1;
      $pageDisplay[1] = 2;
      $pageDisplay[2] = 3;
      break;
      
    default:
      $pageDisplay[0] = $page - 3;
      $pageDisplay[1] = $page - 2;
      $pageDisplay[2] = $page - 1;
      break;
      
  }

  $index = count($pageDisplay) - 1;
  $pageIndex = $pageDisplay[$index];
  $pageIndex++;
  $index++;
  $afterCurrentIndex = $index;
  $afterCurrentMax = 5;

  
  while ($pageIndex <= $maxPage && $afterCurrentIndex < $afterCurrentMax)
  {
    $pageDisplay[$index] = $pageIndex;
    $pageIndex++;
    $index++;
    $afterCurrentIndex++;
  }
  
?>

<!DOCTYPE html>


<html>

<head>
  <?php
    require 'module/html_head.php';
  ?>
  
  <link href="//<?php echo DOMAIN; ?>/css/countdown.css" rel="stylesheet" type="text/css"/>
  <link href="//<?php echo DOMAIN; ?>/css/page/playerlist.css" rel="stylesheet" type="text/css"/>
  
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
          
          <div id="playerlist_header">
            
            <div id="playerlist_display_options">
              <form name="playerlist_display_options_form" action="//<?php echo DOMAIN; ?>/playerlist" type="GET">
                <div class="playerlist_display_options_container">
                  <div class="playerlist_display_options_label">
                    Filter by:
                  </diV>
                  <select class="playerlist_display_options_select" name="filterBy">
                    <option value="all" <?php if (isset($filterBy) && $filterBy == 'all') echo "selected"; ?> >All</option>
                    <option value="humans" <?php if (isset($filterBy) && $filterBy == 'humans') echo "selected"; ?> >Humans</option>
                    <option value="zombies" <?php if (isset($filterBy) && $filterBy == 'zombies') echo "selected"; ?> >Zombies</option>
                    <option value="deceased" <?php if (isset($filterBy) && $filterBy == 'deceased') echo "selected"; ?> >Deceased</option>
                    <option value="in_squad" <?php if (isset($filterBy) && $filterBy == 'in_squad') echo "selected"; ?> >In Squad</option>
                  </select>
                </div>
                <div class="playerlist_display_options_container">
                  <div class="playerlist_display_options_label">
                    Sort by:
                  </diV>
                  <select class="playerlist_display_options_select" name="sortBy">
                    <option value="name" <?php if (isset($sortBy) && $sortBy == 'name') echo "selected"; ?> >Name</option>
                    <option value="squad" <?php if (isset($sortBy) && $sortBy == 'squad') echo "selected"; ?> >Squad Name</option>
                    <option value="kills" <?php if (isset($sortBy) && $sortBy == 'kills') echo "selected"; ?> >Kills</option>
                    <option value="starve_time" <?php if (isset($sortBy) && $sortBy == 'starve_time') echo "selected"; ?> >Starve Time</option>
                  </select>
                </div>
                <div class="playerlist_display_options_container">
                  <div class="playerlist_display_options_label">
                    Players per page:
                  </diV>
                  <select class="playerlist_display_options_select" name="pageBy">
                    <option value="100" <?php if (isset($pageBy) && $pageBy == '100') echo "selected"; ?> >100</option>
                    <option value="200" <?php if (isset($pageBy) && $pageBy == '200') echo "selected"; ?> >200</option>
                    <option value="500" <?php if (isset($pageBy) && $pageBy == '500') echo "selected"; ?> >500</option>
                    <option value="1000" <?php if (isset($pageBy) && $pageBy == '1000') echo "selected"; ?> >1000</option>
                  </select>
                </div>
                <div class="playerlist_display_options_container">
                  <input class="button" type="submit" value="Update" class="playerlist_display_options_submit"></input>
                </div>
                
              </form>
              <div class="clearfix"></div>
            </div>
            
            <div class="playerlist_pagination">
              <?php if (count($pageDisplay) > 0): ?>
                <?php foreach ($pageDisplay as $row): ?>
                  <?php if ($row == $page): ?>
                   <div class="playerlist_header_pagination_page accent_color">
                    <?php echo $row; ?>
                   </div>
                  <?php else: ?>           
                   <div class="playerlist_header_pagination_page">
                    <a class="playerlist_header_pagination_page_link" href="//<?php echo DOMAIN; ?>/playerlist?p=<?php echo $row; if (isset($pageBy)) echo "&pageBy={$pageBy}"; if (isset($sortBy)) echo "&sortBy={$sortBy}"; if (isset($filterBy)) echo "&filterBy={$filterBy}";       ?>"><?php echo $row; ?></a>
                   </div>
                  <?php endif ?>
                <?php endforeach ?>
              <?php endif ?>
            </div>
            
            <div class="playerlist_right_text">
              Click on a user picture or name for more information. <?php if ($GLOBALS['state']): ?>
              &nbsp; Humans: <?php echo $playerCounts['humans']?>, &nbsp; Zombies: <?php echo $playerCounts['zombies']?>, &nbsp; Deceased: <?php echo $playerCounts['deceased']?>
              <?php endif ?>              
            </div>
            
            <div class="clearfix"></div>
            
          </div>

          <div id="playerlist_table_container">
          
            <table class="playerlist_table">
              <tr class="playerlist_table_row_headerfooter">
                <td class="playerlist_table_cell playerlist_table_cell_picture">Picture</td>
                <td class="playerlist_table_cell playerlist_table_cell_name">Name</td>
                <td class="playerlist_table_cell playerlist_table_cell_squad">Squad</td>
                <td class="playerlist_table_cell playerlist_table_cell_status">Status</td>
                <td class="playerlist_table_cell playerlist_table_cell_zombiekills">Kills as Zombie</td>
                <td class="playerlist_table_cell playerlist_table_cell_lastfeed">Last Feed as Zombie</td>
              </tr>
              
              <?php if (count($playerArray) > 0): ?>
                <?php foreach ($playerArray as $player): ?>
                  <tr class="playerlist_table_row">
                    <td class="playerlist_table_cell table_cell_center">
                    <a href="//<?php echo DOMAIN; ?>/account/<?php echo $player['uid']; ?>" class="accent_color"><img class="playerlist_table_cell_img" src="<?php     
                        if ($player['using_fb'])
                        {
                          echo '//graph.facebook.com/'.$player['fb_id'].'/picture?type=small';
                          
                        }
                        else
                        {
                          echo '//'.DOMAIN.'/img/user/thumb/u'.$player['uid'].'.jpg';
                        }
                      ?>"></img></a>
                    </td>
                    <td class="playerlist_table_cell">
                      <a href="//<?php echo DOMAIN; ?>/account/<?php echo $player['uid']; ?>" class="accent_color"><?php echo $player['name']; ?></a>
                    </td>
                    <td class="playerlist_table_cell">
                      <?php echo $player['squad_name']; ?>
                    </td>
                    <td class="playerlist_table_cell">
                      <?php 
                        if (($GLOBALS['state']['oz_hidden'] && $player['oz']) && $player['status'] == 'zombie')
                        {
                          echo "human";
                        }
                        else
                        {
                          echo $player['status'];
                          if ($player['oz'])
                          {
                            echo " (oz)";
                          }
                        }
                        
                      ?>
                    </td>
                    <td class="playerlist_table_cell">
                      <?php
                        if ($player['status'] == 'human' || ($GLOBALS['state']['oz_hidden'] && $player['oz']))
                          echo "--";
                        else
                          echo $player['zombie_kills'];
                      ?>
                    </td>
                    <td class="playerlist_table_cell table_cell_center">
                      <?php
                        if ($player['status'] == 'human' || $player['zombie_feed_timer'] == 0 || ($GLOBALS['state']['oz_hidden'] && $player['oz']))
                          echo "--";
                        else
                          echo date("D m/d, g:iA", $player['zombie_feed_timer']);
                      ?>
                    </td>
                  </tr>
                <?php endforeach ?>
                
              <?php else: ?>
                <tr class="playerlist_table_row_noplayers">
                  <td colspan="5" class="playerlist_table_cell table_cell_center">There are no players to display</td>
                </tr>
              <?php endif ?>
              
              <tr class="playerlist_table_row_headerfooter">
                <td class="playerlist_table_cell playerlist_table_cell_picture"></td>
                <td class="playerlist_table_cell playerlist_table_cell_name"></td>
                <td class="playerlist_table_cell playerlist_table_cell_squad"></td>
                <td class="playerlist_table_cell playerlist_table_cell_status"></td>
                <td class="playerlist_table_cell playerlist_table_cell_zombiekills"></td>
                <td class="playerlist_table_cell playerlist_table_cell_lastfeed"></td>
              </tr>
              
            </table>
          </div>
          
          <div id="playerlist_footer">
            <div class="playerlist_pagination">
              <?php if (count($pageDisplay) > 0): ?>
                <?php foreach ($pageDisplay as $row): ?>
                  <?php if ($row == $page): ?>
                   <div class="playerlist_header_pagination_page accent_color">
                    <?php echo $row; ?>
                   </div>
                  <?php else: ?>           
                   <div class="playerlist_header_pagination_page">
                    <a class="playerlist_header_pagination_page_link" href="//<?php echo DOMAIN; ?>/playerlist?p=<?php echo $row; if (isset($pageBy)) echo "&pageBy={$pageBy}"; if (isset($sortBy)) echo "&sortBy={$sortBy}"; if (isset($filterBy)) echo "&filterBy={$filterBy}";       ?>"><?php echo $row; ?></a>
                   </div>
                  <?php endif ?>
                <?php endforeach ?>
              <?php endif ?>
            </div>
            <div class="clearfix"></div>
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
