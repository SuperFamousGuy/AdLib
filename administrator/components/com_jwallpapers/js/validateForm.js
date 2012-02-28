/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: validateForm.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */


var formSubmitted = false;

window
	.addEvent('domready', function() {
	    $('pictureForm')
		    .addEvent('submit', function(e) {
			new Event(e).stop();

			var url = 'index.php?option=' + document.pictureForm.option.value + '&task=checkCaptcha&keystring=' + document.pictureForm.keystring.value;

			new Ajax(url, {
			method : 'get',
			onComplete : function(response, responseXML) {

			    var root = responseXML.documentElement;
			    var check_result = root
				    .getElementsByTagName('check_result')
				    .item(0);
			    var result = check_result.firstChild.nodeValue;

			    if (result == 'true') {
				var new_cat_div = document
					.getElementById('new_cat_div');
				if (new_cat_div.style.display == 'none') {
				    if (document.pictureForm.cat_id.value == 0) {
					alert(jwallpapers_selectCatMsg);
					return false;
				    }
				} else {
				    if (document.pictureForm.new_cat.value == '') {
					alert(jwallpapers_enterNewCatNameMsg);
					return false;
				    }
				}

				
				var file_count = 0;
				for ( var i = 0; i < jwallpapers_upload_boxes; i++) {
				    if (eval('document.pictureForm.picturefile_' + i + '.value') != '') {
					file_count++;
				    }
				}

				
				
				if (file_count == 0) {
				    alert(jwallpapers_selectFileMsg);
				    return false;
				}

				if (formSubmitted == true) {
				    alert(jwallpapers_bePatientMsg);
				    return false;
				}

				var button_container = $('button_container')
					.empty();
				var uploading_msg_container = $('uploading_msg_container')
					.empty();

				button_container.innerHTML = '<img src="components/' + jwallpapers_option + '/images/ajax_loader/ajax-loader-rating.gif" border="0" align="absmiddle" />';
				uploading_msg_container.innerHTML = '<strong>' + jwallpapers_filesUploadingMsg + '</strong>';

				$('pictureForm').submit();
				formSubmitted = true;
			    } else {
				alert(jwallpapers_insertValidCodeMsg);

				refreshCaptcha();
			    }

			}
			}).request();

		    });
	});
