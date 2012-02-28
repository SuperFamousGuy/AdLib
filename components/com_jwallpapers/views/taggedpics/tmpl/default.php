<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: default.php 274 2010-04-13 14:17:44Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );
?>
<div id="thumbs_container" <?php
echo $this->id_class;
?>>
<div class="componentheading<?php
echo $this->class_suffix;
?>"><?php
echo $this->headString;
?></div>
<?php
if (! empty ( $this->pics )) {
	?>
<ul class="thumbnails<?php
	echo $this->class_suffix;
	?>">
    <?php
	
	for($j = 0; $j < count ( $this->pics ); $j ++) {
		
		echo JWallpapersHelperLayout::getThumbLayout ( $this->pics [$j], $this->layout_params );
	
	}
	?>						
  <div class="clear_both"></div>
</ul>
<?php
} else {
	
	echo '<div class="jw_message_big_margins' . $this->class_suffix . '"><h2>' . JText::_ ( 'PIC_LIST_EMPTY' ) . '</h2></div>';
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