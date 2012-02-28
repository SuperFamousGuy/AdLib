/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: jw_slimbox_loader.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

window.addEvent('domready', jwSlimboxLoader);

function jwSlimboxLoader() {

    $$('.slimshow')
	    .each( function(el) {
		el
			.addEvent('click', function(e) {

			    new Event(e).stop();

			    Slimbox
				    .open( [ jwallpapers_cat_id, jwallpapers_pics_count ], jwallpapers_pic_pos - 1);

			});
	    });
}

function jwSlimboxSetActiveImage(activeImagePos) {

    var jw_activeImageUrl = '';
    var url = 'index.php?option=com_jwallpapers&task=ajaxGetImageUrl&cat_id=' + jwallpapers_cat_id + '&pos=' + activeImagePos + '&pics_count=' + jwallpapers_pics_count + '&item_id=' + jwallpapers_item_id;

    new Ajax(url, {
    method : 'get',
    onComplete : function(response, responseXML) {

	
	var root = responseXML.documentElement;
	var jw_active_image_url_node = root
		.getElementsByTagName('active_image_url').item(0);
	
	var jw_active_image_url = jw_active_image_url_node.firstChild.nodeValue;
	
	window.location.href = jw_active_image_url;
    }
    }).request();
}