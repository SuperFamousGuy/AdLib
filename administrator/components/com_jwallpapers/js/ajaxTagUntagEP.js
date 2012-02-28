/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: ajaxTagUntagEP.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

window.addEvent('domready', ajaxTagUntagEP);

function ajaxTagUntagEP() {
    $$('.tag_untag_ep')
	    .each( function(el) {
		el
			.addEvent('click', function(e) {

			    
			    e = new Event(e).stop();

			    var url = this.getAttribute('href');

			    var div1 = $('editors_pick_container').empty();
			    var div2 = $('editors_pick_admin_container')
				    .empty();

			    div2.innerHTML = '<img src="components/' + jwallpapers_option + '/images/ajax_loader/ajax-loader-rating.gif" border="0" align="absmiddle" />';

			    
			    
			    new Ajax(url, {
			    method : 'get',
			    onComplete : function(response, responseXML) {

				
				var root = responseXML.documentElement;
				var layout_update = root
					.getElementsByTagName('editors_pick_layout_update')
					.item(0);
				var admin_layout_update = root
					.getElementsByTagName('editors_pick_admin_layout_update')
					.item(0);

				
				var editors_pick_layout_update = layout_update.firstChild.nodeValue
				if (editors_pick_layout_update != 'null') {
				    div1
					    .empty()
					    .setHTML(editors_pick_layout_update);
				}
				div2
					.empty()
					.setHTML(admin_layout_update.firstChild.nodeValue);

				ajaxTagUntagEP();
			    }
			    }).request();
			});
	    });
}