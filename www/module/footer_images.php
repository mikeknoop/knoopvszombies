<?php

$pictures = $GLOBALS['Photo']->GetRandomFooter();

if (is_array($pictures))
{
  foreach ($pictures as $picture)
  {
    echo '
          <a target="_new" href="http://'.DOMAIN.'/'.$picture['link'].'">
            <div class="footer_image_single_container">
              <img class="footer_image" src="'.$picture['picture'].'" />
            </div>
          </a>
          
          ';
  }
}

?>