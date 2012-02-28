/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: commonForm.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */


var descriptionCount = '1000';
function descriptionLimiter(form) {
    var text = form.description.value;
    var len = text.length;
    if (len > descriptionCount) {
	text = text.substring(0, descriptionCount);
	form.description.value = text;
	return false;
    }
    form.descriptionLimit.value = descriptionCount - len;
}


var titleCount = '64';
function titleLimiter(form) {
    var text = form.title.value;
    var len = text.length;
    if (len > titleCount) {
	text = text.substring(0, titleCount);
	form.title.value = text;
	return false;
    }
    form.titleLimit.value = titleCount - len;
}


var ownerCount = '32';
function ownerLimiter(form) {
    var text = form.owner.value;
    var len = text.length;
    if (len > ownerCount) {
	text = text.substring(0, ownerCount);
	form.owner.value = text;
	return false;
    }
}


var keywordsCount = '255';
function keywordsLimiter(form) {
    var text = form.keywords.value;
    var len = text.length;
    if (len > keywordsCount) {
	text = text.substring(0, keywordsCount);
	form.keywords.value = text;
	return false;
    }
    form.keywordsLimit.value = keywordsCount - len;
}
