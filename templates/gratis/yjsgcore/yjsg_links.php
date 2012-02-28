<?php 
/*======================================================================*\
|| #################################################################### ||
|| # Package - Joomla Template based on YJSimpleGrid Framework          ||
|| # Copyright (C) 2010  Youjoomla LLC. All Rights Reserved.            ||
|| # license - PHP files are licensed under  GNU/GPL V2                 ||
|| # license - CSS  - JS - IMAGE files  are Copyrighted material        ||
|| # bound by Proprietary License of Youjoomla LLC                      ||
|| # for more information visit http://www.youjoomla.com/license.html   ||
|| # Redistribution and  modification of this software                  ||
|| # is bounded by its licenses                                         ||
|| # websites - http://www.youjoomla.com | http://www.yjsimplegrid.com  ||
|| #################################################################### ||
\*======================================================================*/
# FOR YOUJOOMLA LLC COPYRIGHT REMOVAL VISIT THIS PAGE 
# http://www.youjoomla.com/faq/joomla-templates-club-faq/can-i-remove-youjoomla.com-copyright-3f.html
?>
<?php
function getYJLINKS($default_font_family,$yj_copyrightear,$yj_templatename){
echo"\n<script type=\"text/javascript\">\n
	window.addEvent('domready', function() {
	new SmoothScroll({duration: 500});	
	})
</script>\n";
echo'<div class="yjsgcp">Copyright &copy; '.$yj_copyrightear.' All rights reserverd. </div>';
echo'<div style="float:right;margin-top:5px;"><a href="#stylef'.$default_font_family.'"><img border="0" src="templates/'.$yj_templatename.'/images/top.png" width="50" height="22" title="Go to Top" alt="Go to Top" /></a></div>';
echo'<br />';
}

function getYJLINKSM(){
echo '<a class="mscroll" href="#centertop" title="Scroll to top">Top</a>';
}
?>