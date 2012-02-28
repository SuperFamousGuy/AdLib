<?php
	//S5 Flex menu start
	$app = & JFactory::getApplication();
	$templateparams  = $app->getTemplate(true)->params;
	jimport('joomla.filesystem.file');	
	JHTML::_('behavior.mootools');
	
	$document =& JFactory::getDocument();
	$document->addScript($s5_directory_path."/js/s5_flex_menu.js");
	$document->addStyleSheet($s5_directory_path."/css/s5_flex_menu.css");
	
	$duration = ($s5_duration == '' ? '500' : $s5_duration);
	$hideDelay = ($s5_hide_delay == '' ? '500' : $s5_hide_delay);
    $opacity = ($s5_opacity == '' ? '100' : $s5_opacity);
    $orientation = ($s5_orientation == '' ? 'horizontal' : $s5_orientation);
	$effect = ($s5_effect == '' ? '2' : $s5_effect);
	
	if($effect == 0){
		$effect = "slide";
	}elseif($effect == 1){
		$effect = "fade";
	}elseif($effect == 2){
		$effect = "slide & fade";
	}
	
	if ($effect == "3") {
	$duration = "0";
	$effect = "0";
	}
	
?>
	<script type="text/javascript">
		<?php if ($browser == "ie9") { ?>
        function s5_load_flex_menu() {
		<?php } ?>
		<?php if ($browser != "ie9") { ?>
        window.addEvent('domready', function() {
		<?php } ?>
            var myMenu = new MenuMatic({
                effect:"<?php echo $effect; ?>",
                duration:<?php echo $duration; ?>,
                physics: Fx.Transitions.Pow.easeOut,
                hideDelay:<?php echo $hideDelay; ?>,
                orientation:"<?php echo $orientation; ?>",
                tweakInitial:{x:0, y:0},
                 <?php if($s5_language_direction == "1") { ?>
	                direction:{    x: 'left',    y: 'down' },
				<?php } ?>
                <?php if($s5_language_direction != "1") { ?>
    	            direction:{    x: 'right',    y: 'down' },
				<?php } ?>
                opacity:<?php echo $opacity; ?>
            });
        }<?php if ($browser != "ie9") { ?>);<?php } ?>
		
		<?php if ($browser == "ie9") { ?>
		window.setTimeout(s5_load_flex_menu,1000);
		<?php } ?>
		
    </script>    
<?php //S5 Flex menu end ?>