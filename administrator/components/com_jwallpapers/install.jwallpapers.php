<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * @version 2.0.1 $Id: install.jwallpapers.php 364 2010-06-03 19:43:07Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
function com_install() {
	
	$option = 'com_jwallpapers';
	
	$status = 1;
	$success = 'JWallpapers was successfully installed<br />';
	$needsAttention = 'JWallpapers was successfully installed<br />However, some problems were detected during the installation.';
	
	$db = & JFactory::getDBO ();
	$prefix = $db->getPrefix ();
	
	$query = "DROP PROCEDURE IF EXISTS recursivesubtree";
	
	$db->Execute ( $query );
	
	$query = "CREATE PROCEDURE `recursivesubtree`( iroot INT, ilevel INT )
BEGIN
  DECLARE iid, ichildcount,done INT DEFAULT 0;
  DECLARE cur CURSOR FOR
  SELECT 
    t.id,
    (SELECT COUNT(*) FROM " . $prefix . "jwallpapers_categories WHERE parent_id=t.id AND published = 1) AS childcount FROM " . $prefix . "jwallpapers_categories t
  WHERE parent_id = iroot AND published = 1;
  DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
  IF ilevel = 0 THEN
    DROP TEMPORARY TABLE IF EXISTS descendants;
    CREATE TEMPORARY TABLE descendants(
      id INT, depth INT
    );
  END IF;
  OPEN cur;
  WHILE NOT done DO
    FETCH cur INTO iid,ichildcount;
    IF NOT done THEN
      INSERT INTO descendants VALUES(iid, ilevel);
      IF ichildcount > 0 THEN
        CALL recursivesubtree( iid, ilevel + 1 );
      END IF;
    END IF;
  END WHILE;
  CLOSE cur;
END";
	
	if ($db->Execute ( $query ) == false) {
		echo "<p><font color='red'><b>Error while creating recursivesubtree stored procedure</b></font></p><p>You will need to create it manually. Go to the FAQ at joomlaplugs.com for more information on how to do this.</p>";
		$status = 0;
	}
	
	$query = "DROP PROCEDURE IF EXISTS getCatDownPath";
	
	$db->Execute ( $query );
	
	$query = "CREATE PROCEDURE `getCatDownPath`(node INT, stop_node INT)
BEGIN
DECLARE newParent, currentParent, currentNodeId, done, cur_pos INT DEFAULT 0;
DECLARE currentParentTitle, currentParentAlias VARCHAR(255);
DROP TEMPORARY TABLE IF EXISTS catDownPath;
CREATE TEMPORARY TABLE catDownPath(id INT, pos INT, title VARCHAR(255), alias VARCHAR(255));
INSERT INTO catDownPath (SELECT id, cur_pos, title, alias FROM " . $prefix . "jwallpapers_categories WHERE id = node);
SELECT parent_id INTO currentParent  FROM " . $prefix . "jwallpapers_categories WHERE id = node;
IF node = stop_node THEN
SET done = 1;
END IF;
WHILE NOT done DO
SELECT parent_id, title, alias INTO newParent, currentParentTitle, currentParentAlias FROM " . $prefix . "jwallpapers_categories WHERE id = currentParent;
IF currentParent AND stop_node <> currentParent THEN 
SET cur_pos = cur_pos + 1;
INSERT INTO catDownPath VALUES (currentParent, cur_pos, currentParentTitle, currentParentAlias);
ELSE
SET done = 1;
END IF;
SET currentParent = newParent;
END WHILE;
END";
	
	if ($db->Execute ( $query ) == false) {
		echo "<p><font color='red'><b>Error while creating getCatDownPath stored procedure</b></font></p><p>You will need to create it manually. Go to the FAQ at joomlaplugs.com for more information on how to do this.</p>";
		$status = 0;
	}
	
	
	if (! upgrade_dbs ( $db, $prefix, $fail_query )) {
		
		$database_upgrade_status = '<li><font color="orange"><b>There was problem while upgrading the databases on query: ' . $fail_query . '. Please check the Knowledge Base or contact the developer for more info.</b></font></li>';
		$status = 0;
	} else {
		$database_upgrade_status = '<li><font color="green"><b>Databases were successfully created/updated.</b></font></li>';
	}
	
	$php_safe_mode = ini_get ( 'safe_mode' );
	if ($php_safe_mode) {
		$php_safe_mode_check = '<li><font color="orange"><b>PHP safe mode is On. Depending on your system configuration, JWallpapers will still be able to work when PHP safe mode is activated. However, your PHP settings might need your attention if you want to make use of the Asynchronous resizing method. There is an article in the Knowledge base that explains the process.</b></font></li>';
		$status = 0;
	}
	
	$php_ver = phpversion ();
	$php_ver_array = explode ( '.', $php_ver );
	if ($php_ver_array [0] >= 5) {
		$php_check = '<li><font color="green"><b>PHP version found: ' . $php_ver . '. Required >= 5.0</b></font></li>';
	} else {
		$php_check = '<li><font color="red"><b>PHP version found: ' . $php_ver . '. Required >= 5.0</b></font></li>';
		$status = 0;
	}
	
	$query = "SELECT VERSION()";
	$db->setQuery ( $query );
	$mysql_ver = $db->loadResult ();
	$mysql_ver_array = explode ( '.', $mysql_ver );
	if ($mysql_ver_array [0] >= 5) {
		$mysql_check = '<li><font color="green"><b>MySQL version found: ' . $mysql_ver . '. Required >= 5.0</b></font></li>';
	} else {
		$mysql_check = '<li><font color="red"><b>MySQL version found: ' . $mysql_ver . '. Required >= 5.0</b></font></li>';
		$status = 0;
	}
	
	$gd_info = (function_exists ( 'gd_info' )) ? gd_info () : array ();
	$imagick_exists = (class_exists ( 'Imagick' )) ? 1 : 0;
	If ($imagick_exists) {
		$imagick = new Imagick ( );
		$imagick_ver = $imagick->getVersion ();
	} else {
		$imagick_ver = array ();
	}
	
	if (empty ( $gd_info ) && empty ( $imagick_ver )) {
		$image_library_check = '<li><font color="red"><b>JWallpapers requires at least one of the following image processing libraries: GD2 or Imagick. The installer failed to find any of those libraries on your system.</b></font></li>';
		$status = 0;
	} else {
		$image_library_check = (! empty ( $gd_info )) ? '<li><font color="green"><b>GD found: ' . $gd_info ['GD Version'] . '. Required >= 2.0</b></font></li>' : '';
		$image_library_check .= (! empty ( $imagick_ver )) ? '<li><font color="green"><b>Imgick found: ' . $imagick_ver ['versionString'] . '.</b></font></li>' : '';
	}
	
	jimport ( 'joomla.filesystem.file' );
	$jwallpapers_admin_path = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $option;
	
	$jwallpapers_files_path = JPATH_ROOT . DS . 'jwallpapers_files';
	
	if (! file_exists ( $jwallpapers_files_path )) {
		if (mkdir ( $jwallpapers_files_path, 0777, true ) === FALSE) { 
			
			
			jimport ( 'joomla.filesystem.folder' );
			
			
			
			
			

			
			
			$old_mask = umask ( 0 );
			
			
			if (! JFolder::create ( $jwallpapers_files_path, 02777 )) {
				
				$mkdir_jwallpapers_files_error = '<font color="orange"><b>Failed to create the jwallpapers_files directory (probably due to a permission problem). You need to manually create a directory called jwallpapers_files in your Joomla site root directory. Set the permissions of this folder to 2777 for a maximum of compatibility. This set of permissions can be strengthen depending on your system configuration. Contact the developer for more information about this.<br />In the backend JWallpapers directory (administrator/components/com_jwallpapers) there is a file named files_htaccess.txt. You need to make a copy of that file named .htaccess in the jwallpapers_files directory previously mentioned.</b></font>';
			}
			
			umask ( $old_mask );
		}
	}
	
	if (empty ( $mkdir_jwallpapers_files_error )) {
		
		
		if (! JFile::copy ( $jwallpapers_admin_path . DS . 'files_htaccess.txt', $jwallpapers_files_path . DS . '.htaccess' )) {
			$files_htaccess_error = '<font color="orange"><b>Failed to copy the .htaccess file. You will have do to this manually. In the backend JWallpapers directory (administrator/components/com_jwallpapers) there is a file named files_htaccess.txt. You need to make a copy of that file named .htaccess in the jwallpapers_files directory located in your Joomla root path.</b></font>';
		}
	}
	
	
	
	$query = 'SHOW TABLES LIKE \'' . $prefix . 'jwallpapers_settings_backup\'';
	$db->setQuery ( $query );
	$table_exists = $db->loadResult ();
	if (! empty ( $table_exists )) {
		
		$query = 'SELECT * FROM ' . $prefix . 'jwallpapers_settings_backup';
		$db->setQuery ( $query );
		$backedUp_settings = $db->loadObjectList ();
		
		
		
		$component_row = & JTable::getInstance ( 'Component', 'JTable' );
		
		
		if (! $component_row->loadByOption ( $option )) {
			JError::raiseError ( 500, $component_row->getError () );
		}
		
		
		$params = new JParameter ( $component_row->params );
		
		
		$params = $params->toArray ();
		
		
		
		$formated_params = array ('params' );
		
		foreach ( $params as $param_key => $param_value ) {
			$formated_params ['params'] [$param_key] = $param_value;
		}
		
		foreach ( $backedUp_settings as $backedUp_setting ) {
			
			$formated_params ['params'] [$backedUp_setting->param] = $backedUp_setting->value;
		}
		
		
		
		if (! $component_row->bind ( $formated_params )) {
			JError::raiseError ( 500, $component_row->getError () );
		}
		
		if (! $component_row->store ()) {
			JError::raiseError ( 500, $component_row->getError () );
		}
	
	}
	
	?>
<div class="header"><?php
	echo ($status) ? $success : $needsAttention;
	?></div>

<ul>
	<h3>System configuration tests:<br />
	</h3>
<?php
	if (isset ( $php_safe_mode_check )) {
		echo $php_safe_mode_check;
	}
	echo $php_check;
	echo $mysql_check;
	echo $image_library_check;
	echo $database_upgrade_status;
	?>
</ul>
<?php
	if (isset ( $mkdir_jwallpapers_files_error )) {
		echo $mkdir_jwallpapers_files_error;
	}
	
	if (isset ( $files_htaccess_error )) {
		echo $files_htaccess_error;
	}

}



function upgrade_dbs(&$db, $prefix, &$fail_query) {
	
	
	
	
	$config = & JFactory::getConfig ();
	
	
	$config_obj = $config->toObject ();
	$db_name = $config_obj->db;
	
	$queries = array ();
	
	
	
	$query = 'SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = \'' . $db_name . '\' AND TABLE_NAME = \'' . $prefix . 'jwallpapers_categories\' AND COLUMN_NAME = \'file_id\'';
	$db->setQuery ( $query );
	$column_exists = $db->loadResult ();
	if (! $column_exists) {
		
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` ADD `file_id` INT(11) DEFAULT NULL AFTER `parent_id`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `keywords` VARCHAR(255) DEFAULT NULL AFTER `alias`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD INDEX `idx-user_id-cat_id-published` (`user_id`,`cat_id`,`published`)';
	}
	
	
	$query = 'SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = \'' . $db_name . '\' AND TABLE_NAME = \'' . $prefix . 'jwallpapers_files\' AND COLUMN_NAME = \'tag_ep\'';
	$db->setQuery ( $query );
	$column_exists = $db->loadResult ();
	if (! $column_exists) {
		
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` CHANGE COLUMN `title` `title` varchar(64) NOT NULL';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` DROP INDEX `idx-user_id-cat_id-published`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD INDEX `idx-user_id` (`user_id`)';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `tag_ep` TINYINT(1) NOT NULL DEFAULT \'0\' AFTER `owner`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `tag_ep_date` DATETIME DEFAULT NULL AFTER `tag_ep`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD INDEX `idx-tag_ep` (`tag_ep`)';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `votes_en` TINYINT(1) NOT NULL DEFAULT  \'1\' AFTER `tag_ep_date`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `downloadable` TINYINT(1) NOT NULL DEFAULT  \'1\' AFTER `votes_en`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` ADD `frontend_uploads_en` TINYINT(1) NOT NULL DEFAULT  \'1\' AFTER `file_id`';
		$queries [] = 'DROP TABLE `#__jwallpapers_resizes`';
		$queries [] = 'DROP TABLE `#__jwallpapers_resizes_queue`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_resizes_params` RENAME `#__jwallpapers_global_resizes`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` DROP `is_locked`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `checked_out` int(11) unsigned NOT NULL DEFAULT \'0\' AFTER `downloadable`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `checked_out_time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `checked_out`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` ADD `checked_out` int(11) unsigned NOT NULL DEFAULT \'0\' AFTER `published`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` ADD `checked_out_time` datetime NOT NULL DEFAULT \'0000-00-00 00:00:00\' AFTER `checked_out`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `item_deny_acl` varchar(255) NOT NULL AFTER `checked_out_time`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` ADD `item_deny_acl` varchar(255) NOT NULL AFTER `checked_out_time`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `votes_deny_acl` varchar(255) NOT NULL AFTER `item_deny_acl`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` ADD `votes_deny_acl` varchar(255) NOT NULL AFTER `item_deny_acl`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `downloads_deny_acl` varchar(255) NOT NULL AFTER `votes_deny_acl`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` ADD `downloads_deny_acl` varchar(255) NOT NULL AFTER `votes_deny_acl`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `tagging_deny_acl` varchar(255) NOT NULL AFTER `downloads_deny_acl`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` ADD `tagging_deny_acl` varchar(255) NOT NULL AFTER `downloads_deny_acl`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` ADD `uploads_deny_acl` varchar(255) NOT NULL AFTER `tagging_deny_acl`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` ADD `hits` INT(11) NOT NULL DEFAULT \'0\' AFTER `published`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_files` ADD `downloads` INT(11) NOT NULL DEFAULT \'0\' AFTER `hits`';
		$queries [] = 'ALTER TABLE `#__jwallpapers_categories` ADD `def_downloadable_front_pics_stat` TINYINT(1) NOT NULL DEFAULT \'1\' AFTER `hits`';
	}
	
	if (! empty ( $queries )) {
		foreach ( $queries as $query ) {
			if ($db->Execute ( $query ) == false) {
				
				$fail_query = $query;
				return 0;
			}
		}
	}
	
	return 1;
}
?>
