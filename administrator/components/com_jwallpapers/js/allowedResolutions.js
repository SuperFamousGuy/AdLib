/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: allowedResolutions.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

window.addEvent('domready', allowedResolutionCall);

function allowedResolutionCall() {
    $$('.ajax_allowed_res_link')
	    .each( function(el) {
		el
			.addEvent('click', function(e) {

			    new Event(e).stop();

			    var url = this.getAttribute('href');

			    
			    if (this.getAttribute('id') == 'new_allowed_resolution') {
				var width = document
					.getElementById('allowed_res_width_new').value;
				if (!isPositiveInteger(width)) {
				    alert(jwallpapers_notIntegerWidth);
				    return;
				}
				var height = document
					.getElementById('allowed_res_height_new').value;
				if (!isPositiveInteger(height)) {
				    alert(jwallpapers_notIntegerHeight);
				    return;
				}

				url = url + '&w=' + width + '&h=' + height;

			    } else {
				
				if (!confirm(jwallpapers_deleteConfirm)) {
				    return;
				}

			    }

			    var div = $('allowedResolutions').empty();

			    div.innerHTML = '<img src="../components/' + jwallpapers_option + '/images/ajax_loader/ajax-loader-cat-select.gif" border="0" align="absmiddle" style="margin: 20px; padding-left: 10px;"/>';

			    new Ajax(url, {
			    method : 'get',
			    onComplete : function(response, responseXML) {

				
				var root = responseXML.documentElement;
				var allowed_resolutions_layout_update = root
					.getElementsByTagName('allowed_resolutions_layout_update')
					.item(0);

				
				
				var updateAllowedResLayout, tmpArray = [];
				
				for ( var i = 0; i < allowed_resolutions_layout_update.childNodes.length; i++) {
				    
				    tmpArray
					    .push(allowed_resolutions_layout_update.childNodes
						    .item(i).nodeValue);
				}
				
				
				updateAllowedResLayout = tmpArray.join('');
				div.empty().setHTML(updateAllowedResLayout);
				allowedResolutionCall();
			    }
			    }).request();
			})
	    })
}