<?php if ($s5_tooltips  == "yes") { ?>
	<script type="text/javascript" language="javascript" src="<?php echo $s5_directory_path ?>/js/tooltips.js"></script>
<?php } ?>
	
<?php if ($s5_multibox  == "yes") { ?>
	<script type="text/javascript">
		var s5mbox = {};
		<?php if ($browser == "ie9") { ?>
		window.setTimeout(s5_multiboxg,1000);
		<?php } ?>

		<?php if ($browser == "ie9") { ?>function s5_multiboxg() {	
		<?php } ?>
		
		<?php if ($browser != "ie9") { ?>
        window.addEvent('domready', function() {
		<?php } ?>
		
		s5mbox = new MultiBox('s5mb', {descClassName: 's5_multibox', <?php if ($s5_multioverlay  == "yes") { ?>useOverlay: true<?php } else {?>useOverlay: false<?php } ?>, <?php if ($s5_multicontrols  == "yes") { ?>showControls: true<?php } else {?>showControls: false<?php } ?>});	
		
		}<?php if ($browser != "ie9") { ?>);<?php } ?>
	</script>
<?php } ?>