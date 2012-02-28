<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: uninstall.jwallpapers.php 322 2010-05-21 16:42:59Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );

function com_uninstall() {
	
	$option = 'com_jwallpapers';
	
	
	

	
	$db = & JFactory::getDBO ();
	$query = 'CREATE TABLE IF NOT EXISTS #__jwallpapers_settings_backup';
	$db->Execute ( $query );
	$query = 'TRUNCATE TABLE #__jwallpapers_settings_backup';
	$db->Execute ( $query );
	
	
	$component = JComponentHelper::getComponent ( $option );
	$params = new JParameter ( $component->params );
	
	
	$params = $params->toArray ();
	
	foreach ( $params as $param_key => $param_value ) {
		
		$query = 'INSERT INTO #__jwallpapers_settings_backup VALUES (\'' . $db->getEscaped ( $param_key ) . '\',\'' . $db->getEscaped ( $param_value ) . '\') ON DUPLICATE KEY UPDATE value = \'' . $db->getEscaped ( $param_value ) . '\'';
		$db->Execute ( $query );
	
	}
	
	?>
<div class="header">JWallpapers is now removed from your system.</div>
<p>In order to avoid any loss of data, the databases containing all your
JWallpapers data as well as all you JWallpapers images
(jwallpapers_files directory) were not deleted.</p>
<?php
}
?>