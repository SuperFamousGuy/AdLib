/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: ajaxCaptcha.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

function refreshCaptcha() {

    var url = 'index.php?option=' + jwallpapers_option + '&task=refreshCaptcha';

    var div = $('captchaImage').empty();

    div.innerHTML = '<img style="display:block; margin: auto; padding-top: 15px;" src="components/' + jwallpapers_option + '/images/ajax_loader/ajax-loader-rating.gif" border="0" align="absmiddle" />';

    new Ajax(url, {
    method : 'get',
    onComplete : function(response, responseXML) {

	var root = responseXML.documentElement;
	var captcha_info = root.getElementsByTagName('captcha_info').item(0);
	var captcha_image = captcha_info.firstChild.nodeValue;
	div.empty().setHTML(captcha_image);

    }
    }).request();
}