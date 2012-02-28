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
?>
<div class="componentheading<?php
echo $this->class_suffix;
?>"
	style="float: left; border: none !important;"><?php
	echo $this->catName;
	?></div>
<?php
if (isset ( $this->submit_picture_layout )) {
	echo $this->submit_picture_layout;
}
?>
<div class="clear_both"></div>
<div id="thumbs_left_section" <?php
echo $this->id_class;
?> style="width: <?php
echo ($this->thumbs_area_width > 100) ? 100 : $this->thumbs_area_width;
?>%;">
<?php
if (! empty ( $this->catDesc )) {
	?>
<div id="jw_cat_desc">
<?php
	echo $this->catDesc;
	?>
</div>
<?php
}
?>
<div id="thumbs_container" <?php
echo $this->id_class;
?>>
<?php
if (! empty ( $this->pics )) {
	?>
<ul class="thumbnails<?php
	echo $this->class_suffix;
	?>">
    <?php
	
	switch ($this->params->get ( 'display_mode' )) {
		
		case 0 :
			
			
			for($j = 0; $j < count ( $this->pics ['cats'] ); $j ++) {
				echo JWallpapersHelperLayout::getCatThumbLayout ( $this->pics ['cats'] [$j], $this->cat_layout_params );
			}
			
			for($j = 0; $j < count ( $this->pics ['pics'] ); $j ++) {
				echo JWallpapersHelperLayout::getThumbLayout ( $this->pics ['pics'] [$j], $this->pic_layout_params );
			}
			break;
		case 1 :
			
			
			for($j = 0; $j < count ( $this->pics ); $j ++) {
				echo JWallpapersHelperLayout::getThumbLayout ( $this->pics [$j], $this->pic_layout_params );
			}
			break;
	}
	?>						
</ul>
<div class="clear_both"></div>
<?php
} else {
	
	echo '<div class="jw_message_big_margins' . $this->class_suffix . '"><h2>' . JText::_ ( 'PIC_LIST_EMPTY' ) . '</h2></div>';
}

if (! empty ( $this->vm_product_link )) {
	echo '<div class="vm_product_link' . $this->class_suffix . '"><a class="vm_product_link' . $this->class_suffix . '" href="' . $this->vm_product_link . '" title="' . htmlspecialchars ( JText::_ ( 'BUY_VM_CAT_PRODUCT' ), ENT_QUOTES ) . '">' . JText::_ ( 'BUY_VM_CAT_PRODUCT' ) . '</a></div>';
}



if (isset ( $this->title_link )) {
	
	echo '<div class="jw_order_by_links' . $this->class_suffix . '">';
	echo $this->title_link;
	echo $this->newest_first_link;
	echo $this->newest_last_link;
	echo $this->best_rated_link;
	echo $this->most_viewed_link;
	echo '</div>';
}

echo '<div class="jw_nav_pages_links' . $this->class_suffix . '">';
echo $this->pageNav->getPagesLinks ();
echo '</div><div class="jw_nav_pages_count' . $this->class_suffix . '">';
echo $this->pageNav->getPagesCounter ();
echo '</div>';
?>

</div>
<?php
if ($this->show_credits) {
	?>
<div class="jw_credits<?php
	echo $this->class_suffix;
	?>"><a href="http://www.wextend.com">Powered by JWallpapers</a></div>
<?php
}
?>
</div>
<?php

if ($this->right_area_width > 0) {
	?>
<div id="thumbs_right_section" <?php
	echo $this->id_class;
	?> style="width: <?php
	echo $this->right_area_width;
	?>%;">
<?php
	
	if ($this->params->get ( 'show_category_list' )) {
		
		$countSubCats = count ( $this->subCategories );
		
		echo '<h3>' . JText::_ ( 'SUBCATEGORIES' ) . '</h3><ul>';
		
		for($i = 0; $i < count ( $this->subCategories ); $i ++) {
			echo '<li><a href="' . $this->subCategories [$i]->link . '">' . $this->subCategories [$i]->title . '</a></li>';
		}
		
		?>
</ul>

<?php
		if (! $countSubCats) {
			echo '<center>' . JText::_ ( 'CAT_LIST_EMPTY' ) . '</center>';
		}
	}
	?>
</div>
<?php
}
?>
<div class="clear_both"></div>