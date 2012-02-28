/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: manageResizes.js 278 2010-04-16 17:03:22Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

window.addEvent('domready', ajaxRegenerateThumbs);
var ajax_regenerate_thumbs_timer = null;
var regenerating_thumbs = false;

function ajaxRegenerateThumbs() {
    $$('.ajax_regenerate_thumbs_link')
	    .addEvent('click', function(e) {

		ajax_regenerate_thumbs_timer = $clear(ajax_regenerate_thumbs_timer);

		new Event(e).stop();

		if (regenerating_thumbs == true) {
		    return false;
		} else {
		    regenerating_thumbs = true;
		}

		if (!confirm(jwallpapers_regenerateThumbsWarn)) {
		    regenerating_thumbs = false;
		    return false;
		}

		var url = this.getAttribute('href');

		var container = $('regenerate_thumbs_status');

		
		container.style.display = '';

		var myFx = new Fx.Style(container, 'opacity', {
		    wait : false
		});
		
		myFx.set(0);
		container.innerHTML = jwallpapers_regeneratingThumbs;
		
		myFx.start(0, 1);
		
		ajax_regenerate_thumbs_timer = ( function(mfFx) {
		    myFx.start(1, 0);
		}).delay(1000);

		new Ajax(url, {
		method : 'get',
		onComplete : function() {
		    
		    ajax_regenerate_thumbs_timer = $clear(ajax_regenerate_thumbs_timer);

		    
		    myFx.set(0);

		    container.innerHTML = jwallpapers_regenerateThumbsSuccess;

		    
		    myFx.start(0, 1);
		    
		    ajax_regenerate_thumbs_timer = ( function() {
			myFx.start(1, 0);
		    }).delay(10000);

		    
		    regenerating_thumbs = false;
		}
		}).request();
	    })
}

window.addEvent('domready', ajaxRegenerateResizes);
var ajax_regenerate_resizes_timer = null;
var regenerating_resizes = false;

function ajaxRegenerateResizes() {
    $$('.ajax_regenerate_resizes_link')
	    .addEvent('click', function(e) {

		ajax_regenerate_resizes_timer = $clear(ajax_regenerate_resizes_timer);

		new Event(e).stop();

		if (regenerating_resizes == true) {
		    return false;
		} else {
		    regenerating_resizes = true;
		}

		if (!confirm(jwallpapers_regenerateResizesWarn)) {
		    regenerating_resizes = false;
		    return false;
		}

		var url = this.getAttribute('href');

		var container = $('regenerate_resizes_status');

		var myFx = new Fx.Style(container, 'opacity', {
		    wait : false
		});
		
		myFx.set(0);
		container.innerHTML = jwallpapers_regeneratingResizes;
		
		myFx.start(0, 1);
		
		ajax_regenerate_resizes_timer = ( function() {
		    myFx.start(1, 0);
		}).delay(1000);

		new Ajax(url, {
		method : 'get',
		onComplete : function() {
		    
		    ajax_regenerate_resizes_timer = $clear(ajax_regenerate_resizes_timer);

		    
		    myFx.set(0);

		    container.innerHTML = jwallpapers_regenerateResizesSuccess;

		    
		    myFx.start(0, 1);
		    
		    ajax_regenerate_resizes_timer = ( function() {
			myFx.start(1, 0);
		    }).delay(10000);

		    
		    regenerating_resizes = false;
		}
		}).request();
	    })
}