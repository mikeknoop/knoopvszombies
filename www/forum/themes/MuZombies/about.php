<?php if (!defined('APPLICATION')) exit();
/*
Copyright 2008, 2009 Vanilla Forums Inc.
This file is part of Garden.
Garden is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
Garden is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with Garden.  If not, see <http://www.gnu.org/licenses/>.
Contact Vanilla Forums Inc. at support [at] vanillaforums [dot] com
*/

/**
 * An associative array of information about this application.
 */
$ThemeInfo['DefaultSmarty'] = array(
   'Name' => 'MuZombies',
   'Description' => "MuZombies customized default Vanilla Theme.",
   'Version' => '1.0',
   'Author' => "Mike Knoop",
   'AuthorEmail' => 'muzombies@gmail.com',
   'AuthorUrl' => 'http://muzombies.org',
   'Options' => array(
		'Description' => 'This theme has <font color="red">7 color</font> options. Find out more on <a href="http://www.vanillaforums.com/blog/help-tutorials/how-to-use-theme-options">Theme Options</a>.',
      'Styles' => array(
         'Vanilla Terminal' => '%s_terminal',
			'Vanilla Grey' => '%s_grey',
			'Vanilla Big City' => '%s_bigcity',
			'Vanilla Poppy' => '%s_poppy',
			'Vanilla Lemon Sea' => '%s_lemonsea',
         'Vanilla Blue' => '%s'
      ),
   )
);