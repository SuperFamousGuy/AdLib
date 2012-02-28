<?php
/**
 * JWallpapers Newest module - A module to display the newest JWallpapers pictures
 * 
 * @version 1.4 $Id: mod_jwnewest.php 353 2010-06-01 10:04:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jwallpapers' . DS . 'helpers' . DS . 'layout.php');
require_once (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_jwallpapers' . DS . 'helpers' . DS . 'system.php');

JHTML::_ ( 'stylesheet', 'default.css', 'components/com_jwallpapers/css/' );

$language = & JFactory::getLanguage ();
$language->load ( 'com_jwallpapers' );

$db = & JFactory::getDBO ();


$menu_id = ( int ) $params->get ( 'menu_id', 0 );
$category_ids = ( int ) $params->get ( 'category_ids', 0 );
$target_new_window = $params->get ( 'target_new_window', 0 );
$show_thumb_info = $params->get ( 'show_thumb_info', 0 );
$show_thumb_title = $params->get ( 'show_thumb_title', 1 );
$columns = ( int ) $params->get ( 'thumbs_columns', 3 );
$lines = ( int ) $params->get ( 'thumbs_lines', 1 );
$show_more_pics = $params->get ( 'show_more_pics', 1 );
$more_pics = $params->get ( 'more_pics', 'More pics ...' );


$thumbs_width = ( int ) $params->get ( 'thumbs_width', 0 );
$thumbs_height = ( int ) $params->get ( 'thumbs_height', 0 );
$thumbs_wrapper_height_mod = ( int ) $params->get ( 'thumbs_wrapper_height_mod', 90 );
$thumbs_wrapper_width_mod = ( int ) $params->get ( 'thumbs_wrapper_width_mod', 14 );
$page_class_suffix = $params->get ( 'moduleclass_sfx', '' );
$page_id_class_suffix = 'class="' . $page_class_suffix . '"';


$category_ids = JWallpapersHelperSystem::filterIdList ( $category_ids );


if ($category_ids) {
	$where_cat_cond = ' AND cat_id IN (' . $category_ids . ')';
} else {
	$where_cat_cond = '';
}


$com_params = & JComponentHelper::getParams ( 'com_jwallpapers' );
$acl_show_restricted_picture = $com_params->get ( 'acl_show_restricted_picture', 1 );


$user_aro_gid = JWallpapersHelperSystem::getUserAroGroupID ();


if ($acl_show_restricted_picture) {
	
	$filter_restricted_pics_cond = '';
} else {
	
	$filter_restricted_pics_cond = ' AND NOT FIND_IN_SET(' . $user_aro_gid . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END)';
}

$items = $columns * $lines;
$query = 'SELECT t1.id, CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t3.item_deny_acl END AS item_deny_acl, tag_ep, CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext, t1.title, t1.hits, average AS rating FROM #__jwallpapers_files AS t1 LEFT JOIN #__jwallpapers_votes_cache AS t2 ON t1.id = t2.file_id INNER JOIN #__jwallpapers_categories AS t3 ON t1.cat_id = t3.id WHERE t3.published = 1' . $where_cat_cond . $filter_restricted_pics_cond . ' AND t1.published = 1 ORDER BY upload_date DESC';
$db->setQuery ( $query, 0, $items );
$rows = $db->loadObjectList ();


$layout_params = new stdClass ( );
$layout_params->thumb_li_width = floor ( 100 / $columns );

if (empty ( $thumbs_width ) && empty ( $thumbs_height )) {
	
	$thumbs_width = ( int ) $com_params->get ( 'small_thumbs_width' );
	$thumbs_height = ( int ) $com_params->get ( 'small_thumbs_height' );
} else {
	
	
	$layout_params->thumbs_width = $thumbs_width;
	$layout_params->thumbs_height = $thumbs_height;
}



$layout_params->thumb_li_height = $thumbs_height + $thumbs_wrapper_height_mod;


$layout_params->thumb_div_width = $thumbs_width + $thumbs_wrapper_width_mod;


$layout_params->thumbs_title_max_length = ( int ) abs ( $com_params->get ( 'thumbs_title_max_length', 45 ) );


$layout_params->show_thumb_info = $show_thumb_info;


$layout_params->show_thumb_title = $show_thumb_title;


if ($target_new_window) {
	$layout_params->target_window = 'new';
} else {
	$layout_params->target_window = 'current';
}

$itemid_url = (empty ( $menu_id )) ? '' : '&Itemid=' . $menu_id;

?>
<div class="jw_thumb_container<?php
echo $page_class_suffix;
?>">
<ul class="thumbnails<?php
echo $page_class_suffix;
?>">
	
    <?php
				$i = 0;
				foreach ( $rows as $row ) {
					
					$row->link = JRoute::_ ( 'index.php?option=com_jwallpapers&id=' . $row->slug . '&view=picture' . $itemid_url );
					if ($row->rating == null) {
						$row->rating = 0;
					}
					echo JWallpapersHelperLayout::getThumbLayout ( $row, $layout_params );
					$i ++;
				}
				?>						
</ul>
</div>
<div class="clear_both"></div>
<?php

if ($show_more_pics) {
	
	
	
	
	
	if ($menu_id) {
		$viewMoreLink = 'index.php?Itemid=' . $menu_id;
	} else {
		$newestString = JFilterOutput::stringURLSafe ( JText::_ ( 'NEWEST' ) );
		$viewMoreLink = 'index.php?option=com_jwallpapers&view=special&id=2:' . $newestString;
	}
	
	
	if ($target_new_window) {
		$target_html = 'target="_blank"';
	} else {
		$target_html = '';
	}
	
	?>
<div class="jw_mod_more_pics<?php
	echo $page_class_suffix;
	?>">
<center><?php
	echo '<a href="' . JRoute::_ ( $viewMoreLink ) . '" ' . $target_html . '>' . $more_pics . '</a>';
	?>
	</center>
</div>
<?php
}
?>
