<!-- Page scroll, tooltips, multibox, and ie6 warning -->	
	<?php require(dirname(__FILE__)."/../../vertex/page_scroll.php"); ?>
	<?php require(dirname(__FILE__)."/../../vertex/tooltips_and_multibox.php"); ?>
	<?php require(dirname(__FILE__)."/../../vertex/lazy_load.php"); ?>
	<?php require(dirname(__FILE__)."/../../vertex/ie6_warning.php"); ?>
	<?php require(dirname(__FILE__)."/../../vertex/resize_columns.php"); ?>
	
<!-- Additional scripts to load just before closing body tag -->
	<?php 
	
	if ($s5_additional_scripts1 != "") {
		echo $s5_additional_scripts1;
	}
	
	if ($s5_additional_scripts2 != "") {
		echo $s5_additional_scripts2;
	}
	
	?>
