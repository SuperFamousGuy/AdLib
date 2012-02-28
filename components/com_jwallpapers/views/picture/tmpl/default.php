<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: default.php 317 2010-05-21 11:41:27Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );

JHTML::_ ( 'behavior.mootools' );

$js = 'var jwallpapers_option = "' . $option . '";
var jwallpapers_userAlreadyVotedMessage = "' . JText::_ ( 'ALREADY_VOTE' ) . '";
var jwallpapers_isUserVoteAllowedMessage = "' . JText::_ ( 'VOTES_NOT_AUTHORIZED' ) . '";
var jwallpapers_joomla_base_url = "' . JURI::base () . '";
var jwallpapers_is_user_voting = false;';

$document = & JFactory::getDocument ();

$document->addScript ( 'administrator/components/' . $option . '/js/downloadResizes.js' );

$lightbox_link_attrs = '';

if ($this->lightbox) {
	
	$js .= 'var jwallpapers_pic_id = ' . $this->picInfo->id . ';
	var jwallpapers_cat_id = ' . $this->picInfo->cat_id . ';
	var jwallpapers_pic_pos = ' . $this->picPos . ';
	var jwallpapers_pics_count = ' . $this->picsInCat . ';
	var jwallpapers_item_id = ' . $this->Itemid . ';
	var jwallpapers_slideshow_period = ' . $this->slideshow_period . ';';
	
	
	$lightbox_link_attrs = 'href="#" class="slimshow"';
	
	$document->addScript ( 'administrator/components/' . $option . '/js/slimbox/jw_slimbox_loader.js' );
	$document->addScript ( 'administrator/components/' . $option . '/js/slimbox/js/slimbox.js' );

}

$document->addScriptDeclaration ( $js );


if (isset ( $this->editors_pick_admin_layout )) {
	echo $this->editors_pick_admin_layout;
	$document->addScript ( 'administrator/components/' . $option . '/js/ajaxTagUntagEP.js' );
}

if (! $this->show_navigation && isset ( $this->go_back_link )) {
	echo $this->go_back_link;
}

?>
<div id="picture_container" <?php
echo $this->id_class;
?> style="width: <?php
echo ($this->picture_area_width > 100) ? 100 : $this->picture_area_width;
?>%; min-width: <?php
echo $this->picture_container_min_width?>px;"><!-- LEFT START -->
  <?php
		echo '<div class="big_thumb' . $this->class_suffix . '"><a ' . $lightbox_link_attrs . '><img alt="' . htmlspecialchars ( $this->picInfo->title, ENT_QUOTES ) . '" src="' . $this->picUri . '" />' . $this->pic_pos_in_cat . '</a></div>';
		?> 
<?php
if ($this->show_navigation) {
	?>
  <div class="navigation<?php
	echo $this->class_suffix;
	?>">
    <?php
	echo '<div class="nav_left' . $this->class_suffix . '">';
	if (isset ( $this->links->prevPic )) {
		echo '<a class="not_nav_limit_left' . $this->class_suffix . '" href="' . $this->links->prevPic . '" title="' . htmlspecialchars ( JText::_ ( 'PREVIOUS' ), ENT_QUOTES ) . '"></a>';
	} else {
		echo '<a class="nav_limit_left' . $this->class_suffix . '"></a>';
	}
	echo '</div>';
	echo '<div class="nav_right' . $this->class_suffix . '">';
	if (isset ( $this->links->nextPic )) {
		echo '<a class="not_nav_limit_right' . $this->class_suffix . '" href="' . $this->links->nextPic . '" title="' . htmlspecialchars ( JText::_ ( 'NEXT' ), ENT_QUOTES ) . '"></a>';
	} else {
		echo '<a class="nav_limit_right' . $this->class_suffix . '"></a>';
	}
	echo '</div>';
	
	

	
	
	

	?>
    <div class="clear_both"></div>
</div>
<?php
}
?>



<div class="resizes<?php
echo $this->class_suffix;
?>">
<form name="resizes_form" class="form<?php
echo $this->class_suffix;
?>">
<fieldset
	class="download_options_fieldset<?php
	echo $this->class_suffix;
	?>">
<?php

if (! $this->disable_downloads) {
	
	if ($this->showDownload) {
		
		if (! empty ( $this->resizeOptions )) {
			?>
<label for="resizes_box"><?php
			echo JText::_ ( 'AVAILABLE_RESOLUTIONS' );
			?></label> <select id="resizes_box" name="by_resolution"
	class="download_options_select<?php
			echo $this->class_suffix;
			?>">
	  <?php
			foreach ( $this->resizeOptions as $resizeOption ) {
				echo $resizeOption;
			}
			?>  
	</select> <input type="button"
	value="<?php
			echo htmlspecialchars ( JText::_ ( 'DOWNLOAD' ), ENT_QUOTES );
			?>"
	class="download_options_button<?php
			echo $this->class_suffix;
			?>"
	onClick="downloadResizes(this.form,jwallpapers_joomla_base_url);"></input>
	<?php
		} else {
			
			echo '<h4>' . JText::_ ( 'NO_DOWNLOAD_PRIVILEGES' ) . '</h4>';
		}
	} else {
		
		echo '<h4>' . JText::_ ( 'DOWNLOADS_NOT_AUTHORIZED' ) . '</h4>';
	}
	
	
	if (! empty ( $this->vm_product_link )) {
		echo '<div class="vm_product_link' . $this->class_suffix . '"><a class="vm_product_link' . $this->class_suffix . '" href="' . $this->vm_product_link . '" title="' . htmlspecialchars ( JText::_ ( 'BUY_VM_PIC_PRODUCT' ), ENT_QUOTES ) . '">' . JText::_ ( 'BUY_VM_PIC_PRODUCT' ) . '</a></div>';
	}

}
?>

</fieldset>
</form>
</div>
</div>
<!-- LEFT END -->
<?php


if ($this->right_area_width > 0) {
	
	?>
<div id="picture_right_content" <?php
	echo $this->id_class;
	?> style="width: <?php
	echo $this->right_area_width;
	?>%;"><!-- RIGHT START -->
<div
	class="picture_right_content_elements<?php
	echo $this->class_suffix;
	?>">
<div id="picture_info" <?php
	echo $this->id_class;
	?>>
<h2><?php
	echo $this->picInfo->title;
	?></h2>
<span class="small<?php
	echo $this->class_suffix;
	?>"><?php
	echo JText::_ ( 'CREATED_BY' ) . " " . $this->picture_author;
	
	
	
	if (isset ( $this->cb_field1 )) {
		echo '<span class="jw_cb_field' . $this->class_suffix . '">' . $this->cb_field1 . '</span>';
	}
	
	if (isset ( $this->cb_field2 )) {
		echo '<span class="jw_cb_field' . $this->class_suffix . '">' . $this->cb_field2 . '</span>';
	}
	?></span>
	<?php
	echo $this->editors_pick_layout;
	?>
<ul class="bullet-d<?php
	echo $this->class_suffix;
	?>">
	<li><?php
	echo JText::_ ( 'UPLOADED_BY' ) . " " . $this->upload_user;
	?><br />
    <?php
	echo JHTML::date ( $this->picDate );
	?></li>
	<li><?php
	echo JText::_ ( 'RESOLUTION' ) . ": " . $this->picInfo->width . "x" . $this->picInfo->height;
	?></li>
	<li><?php
	echo JText::_ ( 'HITS' ) . ": " . $this->picInfo->hits;
	?></li>
</ul>
  <?php
	if ($this->picInfo->description) {
		?>
  <div class="pic_description<?php
		echo $this->class_suffix;
		?>"><?php
		echo $this->picInfo->description;
		?></div>
  <?php
	}
	?>   
  </div>

<?php
	
	if ($this->votes) {
		
		
		
		if ($this->isUserVoteAllowed) {
			$js = 'var jwallpapers_isUserVoteAllowed = true;';
		} else {
			$js = 'var jwallpapers_isUserVoteAllowed = false;';
		}
		
		
		
		
		if ($this->userAlreadyVoted) {
			$js .= 'var jwallpapers_userAlreadyVoted = true;';
		} else {
			$js .= 'var jwallpapers_userAlreadyVoted = false;';
		}
		
		
		
		$js .= 'var jwallpapers_rating_link_one_star = "' . $this->rating_links [1] . '";
		var jwallpapers_rating_link_two_stars = "' . $this->rating_links [2] . '";
		var jwallpapers_rating_link_three_stars = "' . $this->rating_links [3] . '";
		var jwallpapers_rating_link_four_stars = "' . $this->rating_links [4] . '";
		var jwallpapers_rating_link_five_stars = "' . $this->rating_links [5] . '";';
		
		$document->addScriptDeclaration ( $js );
		
		$document->addScript ( 'administrator/components/' . $option . '/js/ajaxRating.js' );
		
		?>
<!-- START AJAX VOTE -->

<div id="jwajaxvote-inline-rating" <?php
		echo $this->id_class;
		?>>

<ul class="jwajaxvote-star-rating<?php
		echo $this->class_suffix;
		?>">
	<div id="rating_stars_update" <?php
		echo $this->id_class;
		?>>
	<li id="rating" class="current-rating<?php
		echo $this->class_suffix;
		?>" style="width:<?php
		echo $this->ratingPercent;
		?>%"></li>
	</div>
	<!--  The use of single quotes instead of double quotes for defining the href property is temporary. Joomla calls JRouter::_ with links defined with double quotes by default. -->
	<li><a id="one_star"
		title="<?php
		echo htmlspecialchars ( JText::_ ( '1_OUT_OF_5' ), ENT_QUOTES );
		?>"
		class="one-star<?php
		echo $this->class_suffix;
		?>">1</a></li>
	<li><a id="two_stars"
		title="<?php
		echo htmlspecialchars ( JText::_ ( '2_OUT_OF_5' ), ENT_QUOTES );
		?>"
		class="two-stars<?php
		echo $this->class_suffix;
		?>">2</a></li>
	<li><a id="three_stars"
		title="<?php
		echo htmlspecialchars ( JText::_ ( '3_OUT_OF_5' ), ENT_QUOTES );
		?>"
		class="three-stars<?php
		echo $this->class_suffix;
		?>">3</a></li>
	<li><a id="four_stars"
		title="<?php
		echo htmlspecialchars ( JText::_ ( '4_OUT_OF_5' ), ENT_QUOTES );
		?>"
		class="four-stars<?php
		echo $this->class_suffix;
		?>">4</a></li>
	<li><a id="five_stars"
		title="<?php
		echo htmlspecialchars ( JText::_ ( '5_OUT_OF_5' ), ENT_QUOTES );
		?>"
		class="five-stars<?php
		echo $this->class_suffix;
		?>">5</a></li>
</ul>
<br />
<div id="jwajaxvote"
	class="jwajaxvote-box<?php
		echo $this->class_suffix;
		?>">(<?php
		echo $this->picInfo->vote_count . ' ' . JText::_ ( 'VOTES' );
		?>)</div>

</div>
<!-- <div class='jwajaxvote-clr'></div> -->
<div id="rating_verbose_update" <?php
		echo $this->id_class;
		?>>
<p><?php
		echo JText::_ ( 'RATING' ) . ': ' . $this->picInfo->rating . ' / 5.00';
		?></p>
</div>

<!-- END AJAX VOTE -->
  <?php
	}
	?>
  </div>
</div>
<?php
}
?>
<!-- RIGHT END -->
<div class="clear_both"></div>

<?php


if ($this->frontend_tagging_layout) {
	
	echo $this->frontend_tagging_layout;
}


if ($this->comments) {
	?>

<div class="componentheading<?php
	echo $this->class_suffix;
	?>"><?php
	echo JText::_ ( 'COMMENTS' );
	?></div>

<div id="comments_area" <?php
	echo $this->id_class;
	?>>
  <?php
	
	switch ($this->comments) {
		case 1 :
			
			$comments = JPATH_BASE . DS . 'components' . DS . 'com_jcomments' . DS . 'jcomments.php';
			if (file_exists ( $comments )) {
				require_once ($comments);
				echo JComments::showComments ( $this->picInfo->id, $option, $this->picInfo->title );
			}
			break;
		case 2 :
			
			include_once (JPATH_PLUGINS . DS . 'content' . DS . 'jom_comment_bot.php');
			echo jomcomment ( $this->picInfo->id, $option );
			break;
	}
	?>
</div>
<?php
}

if ($this->show_credits) {
	?>
<div class="jw_credits<?php
	echo $this->class_suffix;
	?>"><a href="http://www.wextend.com">Powered by JWallpapers</a></div>
<?php
}
?>