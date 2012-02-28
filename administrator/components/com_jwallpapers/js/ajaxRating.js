/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: ajaxRating.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

window
	.addEvent('domready', function() {
	    $$('#jwajaxvote-inline-rating a')
		    .each( function(el) {
			el
				.addEvent('click', function(e) {

				    
				    e = new Event(e).stop();

				    
				    if (jwallpapers_is_user_voting) {
					
					alert(jwallpapers_userAlreadyVotedMessage);
					return;
				    } else {
					
					
					jwallpapers_is_user_voting = true;
				    }

				    
				    if (jwallpapers_isUserVoteAllowed == false) {
					alert(jwallpapers_isUserVoteAllowedMessage);
					return false;
				    }

				    
				    
				    if (jwallpapers_userAlreadyVoted == true) {
					alert(jwallpapers_userAlreadyVotedMessage);
					return false;
				    }

				    var id = this.getAttribute('id');

				    var url = eval("jwallpapers_rating_link_" + id);

				    var div1 = $('rating_stars_update');
				    var div2 = $('jwajaxvote').empty();
				    div2.innerHTML = '<img src="components/' + jwallpapers_option + '/images/ajax_loader/ajax-loader-rating.gif" border="0" align="absmiddle" />';
				    var div3 = $('rating_verbose_update');

				    
				    
				    new Ajax(url, {
				    method : 'get',
				    onComplete : function(response, responseXML) {

					jwallpapers_userAlreadyVoted = true;

					
					var root = responseXML.documentElement;
					var rating_stars_update = root
						.getElementsByTagName('rating_stars_update')
						.item(0);
					var rating_count_update = root
						.getElementsByTagName('rating_count_update')
						.item(0);
					var rating_verbose_update = root
						.getElementsByTagName('rating_verbose_update')
						.item(0);

					
					var updateRating = rating_stars_update.firstChild.nodeValue;
					var updateCounter = rating_count_update.firstChild.nodeValue;
					var updateVerbose = rating_verbose_update.firstChild.nodeValue;

					
					div1.empty().setHTML(updateRating);
					div2.empty().setHTML(updateCounter);
					div3.empty().setHTML(updateVerbose);

					
					jwallpapers_is_user_voting = false;

				    }
				    }).request();
				});
		    });
	});