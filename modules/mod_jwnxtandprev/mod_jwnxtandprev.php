<?php
/**
 * JWallpapers next and previous module - A module to display the next and previous pictures based on the position and the category of the picture being displayed 
 * 
 * @version 1.0 $Id: mod_jwnxtandprev.php 353 2010-06-01 10:04:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2010 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

global $option, $Itemid;


$view = JRequest::getVar ( 'view', null );
$menu = & JSite::getMenu ();
$menu_params = & $menu->getParams ( $Itemid );
$menu_item_type = $menu_params->get ( 'menu_item_type' );
if (! (isset ( $view ) && $option == 'com_jwallpapers' && $view == 'picture' && ($menu_item_type == 'jw_main_gallery' || $menu_item_type == 'jw_category'))) {
	
	return;
}

require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jwallpapers' . DS . 'helpers' . DS . 'layout.php');
require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jwallpapers' . DS . 'helpers' . DS . 'system.php');

JHTML::_ ( 'stylesheet', 'mod_jwnxtandprev.css', 'modules/mod_jwnxtandprev/' );

$language = & JFactory::getLanguage ();
$language->load ( 'com_jwallpapers' );

$db = & JFactory::getDBO ();


$target_new_window = $params->get ( 'target_new_window', 0 );
$columns = ( int ) $params->get ( 'thumbs_columns', 3 );
$lines = ( int ) $params->get ( 'thumbs_lines', 1 );
$thumbs_width = ( int ) $params->get ( 'thumbs_width', 0 );
$thumbs_height = ( int ) $params->get ( 'thumbs_height', 0 );
$page_class_suffix = $params->get ( 'moduleclass_sfx', '' );


$pic_id = JRequest::getInt ( 'id', 0 );


if (! $pic_id) {
	
	return;
}


$user_aro_gid = JWallpapersHelperSystem::getUserAroGroupID ();


$query = 'SELECT cat_id FROM #__jwallpapers_files WHERE id = ' . $pic_id;
$db->setQuery ( $query );
$cat_id = $db->loadResult ();


$query = 'SELECT COUNT(id) FROM #__jwallpapers_files WHERE published = 1 AND cat_id = ' . $cat_id . ' AND NOT FIND_IN_SET(' . $user_aro_gid . ',item_deny_acl)';
$db->setQuery ( $query );
$pic_count = $db->loadResult ();


$query = 'SELECT COUNT(id) FROM #__jwallpapers_files WHERE published = 1 AND cat_id = ' . $cat_id . ' AND id <= ' . $pic_id . ' AND NOT FIND_IN_SET(' . $user_aro_gid . ',item_deny_acl)';
$db->setQuery ( $query );
$pic_pos = $db->loadResult ();


$items = $columns * $lines;
$med_pos = ceil ( $items / 2 );


$sup = $items - $med_pos;
$inf = $med_pos;





if ($pic_pos < $inf) {
	
	$inf_cond = 'AND id <= ' . $pic_id . ' ORDER BY id DESC LIMIT ' . $pic_pos;
	$diff = $inf - $pic_pos;
	$sup_cond = 'AND id > ' . $pic_id . ' ORDER BY id ASC LIMIT ' . ($sup + $diff);
} elseif (($pic_count - $pic_pos) < $sup) {
	
	$sup_cond = 'AND id > ' . $pic_id . ' ORDER BY id ASC LIMIT ' . ($pic_count - $pic_pos);
	$diff = $sup - ($pic_count - $pic_pos);
	$inf_cond = 'AND id <= ' . $pic_id . ' ORDER BY id DESC LIMIT ' . ($inf + $diff);
} else {
	
	$sup_cond = 'AND id > ' . $pic_id . ' ORDER BY id ASC LIMIT ' . $sup;
	$inf_cond = 'AND id <= ' . $pic_id . ' ORDER BY id DESC LIMIT ' . $inf;
}

$query_inf = 'SELECT id, CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\':\', id, alias) ELSE id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, title, hits FROM #__jwallpapers_files WHERE cat_id = ' . $cat_id . ' AND published = 1 AND NOT FIND_IN_SET(' . $user_aro_gid . ',item_deny_acl)' . $inf_cond;
$query_sup = 'SELECT id, CASE WHEN CHAR_LENGTH(alias) THEN CONCAT_WS(\':\', id, alias) ELSE id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, title, hits FROM #__jwallpapers_files WHERE cat_id = ' . $cat_id . ' AND published = 1 AND NOT FIND_IN_SET(' . $user_aro_gid . ',item_deny_acl)' . $sup_cond;

$db->setQuery ( $query_inf );
$inf_rows = $db->loadObjectList ();

$db->setQuery ( $query_sup );
$sup_rows = $db->loadObjectList ();


$inf_rows = array_reverse ( $inf_rows );


$rows = array_merge ( $inf_rows, $sup_rows );


$layout_params = new stdClass ( );
$layout_params->thumb_li_width = floor ( 100 / $columns );

$layout_params->thumbs_width = $thumbs_width;
$layout_params->thumbs_height = $thumbs_height;



$layout_params->thumb_li_height = $thumbs_height + 6;
$layout_params->thumb_div_width = $thumbs_width + 6;


$layout_params->thumbs_title_max_length = 45;


$layout_params->show_thumb_info = 0;


$layout_params->show_thumb_title = 0;


if ($target_new_window) {
	$layout_params->target_window = 'new';
} else {
	$layout_params->target_window = 'current';
}

?>
<ul class="thumbnails_nxt_prev<?php
echo $page_class_suffix;
?>">
	
    <?php
				$i = 0;
				foreach ( $rows as $row ) {
					
					$row->link = JRoute::_ ( 'index.php?option=com_jwallpapers&id=' . $row->slug . '&view=picture' );
					$row->rating = 0;
					
					$thumb_layout = JWallpapersHelperLayout::getThumbLayout ( $row, $layout_params );
					
					
					if ($row->id == $pic_id) {
						$thumb_layout = str_replace ( '<a', '<a class="nxt_and_prev_current' . $page_class_suffix . '"', $thumb_layout );
						
						$thumb_layout = preg_replace ( '/href="(.*?)"/', '', $thumb_layout );
					}
					
					echo $thumb_layout;
					
					$i ++;
				}
				?>						
</ul>
<div class="clear_both"></div>