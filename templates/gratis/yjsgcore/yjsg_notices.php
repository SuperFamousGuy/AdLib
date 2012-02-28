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
defined( '_JEXEC' ) or die( 'Restricted index access' );?>
<?php if ($ie6notice == 1 && preg_match( "/msie 6.0/",$who)){?>
<?php $document->addScript($yj_site.'/src/yjsge.js'); ?>
<div id="ie6Warning">
	<h1><?php echo JText::_( 'IE6_MSG' ); ?></h1>
    <div class="browsers">
    <a href="http://www.getfirefox.net/" target="_blank" id="fox">Get firefox</a>
     <a href="http://www.google.com/chrome/index.html?hl=en&brand=CHMA&utm_campaign=en&utm_source=en-ha-row-bk&utm_medium=ha" target="_blank" id="chrome">Get Chrome</a>
      <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx" target="_blank" id="ie8">Get IE8</a>
       <a href="http://www.apple.com/safari/download/" target="_blank" id="safari">Get Safari</a>
        <a href="http://www.opera.com/download/" target="_blank" id="opera">Get Opera</a>
    </div><h4><?php echo JText::_( 'UPGRADE_BROWSER_MSG' ); ?></h4>  
	<a href="#" id="closeIe6Alert">close</a>
</div>
<?php } ?>
  <?php if($nonscript == 1 ){?>
<!-- noscript notice -->
  <noscript>
  <p class="nonscript" style="text-align:center" ><?php echo JText::_( 'NONCSCRIPT_MSG' ); ?></p>
  </noscript>
<!-- end noscript notice -->
<?php } ?>