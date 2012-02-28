<?php
/**
* @version 3.0
* @package Raf Cloud
* @copyright Copyright (C) 2007 Skorp. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Raf Cloud is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @Author: Rafal Blachowski (Skorp) <http://joomla.royy.net>
*/
defined( '_JEXEC' ) or die( 'Restricted access' );

class TOOLBAR_rafcloud {
	function CONFIG_MENU() {
		
		JToolBarHelper::save('saveconfig', RC_SAVE);
		JToolBarHelper::spacer();
		JToolBarHelper::cancel('view', RC_CANCEL);
		
	}
	function PLUGIN_MENU() {
		
		JToolBarHelper::publishList('publishPlugin');
		JToolBarHelper::spacer();
		JToolBarHelper::unpublishList('unpublishPlugin');
		JToolBarHelper::spacer();
		JToolBarHelper::trash( 'removePlugin', RC_REMOVE_PLUGIN);
		JToolBarHelper::spacer();
		JToolBarHelper::cancel('view', RC_CLOSE);
		
	}
	function REMOVE_MENU() {
		
		JToolBarHelper::trash( 'eraseAll', RC_ERASE_ALL,true);
		JToolBarHelper::divider();
		JToolBarHelper::trash( 'eraseUnpubl', RC_ERASE_UNPUBL,false);
		JToolBarHelper::spacer();
		JToolBarHelper::cancel('view', RC_CANCEL);
		
	}
	function _DEFAULT() {
		
		JToolBarHelper::custom( 'create', 'upload.png','upload.png', RC_BUILD,false);
		JToolBarHelper::spacer();
		JToolBarHelper::trash( 'removeWords', RC_ERASE,false);
		JToolBarHelper::spacer();
		JToolBarHelper::publishList();
		JToolBarHelper::spacer();
		JToolBarHelper::unpublishList();
		JToolBarHelper::spacer();
		JToolBarHelper::custom( 'plugins', 'menus.png','menus.png', RC_PLUGINS,false);
		JToolBarHelper::spacer();
		//JToolBarHelper::preferences('com_banners', '200'); //to do! skorp
		JToolBarHelper::custom( 'config', 'config.png','config.png', RC_CONFIG,false);

		global $mosConfig_lang, $mosConfig_absolute_path;
               if (file_exists($mosConfig_absolute_path.'/administrator/components/com_rafcloud/help/rafcloud.help.'.$mosConfig_lang.'.html')) {
                  $help_file = 'rafcloud.help.'.$mosConfig_lang;
               } else {
                  $help_file = 'rafcloud.help.english';
               }
		JToolBarHelper::spacer();
                JToolBarHelper::help($help_file, true);
		JToolBarHelper::spacer();
		
	}
}
?>