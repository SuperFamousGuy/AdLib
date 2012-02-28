/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: ajaxFrontendTag.js 278 2010-04-16 17:03:22Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */


var frontendAjaxTagFiles_timer = null;
var jwallpapers_tagging = false;

function frontendAjaxTagFiles() {

    $$('.tag_search_result')
	    .each( function(el) {
		el
			.addEvent('click', function(e) {

			    
			    frontendAjaxTagFiles_timer = $clear(frontendAjaxTagFiles_timer);

			    new Event(e).stop();

			    if (jwallpapers_tagging) {
				return false;
			    } else {
				jwallpapers_tagging = true;
			    }

			    var url = this.getAttribute('href');

			    
			    if (document.getElementById('captcha_string')) {
				url = url + '&captcha_string=' + $('captcha_string').value;
			    }

			    var div = $('tag_pic_status');
			    var myFx = new Fx.Style(div, 'opacity', {
				wait : false
			    });
			    
			    myFx.set(0);
			    div.innerHTML = jwallpapers_tagging_pic;
			    
			    myFx.start(0, 1);
			    
			    frontendAjaxTagFiles_timer = ( function() {
				myFx.start(1, 0);
			    }).delay(1000);

			    new Ajax(url, {
			    method : 'get',
			    onComplete : function(response, responseXML) {
				
				frontendAjaxTagFiles_timer = $clear(frontendAjaxTagFiles_timer);

				
				var root = responseXML.documentElement;
				var tag_picture_status = root
					.getElementsByTagName('ajax_tag_picture_status')
					.item(0).firstChild.nodeValue;

				
				myFx.set(0);
				if (tag_picture_status == 'success') {
				    div.innerHTML = jwallpapers_pic_tagged;
				    refreshPicTagsLayout(jwallpapers_pic_id);
				} else if (tag_picture_status == 'exists') {
				    div.innerHTML = jwallpapers_pic_tag_exists;
				} else if (tag_picture_status == 'captcha') {
				    div.innerHTML = jwallpapers_pic_tag_captcha;
				    refreshCaptcha();
				    $('captcha_string').value = '';
				} else {
				    div.innerHTML = jwallpapers_pic_tag_failed;
				}
				
				myFx.start(0, 1);
				
				frontendAjaxTagFiles_timer = ( function() {
				    myFx.start(1, 0);
				}).delay(3000);

				jwallpapers_tagging = false;

			    }
			    }).request();
			})
	    })
}

function refreshPicTagsLayout(pic_id) {

    
    if (!document.getElementById('pic_tags_section')) {
	return;
    }

    var div = $('pic_tags');

    var url = 'index.php?option=' + jwallpapers_option + '&task=ajaxRefreshPicTagsLayout&pic_id=' + pic_id;

    new Ajax(url, {
    method : 'get',
    onComplete : function(response, responseXML) {

	
	var root = responseXML.documentElement;
	var picture_tags = root.getElementsByTagName('ajax_picture_tags')
		.item(0);

	var update_picture_tags_layout, tmpArray = [];
	
	for ( var i = 0; i < picture_tags.childNodes.length; i++) {
	    
	    tmpArray.push(picture_tags.childNodes.item(i).nodeValue);
	}
	
	
	update_picture_tags_layout = tmpArray.join('');

	div.innerHTML = update_picture_tags_layout;

    }
    }).request();

}