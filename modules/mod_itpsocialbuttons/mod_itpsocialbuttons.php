<?php
/**
 * @package      ITPrism Modules
 * @subpackage   ITPSocialButtons
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2010 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * ITPSocialButtons is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */

// no direct access
defined( "_JEXEC" ) or die( "Restricted access" );

$urlPath = JURI::base() . "modules/mod_itpsocialbuttons/";

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$doc = JFactory::getDocument();

$style = $urlPath . "style.css";
$doc->addStyleSheet($style);

$link       = JURI::getInstance();
$link       = $link->toString();
$title      = $doc->getTitle();

$title      = rawurlencode($title);
$link       = rawurlencode($link);

// Short URL service
if($params->get("shortUrlService")) {
    $link = ItpSocialButtonsHelper::getShortUrl($link, $params);
}

$stylePath = $urlPath . "images/" . $params->get("style");

require(JModuleHelper::getLayoutPath('mod_itpsocialbuttons'));

