<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.raw.php 350 2010-05-31 14:28:19Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport ( 'joomla.application.component.view' );
jimport ( 'joomla.utilities.simplexml' );

class JWallpapersViewPicture extends JView {
	
	function display() {
		
		global $option;
		
		$referer = JRequest::getVar ( 'referer', '' );
		
		if ($referer == 'ajaxGetPicsFromCat') {
			
			
			
			

			$pic_id = JRequest::getInt ( 'id', 0 );
			$cat_id = JRequest::getInt ( 'cat_id', 0 );
			
			$pic_row = JTable::getInstance ( 'JWallpapers_file', 'Table' );
			$cat_row = JTable::getInstance ( 'JWallpapers_category', 'Table' );
			
			
			if ($pic_id == 0 || $cat_id == 0 || ! $pic_row->exists ( $pic_id ) || ! $cat_row->exists ( $cat_id )) {
				die ( 'Invalid data' );
			}
			
			$db = & JFactory::getDBO ();
			
			
			$query = 'SELECT #__jwallpapers_files.id AS id, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name FROM #__jwallpapers_files WHERE cat_id = ' . $cat_id . '  AND #__jwallpapers_files.published = 1 ORDER BY id';
			$db->setQuery ( $query );
			
			$pics = $db->loadObjectList ();
			
			
			$jw_imageArray = '[';
			
			$i = 0;
			
			$jw_startImage = 0;
			
			foreach ( $pics as $pic ) {
				
				if ($i != 0) {
					$jw_imageArray .= ',';
				}
				
				$img_href = 'jwallpapers_files/' . $pic->year . '/' . $pic->month . '/light_thumb_' . $pic->name . '.jpg';
				
				

				
				if ($pic->id == $pic_id) {
					$jw_startImage = $i;
				}
				
				
				
				$jw_imageArray .= '["' . $img_href . '"]';
				
				$i ++;
			
			}
			
			$jw_imageArray .= ']';
			
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item', array ('category' => $cat_id ) );
			$xmlImagesArray = & $xml->addChild ( 'images_array' );
			$xmlStartImage = & $xml->addChild ( 'start_image' );
			
			$xmlImagesArray->setData ( $jw_imageArray );
			
			$xmlStartImage->setData ( $jw_startImage + 1 );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		} elseif ($referer == 'ajaxGetImageUrl') {
			
			
			
			

			$user_aro_group = JWallpapersHelperSystem::getUserAroGroupID ();
			
			
			$pic_pos = JRequest::getInt ( 'pos', 0 );
			$cat_id = JRequest::getInt ( 'cat_id', 0 );
			$pics_count = JRequest::getInt ( 'pics_count', 0 );
			$item_id = JRequest::getInt ( 'item_id', 0 );
			
			$pic_row = JTable::getInstance ( 'JWallpapers_file', 'Table' );
			$cat_row = JTable::getInstance ( 'JWallpapers_category', 'Table' );
			
			
			if ($cat_id == 0 || ! $cat_row->exists ( $cat_id ) || $pics_count == 0) {
				die ( 'Invalid data' );
			}
			
			$db = & JFactory::getDBO ();
			
			
			$pic_file = array ('previous' => 'null', 'active' => 'null', 'next' => 'null' );
			
			
			
			
			
			
			
			

			switch ($pics_count) {
				case 1 :
					
					$query = 'SELECT CASE WHEN CHAR_LENGTH(#__jwallpapers_files.alias) THEN CONCAT_WS(\':\', #__jwallpapers_files.id, #__jwallpapers_files.alias) ELSE #__jwallpapers_files.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext FROM #__jwallpapers_files WHERE #__jwallpapers_files.cat_id = ' . $cat_id . ' AND #__jwallpapers_files.published = 1 ORDER BY id LIMIT ' . $pic_pos . ',1';
					$current_scenario = 1;
					break;
				default :
					if ($pic_pos == 0) {
						
						
						$query = 'SELECT CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id WHERE cat_id = ' . $cat_id . ' AND t1.published = 1 AND NOT FIND_IN_SET(' . $user_aro_group . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END) ORDER BY t1.id LIMIT ' . $pic_pos . ',2';
						$current_scenario = 2;
					} elseif ($pic_pos == $pics_count - 1) {
						
						
						$query = 'SELECT CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id WHERE cat_id = ' . $cat_id . ' AND t1.published = 1 AND NOT FIND_IN_SET(' . $user_aro_group . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END) ORDER BY t1.id LIMIT ' . ($pic_pos - 1) . ',2';
						$current_scenario = 3;
					} else {
						
						$query = 'SELECT CASE WHEN CHAR_LENGTH(t1.alias) THEN CONCAT_WS(\':\', t1.id, t1.alias) ELSE t1.id END AS slug, MONTH(upload_date) AS month, YEAR(upload_date) AS year, file_name AS name, file_ext AS ext FROM #__jwallpapers_files AS t1 INNER JOIN #__jwallpapers_categories AS t2 ON t1.cat_id = t2.id WHERE cat_id = ' . $cat_id . ' AND t1.published = 1 AND NOT FIND_IN_SET(' . $user_aro_group . ',CASE WHEN CHAR_LENGTH(t1.item_deny_acl) THEN t1.item_deny_acl ELSE t2.item_deny_acl END) ORDER BY t1.id LIMIT ' . ($pic_pos - 1) . ',3';
						$current_scenario = 4;
					}
					break;
			
			}
			
			

			$db->setQuery ( $query );
			
			switch ($current_scenario) {
				case 1 :
					$pic_info = $db->loadObjectList ();
					$pic_url = str_replace ( '&amp;', '&', JRoute::_ ( 'index.php?option=' . $option . '&view=picture&id=' . $pic_info [0]->slug . '&Itemid=' . $item_id ) );
					$pic_file ['active'] = 'jwallpapers_files/' . $pic_info [0]->year . '/' . $pic_info [0]->month . '/light_thumb_' . $pic_info [0]->name . '.jpg';
					break;
				case 2 :
					$pic_info = $db->loadObjectList ();
					
					$pic_url = str_replace ( '&amp;', '&', JRoute::_ ( 'index.php?option=' . $option . '&view=picture&id=' . $pic_info [0]->slug . '&Itemid=' . $item_id ) );
					$pic_file ['active'] = 'jwallpapers_files/' . $pic_info [0]->year . '/' . $pic_info [0]->month . '/light_thumb_' . $pic_info [0]->name . '.jpg';
					$pic_file ['next'] = 'jwallpapers_files/' . $pic_info [1]->year . '/' . $pic_info [1]->month . '/light_thumb_' . $pic_info [1]->name . '.jpg';
					break;
				case 3 :
					$pic_info = $db->loadObjectList ();
					
					$pic_url = str_replace ( '&amp;', '&', JRoute::_ ( 'index.php?option=' . $option . '&view=picture&id=' . $pic_info [1]->slug . '&Itemid=' . $item_id ) );
					$pic_file ['previous'] = 'jwallpapers_files/' . $pic_info [0]->year . '/' . $pic_info [0]->month . '/light_thumb_' . $pic_info [0]->name . '.jpg';
					$pic_file ['active'] = 'jwallpapers_files/' . $pic_info [1]->year . '/' . $pic_info [1]->month . '/light_thumb_' . $pic_info [1]->name . '.jpg';
					break;
				case 4 :
					$pic_info = $db->loadObjectList ();
					
					$pic_url = str_replace ( '&amp;', '&', JRoute::_ ( 'index.php?option=' . $option . '&view=picture&id=' . $pic_info [1]->slug . '&Itemid=' . $item_id ) );
					$pic_file ['previous'] = 'jwallpapers_files/' . $pic_info [0]->year . '/' . $pic_info [0]->month . '/light_thumb_' . $pic_info [0]->name . '.jpg';
					$pic_file ['active'] = 'jwallpapers_files/' . $pic_info [1]->year . '/' . $pic_info [1]->month . '/light_thumb_' . $pic_info [1]->name . '.jpg';
					$pic_file ['next'] = 'jwallpapers_files/' . $pic_info [2]->year . '/' . $pic_info [2]->month . '/light_thumb_' . $pic_info [2]->name . '.jpg';
					break;
			}
			
			
			foreach ( $pic_info as $item ) {
				JWallpapersHelperImage::imageGenChk ( $item, 'light_thumb' );
			}
			
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item', array ('pos_category' => $pic_pos . '_' . $cat_id ) );
			$xmlActiveImageUrl = & $xml->addChild ( 'active_image_url' );
			$xmlPreviousImageFile = & $xml->addChild ( 'previous_image_file' );
			$xmlActiveImageFile = & $xml->addChild ( 'active_image_file' );
			$xmlNextImageFile = & $xml->addChild ( 'next_image_file' );
			
			$xmlActiveImageUrl->setData ( $pic_url );
			$xmlPreviousImageFile->setData ( $pic_file ['previous'] );
			$xmlActiveImageFile->setData ( $pic_file ['active'] );
			$xmlNextImageFile->setData ( $pic_file ['next'] );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		} elseif ($referer == 'vote') {
			
			
			

			$model = & $this->getModel ();
			
			$picInfo = $model->getPicInfo ();
			
			
			$ratingPercent = round ( $picInfo->rating * 100 / 5 );
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item', array ('picture' => $picInfo->id ) );
			
			$xmlRatingStarsUpdate = & $xml->addChild ( 'rating_stars_update' );
			$xmlRatingCountUpdate = & $xml->addChild ( 'rating_count_update' );
			$xmlVerboseRatingUpdate = & $xml->addChild ( 'rating_verbose_update' );
			
			
			$data1 = '<li id="rating" class="current-rating" style="width:' . $ratingPercent . '%"></li>';
			$xmlRatingStarsUpdate->setData ( $data1 );
			
			$data2 = '(' . $picInfo->vote_count . ' ' . JText::_ ( 'VOTES' ) . ')';
			$xmlRatingCountUpdate->setData ( $data2 );
			
			$data3 = '<p>' . JText::_ ( 'RATING' ) . ': ' . $picInfo->rating . ' / 5.00</p>';
			$xmlVerboseRatingUpdate->setData ( $data3 );
			
			$session = & JFactory::getSession (); 
			$cantVoteIds = $session->get ( 'vote', array (), $option );
			array_push ( $cantVoteIds, $picInfo->id );
			$session->set ( 'vote', $cantVoteIds, $option );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
			
		
		

		} elseif ($referer == 'tag_untag_ep') {
			
			$action = JRequest::getVar ( 'action' );
			$id = JRequest::getInt ( 'id', 0 );
			
			$url = 'index.php?option=' . $option;
			
			switch ($action) {
				case 'tag' :
					$editors_picks_layout = '<div class="editors_pick">' . JText::_ ( 'EDITORS_PICK' ) . '</div>';
					$editors_pick_admin_layout = '<a class="tag_editors_pick tag_untag_ep" href=\'' . $url . '&task=tag_untag_ep&action=untag&id=' . $id . '\'>' . JText::_ ( 'UNTAG_EDITORS_PICK' ) . '</a>';
					break;
				case 'untag' :
					$editors_picks_layout = 'null';
					$editors_pick_admin_layout = '<a class="tag_editors_pick tag_untag_ep" href=\'' . $url . '&task=tag_untag_ep&action=tag&id=' . $id . '\'>' . JText::_ ( 'TAG_EDITORS_PICK' ) . '</a>';
					break;
				default :
					die ();
					break;
			}
			
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item', array ('picture' => $id ) );
			
			$xml_editors_pick_layout_update = & $xml->addChild ( 'editors_pick_layout_update' );
			$xml_editors_pick_admin_layout_update = & $xml->addChild ( 'editors_pick_admin_layout_update' );
			
			$xml_editors_pick_layout_update->setData ( $editors_picks_layout );
			$xml_editors_pick_admin_layout_update->setData ( $editors_pick_admin_layout );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		} elseif ($referer == 'ajaxSearchTag') {
			
			$params = & JComponentHelper::getParams ( $option );
			
			
			require_once (JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $option . DS . 'models' . DS . 'tags.php');
			
			$tags_model = new JWallpapersModelTags ( );
			
			
			$id = JRequest::getInt ( 'id', 0 );
			
			$search_string = JRequest::getString ( 'str', '' );
			
			
			if (strlen ( $search_string ) >= $params->get ( 'ajax_search_min_chars' )) {
				$data = array ();
				$tags = & $tags_model->matching_tags ( $search_string );
				
				
				$user = & JFactory::getUser ();
				$frontend_tag_proposal = $params->get ( 'frontend_tag_proposal' );
				if ($user->gid == 25) {
					$frontend_tag_proposal = 1;
				}
				
				if (empty ( $tags )) {
					
					if ($frontend_tag_proposal) {
						$data = '<a href="index.php?option=' . $option . '&task=ajaxTagPicture&pic_id=' . $id . '&' . JUtility::getToken () . '=1&new_tag=' . urlencode ( $search_string ) . '" class="tag_search_result" title="' . JText::_ ( 'CLICK_TAG_PIC' ) . '">' . JText::_ ( 'CLICK_TAG_PIC' ) . '</a>';
					} else {
						
						
						$data = '<span>' . JText::_ ( 'TAG_NOT_FOUND' ) . '</span>';
					}
				} else {
					foreach ( $tags as $tag ) {
						$data [] = '<a href="index.php?option=' . $option . '&task=ajaxTagPicture&pic_id=' . $id . '&tag_id=' . $tag->id . '&' . JUtility::getToken () . '=1" class="tag_search_result" title="' . JText::_ ( 'CLICK_TAG_PIC' ) . '">' . $tag->title . '</a>';
					}
					$data = implode ( ', ', $data );
					if ($frontend_tag_proposal) {
						$data = '<a href="index.php?option=' . $option . '&task=ajaxTagPicture&pic_id=' . $id . '&' . JUtility::getToken () . '=1&new_tag=' . urlencode ( $search_string ) . '" class="tag_search_result" title="' . JText::_ ( 'CLICK_NEW_TAG_PIC' ) . '">' . JText::_ ( 'CLICK_NEW_TAG_PIC' ) . '</a> ' . JText::_ ( 'OR_SELECT_ABOVE' ) . '<br />' . $data;
					}
				}
			}
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item' );
			$ajax_tag_search_result = & $xml->addChild ( 'ajax_tag_search_result' );
			
			if (empty ( $data )) {
				$data = '&nbsp;';
			}
			
			$ajax_tag_search_result->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		} elseif ($referer == 'ajaxTagPicture') {
			
			$status = JRequest::getVar ( 'status' );
			
			switch ($status) {
				case 1 :
					$data = 'success';
					break;
				case - 1 :
					$data = 'failed';
					break;
				case 0 :
					$data = 'exists';
					break;
				case - 2 :
					$data = 'captcha';
					break;
			}
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item' );
			$ajax_tag_picture_status = & $xml->addChild ( 'ajax_tag_picture_status' );
			
			$ajax_tag_picture_status->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		} elseif ($referer == 'ajaxRefreshPicTagsLayout') {
			
			$pic_id = JRequest::getInt ( 'pic_id', 0 );
			
			require_once (JPATH_COMPONENT . DS . 'models' . DS . 'picture.php');
			
			$model = new JWallpapersModelPicture ( $pic_id );
			
			$tags = & $model->getPicTags ();
			
			$data = JWallpapersHelperLayout::getTagCloud ( $tags, true );
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item' );
			$ajax_picture_tags = & $xml->addChild ( 'ajax_picture_tags' );
			
			$ajax_picture_tags->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		}
	
	}
}

?>
