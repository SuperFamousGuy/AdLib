/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: availableResizes.js 283 2010-04-20 15:41:03Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

window.addEvent('domready', availableResizeCall);

function availableResizeCall() {
    $$('.ajax_available_resize_link')
	    .each( function(el) {
		el
			.addEvent('click', function(e) {

			    new Event(e).stop();

			    var url = this.getAttribute('href');

			    
			    if (this.getAttribute('id') == 'new_resize') {
				var width = document
					.getElementById('resize_width_new').value;
				if (!isPositiveInteger(width)) {
				    alert(jwallpapers_notIntegerWidth);
				    return;
				}
				var height = document
					.getElementById('resize_height_new').value;
				if (!isPositiveInteger(height)) {
				    alert(jwallpapers_notIntegerHeight);
				    return;
				}

				
				var formatsArray = [];
				var tmpArray = [ 'resize_format_0_new', 'resize_format_1_new', 'resize_format_2_new', 'resize_format_3_new', 'resize_format_4_new' ];
				for ( var i = 0; i < 5; i++) {
				    if (document.getElementById(tmpArray[i]) != null && document
					    .getElementById(tmpArray[i]).checked) {
					formatsArray.push(i);
				    }
				}
				
				var size_formats = formatsArray.join(',');
				url = url + '&w=' + width + '&h=' + height;

				if (size_formats.length > 0) {
				    url = url + '&size_formats=' + size_formats;
				}

			    } else {
				
				if (!confirm(jwallpapers_deleteConfirm)) {
				    return;
				}

			    }

			    var div = $('availableResizes').empty();

			    div.innerHTML = '<img src="../components/' + jwallpapers_option + '/images/ajax_loader/ajax-loader-cat-select.gif" border="0" align="absmiddle" style="margin: 20px; padding-left: 10px;"/>';

			    new Ajax(url, {
			    method : 'get',
			    onComplete : function(response, responseXML) {
				
				var root = responseXML.documentElement;
				var available_resizes_layout_update = root
					.getElementsByTagName('available_resizes_layout_update')
					.item(0);
				
				
				var updateAvResLayout, tmpArray = [];
				
				for ( var i = 0; i < available_resizes_layout_update.childNodes.length; i++) {
				    
				    tmpArray
					    .push(available_resizes_layout_update.childNodes
						    .item(i).nodeValue);
				}

				
				updateAvResLayout = tmpArray.join('');
				div.empty().setHTML(updateAvResLayout);
				availableResizeCall();
			    }
			    }).request();
			})
	    })
}