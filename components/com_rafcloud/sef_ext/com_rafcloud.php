<?php
/**
* @version 3.0
* @package Raf Cloud
* @copyright Copyright (C) 2007 Skorp. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Raf Cloud is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @Author: Rafal Blachowski (Skorp) <http://joomla.royy.net>
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG, $sefConfig;  
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
// ------------------  standard plugin initialize function - don't change ---------------------------

// ------------------  load language file - adjust as needed ----------------------------------------


shRemoveFromGETVarsList('option');

if (isset($lang))
  shRemoveFromGETVarsList('lang'); 
if (isset($Itemid))
  shRemoveFromGETVarsList('Itemid'); 
if (!empty($ordering))
  shRemoveFromGETVarsList('ordering');
if (!empty($searchphrase))
  shRemoveFromGETVarsList('searchphrase');

shRemoveFromGETVarsList('sid');

	$result=null;
	$database->setQuery("SELECT RC_value FROM #__rafcloud_config WHERE RC_key = 'RC_sh404sef_prefix' AND RC_section ='config'");
	$result=$database->loadObject();
	
	if (empty($result->RC_value)) 
		$RC_value="RC-Tag"; 
	else 	$RC_value=$result->RC_value;

$title[] = $RC_value;
//$title[] = $sid;

	$database->setQuery("SELECT RC_value FROM #__rafcloud_config WHERE RC_key = 'RC_sh404sef_link' AND RC_section ='config'");
	$result=$database->loadObject();
	$RC_link = $result->RC_value;
	if (empty($RC_link)) $title[] = $sid;

	if ($RC_link>=1)
	{
		$word=null;
		$database->setQuery("SELECT word FROM #__rafcloud_stat WHERE id='".intval($sid)."'");
		$result=$database->loadObject();
		if (!empty($result)) $word=trim($result->word);
		if ($RC_link==2) $word.="-".$sid;
		if (!empty($word)) $title[] = $word;
	}



// ------------------  standard plugin finalize function - don't change ---------------------------  
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString, 
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null), 
      (isset($shLangName) ? @$shLangName : null));
}      
// ------------------  standard plugin finalize function - don't change ---------------------------
     
?>