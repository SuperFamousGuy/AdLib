<?php
/*======================================================================*\
|| #################################################################### ||
|| # Package - Joomla Template based on YJSimpleGrid Framework          ||
|| # Copyright (C) 2010  Youjoomla LLC. All Rights Reserved.            ||
|| # Authors - Dragan Todorovic and Constantin Boiangiu                 ||
|| # license - PHP files are licensed under  GNU/GPL V2                 ||
|| # license - CSS  - JS - IMAGE files  are Copyrighted material        ||
|| # bound by Proprietary License of Youjoomla LLC                      ||
|| # for more information visit http://www.youjoomla.com/license.html   ||
|| # Redistribution and  modification of this software                  ||
|| # is bounded by its licenses                                         ||
|| # websites - http://www.youjoomla.com | http://www.yjsimplegrid.com  ||
|| #################################################################### ||
\*======================================================================*/

defined('JPATH_BASE') or die();
JHTML::_('behavior.modal');
class JElementYJAccordion extends JElement {
	

	function fetchElement($name, $value, &$node, $control_name)
	{
		if( !defined( 'YJACCORDION' ) ){
			$document =& JFactory::getDocument();
			
	        /* determine template filepath */
	        $uri = str_replace(DS,"/",str_replace( JPATH_SITE, JURI::base (), dirname(dirname(__FILE__)) ));
			$uri = str_replace("/administrator/", "", $uri);
			$this->template = end( explode( '/', $uri ) );
			
$originalString = "paramlist_key";
$newString = str_replace("paramlist_key","yjsgparamlist_key",$originalString);
			
			/* add scripts */
	        $document->addScript($uri.'/src/admin/yjsg_admin.js');
			$document->addScriptDeclaration("
			window.addEvent('domready', function() {

$$('fieldset.adminform').each(function(el, i){ el.set({'id': 'myForm_'+i}) })
$$('td.paramlist_value').each(function(el, i){ el.set({'id': 'tidi_'+i}) })

	$$('div.col').each( function( e, i ){
		e.removeClass('col width-50').addClass('col_'+i);
	});	
			$$('td.paramlist_value').each( function( e, i ){
		e.removeClass('paramlist_value').addClass('paramlist_value tdem_'+i);
	});	
});
		
			
			");
$document->addCustomTag('
<!--[if IE 7]>
<style type="text/css">
.elSelect .option{
	margin-top:-1px;
}
.selectsContainer .overDiv{
position:static;
}
</style>
<![endif]--> 
<style type="text/css">
.yj_system_check{
	width:280px;
	overflow:hidden;
	margin:0;
	padding:0;
}
.yj_system_check .yjmm_installed,
.yj_system_check .yjmm_published{
	color:green;
	font-weight:bold;
	margin:5px 0 0 0;
}
.yj_system_check .yjmm_installed_no,
.yj_system_check .yjmm_published_no{
	color:red;
	font-weight:bold;
	background: url('.JURI::base ().'images/publish_x.png) no-repeat right center;
	margin:5px 0 0 0;
}
.getyjmplugin{
	color:green;
	font-weight:bold;
	margin:5px 0 0 0;
}
.yj_system_check h3{
	color:#0B55C4;
	margin:0;
	line-height:17px;
}
</style>
');

//if (!JPluginHelper::getPlugin('system', 'YJMegaMenu')){
if (!JFile::exists(JPATH_SITE.DS.'plugins'.DS.'system'.DS.'YJMegaMenu.php')){
$plug_installed ="_no";
$installed_word ="not";
$download='<div style="margin-top:15px;color:#828627;font-weight:bold;">PLEASE INSTALL THIS PLUGIN. </div> <div style="margin-top:5px;">It is found in the Gratis download area on the PPC website.</div>';
}else{
$plug_installed ="";
$installed_word ="";
$download='';
}

if(!JPluginHelper::getPlugin('system', 'YJMegaMenu') || !JFile::exists(JPATH_SITE.DS.'plugins'.DS.'system'.DS.'YJMegaMenu.php')){
$plug_publihsed ="_no";
$publihsed_word ="not";
}else{
$plug_publihsed ="";
$publihsed_word ="";
}
echo '
<div class="yj_system_check">
<h3>Mega Menu Plugin Check</h3>

	<ul>
		<li class="yjmm_installed'.$plug_installed.'">Mega Menu plugin is '.$installed_word.' installed</li>
		<li class="yjmm_published'.$plug_publihsed.'">Mega Menu plugin is '.$publihsed_word.'  published</li>
		'.$download.'
	</ul>
</div>
';
			$document->addStyleSheet($uri.'/css/admin/yjsg_admin.css');
           	$zindex = $this->zindex = 100;			 
		}else {
			$zindex = $this->zindex-1;
			$this->zindex-=1;
		}
		
		$section_title  = JText::_($node->attributes('yjsgtogle'));
		$section_detail = JText::_($node->attributes('yjsgdetial'));
		$markup = <<<HTML
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="toggler_l"><div class="toggler_r"><h3 class="YJ_toggler">$section_title</h3></div></div>
<div class="YJ_params" style="z-index:$zindex;">
 <div class="tl">
  <div class="tr">
  	<div class="bl">
		<div class="br"><div class="yjsgdetial">$section_detail</div>
	<table class="paramlist admintable" width="100%" cellspacing="1">
		<tbody>
			<tr>
				<td>
		
HTML;
		
		if( !defined( 'YJACCORDION' ) ){
			$output = str_replace( '</div></div></div></div></div>', '', $markup );
			define( 'YJACCORDION', 1 );
		}else{
			$output = '<div class="YJSGEmpty"><!--empty--></div>'.$markup;			
		}

		return $output;		
	}
	
	function fetchTooltip($label, $description, &$xmlElement, $control_name='', $name='') {
		return false;
	}
}