/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: ajaxCatParentSelect.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

window.addEvent('domready', ajaxCatCall);

function ajaxCatCall() {
    $$('.ajax_cat_link')
	    .each( function(el) {
		el
			.addEvent('click', function(e) {

			    new Event(e).stop();

			    var url = this.getAttribute('href');

			    var div = $('ajax_category').empty();

			    
			    if (typeof (jwallpapers_adminStepDown) == 'undefined') {
				div.innerHTML = '<img src="components/' + jwallpapers_option + '/images/ajax_loader/ajax-loader-cat-select.gif" border="0" align="absmiddle" style="margin: 20px; padding-left: 10px;" />';
			    } else {
				div.innerHTML = '<img src="../components/' + jwallpapers_option + '/images/ajax_loader/ajax-loader-cat-select.gif" border="0" align="absmiddle" style="margin: 20px; padding-left: 10px;" />';
			    }

			    new Ajax(url, {
			    method : 'get',
			    onComplete : function(response, responseXML) {

				
				var root = responseXML.documentElement;
				var category_layout_update = root
					.getElementsByTagName('category_layout_update')
					.item(0);
				
				
				var updateCatLayout, tmpArray = [];
				
				for ( var i = 0; i < category_layout_update.childNodes.length; i++) {
				    
				    tmpArray
					    .push(category_layout_update.childNodes
						    .item(i).nodeValue);
				}

				
				updateCatLayout = tmpArray.join('');
				div.empty().setHTML(updateCatLayout);
				ajaxCatCall();
			    }
			    }).request();
			})
	    })
}