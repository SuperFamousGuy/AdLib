<?php
/**
* googlesearch_cse.php
* Author: kksou
* Copyright (C) 2006-2009. kksou.com. All Rights Reserved
* Website: http://www.kksou.com/php-gtk2
* Jan 3, 2009
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class TablegoogleSearch_cse extends JTable
{
	var $id = null;

	var $google_id = null;
	var $width = null;
	var $width_searchfield = null;
	var $search_button_label = null;
	var $channel = null;
	var $domain = null;
	var $domain_name = null;
	var $domain_as_default = null;
	var $site_language = null;
	var $site_encoding = null;
	var $country = null;
	var $web_only = null;
	var $safesearch = null;
	var $display_last_search = null;
	var $intitle = null;

	var $title_color = null;
	var $bg_color = null;
	var $text_color = null;
	var $url_color = null;

	var $google_logo_pos = null;
	var $radio_pos = null;
	var $button_pos = null;
	var $google_logo_img = null;
	var $button_img = null;
	var $ad_pos = null;

	var $watermark_type = null;
	var $watermark_color_on_blur = null;
	var $watermark_color_on_focus = null;
	var $watermark_bg_color_on_blur = null;
	var $watermark_bg_color_on_focus = null;
	var $watermark_str = null;
	var $watermark_img = null;

	var $mod_width_searchfield = null;
	var $display_searchform = null;
	var $mod_display_last_search = null;
	var $mod_google_logo_pos = null;
	var $mod_radio_pos = null;
	var $mod_button_pos = null;
	var $mod_google_logo_img = null;
	var $mod_button_img = null;

	var $mod_watermark_type = null;
	var $mod_watermark_color_on_blur = null;
	var $mod_watermark_color_on_focus = null;
	var $mod_watermark_bg_color_on_blur = null;
	var $mod_watermark_bg_color_on_focus = null;
	var $mod_watermark_str = null;
	var $mod_watermark_img = null;

	function __construct(&$db)
	{
		parent::__construct( '#__googleSearch_cse_conf', 'id', $db );
	}
}


?>