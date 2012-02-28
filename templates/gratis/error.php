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
defined( '_JEXEC' ) or die( 'Restricted access' );
$app = JFactory::getApplication();
$yjsg_params = $app->getTemplate(true)->params;
$template = $this->template;
$default_color                = $yjsg_params->get("default_color"); 
$default_font_family          = $yjsg_params->get("default_font_family");
$logo_height                  = $yjsg_params->get("logo_height");
$logo_width                   = $yjsg_params->get("logo_width");
$css_width                    = $yjsg_params->get("css_width");
$default_font                 = $yjsg_params->get("default_font");
$css_widthdefined    		  = $yjsg_params->get("css_widthdefined");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $template ?>/css/template.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $template ?>/css/<?php echo $default_color; ?>.css" rel="stylesheet" type="text/css" />
<style type="text/css">
/* error page*/
#sitelogo{
background-color:#000;
}
#errorpage{
margin:10px auto;
width:500px;
overflow:hidden;
display:block;
padding:20px;


}
.error_title{
font-family: Cambria, serif;
font-weight:bold;
padding:10px 0;
color:#fff;
}
.error_title h1{
font-size:48px;
line-height:17px;
color:#f2f2f2;
}
.error_title h2{
font-size:32px;
line-height:32px;
color:#f2f2f2;
}
#errorol{
width:480px;
margin:0 auto;
text-align:left;
background:#ccc;
border:1px solid #999;
padding:10px;
font-size:14px;
}
p.errorp{
padding:5px 10px;
border-bottom:1px dashed #DFDFDF;
text-align:left;
color:#f2f2f2;
}
p.error_contact{
padding:5px 10px;
background:#ccc;
border:1px dashed #999;
font-weight:bold;
color:red;
}
.error_link{
text-align:left;
text-decoration:none;
font-weight:bold;
color:#fff;
}
.error_link a{
color:#fff;
text-transform:uppercase;
}
p.error_msg{
border:1px dashed red;
padding:5px;
font-size:15px;
font-weight:bold;
color:#fff;
display:none;
}
</style>
</head>
<body id="stylef<?php echo $default_font_family ?>" style="background:#000">

<div id="centertop" style="font-size:12px; width:<?php echo $css_width.$css_widthdefined ; ?>; margin:0 auto; text-align:center;">
	<div id="errorpage">	
         <div id="header" class="png" style="margin:0 auto; text-align:center;float:none;height:<?php echo $logo_height?>;width:100%;">
        <img src="<?php echo $this->baseurl; ?>/templates/<?php echo $template ?>/images/<?php echo $default_color; ?>/logo.png" alt="site_logo" />
        </div>
		<div class="error_title"><h1><?php echo $this->error->getCode(); ?></h1><h2><?php echo $this->error->getMessage(); ?></h2></div>
		
			<p class="errorp"><strong><?php echo JText::_('You may not be able to visit this page because of:'); ?></strong></p>
				<ol id="errorol">
					<li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
					<li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
					<li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
					<li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
					<li><?php echo JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
					<li><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
				</ol>
			<p class="errorp"><strong><?php echo JText::_('Please try one of the following pages:'); ?></strong></p>
			
				<ol class="error_link">
					<li>
						<a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('Go to the home page'); ?>">
							<?php echo JText::_('Home Page'); ?>
						</a>
					</li>
					<li>
						<a href="<?php echo $this->baseurl; ?>/index.php?option=com_search" title="<?php echo JText::_('JERROR_LAYOUT_SEARCH_PAGE'); ?>">
							<?php echo JText::_('JERROR_LAYOUT_SEARCH_PAGE'); ?>
						</a>
					</li>
				</ol>
			
			<p class="error_contact"><?php echo JText::_('If difficulties persist, please contact the system administrator of this site.'); ?></p>
			
			<p class="error_msg"><?php echo $this->error->getMessage(); ?></p>
			<p><?php if($this->debug) : echo $this->renderBacktrace();	endif; ?></p>
            </div>
</div>
</body>
</html>
