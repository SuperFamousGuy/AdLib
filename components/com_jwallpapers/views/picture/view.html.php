<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: view.html.php 317 2010-05-21 11:41:27Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
jimport ( 'joomla.application.component.view' );
jimport ( 'joomla.filter.filteroutput' );

class JWallpapersViewPicture extends JView {
	
	function display($tpl = null) {
		
		global $mainframe, $option, $Itemid;
		
		
		if (! JWallpapersHelperSystem::authorize ( 'view_item' )) {
			
			$mainframe->redirect ( 'index.php', JText::_ ( 'RESTRICTED_ACCESS' ), 'notice' );
			return;
		}
		
		$user = & JFactory::getUser ();
		
		
		JHTML::_ ( 'stylesheet', 'default.css', 'components/' . $option . '/css/' );
		JHTML::_ ( 'stylesheet', 'ajaxvote.css', 'components/' . $option . '/css/' );
		
		
		$model = & $this->getModel ();
		
		$picInfo = $model->getPicInfo ();
		
		
		if (! $picInfo->published) {
			JError::raiseError ( 404, JText::_ ( "PIC_NOT_FOUND" ) );
		}
		$resizes = $model->getResizes ();
		
		
		
		
		
		
		
		$params = & JComponentHelper::getParams ( $option );
		
		$this->prepareNavigation ( $model, $params );
		
		
		$show_credits = $params->get ( 'show_credits', 1 );
		
		
		$picDate = strtotime ( $picInfo->upload_date );
		
		
		$picInfo->year = date ( 'Y', $picDate );
		$picInfo->month = date ( 'n', $picDate );
		$picInfo->name = $picInfo->file_name;
		$picInfo->ext = $picInfo->file_ext;
		
		
		
		
		
		

		
		$bigThumbPath = JPATH_BASE . DS . 'jwallpapers_files' . DS . $picInfo->year . DS . $picInfo->month;
		$bigThumb = $bigThumbPath . DS . 'big_thumb_' . $picInfo->file_name . '.jpg';
		
		$picUri = JURI::base () . 'jwallpapers_files/' . $picInfo->year . '/' . $picInfo->month . '/big_thumb_' . $picInfo->file_name . '.jpg';
		
		
		JWallpapersHelperImage::imageGenChk ( $picInfo, 'big_thumb' );
		JWallpapersHelperImage::imageGenChk ( $picInfo, 'light_thumb' );
		
		
		
		
		
		
		$fullSizePath = JURI::base () . 'jwallpapers_files/' . $picInfo->year . '/' . $picInfo->month . '/' . $picInfo->file_name . '.' . $picInfo->file_ext;
		
		$resizeOptions = & JWallpapersHelperLayout::prepareDownloadOptions ( $picInfo, $resizes, true );
		
		
		
		JPluginHelper::importPlugin ( 'jwallpapers' );
		$mainframe->triggerEvent ( 'onInitJWallpapersVMDownload' );
		$mainframe->triggerEvent ( 'onRenderJWallpapersVMDownload', array (&$resizeOptions, &$picInfo, &$resizes ) );
		
		$vm_product_link = null;
		$mainframe->triggerEvent ( 'getVMBuyProductLink', array (&$vm_product_link, 'P' ) );
		
		$cbIntegration = $params->get ( 'cb_integration' );
		$comments = $params->get ( 'comments' );
		
		
		$votes = $params->get ( 'votes' ) && $picInfo->votes_en;
		$picture_area_width = ( int ) $params->get ( 'picture_area_width' );
		$big_thumbs_width = ( int ) $params->get ( 'big_thumbs_width' );
		
		
		$picture_container_min_width = $big_thumbs_width + 12;
		
		
		
		if ($picture_area_width == 100) {
			$right_area_width = 100;
		} else {
			$right_area_width = 100 - $picture_area_width;
		}
		
		
		if ($model->uploadUserExists ()) {
			
			$user = & JUser::getInstance ( $picInfo->upload_user_id );
			$uploadUserExists = true;
		} else {
			
			$user = new stdClass ( );
			$user->username = JText::_ ( 'UNKNOWN_USER' );
			$uploadUserExists = false;
		}
		
		if ($picInfo->upload_user_id != 0) {
			
			if ($cbIntegration && $uploadUserExists) {
				$cbItemId = $params->get ( 'cb_item_id' );
				
				$upload_user = '<a href="' . JRoute::_ ( 'index.php?option=com_comprofiler&task=userProfile&user=' . $picInfo->upload_user_id . '&Itemid=' . $cbItemId ) . '">' . $user->username . '</a>';
			} else {
				$upload_user = $user->username;
			}
		} else {
			$upload_user = JText::_ ( 'GUEST' );
		}
		
		
		if ($picInfo->is_owner) {
			if ($picInfo->upload_user_id != 0 && $uploadUserExists) {
				$picture_author = $user->name;
				
				if ($cbIntegration) {
					$cb_field1 = $model->getCBfield ( $params->get ( 'cb_field1' ), $picInfo->upload_user_id );
					$cb_field2 = $model->getCBfield ( $params->get ( 'cb_field2' ), $picInfo->upload_user_id );
				}
			} else {
				
				$picture_author = JTEXT::_ ( 'UNKNOWN_AUTHOR' );
			}
		} else {
			if ($picInfo->owner != null) {
				$picture_author = $picInfo->owner;
			} else {
				$picture_author = JTEXT::_ ( 'UNKNOWN_AUTHOR' );
			}
		}
		
		
		if ($picInfo->rating == null) {
			$picInfo->rating = 0;
			$picInfo->vote_count = 0;
		}
		$ratingPercent = round ( $picInfo->rating * 100 / 5 );
		
		JWallpapersHelperLayout::prepareBreadcrumb ( $picInfo->cat_id, $picInfo->title );
		
		
		

		$metaKeywords = $picInfo->keywords; 
		
		$document = & JFactory::getDocument ();
		
		
		$sef_pic_inherit_keywords = $params->get ( 'sef_pic_inherit_keywords' );
		
		switch ($sef_pic_inherit_keywords) {
			default :
				$sef_pic_inherit_keywords = 0;
			case 0 :
				
				$document->setMetaData ( 'keywords', $metaKeywords );
				break;
			case 1 :
				
				$catRow = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
				$catRow->load ( $picInfo->cat_id );
				$document->setMetaData ( 'keywords', $catRow->keywords );
				break;
			case 2 :
				
				if (empty ( $metaKeywords )) {
					$catRow = & JTable::getInstance ( 'JWallpapers_Category', 'Table' );
					$catRow->load ( $picInfo->cat_id );
					$document->setMetaData ( 'keywords', $catRow->keywords );
				} else {
					$document->setMetaData ( 'keywords', $metaKeywords );
				}
				break;
		}
		
		
		
		$document->setTitle ( $picInfo->title );
		
		
		$filtered_description = $picInfo->description;
		
		JFilterOutput::cleanText ( $filtered_description );
		
		if (strlen ( $filtered_description ) > 160) {
			$filtered_description = substr ( $filtered_description, 0, 157 ) . '...';
		}
		
		$document->setMetaData ( 'description', $filtered_description );
		
		
		$lightbox = $params->get ( 'lightbox' );
		if ($lightbox) {
			
			$this->assign ( 'slideshow_period', $params->get ( 'slideshow_period' ) );
			
			JHTML::_ ( 'stylesheet', 'slimbox.css', 'administrator/components/' . $option . '/js/slimbox/css/' );
		}
		
		
		if ($votes) {
			
			$this->prepareRatingLinks ( $picInfo );
			
			$this->ratingsController ( $params, $picInfo );
		}
		
		
		$this->downloadController ( $params, $picInfo );
		
		$this->preparePageClassSuffixes ( $params );
		
		$this->prepareEditorsPick ( $picInfo );
		
		$this->prepareFrontendTagging ( $params, $document, $picInfo->id );
		
		
		$this->assign ( 'show_credits', $show_credits );
		$this->assign ( 'lightbox', $lightbox );
		$this->assign ( 'Itemid', $Itemid );
		$this->assignRef ( 'picInfo', $picInfo );
		$this->assignRef ( 'resizes', $resizes );
		$this->assign ( 'picDate', $picDate );
		$this->assign ( 'picUri', $picUri );
		
		$this->assign ( 'fullSizePath', $fullSizePath );
		$this->assignRef ( 'resizeOptions', $resizeOptions );
		$this->assign ( 'upload_user', $upload_user );
		$this->assign ( 'picture_author', $picture_author );
		$this->assign ( 'ratingPercent', $ratingPercent );
		$this->assign ( 'comments', $comments );
		$this->assign ( 'votes', $votes );
		$this->assign ( 'picture_area_width', $picture_area_width );
		$this->assign ( 'right_area_width', $right_area_width );
		$this->assign ( 'picture_container_min_width', $picture_container_min_width );
		$this->assign ( 'vm_product_link', $vm_product_link );
		
		
		if ($cbIntegration) {
			$this->assign ( 'cb_field1', $cb_field1 );
			$this->assign ( 'cb_field2', $cb_field2 );
		}
		
		
		parent::display ( $tpl );
	}
	
	
	
	function prepareNavigation(&$model, &$params) {
		
		global $option, $Itemid;
		
		
		
		
		
		
		$show_nav = JRequest::getInt ( 'show_nav', 1 );
		
		
		$menu_item_type = $params->get ( 'menu_item_type' );
		if (($menu_item_type == 'jw_category' || $menu_item_type == 'jw_main_gallery') && $show_nav) {
			
			$prevPic = $model->getPrevPic ();
			$nextPic = $model->getNextPic ();
			$picPos = $model->getPosition ();
			$picsInCat = $model->getTotalPicsInCat ();
			$picCat = $model->getCategory ();
			
			
			$picPos = ( int ) $picPos->pos;
			$picPos ++;
			
			$links = new stdClass ( );
			
			if ($nextPic) {
				$links->nextPic = JRoute::_ ( 'index.php?option=' . $option . '&id=' . $nextPic->slug . '&view=picture' );
			}
			
			
			if ($prevPic) {
				$links->prevPic = JRoute::_ ( 'index.php?option=' . $option . '&id=' . $prevPic->slug . '&view=picture' );
			}
			
			$pic_pos_in_cat = $picPos . ' / ' . $picsInCat . '<br/>' . JText::_ ( 'IN' ) . ' ' . $picCat;
			
			$this->assign ( 'pic_pos_in_cat', $pic_pos_in_cat );
			$this->assign ( 'picPos', $picPos );
			$this->assign ( 'picsInCat', $picsInCat );
			$this->assignRef ( 'links', $links );
			$this->assign ( 'show_navigation', 1 );
		} else {
			
			
			
			
			@$referer = $_SERVER ['HTTP_REFERER'];
			if (! empty ( $referer )) {
				$this->assign ( 'go_back_link', '<a class="go_back" href="' . $referer . '">' . JText::_ ( 'GO_BACK' ) . '</a>' );
			}
			
			$picPos = $model->getPosition ();
			
			$picPos = ( int ) $picPos->pos;
			$picPos ++;
			
			
			
			
			$this->assign ( 'picsInCat', 1 );
			$this->assign ( 'picPos', $picPos );
			$this->assign ( 'show_navigation', 0 );
			$this->assign ( 'pic_pos_in_cat', '' );
		
		}
	
	}
	
	
	function preparePageClassSuffixes(&$params) {
		
		
		$page_class_suffix = $this->escape ( $params->get ( 'pageclass_sfx' ) );
		If (! empty ( $page_class_suffix )) {
			$class_suffix = $page_class_suffix;
			
			$id_class = 'class="' . $page_class_suffix . '"';
		} else {
			$class_suffix = '';
			$id_class = '';
		}
		
		$this->assign ( 'class_suffix', $class_suffix );
		$this->assign ( 'id_class', $id_class );
	
	}
	
	
	function downloadController(&$params, &$picInfo) {
		
		
		$this_user = & JFactory::getUser ();
		
		
		if (! JWallpapersHelperSystem::authorize ( 'download' )) {
			$this->assign ( 'showDownload', false );
		} else {
			$this->assign ( 'showDownload', true );
		}
		
		
		
		$this->assign ( 'disable_downloads', $params->get ( 'disable_downloads' ) || ! $picInfo->downloadable );
	
	}
	
	
	function prepareRatingLinks(&$picInfo) {
		
		global $option;
		
		
		
		$token = '&' . JUtility::getToken () . '=1';
		$basicRoute = 'index.php?option=' . $option;
		$rating_links = array ();
		
		for($i = 1; $i <= 5; $i ++) {
			$rating_links [$i] = $basicRoute . '&task=vote&value=' . $i . '&id=' . $picInfo->id . $token;
		}
		
		$this->assignRef ( 'rating_links', $rating_links );
	
	}
	
	
	function ratingsController(&$params, &$picInfo) {
		
		global $mainframe, $option;
		
		
		$auth_vote_status = 1;
		
		
		$mainframe->triggerEvent ( 'onInitJWallpapersVote' );
		
		
		
		$mainframe->triggerEvent ( 'onPrepareJWallpapersVote', array (&$auth_vote_status ) );
		
		
		if (! JWallpapersHelperSystem::authorize ( 'vote' )) {
			$this->assign ( 'isUserVoteAllowed', false );
		} else {
			$this->assign ( 'isUserVoteAllowed', true );
		}
		
		
		$session = & JFactory::getSession ();
		$cantVoteIds = $session->get ( 'vote', array (), $option );
		
		if (in_array ( $picInfo->id, $cantVoteIds ) || ! $auth_vote_status) {
			$this->assign ( 'userAlreadyVoted', true );
		} else {
			$this->assign ( 'userAlreadyVoted', false );
		}
	
	}
	
	
	function prepareEditorsPick(&$pic_info) {
		
		global $option;
		
		if ($pic_info->tag_ep) {
			$editors_pick_layout = '<div id="editors_pick_container"><div class="editors_pick">' . JText::_ ( 'EDITORS_PICK' ) . '</div></div>';
		} else {
			$editors_pick_layout = '<div id="editors_pick_container"></div>';
		}
		
		$this->assign ( 'editors_pick_layout', $editors_pick_layout );
		
		$this_user = & JFactory::getUser ();
		if ($this_user->gid == 25) {
			$editors_pick_admin_layout = '<div id="editors_pick_admin_container">';
			$url = 'index.php?option=' . $option;
			
			if (! $pic_info->tag_ep) {
				$editors_pick_admin_layout .= '<a class="tag_editors_pick tag_untag_ep" href=\'' . $url . '&task=tag_untag_ep&action=tag&id=' . $pic_info->id . '\'>' . JText::_ ( 'TAG_EDITORS_PICK' ) . '</a>';
			} else {
				$editors_pick_admin_layout .= '<a class="untag_editors_pick tag_untag_ep" href=\'' . $url . '&task=tag_untag_ep&action=untag&id=' . $pic_info->id . '\'>' . JText::_ ( 'UNTAG_EDITORS_PICK' ) . '</a>';
			}
			$editors_pick_admin_layout .= '</div>';
			$this->assign ( 'editors_pick_admin_layout', $editors_pick_admin_layout );
		}
	}
	
	function prepareFrontendTagging(&$params, &$document, $pic_id) {
		
		global $option;
		
		$frontend_tagging = $params->get ( 'frontend_tagging' );
		$frontend_show_pic_tags = $params->get ( 'frontend_show_pic_tags' );
		$moderate_frontend_tagging = $params->get ( 'moderate_frontend_tagging' );
		
		
		
		$user = & JFactory::getUser ();
		if ($user->gid == 25) {
			$frontend_tagging = 1;
			$moderate_frontend_tagging = 0;
		}
		
		
		if ($frontend_tagging) {
			$layout = '<div id="frontend_tagging_section">';
			$layout .= '<h3>' . JText::_ ( 'TAG_THIS_PIC' ) . '</h3>';
			
			if (! JWallpapersHelperSystem::authorize ( 'tagging' )) {
				
				$layout .= '<h4>' . JText::_ ( 'TAGGING_NOT_AUTHORIZED' ) . '</h4>';
			} else {
				
				if ($moderate_frontend_tagging) {
					$jwallpapers_pic_tagged = JText::_ ( 'PIC_TAGGED_MODERATE' );
				} else {
					$jwallpapers_pic_tagged = JText::_ ( 'PIC_TAGGED' );
				}
				
				$js = 'var jwallpapers_tagging_pic = "' . JText::_ ( 'TAGGING_PIC' ) . '";
			var jwallpapers_pic_tagged = "' . $jwallpapers_pic_tagged . '";
			var jwallpapers_pic_tag_failed = "' . JText::_ ( 'PIC_TAG_FAILED' ) . '";
			var jwallpapers_pic_tag_exists = "' . JText::_ ( 'PIC_TAG_EXISTS' ) . '";
			var jwallpapers_pic_tag_captcha = "' . JText::_ ( 'PIC_TAG_CAPTCHA' ) . '";
			var jwallpapers_pic_id = ' . $pic_id . ';';
				
				$document->addScriptDeclaration ( $js );
				$document->addScript ( 'administrator/components/' . $option . '/js/ajaxFrontendTag.js' );
				
				$layout .= JWallpapersHelperLayout::getSearchTagLayout ( array ('\'frontendAjaxTagFiles();\'' ), $params );
				
				
				if (JWallpapersHelperSystem::showCaptcha ()) {
					$document->addScript ( 'administrator/components/' . $option . '/js/ajaxCaptcha.js' );
					$layout .= '<div id="frontend_captcha">';
					$layout .= '<div style="width: 120px; height: 60px;" id="captchaImage">';
					$layout .= '<img src="administrator/components/' . $option . '/kcaptcha/index.php" />';
					$layout .= '</div>';
					$layout .= '<a href="#" onClick="refreshCaptcha(); return false;">';
					$layout .= '<image src="components/' . $option . '/images/default/icons/recur.png" alt="refresh" title="Refresh" /></a>';
					$layout .= '<input id="captcha_string" type="text" name="captcha_string" value="" />';
					$layout .= '</div>';
				}
				
				$layout .= '<div id="tag_pic_status"></div>';
			
			}
			$layout .= '</div>';
		}
		
		
		if ($frontend_show_pic_tags) {
			
			
			
			if ($frontend_tagging) {
				$layout .= '<div id="pic_tags_section">';
			} else {
				$layout = '<div style="width: 100%;" id="pic_tags_section">';
			}
			$layout .= '<h3>' . JText::_ ( 'PIC_TAGS' ) . '</h3>';
			$model = & $this->getModel ();
			$tags = & $model->getPicTags ();
			$layout .= '<div id="pic_tags">';
			if (! empty ( $tags )) {
				$layout .= JWallpapersHelperLayout::getTagCloud ( $tags, true );
			} else {
				$layout .= '<h4>' . JText::_ ( 'NO_PIC_TAGS' ) . '</h4>';
			}
			$layout .= '</div></div>';
		}
		
		if ($frontend_tagging || $frontend_show_pic_tags) {
			
			$layout .= '<div class="clear_both"></div>';
			$this->assignRef ( 'frontend_tagging_layout', $layout );
		}
	
	}

}
?>