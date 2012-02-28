/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: commonPictureForm.js 246 2010-03-29 17:52:20Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

window.addEvent('domready', function() {
    $('is_owner0').addEvent('click', showAutorInput);
});

window.addEvent('domready', function() {
    $('is_owner1').addEvent('click', hideAutorInput);
});

function showAutorInput() {

    var owner_text_box = document.getElementById('owner');
    var owner_note = document.getElementById('owner_note');
    owner_text_box.value = '';
    owner_text_box.style.display = '';
    owner_note.style.display = '';

}

function hideAutorInput() {

    var owner_text_box = document.getElementById('owner');
    var owner_note = document.getElementById('owner_note');
    owner_text_box.value = '';
    owner_text_box.style.display = 'none';
    owner_note.style.display = 'none';

}