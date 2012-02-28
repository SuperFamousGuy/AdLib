<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.raw.php 283 2010-04-20 15:41:03Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.view' );

class JWallpapersViewPicture extends JView {
	function display($tpl = null) {
		
		global $option;
		
		$referer = JRequest::getVar ( 'referer', '' );
		
		if ($referer == 'ajaxGetCat') {
			
			require_once (JPATH_COMPONENT . DS . 'models' . DS . 'category.php');
			
			$id = JRequest::getInt ( 'id' );
			
			$catModel = & new JWallpapersModelCategory ( $id );
			$catList = $catModel->getCategoryChilds ();
			$catPath = $catModel->getPath ();
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item' );
			
			$xmlCategoryLayoutUpdate = & $xml->addChild ( 'category_layout_update' );
			
			ob_start ();
			JWallpapersHelperLayout::getCatSelectLayout ( $catList, $catPath );
			$data = ob_get_contents ();
			ob_end_clean ();
			
			$xmlCategoryLayoutUpdate->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		} elseif ($referer == 'ajaxSearchTag') {
			
			$component = JComponentHelper::getComponent ( $option );
			$params = new JParameter ( $comments->params );
			
			require_once (JPATH_COMPONENT . DS . 'models' . DS . 'tags.php'); // Since I'm invoking the model by using new instead of getModel
			$tags_model = & new JWallpapersModelTags ( );
			
			$search_string = JRequest::getString ( 'str', '' );
			$id = JRequest::getInt ( 'id', 0 );
			
			
			if (strlen ( $search_string ) >= $params->get ( 'ajax_search_min_chars' )) {
				$data = array ();
				$tags = & $tags_model->matching_tags ( $search_string );
				if (empty ( $tags )) {
					$data = '<a href="index.php?option=' . $option . '&controller=taggedpics&task=ajaxTagPicture&pic_id=' . $id . '&' . JUtility::getToken () . '=1&new_tag=' . urlencode ( $search_string ) . '" class="tag_search_result" title="' . JText::_ ( 'CLICK_NEW_TAG_PIC' ) . '">' . JText::_ ( 'CLICK_NEW_TAG_PIC' ) . '</a>';
				} else {
					foreach ( $tags as $tag ) {
						$data [] = '<a href="index.php?option=' . $option . '&controller=taggedpics&task=ajaxTagPicture&pic_id=' . $id . '&tag_id=' . $tag->id . '&' . JUtility::getToken () . '=1" class="tag_search_result" title="' . JText::_ ( 'CLICK_TAG_PIC' ) . '">' . $tag->title . '</a>';
					}
					$data = implode ( ', ', $data );
					$data = '<a href="index.php?option=' . $option . '&controller=taggedpics&task=ajaxTagPicture&pic_id=' . $id . '&' . JUtility::getToken () . '=1&new_tag=' . urlencode ( $search_string ) . '" class="tag_search_result" title="' . JText::_ ( 'CLICK_NEW_TAG_PIC' ) . '">' . JText::_ ( 'CLICK_NEW_TAG_PIC' ) . '</a> ' . JText::_ ( 'OR_SELECT_ABOVE' ) . '<br />' . $data;
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
			}
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item' );
			$ajax_tag_picture_status = & $xml->addChild ( 'ajax_tag_picture_status' );
			
			$ajax_tag_picture_status->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		} elseif ($referer == 'ajaxRemovePicTag' || $referer == 'ajaxRefreshUntagPicLayout') {
			
			$pic_id = JRequest::getInt ( 'pic_id', 0 );
			$status = JRequest::getInt ( 'status', 0 );
			
			require_once (JPATH_COMPONENT . DS . 'models' . DS . 'picture.php');
			$model = new JWallpapersModelPicture ( $pic_id );
			$pic_tags = & $model->getPicTags ();
			
			$data = JWallpapersHelperLayout::getUntagPicLayout ( $pic_tags, $pic_id );
			
			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item' );
			
			$ajax_picture_tags = & $xml->addChild ( 'ajax_picture_tags' );
			if (empty ( $data )) {
				$data = '&nbsp;';
			}
			$ajax_picture_tags->setData ( $data );
			
			if ($referer == 'ajaxRemovePicTag') {
				$ajax_untag_picture_status = & $xml->addChild ( 'ajax_untag_picture_status' );
				switch ($status) {
					case 1 :
						$ajax_untag_picture_status->setData ( 'success' );
						break;
					case 0 :
						$ajax_untag_picture_status->setData ( 'failed' );
						break;
				}
			}
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
		
		} elseif($referer == 'addResize' || $referer == 'delResize') {
			
			$model = & $this->getModel ( 'picture' );
			
			$file_resizes =& $model->getFileResizes ();

			$document = & JFactory::getDocument ();
			$document->setMimeEncoding ( 'text/xml' );
			
			$xml = new JSimpleXMLElement ( 'item' );
			
			$xmlAvailableResizesLayoutUpdate = & $xml->addChild ( 'available_resizes_layout_update' );
			ob_start ();
			JWallpapersHelperLayout::getResizeListLayout ( $file_resizes );
			$data = ob_get_contents ();
			ob_end_clean ();
			
			$xmlAvailableResizesLayoutUpdate->setData ( $data );
			
			echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
			echo $xml->toString ();
			
		}
	
	}
}
?>