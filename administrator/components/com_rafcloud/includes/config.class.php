<?php
/**
* @version 3.0
* @package Raf Cloud
* @copyright Copyright (C) 2007 Skorp. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* Raf Cloud is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @Author: Rafal Blachowski (Skorp) <http://joomla.royy.net>
*/

defined('_JEXEC') or die('Restricted access');

class RafCloud_config
{

function setValue( $key, $value, $section) 
{
	$database = &JFactory::getDBO(); 

	if ((!empty($section))&&(!empty($key)))
	{
		$sql = "SELECT COUNT(*) FROM #__rafcloud_config WHERE RC_key =\"".$key."\" AND  RC_section=\"".$section."\"";
		$database->setQuery( $sql );
		if ($database->loadResult()>0)
		{
		    	$sql = "UPDATE #__rafcloud_config SET RC_value = \"".$value."\" WHERE RC_key =\"".$key."\" AND  RC_section=\"".$section."\"";
		}else
		{
			$sql= "INSERT INTO #__rafcloud_config (RC_value,RC_key,RC_section) VALUES (\"".$value."\",\"".$key."\",\"".$section."\")";
		}
		$database->setQuery($sql);
		$database->query();

		if($database->getErrorNum()) {
			$err = $database->stderr(true);
			trigger_error("Cannot set value '{$value}' for the '{$key}' key in section {$section}. {$err}");
		}
	}
}

function getValue($key , $section='config') 
{
	$database = &JFactory::getDBO(); 

	if (!empty($key))
	{
	    	$sql = "SELECT RC_value FROM #__rafcloud_config WHERE RC_key = \"".$key."\" AND RC_section =\"".$section."\"";
	    	$database->setQuery( $sql );
	    	$return  = $database->loadResult();

		if ($database->getErrorNum())
			echo $this->database->stderr();
		else
			return $return;
    	}
	return null;
}

function getValues($section='config')
{
	$database = &JFactory::getDBO(); 

	if (!empty($section))
	{
	    	$sql = "SELECT RC_key,RC_value FROM #__rafcloud_config WHERE RC_section ='".$section."'";
	    	$database->setQuery( $sql );
	    	$return  = $database->loadObjectList();
		if ($database->getErrorNum())
			echo $this->database->stderr();
		else
			return $return;
	}
	return null;
}

function isSection($section='config')
{
	$database = &JFactory::getDBO();
	if (!empty($section))
	{
	    	$sql = "SELECT count(RC_section) FROM #__rafcloud_config WHERE RC_section ='".$section."'";
	    	$database->setQuery( $sql );
	    	return $database->loadResult();
	}
}

}
?>