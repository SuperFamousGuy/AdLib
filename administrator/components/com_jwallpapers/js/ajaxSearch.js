/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: ajaxSearch.js 248 2010-03-30 17:17:52Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

function ajaxSearch() {

    
    this.min_chars = null;
    
    this.min_time = null;
    
    this.search_string = null;
    
    this.search_timer = null;
    
    this.url = null;
    
    this.search_result_xml_tag_name = null;
    
    this.search_result_container_id = null;
    
    this.anim = null;
    
    
    this.callbacks = null;

    
    this.prepareSearchQuery = function(search_string) {
	
	this.search_timer = $clear(this.search_timer);

	
	search_string = trim(search_string);
	
	if (!(search_string.length >= this.min_chars)) {
	    return;
	}

	
	this.search_string = urlencode(search_string);

	
	this.search_timer = this.performSearch
		.delay(this.min_time * 1000, this);
    }

    
    this.performSearch = function() {

	var search_result_container = $(this.search_result_container_id);
	var search_result_xml_tag_name = this.search_result_xml_tag_name;
	var callbacks = this.callbacks;

	
	search_result_container.empty();
	
	search_result_container.innerHTML = this.anim;

	
	var url = this.url + this.search_string;

	new Ajax(url, {
	method : 'get',
	onComplete : function(response, responseXML) {
	    var root = responseXML.documentElement;
	    var search_result = root
		    .getElementsByTagName(search_result_xml_tag_name).item(0);
	    
	    
	    var search_result_layout, tmpArray = [];
	    
	    for ( var i = 0; i < search_result.childNodes.length; i++) {
		
		tmpArray.push(search_result.childNodes.item(i).nodeValue);
	    }

	    
	    search_result_layout = tmpArray.join('');
	    search_result_container.empty().setHTML(search_result_layout);

	    
	    for ( var i = 0; i < callbacks.length; i++) {
		
		eval(callbacks[i]);
	    }

	}
	}).request();

    }
}


function trim(string) {
    return string.replace(/^\s+/g, '').replace(/\s+$/g, '');
}


function urlencode(string) {
    string = encodeURIComponent(string);
    return string.replace(/~/g, '%7E').replace(/!/g, '%21')
	    .replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29')
	    .replace(/\*/g, '%2A').replace(/%20/g, '+');
}
