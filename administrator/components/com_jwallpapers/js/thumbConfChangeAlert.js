/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: thumbConfChangeAlert.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

window.addEvent('domready', thumbConfChangeAlert);

function thumbConfChangeAlert() {

    $('paramsthumbs_resize_method').addEvent('change', function(e) {

	alert(jwallpapers_thumb_conf_change_alert);

    });

    $('paramssmall_thumbs_width').addEvent('click', function(e) {

	alert(jwallpapers_thumb_conf_change_alert);

    });

    $('paramssmall_thumbs_height').addEvent('click', function(e) {

	alert(jwallpapers_thumb_conf_change_alert);

    });

    $('paramsbig_thumbs_width').addEvent('click', function(e) {

	alert(jwallpapers_thumb_conf_change_alert);

    });

    $('paramsbig_thumbs_height').addEvent('click', function(e) {

	alert(jwallpapers_thumb_conf_change_alert);

    });

    $('paramslight_thumbs_width').addEvent('click', function(e) {

	alert(jwallpapers_thumb_conf_change_alert);

    });

    $('paramslight_thumbs_height').addEvent('click', function(e) {

	alert(jwallpapers_thumb_conf_change_alert);

    });

}