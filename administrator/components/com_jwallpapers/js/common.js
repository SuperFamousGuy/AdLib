/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: common.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

function isPositiveInteger(value) {
    if (isNaN(value)) {
	return false;
    } else if ((value % 1) != 0) {
	return false;
    } else if (value <= 0) {
	return false;
    } else if (value == null || value == '') {
	return false;
    } else {
	return true;
    }
}