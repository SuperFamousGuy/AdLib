<?php
/**
* @version 3.0
* @package Raf Cloud
* @copyright Copyright (C) 2007 Skorp. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Raf Cloud is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivaFttive of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @Author: Rafal Blachowski (Skorp) <http://joomla.royy.net>
*/
defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );


require_once( $mainframe->getPath( 'admin_html' ) );

global $RC_version;

$RC_version = "3.0_beta_9";
$encoding = "UTF-8";
$langcode=".utf-8";
$lang =& JFactory::getLanguage();

if( !@include_once( JPATH_SITE ."/administrator/components/com_rafcloud/language/".$lang->getBackwardLang().$langcode.".php" ) ) {
	include_once( JPATH_SITE ."/administrator/components/com_rafcloud/language/english.php" );
}
//require(JPATH_SITE."/administrator/components/com_rafcloud/settings.php");

//JRequest::get( 'post' );
$task = JRequest::getCmd( 'task' );
$no_html = JRequest::getInt( 'no_html' );
$plid = JRequest::getVar( 'plid', array(0), 'post', 'array' );
//$cid = josGetArrayInts( 'cid' );
$cid = JRequest::getVar( 'cid', array(0), 'post', 'array' );

$option="com_rafcloud";

require(JPATH_SITE."/administrator/components/com_rafcloud/includes/config.class.php");
require(JPATH_SITE."/administrator/components/com_rafcloud/includes/tag.creator.class.php");

$RC_config = new RafCloud_config();
$tagCreator = new RafCloud_TagCreator($RC_config);

switch ($task) {
	case 'upload':
		upload($option);
		break;
	case 'publish':
		publishWord( $cid,1,$option );
		$tagCreator->setFontSize();
		viewWords( $option );
		break;
	case 'unpublish':
		publishWord( $cid, 0 ,$option );
		$tagCreator->setFontSize();
		viewWords( $option );
		break;
	case 'publishPlugin':
		publishPlugin( $plid,1,$option );
		break;
	case 'unpublishPlugin':
		publishPlugin( $plid, 0 ,$option );
		break;
	case 'config':
		showConfig( $option,$RC_config );
		break;
	case 'saveconfig':
		saveConfig($option);
		//viewWords( $option );
		$mainframe->redirect("index2.php?option=$option&task=refresh", RC_SAVED);
		break;
	case 'create':
		$tagCreator->createCloudArray ();
		viewWords( $option );
		//$mainframe->redirect( "index2.php?option=$option&task=view" );
		break;
	case 'eraseAll': //disabled
		emptyDatabase ($option);
		$mainframe->redirect( "index2.php?option=$option" );
		break;
	case 'eraseUnpubl':
		eraseUnpublished ($option);
		$mainframe->redirect( "index2.php?option=$option" );
		break;
	case 'removeWords':
		$eraseDes=true;
		viewWords( $option );
		break;
	case 'plugins':
		plugins ($option);
		break;
	case 'removePlugin':
		removePlugin( $plid, $option);
		break;
	case 'refresh':
		//eraseUnpublished($option);
		//$tagCreator->createCloudArray ();
		viewWords( $option );
		break;
	case 'view':
		viewWords( $option );
		break;
	case 'addBlacklist':
		addBlacklist($cid, $option );
		viewWords( $option );
		break;
	case 'sortBlacklist':
		echo(sortBlacklist());
		break;
	default:
		viewWords( $option );
		break;
}

function viewWords( $option) {
	global  $mainframe;

	$database = &JFactory::getDBO(); 
	$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search = $database->getEscaped( trim( $search ) );

	$showPublished = $mainframe->getUserStateFromRequest( "showPublished{$option}", 'showPublished', '' );
	$showPublished = $database->getEscaped( trim( $showPublished ) );

	$orderby = JRequest::getWord('orderby', 'counter');
	$sort = JRequest::getWord('ordering', 'DESC');
	//$limit 		= intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', 10 ) );
	//$limitstart = intval( $mainframe->getUserStateFromRequest( "viewban{$option}limitstart", 'limitstart', 10 ) );

	$context	= 'com_rafcloud.word.list.';

	$limit		= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
	$limitstart	= $mainframe->getUserStateFromRequest($context.'limitstart', 'limitstart', 0, 'int');

	if( !empty( $search ) ) 
		$r_search=" WHERE word LIKE '%$search%' ";
	else
		$r_search=null;

	$query = "SELECT COUNT(*)"
	. "\n FROM #__rafcloud_stat ".$r_search." ORDER BY ".$orderby." ".$sort." , word ASC";
	$database->setQuery( $query );
	$total = $database->loadResult();

	jimport('joomla.html.pagination');
	//require_once( JPATH_SITE.'/administrator/includes/pageNavigation.php' );
	$pageNav = new JPagination( $total, $limitstart, $limit );
	

	$query = "SELECT * FROM #__rafcloud_stat ".$r_search." ORDER BY ".$orderby." ".$sort." , word ASC "
	;
	$database->setQuery( $query ,$pageNav->limitstart,$pageNav->limit);
	$rows = $database->loadObjectList();

	HTML_rafcloud::showWords( $rows, $pageNav, $option ,$search ,$sort, $orderby,$showPublished);
}

function sortBlacklist()
{
	global $RC_config;
	$RC_blacklist = $RC_config->getValue("RC_blacklist");
	$blist = explode (",",str_replace(" ","",$RC_blacklist));
	$blist=array_unique($blist);
	sort($blist);
	$blist=implode(",<br>",$blist);
	return $blist;
}

function publishWord( $cid=null, $publish=1, $option ) {
	global $my;
	$database = &JFactory::getDBO();
	if (!is_array( $cid ) || count( $cid ) < 1) 
	{
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__rafcloud_stat SET dateAdd=now(), published='$publish'"
	. "\nWHERE id IN (".$cids.")");
	if (!$database->query()) 
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
}

function addBlacklist( $cid=null, $option ) {
	global $my;
	$database = &JFactory::getDBO();
	$RC_config = new RafCloud_config();
	if (!is_array( $cid ) || count( $cid ) < 1) 
	{
		echo "<script> alert('Select an item to blacklist'); window.history.go(-1);</script>\n";
		exit;
	}

	$cid=$cid[0];
	$database->setQuery("SELECT * FROM #__rafcloud_stat WHERE id=".$cid);
	if ($row=$database->loadObject())
	{
		$word=$row->word;
		$database->setQuery( "DELETE FROM #__rafcloud_stat WHERE id =".$cid);
		if (!$database->query()) 
		{
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
			exit();
		} else
		{
			$RC_blacklist = $RC_config->getValue("RC_blacklist");
			if (empty($RC_blacklist))
				$RC_blacklist = $word;
			else
				$RC_blacklist.=", ".$word;

			$RC_config->setValue("RC_blacklist", $RC_blacklist,'config');
		}
	}else
	{
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
}

function removeBlacklisted()
{

}

function emptyDatabase($option)
{
		$database = &JFactory::getDBO();
	$database -> setQuery("DELETE FROM #__rafcloud_stat");
	$database -> query();
}

function eraseUnpublished($option)
{
	$database = &JFactory::getDBO();
	$database -> setQuery("DELETE FROM #__rafcloud_stat WHERE published=0");
	$database -> query();
}




function publishPlugin( $plid=null, $publish=1, $option ) {
	global $my,$mainframe;
	$database = &JFactory::getDBO();
	if (!is_array( $plid ) || count( $plid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$plids = implode( ',', $plid );
	$plids=str_replace(",","','",$plids);

	$database->setQuery( "UPDATE #__rafcloud_plugins SET published='$publish' "
	. "\nWHERE plugin IN ('".$plids."')");
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$mainframe->redirect( "index2.php?option=$option&task=plugins" );
}

function removePlugin( $plid=null, $option ) {
	global $mainframe;
	$database = &JFactory::getDBO();
	$dir=JPATH_SITE."/administrator/components/com_rafcloud/plugins/";
	if (!is_array( $plid ) || count( $plid ) < 1) {
		echo "<script> alert('Select an item to remove'); window.history.go(-1);</script>\n";
		exit;
	}

	foreach($plid as $plugin)
	{
		$database->setQuery("SELECT * FROM #__rafcloud_plugins WHERE plugin='".$plugin."'");
		if ($row=$database->loadObject())
		{
			//$plugin=$row->plugin;
			$database->setQuery( "DELETE FROM #__rafcloud_plugins WHERE plugin ='".$plugin."'");
			if ($database->query()) 
			{
				if (!unlink($dir.$plugin))
				{
					echo "<script> alert('Error unlink file!'); window.history.go(-1); </script>\n";
					exit();
				}
			}
			else
			{
				echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
				exit();
			}
		}
	}
	$mainframe->redirect( "index2.php?option=$option&task=plugins" );
}


/*Configuratior*/
function showConfig( $option='com_rafcloud',&$RC_config) {
	HTML_rafcloud::settings( $option ,$RC_config);
}

function saveConfig ($option) {
	global  $mainframe;
	$database = &JFactory::getDBO();

if ((JRequest::getVar('remove_database')==1)&&(JRequest::getVar('remove_database_1')))
{
	$database->setQuery("DROP TABLE `#__rafcloud_config`;");
	if (!$database->query()) $mainframe->redirect("index2.php?option=$option", "rafcloud_config - ".RC_ERROR); 
	$database->setQuery("DROP TABLE `#__rafcloud_plugins`;");
	if (!$database->query()) $mainframe->redirect("index2.php?option=$option", "rafcloud_plugins - ".RC_ERROR);
	$database->setQuery("DROP TABLE `#__rafcloud_stat`;");
	if (!$database->query()) $mainframe->redirect("index2.php?option=$option", "rafcloud_stat - ".RC_ERROR);

	$mainframe->redirect("index2.php?option=com_installer&element=component", RC_REMOVED );
	//$mainframe->redirect("index2.php?option=$option", RC_REMOVED);
return;
}

$RC_config = new RafCloud_config();
$RC_config->setValue("RC_enabled", JRequest::getVar('words_enabled'),'config');
$RC_config->setValue("RC_published", JRequest::getVar('published'),'config');
$RC_config->setValue("RC_min_counter", JRequest::getVar('mincounter'),'config');
$RC_config->setValue("RC_min_len", JRequest::getVar('minlen'),'config');
if (JRequest::getVar('maxlen')>200) $ml=200; else $ml=JRequest::getVar('maxlen');
$RC_config->setValue("RC_max_len", $ml,'config');
$RC_config->setValue("RC_blacklist", JRequest::getVar('blacklist'),'config');
$RC_config->setValue("RC_whitelist", JRequest::getVar('whitelist'),'config');
$RC_config->setValue("RC_min_font", JRequest::getVar('minfont'),'config');
$RC_config->setValue("RC_max_font", JRequest::getVar('maxfont'),'config');

$RC_config->setValue("RC_run_period", JRequest::getVar('run_period'),'scheduler');
$RC_config->setValue("RC_run_period_unit", JRequest::getVar('period_unit'),'scheduler');
$RC_config->setValue("RC_run_limit", JRequest::getVar('run_limit'),'scheduler');
$RC_config->setValue("RC_admin_email", JRequest::getVar('admin_email'),'scheduler');
$RC_config->setValue("RC_run_hour", JRequest::getVar('run_hour'),'scheduler');
$RC_config->setValue("RC_run_minute", JRequest::getVar('run_minute'),'scheduler');
$RC_config->setValue("RC_run_day", JRequest::getVar('run_day'),'scheduler');
$RC_config->setValue("RC_run_month", JRequest::getVar('run_month'),'scheduler');
$RC_config->setValue("RC_run_year", JRequest::getVar('run_year'),'scheduler');

$RC_config->setValue("RC_preg_replace", JRequest::getVar('replace_pattern'),'config');
$RC_config->setValue("RC_str_lower", JRequest::getVar('str_lower'),'config');


$RC_config->setValue("RC_key_enabled", JRequest::getVar('key_enabled'),'config');
$RC_config->setValue("RC_key_published", JRequest::getVar('key_published'),'config');
$RC_config->setValue("RC_key_min_counter", JRequest::getVar('key_mincounter'),'config');
$RC_config->setValue("RC_key_min_len", JRequest::getVar('key_minlen'),'config');
if (JRequest::getVar('key_maxlen')>200) $ml=200; else $ml=JRequest::getVar('key_maxlen');
$RC_config->setValue("RC_key_max_len", $ml,'config');
$RC_config->setValue("RC_key_whitelist", JRequest::getVar('key_whitelist'),'config');

$RC_config->setValue("RC_key_preg_replace", JRequest::getVar('key_replace_pattern'),'config');
$RC_config->setValue("RC_key_str_lower", JRequest::getVar('key_str_lower'),'config');
$RC_config->setValue("RC_key_asword", JRequest::getVar('key_asword'),'config');

$RC_config->setValue("RC_on_cache", JRequest::getVar('cache'),'config');
$RC_config->setValue("RC_sh404sef_prefix", JRequest::getVar('sh404p'),'config');
$RC_config->setValue("RC_sh404sef_link", JRequest::getVar('sh404link'),'config');

//$RC_config->setValue("", JRequest::getVar(''],'config');

	if(is_file(JPATH_SITE."/administrator/components/com_rafcloud/settings.php"))
	{	
		if (!unlink(JPATH_SITE."/administrator/components/com_rafcloud/settings.php")) 	$mainframe->redirect("index2.php?option=$option", RC_ERROR_REMCONF);
	}
	if (JRequest::getVar('resetrun')) 
		unlink(JPATH_SITE."/administrator/components/com_rafcloud/runlog.php");

}


function loadPluginDescr ($plugin)
{	
	$fname= JPATH_SITE ."/administrator/components/com_rafcloud/plugins/".$plugin;

	$file = @fopen ($fname, "r");
	if ($file) 
	{	
		$isDes=false;
		$isPackage=false;
		$isVersion=false;
		while (!feof($file))
		{
    			$buffer = fgets($file, 4096);
			echo($buffer);
			if (strpos($buffer,"descr")!==FALSE) $isDes=true;
			if (strpos($buffer,"@package Raf Cloud")!==FALSE) $isPackage=true;
			if (strpos($buffer,"@version 3.")!==FALSE) $isVersion=true;
    		}
		fclose ($file);
		if($isDes&&$isPackage&&$isVersion)
		{
			$runMe=false;
			include( JPATH_SITE ."/administrator/components/com_rafcloud/plugins/".$plugin );
			if (empty($descr)) return null;
			return $descr;
		}
	}
return null;
}

function savePluginInfo($plugin)
{
	global  $mainframe;
	$database = &JFactory::getDBO();
	$dir=JPATH_SITE."/administrator/components/com_rafcloud/plugins/";
	$plugin=strtolower($plugin);
	if ($descr=loadPluginDescr($plugin))
	{	
	$database->setQuery("SELECT * FROM #__rafcloud_plugins WHERE plugin='".$plugin."'");
	if ($row=$database->loadObject())
	{
		$database -> setQuery("UPDATE #__rafcloud_plugins SET descr='".$descr."' WHERE plugin='".$plugin."'");
	} else
	{ 
		$database -> setQuery("INSERT INTO #__rafcloud_plugins (plugin,descr) VALUES ('".$plugin."','".$descr."')");
	}
	$database -> query();
	} else
	{
		if (!unlink($dir.$plugin))
		{
			echo "<script> alert('Error unlink file!'); window.history.go(-1); </script>\n";
			exit();
		}
		$mainframe->redirect( "index2.php?option=com_rafcloud&task=plugins", RC_ERROR_PLUGIN );
	}
	
}



function upload($option)
{
	global  $mainframe;

	$dir=JPATH_SITE."/administrator/components/com_rafcloud/plugins/";

	//$file = mosGetParam( $_FILES, 'rcfile', null );

	$file = $_FILES['rcfile'];	

	if (isset($file) && is_array($file))
	{
		if (strtolower(substr( $file['name'], -4 ))!=".php") 
			$mainframe->redirect( "index2.php?option=com_rafcloud&task=plugins", RC_ERROR_UPLOAD_1.".php" );
	
		if (!move_uploaded_file($file['tmp_name'], $dir.strtolower($file['name'])))
			$mainframe->redirect( "index2.php?option=com_rafcloud&task=plugins", RC_ERROR_UPLOAD_2 );
	
	} else $mainframe->redirect( "index2.php?option=com_rafcloud&task=plugins", RC_ERROR_UPLOAD);

savePluginInfo($file['name']);

$mainframe->redirect( "index2.php?option=com_rafcloud&task=plugins", RC_OK_UPLOAD );
}


function plugins($option)
{
	global $mainframe;
	$database = &JFactory::getDBO();
	//$limit 		= intval( $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit',5 ) );
	//$limitstart = intval( $mainframe->getUserStateFromRequest( "viewban{$option}limitstart", 'limitstart', 0 ) );
	$query = "SELECT COUNT(*)"
	. "\n FROM #__rafcloud_plugins ";
	$database->setQuery( $query );
	$total = $database->loadResult();

	//require_once( JPATH_SITE. '/administrator/includes/pageNavigation.php' );
	//$pageNav = new mosPageNav( $total, $limitstart, $limit );
	

	$query = "SELECT * FROM #__rafcloud_plugins ORDER BY plugin"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	HTML_rafcloud::showPlugins($rows, $pageNav, $option );
}


?>