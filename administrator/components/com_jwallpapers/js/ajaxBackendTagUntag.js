/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: ajaxBackendTagUntag.js 278 2010-04-16 17:03:22Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */


var backendAjaxTagFiles_timer = null;

function backendAjaxTagFiles() {

    $$('.tag_search_result').each( function(el) {
	el.addEvent('click', function(e) {

	    
	    backendAjaxTagFiles_timer = $clear(backendAjaxTagFiles_timer);

	    new Event(e).stop();

	    var url = this.getAttribute('href');

	    var div = $('tag_pic_status');
	    var myFx = new Fx.Style(div, 'opacity', {
		wait : false
	    });
	    
	    myFx.set(0);
	    div.innerHTML = jwallpapers_tagging_pic;
	    
	    myFx.start(0, 1);
	    
	    backendAjaxTagFiles_timer = ( function() {
		myFx.start(1, 0);
	    }).delay(1000);

	    new Ajax(url, {
	    method : 'get',
	    onComplete : function(response, responseXML) {
		
		backendAjaxTagFiles_timer = $clear(backendAjaxTagFiles_timer);

		
		var root = responseXML.documentElement;
		var tag_picture_status = root
			.getElementsByTagName('ajax_tag_picture_status')
			.item(0).firstChild.nodeValue;

		
		myFx.set(0);
		if (tag_picture_status == 'success') {
		    div.innerHTML = jwallpapers_pic_tagged;
		} else if (tag_picture_status == 'exists') {
		    div.innerHTML = jwallpapers_pic_tag_exists;
		} else {
		    div.innerHTML = jwallpapers_pic_tag_failed;
		}
		
		myFx.start(0, 1);
		
		backendAjaxTagFiles_timer = ( function() {
		    myFx.start(1, 0);
		}).delay(3000);

		refreshUntagPicLayout(jwallpapers_pic_id);

	    }
	    }).request();
	})
    })
}

window.addEvent('domready', backendAjaxUntagFiles);


var backendAjaxUntagFiles_timer = null;

function backendAjaxUntagFiles() {

    $$('#ajax_remove_pic_tags a')
	    .each( function(el) {
		el
			.addEvent('click', function(e) {

			    
			    backendAjaxUntagFiles_timer = $clear(backendAjaxUntagFiles_timer);

			    new Event(e).stop();

			    var url = this.getAttribute('href');

			    var div1 = $('ajax_remove_pic_tags');

			    var div2 = $('untag_pic_status');
			    var myFx = new Fx.Style(div2, 'opacity', {
				wait : false
			    });
			    
			    myFx.set(0);
			    div2.innerHTML = jwallpapers_untagging_pic;
			    
			    myFx.start(0, 1);
			    
			    backendAjaxUntagFiles_timer = ( function() {
				myFx.start(1, 0);
			    }).delay(1000);

			    new Ajax(url, {
			    method : 'get',
			    onComplete : function(response, responseXML) {
				
				backendAjaxUntagFiles_timer = $clear(backendAjaxUntagFiles_timer);

				
				var root = responseXML.documentElement;
				var untag_picture_status = root
					.getElementsByTagName('ajax_untag_picture_status')
					.item(0).firstChild.nodeValue;
				var picture_tags = root
					.getElementsByTagName('ajax_picture_tags')
					.item(0);

				var update_picture_tags_layout, tmpArray = [];
				
				for ( var i = 0; i < picture_tags.childNodes.length; i++) {
				    
				    tmpArray.push(picture_tags.childNodes
					    .item(i).nodeValue);
				}
				
				update_picture_tags_layout = tmpArray.join('');

				div1.innerHTML = update_picture_tags_layout;

				
				myFx.set(0);
				if (untag_picture_status == 'success') {
				    div2.innerHTML = jwallpapers_pic_untagged;
				} else {
				    div2.innerHTML = jwallpapers_pic_untag_failed;
				}
				
				myFx.start(0, 1);
				
				backendAjaxUntagFiles_timer = ( function() {
				    myFx.start(1, 0);
				}).delay(3000);

				backendAjaxUntagFiles();
			    }
			    }).request();
			})
	    })
}

function refreshUntagPicLayout(pic_id) {

    var div = $('ajax_remove_pic_tags');
    var url = 'index.php?option=' + jwallpapers_option + '&task=ajaxRefreshUntagPicLayout&pic_id=' + pic_id;

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

	backendAjaxUntagFiles();
    }
    }).request();
}