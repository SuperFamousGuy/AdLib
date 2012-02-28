/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: manageWatermarks.js 278 2010-04-16 17:03:22Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

window.addEvent('domready', ajaxDeleteWaterOrgs);
var ajax_delete_water_orgs_timer = null;
var deleting_water_orgs = false;

function ajaxDeleteWaterOrgs() {
    $$('.ajax_delete_water_orgs_link')
	    .addEvent('click', function(e) {

		ajax_delete_water_orgs_timer = $clear(ajax_delete_water_orgs_timer);

		new Event(e).stop();

		if (deleting_water_orgs == true) {
		    return false;
		} else {
		    deleting_water_orgs = true;
		}

		if (!confirm(jwallpapers_regenerateResizesWarn)) {
		    deleting_water_orgs = false;
		    return false;
		}

		var url = this.getAttribute('href');

		var container = $('delete_water_orgs_status');
		var myFx = new Fx.Style(container, 'opacity', {
		    wait : false
		});
		
		myFx.set(0);
		container.innerHTML = jwallpapers_regeneratingResizes;
		
		myFx.start(0, 1);
		
		ajax_delete_water_orgs_timer = ( function() {
		    myFx.start(1, 0);
		}).delay(1000);

		new Ajax(url, {
		method : 'get',
		onComplete : function() {
		    
		    ajax_delete_water_orgs_timer = $clear(ajax_delete_water_orgs_timer);

		    
		    myFx.set(0);

		    container.innerHTML = jwallpapers_deleteWaterOrgsSuccess

		    
		    myFx.start(0, 1);
		    
		    ajax_delete_water_orgs_timer = ( function() {
			myFx.start(1, 0);
		    }).delay(10000);

		    
		    deleting_water_orgs = false;
		}
		}).request();
	    })
}