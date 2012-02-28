/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: ajaxConfChecks.js 278 2010-04-16 17:03:22Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

window.addEvent('domready', ajaxChkApacheConfCall);

function ajaxChkApacheConfCall() {
    $$('.ajax_chk_apache_link')
	    .each( function(el) {
		el
			.addEvent('click', function(e) {

			    new Event(e).stop();

			    var url = this.getAttribute('href');

			    var div = $('ajax_apache_conf_check_result')
				    .empty();

			    div.innerHTML = '<img src="../components/' + jwallpapers_option + '/images/ajax_loader/ajax-loader-cat-select.gif" border="0" align="absmiddle" style="margin: 20px; padding-left: 10px;" />';

			    new Ajax(url, {
			    method : 'get',
			    onSuccess : function(response) {
				
				
				
				div
					.empty()
					.setHTML('<span class="red_msg">' + jwallpapers_apache_chk_failure + '</span>');
			    },
			    onFailure : function(response) {
				
				var status = response.status;
				if (status == 403) {
				    
				    div
					    .empty()
					    .setHTML('<span class="green_msg">' + jwallpapers_apache_chk_success + '</span>');
				} else {
				    
				    
				    div
					    .empty()
					    .setHTML('<span class="blue_msg">' + jwallpapers_apache_chk_not_conclusive + status + '.</span>');
				}
			    }
			    }).request();
			})
	    })
}