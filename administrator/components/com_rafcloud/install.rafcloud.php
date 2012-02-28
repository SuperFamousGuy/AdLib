<?php
/**
* @version 3.0
* @package Raf Cloud
* @copyright Copyright (C) 2007 Skorp. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Raf Cloud is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivaFttive of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @Author: Rafal Blachowski (Skorp) <http://joomla.royy.net>
*/


defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

function com_install() {

	$database = &JFactory::getDBO();

  ?>
 <div style="text-align:left;">
  <table width="100%" border="0">

<?php

$RC_upgrades = array();

$RC_upgrades[0]['test'] = "SELECT `type` FROM #__rafcloud_stat";
$RC_upgrades[0]['updates'][0] = "ALTER TABLE `#__rafcloud_stat` ADD `type` INT NOT NULL DEFAULT '0',"
				."CHANGE `word` `word` VARCHAR( 200 )"; 
$RC_upgrades[0]['updates'][1] = "UPDATE `#__rafcloud_stat` SET type='1'";

$RC_upgrades[0]['info'] = "1.0.x to 2.0.1 ";

echo("<br>Databse upgrade:<br>");
	foreach ($RC_upgrades AS $RC_upgrade) {
		$database->setQuery($RC_upgrade['test']);
		if (!$database->query()) {
			foreach($RC_upgrade['updates'] as $RC_sql) {
				$database->setQuery($RC_sql);
				if(!$database->query()) {
					echo("<br><font color=red>".$RC_upgrade['info']." failed! SQL error:" . $database->stderr(true)."</font><br />");
				}
			}
			echo "<br><font color=green>".$RC_upgrade['info']." Upgrade Applied Successfully!</font><br />";			
		} 
	}

	$database->setQuery("UPDATE `#__rafcloud_config` SET RC_value='3.0 beta' WHERE RC_key='RC_version'");
	$database->query();
}
?>

</table>