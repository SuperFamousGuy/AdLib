<?php
/**
* googlesearch.lib.php
* Author: kksou
* Copyright (C) 2006-2009. kksou.com. All Rights Reserved
* Website: http://www.kksou.com/php-gtk2
* Jan 3, 2009
*/

#defined('_JEXEC') or die();

if (defined('googlesearch_lib')) return;

define('googlesearch_lib', 1);

class googleSearch_DisplayForm {

	function googleSearch_DisplayForm($r, $mod='', $ver='1.5', $Itemid=0, $moduleclass_sfx='', $use_cse=0) {

		$this->mod = $mod;
		$this->ver = $ver;
		$this->Itemid = $Itemid;
		$this->moduleclass_sfx = $moduleclass_sfx;
		$this->use_cse = $use_cse;

		if ($mod=='') {
			if ($r->display_searchform) $this->display_form($r);
		} else {
			$this->display_form($r);
		}

		if ($mod=='') $this->display_search_result($r->width);

	}

	function display_form(&$r) {
		# added 081223
		if ($this->ver=='1.0') {
			global $mosConfig_live_site;
			$action = $mosConfig_live_site . '/index.php';
		} else {
			$action_base = JURI::base();
			if (substr($action_base, -1, 1)=='/') $action_base = substr($action_base, 0, strlen($action_base) - 1);
			$action = $action_base . '/index.php';
		}

		$class_sfx = '';
		if ($this->use_cse) {
			print '<!-- SiteSearch Google CSE -->';
			$id = $this->mod.'googleSearch_cse';
			$class_sfx = '_cse';

			$width_searchfield = $this->mod.'width_searchfield';
			$google_logo_pos = $this->mod.'google_logo_pos';
			$google_logo_pos = $r->$google_logo_pos;
			if (preg_match('/^(right|bottom)(.*)/', $google_logo_pos, $matches)) {
				$google_logo_pos2 = $matches[1];
				if ($matches[2]=='_black') {
					$google_logo_color = '#FFFFFF';
					$google_logo_bg_color = '#000000';
					$google_logo = 'poweredby_000000.gif';
				} elseif ($matches[2]=='_gray') {
					$google_logo_color = '#000000';
					$google_logo_bg_color = '#999999';
					$google_logo = 'poweredby_999999.gif';
				} else {
					$google_logo_color = '#000000';
					$google_logo_bg_color = '#FFFFFF';
					$google_logo = 'poweredby_FFFFFF.gif';
				}

				print "<style type=\"text/css\">
@import url(http://www.google.com/cse/api/branding.css);
</style>
<div class=\"cse-branding-{$google_logo_pos2}\" style=\"background-color:{$google_logo_bg_color};color:{$google_logo_color}\">
  <div class=\"cse-branding-form\">";
			}
		} else {
			print '<!-- SiteSearch Google -->';
			$id = $this->mod.'googleSearch';
		}
		$this->search_form_name = $id;
		#print "<form method=\"get\" action=\"index.php\" id=\"$id\">";
		print "<form method=\"get\" action=\"$action\" id=\"$id\">";
		$option = 'com_googlesearch';
		print "<input type=\"hidden\" name=\"option\" value=\"$option{$class_sfx}\" />";
		print "<input type=\"hidden\" name=\"n\" value=\"30\" />";

		$moduleclass_sfx = $this->moduleclass_sfx;
		print "<div class=\"".$this->mod."googleSearch{$class_sfx}{$moduleclass_sfx}\">";
		#if ($this->mod=='mod_') {
		#	print "<div class=\"googleSearch{$moduleclass_sfx}\">";
		#} else {
		#	print '<div class="com_search">';
		#}

		if ($this->mod=='mod_') {
			if ($this->Itemid!='') $this->hiddenfield('Itemid', $this->Itemid);
		} else {
			if ($this->ver=='1.0') {
				$Itemid = mosGetParam( $_REQUEST, 'Itemid', 0 );
			} else {
				$Itemid = JRequest::getCmd('Itemid');
			}
			$this->hiddenfield('Itemid', $Itemid);
		}

		$site_encoding = $r->site_encoding;
		if (preg_match('/^---/', $site_encoding)) $site_encoding = 'ISO-8859-1';

		if ($r->ad_pos=='right') {
			$ad_pos = 9;
		} elseif ($r->ad_pos=='top_right') {
			$ad_pos = 10;
		} elseif ($r->ad_pos=='top_bottom') {
			$ad_pos = 11;
		} else {
			$ad_pos = 11;
		}

		if ($this->use_cse) {
			$width_searchfield = $this->mod.'width_searchfield';
			$button_pos = $this->mod.'button_pos';
			$button_pos = $r->$button_pos;

			$val = '';
			$display_last_search = $this->mod.'display_last_search';
			if (isset($_GET['q']) && $r->$display_last_search=='1') $val = $_GET['q'];
			$searchfield = "<input type=\"text\" name=\"q\" class=\"inputbox{$moduleclass_sfx}\" size=\"".$r->$width_searchfield."\" maxlength=\"255\" value=\"$val\" />";
			$search_button_label = $r->search_button_label;
			if ($search_button_label=='') $search_button_label = 'Search';
			#$search_button = "<input type=\"submit\" name=\"sa\" value=\"$search_button_label\" class=\"{$mod2}googlesearch_searchbutton\" />";
			$search_button = "<input type=\"submit\" name=\"sa\" value=\"$search_button_label\" class=\"button{$moduleclass_sfx}\" />";

			$this->hiddenfield('cx', $r->google_id);
			$this->hiddenfield('cof', "FORID:$ad_pos");
			$this->hiddenfield('ie', $site_encoding);
			print $searchfield;
			if ($button_pos=='right') print $search_button;
			else if ($button_pos=='right') print "<br />".$search_button;
			#$google_code1 = $r->google_code1;
			#$google_code1 = str_replace('{', '<', $google_code1);
			#$google_code1 = str_replace('}', '>', $google_code1);
			#print $google_code1;

		} else {
			$this->hiddenfield('domains', $r->domain);

			list($google_logo, $searchfield, $radio_buttons, $search_button) = $this->setup_items($r);

			$this->display_items($r, $google_logo, $searchfield, $radio_buttons, $search_button);

			$regexp = '/^#[0-9a-fA-F]{6}$/';
			$title_color = "0000FF";
			if (preg_match($regexp, $r->title_color)) $title_color = substr($r->title_color, 1);

			$bg_color = "#FFFFFF";
			if (preg_match($regexp, $r->bg_color)) $bg_color = substr($r->bg_color, 1);

			$text_color = "#000000";
			if (preg_match($regexp, $r->text_color)) $text_color = substr($r->text_color, 1);

			$url_color = "#008000";
			if (preg_match($regexp, $r->url_color)) $url_color = substr($r->url_color, 1);

			$google_id = $r->google_id;
			if ($google_id=='') $google_id = 'noaccount';
			$this->hiddenfield('client', 'pub-'.$google_id);
			$this->hiddenfield('forid', 1);
			if ($r->channel!='') $this->hiddenfield('channel', $r->channel);
			$this->hiddenfield('ie', $site_encoding);
			$this->hiddenfield('oe', $site_encoding);

			$this->hiddenfield('cof', "GALT:$url_color;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:$bg_color;LBGC:336699;ALC:ffff00;LC:$title_color;T:$text_color;GFNT:0000FF;GIMP:0000FF;FORID:$ad_pos");
		}
		$this->hiddenfield('hl', $r->site_language);
		if ($r->safesearch=='1') $this->hiddenfield('safe', 'active');
		if (trim($r->country)!='') $this->hiddenfield('cr', $r->country);
		if ($r->intitle=='1') $this->hiddenfield('as_occt', 'title');

		print '</div>';
		print '</form>';

		if ($this->use_cse) {
			if (preg_match('/^(right|bottom)(.*)/', $google_logo_pos, $matches)) {
				print "</div>
  <div class=\"cse-branding-logo\">
    <img src=\"http://www.google.com/images/poweredby_transparent/{$google_logo}\" alt=\"Google\" />
  </div>
  <div class=\"cse-branding-text\">
    Custom Search
  </div>
</div>";
			}
		}

		#if ($r->google_logo_pos='none' || $r->display_google_watermark=='1')
		#if (($this->mod=='' && $r->display_google_watermark=='1') ||
		#($this->mod=='mod_' && $r->mod_display_google_watermark=='1')) print '<script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=cse-search-box&amp;lang=en"></script>';
		$this->setup_bf($r);
	}

	function setup_items(&$r) {
		$val = '';
		$display_last_search = $this->mod.'display_last_search';
		if (isset($_GET['q']) && $r->$display_last_search=='1') $val = $_GET['q'];
		#if ($val=='') $val='treeview';

		$google_logos = array('', 'http://www.google.com/logos/Logo_25wht.gif',
		'http://www.google.com/images/poweredby_transparent/poweredby_FFFFFF.gif',
		'http://www.google.com/images/poweredby_transparent/poweredby_000000.gif'
		);

		$mod2 = $this->mod;
		if ($mod2=='') $mod2='com_';

		$google_logo = '';
		$google_logo_img = $this->mod.'google_logo_img';
		if ($r->$google_logo_img>0) $google_logo = '<a href="http://www.google.com/"><img src="'.$google_logos[$r->$google_logo_img].'" border="0" alt="Google" align="middle" class="google_logo" /></a>';

		$width_searchfield = $this->mod.'width_searchfield';
		#$searchfield = "<input type=\"text\" name=\"q\" class=\"{$mod2}googlesearch_searchfield\" size=\"".$r->$width_searchfield."\" maxlength=\"255\" value=\"$val\" />";
		$moduleclass_sfx = $this->moduleclass_sfx;
		$searchfield = "<input type=\"text\" name=\"q\" class=\"inputbox{$moduleclass_sfx}\" size=\"".$r->$width_searchfield."\" maxlength=\"255\" value=\"$val\" />";

		$domain = $r->domain;
		$domain_name = $r->domain_name;
		$domain_as_default = $r->domain_as_default;
		$checked_web = '';
		$checked_domain = '';
		if (isset($_GET['sitesearch'])) {
			$sitesearch = $_GET['sitesearch'];
			if ($sitesearch=='') $checked_web = 'checked="checked"';
			else $checked_domain = 'checked="checked"';
		} else {
			#$checked_web = ($domain_as_default)?'':'checked="checked"';
			#$checked_domain = ($domain_as_default)?'checked="checked"':'';
			if ($domain_as_default) $checked_domain = 'checked="checked"';
			else $checked_web = 'checked="checked"';
		}

		if ($this->ver=='1.0') {
			global $mosConfig_live_site;
			$sitedomain = str_replace('http://', '', $mosConfig_live_site);
		} else {
			$sitedomain = str_replace('http://', '', $_SERVER['HTTP_HOST']);
		}

		if ($domain=='') {
			$domain = $sitedomain;
		}
		if ($domain_name=='') $domain_name = $sitedomain;

		$radio_buttons = '';
		/*if ($r->web_only==0) {
			$this->hiddenfield('sitesearch', '');
		} elseif ($r->web_only==1) {
			$this->hiddenfield('sitesearch', $domain);
		} elseif ($r->web_only==2) {
			$radio_buttons = "<input type=\"radio\" name=\"sitesearch\" value=\"\" $checked_web />".
			"<font size=\"-1\" color=\"#000000\">Web</font> " .
			"<input type=\"radio\" name=\"sitesearch\" value=\"$domain\" $checked_domain />" .
			"<font size=\"-1\" color=\"#000000\">$domain_name</font>";
		}*/

		$radio_pos = $this->mod.'radio_pos';
		if ($r->$radio_pos=='none_web') {
			$this->hiddenfield('sitesearch', '');
		} elseif ($r->$radio_pos=='none_domain') {
			$this->hiddenfield('sitesearch', $domain);
		} else {
			$radio_buttons = "<div class=\"radiogrp\"><input type=\"radio\" name=\"sitesearch\" class=\"radio\" value=\"\" $checked_web />".
			#"<font size=\"-1\" color=\"#000000\">Web</font> " .
			"<span class=\"radiolabel\">Web</span>".
			"<input type=\"radio\" name=\"sitesearch\" class=\"radio\" value=\"$domain\" $checked_domain />" .
			#"<font size=\"-1\" color=\"#000000\">$domain_name</font>";
			"<span class=\"radiolabel\">$domain_name</span></div>";
		}

		$button_img = $this->mod.'button_img';
		if ($r->$button_img!='') {
			#$search_button = "<input type=\"image\" src=\"$r->button_img\" name=\"sa\" value=\"submit\" alt=\"submit\" class=\"{$mod2}googlesearch_searchbuttonimg\" />";
			$search_button = "<input type=\"image\" src=\"".$r->$button_img."\" name=\"sa\" value=\"submit\" alt=\"submit\" class=\"button_img{$moduleclass_sfx}\" />";
		} else {
			$search_button_label = $r->search_button_label;
			if ($search_button_label=='') $search_button_label = 'Search';
			#$search_button = "<input type=\"submit\" name=\"sa\" value=\"$search_button_label\" class=\"{$mod2}googlesearch_searchbutton\" />";
			$search_button = "<input type=\"submit\" name=\"sa\" value=\"$search_button_label\" class=\"button{$moduleclass_sfx}\" />";
		}

		return array($google_logo, $searchfield, $radio_buttons, $search_button);
	}

	function display_items(&$r, $google_logo, $searchfield, $radio_buttons, $search_button) {
		$google_logo_pos = $this->mod.'google_logo_pos';
		$radio_pos = $this->mod.'radio_pos';
		$button_pos = $this->mod.'button_pos';

		#print '<table border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff" align=right>';
		#print "<table class=\"table{$moduleclass_sfx}\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" bgcolor=\"#ffffff\">";
		print '<table border="0" cellpadding="0" cellspacing="0" bgcolor="#ffffff">';
		if ($r->$google_logo_pos=='above') {
			print '<tr valign="middle">';
			$this->f1();
			if ($r->$google_logo_pos=='above') print "<td align=\"left\">$google_logo</td>"; else $this->f1();
			if ($r->$radio_pos=='right') $this->f1();
			if ($r->$button_pos=='right') $this->f1();
			print '</tr>';
		}

		print '<tr valign="middle">';
		if ($r->$google_logo_pos=='left') print "<td align=\"left\">$google_logo</td>"; else $this->f1();
		#$searchfield_padding = $this->get_searchfield_padding($r);
		#print "<td $searchfield_padding>$searchfield</td>";
		print "<td>$searchfield</td>";
		if ($r->$radio_pos=='right') print "<td align=\"left\">$radio_buttons</td>"; else $this->f1();

		#$button_padding = $this->get_button_padding($r, 'left');
		#if ($r->button_pos=='right') print "<td $button_padding>$search_button</td>";
		if ($r->$button_pos=='right') print "<td>$search_button</td>";
		print '</tr>';

		print '<tr>';
		$this->f1();
		if ($r->$radio_pos=='below') print "<td align=\"left\">$radio_buttons</td>"; else $this->f1();
		if ($r->$radio_pos=='right') $this->f1();
		if ($r->$button_pos=='right') $this->f1();
		print '</tr>';

		if ($r->$button_pos=='below') {
			print '<tr>';
			$this->f1();
			#$button_padding = $this->get_button_padding($r, 'top');
			#if ($r->button_pos=='below') print "<td $button_padding>$search_button</td>";
			if ($r->$button_pos=='below') print "<td>$search_button</td>";
			if ($r->$radio_pos=='right') $this->f1();
			if ($r->$button_pos=='right') $this->f1();
			print '</tr>';
		}
		print '</table>';
	}

	function display_search_result($width) {
		if ($this->use_cse) {
?>
<!-- SiteSearch Google CSE -->
<div id="cse-search-results"></div>

<script type="text/javascript">
var googleSearchIframeName = 'cse-search-results';
var googleSearchFormName = "<?php echo $this->search_form_name;?>";
var googleSearchFrameWidth = <?php echo $width;?>;
var googleSearchDomain = "www.google.com";
var googleSearchPath = "/cse";
</script>
<script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
<p></p>
<?php
		} else {
?>
<!-- SiteSearch Google -->
<div id="googleSearchUnitIframe"></div>

<script type="text/javascript">
var googleSearchIframeName = 'googleSearchUnitIframe';
var googleSearchFrameWidth = <?php echo $width;?>;
var googleSearchFrameborder = 0 ;
var googleSearchDomain = 'www.google.com';
var googleSearchPath = "/cse";
</script>
<script type="text/javascript"
         src="http://www.google.com/afsonline/show_afs_search.js">
</script>
<p></p>
<?php
		}

		if (isset($_GET['q'])) print "<div><p align=\"right\" style=\"padding:0 6 0 0;margin:6 6 6 0\"><a href=\"http://www.kksou.com/php-gtk2/Joomla-Gadgets/googleSearch-CSE-component.php\" style=\"color:#aaa;text-decoration: none;font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:7pt;font-weight: normal;\">Powered by JoomlaGadgets</a></p></div>";

	}

	function setup_bf($r) {
		$id = $this->mod."googleSearch";
		if ($this->use_cse) $id = $this->mod.'googleSearch_cse';
		$watermark_type = $this->mod.'watermark_type';
		$watermark_color_on_blur = $this->mod.'watermark_color_on_blur';
		$watermark_color_on_focus = $this->mod.'watermark_color_on_focus';
		$watermark_bg_color_on_blur = $this->mod.'watermark_bg_color_on_blur';
		$watermark_bg_color_on_focus = $this->mod.'watermark_bg_color_on_focus';
		$watermark_str = $this->mod.'watermark_str';
		$watermark_img = $this->mod.'watermark_img';

		$watermark_type = $r->$watermark_type;
		$watermark_color_on_blur = $r->$watermark_color_on_blur;
		$watermark_color_on_focus = $r->$watermark_color_on_focus;
		$watermark_bg_color_on_blur = $r->$watermark_bg_color_on_blur;
		$watermark_bg_color_on_focus = $r->$watermark_bg_color_on_focus;
		$watermark_str = $r->$watermark_str;
		$watermark_img = $r->$watermark_img;

		$val = '';
		$v1 = '';
		$display_last_search = $this->mod.'display_last_search';
		$t2 = $r->$display_last_search;
		if (isset($_GET['q']) && $r->$display_last_search=='1') {
			$val = $_GET['q'];
			$v1 = "q.value = '$val';";
		}
		$t1 = '';
		if (isset($_GET['q'])) $t1 = $_GET['q'];

		if ($watermark_type=='google') {
			print "<script type=\"text/javascript\"><!--
(function() {var f = document.getElementById('$id');if (f && f.q) {var q = f.q;var b = function(){if (q.value == '') {q.style.color = '$watermark_color_on_blur';q.style.background = '#FFFFFF url(http:\x2F\x2Fwww.google.com\x2Fcoop\x2Fintl\x2Fen\x2Fimages\x2Fgoogle_custom_search_watermark.gif) left no-repeat';}};	var f = function() {q.style.color = '$watermark_color_on_focus';q.style.background = '#ffffff';};q.onfocus = f;q.onblur = b;{$v1}b();}})();
//-->
</script>";
		} elseif ($watermark_type=='text') {
			print "<script type=\"text/javascript\"><!--
(function() {var f = document.getElementById('$id');if (f && f.q) {var q = f.q;var b = function(){if (q.value == '') {q.value='$watermark_str';q.style.color = '$watermark_color_on_blur';q.style.background = '$watermark_bg_color_on_blur';}}; var f = function() {if (q.value=='$watermark_str') {q.value='';q.style.color = '$watermark_color_on_focus';q.style.background = '$watermark_bg_color_on_focus';}};q.onfocus = f;q.onblur = b;{$v1}b();}})();
//-->
</script>";
		}
	}

	function get_searchfield_padding(&$r) {
		$searchfield_padding = '';
		$padding_css = '';
		$has_padding = 0;
		foreach(array('left', 'right', 'top', 'bottom') as $pos) {
			$field = $this->mod.'searchfield_padding_'.$pos;
			$value = intval($r->$field);
			if ($value>0) $has_padding = 1;
			$padding_css .= "padding-{$pos}:{$value}px;";
		}

		if ($has_padding) $searchfield_padding = "style=\"$padding_css\"";
		return $searchfield_padding;
	}

	function get_button_padding(&$r, $pos) {
		$button_padding = '';
		$button_left_padding = intval($r->button_left_padding);
		$button_top_padding = intval($r->button_top_padding);
		if ($button_left_padding>0 || $button_top_padding>0) {
			$button_padding = 'style="';
			if ($pos=='left' && $button_left_padding>0) $button_padding .= "padding-left:{$button_left_padding}px;";
			if ($pos=='top' && $button_top_padding>0) $button_padding .= "padding-top:{$button_top_padding}px;";
			$button_padding .= '"';
		}
		return $button_padding;
	}

	function hiddenfield($var, $value) {
		print "<input type=\"hidden\" name=\"$var\" value=\"$value\" />";
	}

	function f1() {
		print '<td></td>';
	}

}

?>