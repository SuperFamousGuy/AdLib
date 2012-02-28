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
$app =& JFactory::getApplication();
$yjsg_params = $app->getTemplate(true)->params;
$template = $this->template;
$default_color                = $yjsg_params->get("default_color"); 
$default_font_family          = $yjsg_params->get("default_font_family");
$logo_height                  = $yjsg_params->get("logo_height");
$logo_width                   = $yjsg_params->get("logo_width");
$css_width                    = $yjsg_params->get("css_width");
$default_font                 = $yjsg_params->get("default_font");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>

<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $template ?>/css/template.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $template ?>/css/<?php echo $default_color; ?>.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $template ?>/css/user_pages.css" type="text/css" /> 
</head>
<body id="stylef<?php echo $default_font_family ?>">
<jdoc:include type="message" />
	<div id="frame" style="width:850px; background:#fff; margin:0 auto; border:1px dashed #ccc; font-size:12px;">
<div id="userlogin_wrap">
	<div id="userpages">		
<div id="header" class="png" style="margin:0 auto; text-align:center;float:none;height:<?php echo $logo_height?>;width:100%;">
        <img src="<?php echo $this->baseurl; ?>/templates/<?php echo $template ?>/images/<?php echo $default_color; ?>/logo.png" alt="site_logo" />
        </div>
	<p>
		<?php echo $app->getCfg('offline_message'); ?>
	</p>
	<form action="index.php" method="post" name="login" id="form-login">
	<fieldset class="input">
		<p id="form-login-username">
			<label for="username"><?php echo JText::_('Username') ?></label><br />
			<input name="username" id="username" type="text" class="inputbox" alt="<?php echo JText::_('Username') ?>" size="18" />
		</p>
		<p id="form-login-password">
			<label for="password"><?php echo JText::_('Password') ?></label><br />
			<input type="password" name="password" class="inputbox" size="18" alt="<?php echo JText::_('Password') ?>" id="passwd" />
		</p>
		<p id="form-login-remember">
			<label for="remember"><?php echo JText::_('Remember me') ?></label>
			<input type="checkbox" name="remember" class="remeberbox" value="yes" alt="<?php echo JText::_('Remember me') ?>" id="remember" />
		</p>
		<input type="submit" name="Submit" class="button" value="<?php echo JText::_('LOGIN') ?>" />
	</fieldset>
	<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
	</div>
    </div>
    </div>
</body>
</html>