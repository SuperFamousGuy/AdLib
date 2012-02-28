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

defined( '_JEXEC' ) or die( 'Direct Access to this location is not allowed.' );

if (!function_exists("RC_stripos")) {
  function RC_stripos(&$str,&$needle,$offset=null)
  {
      //return strpos(strtolower($str),strtolower($needle),$offset);
      return JString::strpos(JString::strtolower($str),JString::strtolower($needle),$offset);
  }
}

if( !function_exists('memory_get_usage') )
{
    function memory_get_usage()
    {
        if ( substr(PHP_OS,0,3) == 'WIN')
        {
               if ( substr( PHP_OS, 0, 3 ) == 'WIN' )
                {
                    $output = array();
                    exec( 'tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output );
                    return preg_replace( '/[\D]/', '', $output[5] ) * 1024;
                }
        }else
        {
            $pid = getmypid();
            exec("ps -eo%mem,rss,pid | grep $pid", $output);
            $output = explode("  ", $output[0]);
            //rss is given in 1024 byte units
            return $output[1] * 1024;
        }
    } 
}


function RC_trim_value(&$value) 
{ 
    $value = trim($value); 
}


class RafCloud_TagCreator
{

var $RC_config = null;
var $encoding = null;
var $lastTime = null;
var $debug = 0;
var $correctPHP = null;
var $RC_key_preg_replace = null;
var $RC_preg_replace = null;
var $RC_cache = true;
var $RC_startMem = 0;
var $RC_excluded = null;
var $RC_tag = array();
var $RC_key = array();
var $RC_key_str_lower = null;
var $RC_str_lower = null;
var $RC_key_asword = 0;
var $RC_min_counter=0;
var $RC_key_min_counter=0;
var $RC_published=0;
var $RC_key_published=0;

function RafCloud_TagCreator($RC_config)
{
	$this->RC_config=$RC_config;
	$this->encoding = "UTF-8";
	$this->lastTime = $this->getmicrotime();
	$this->correctPHP = $this->correctPHPversion();
	$this->RC_key_preg_replace= $this->RC_config->getValue("RC_key_preg_replace");
	$this->RC_preg_replace= $this->RC_config->getValue("RC_preg_replace");	
	$this->RC_startMem = memory_get_usage(); 
	$RC_blacklist  = $this->RC_config->getValue("RC_blacklist");
	$this->RC_excluded=explode(",",preg_replace("/[.\-:><()!?\n]/", " ", $RC_blacklist));
	$this->trim_array($this->RC_excluded);
	$this->RC_str_lower=$this->RC_config->getValue("RC_str_lower");
	$this->RC_key_str_lower=$this->RC_config->getValue("RC_key_str_lower");
	if ($this->RC_config->getValue("RC_on_cache")!=null)
		$this->RC_cache = $this->RC_config->getValue("RC_on_cache");
	$this->RC_key_asword=$this->RC_config->getValue("RC_key_asword");

	$this->RC_min_counter=$this->RC_config->getValue("RC_min_counter");
	$this->RC_key_min_counter=$this->RC_config->getValue("RC_key_min_counter");
	$this->RC_published = $this->RC_config->getValue("RC_published");
	$this->RC_key_published = $this->RC_config->getValue("RC_key_published");
}

function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
    } 

function memUsage($level)
{
	$memus=memory_get_usage();
	$mem = $memus-$this->RC_startMem;
	$this->RC_startMem=$memus;
	$mem = round($mem/1000,2);
	echo (RC_MEMUS."( ".$level." )".$mem." KB <br>");
}

function runTime($level)
{
	if ($this->debug)
	{
		$time_end = $this->getmicrotime();
		$time = $time_end - $this->lastTime;
		$this->lastTime=$time_end;
		$time = round($time,6);
		$time = RC_GENTIME."( ".$level." ) : ".$time." s<br>";
		echo ($time);
		$this->memUsage($level);
	}
}

function addWord(&$tags)
{
	if (!empty($tags))
	{
		foreach ($tags as $word => $counter)
		{	
			$word=trim($word);
			if (($this->checkWord($word,$this->RC_excluded))&&($counter>=$this->RC_min_counter))
			{
				$this->saveWord($word,$counter,0,$this->RC_published,1);
			}
		}
		unset($tags);
	}
}


function addKeyWord(&$tags)
{
	if (!empty($tags))
	{
		foreach ($tags as $word => $counter)
		{	
			$word=trim($word);
			if (($this->checkWord($word,$this->RC_excluded))&&($counter>=$this->RC_key_min_counter))
			{
				$this->saveWord($word,$counter,0,$this->RC_key_published,2);
			}
		}
		unset($tags);
	}
}

function addKey(&$metaKeys)
{
	if (!empty($metaKeys))
	{
		foreach ($metaKeys as $key => $counter)
		{
			$key=trim($key);
			if 	(($this->checkKey($key,$this->RC_excluded))&&($counter>=$this->RC_key_min_counter))
			{
				$this->saveWord($key,$counter,0,$this->RC_key_published,2);
			}
		}
		unset($metaKeys);
	}
}

function cacheTag(&$stag,&$metaKey)
{
	if ($this->RC_cache)
	{
		if (!empty($stag))
		{

			$this->validate($stag);
			$stag=$this->RC_strtolower($stag,$this->RC_str_lower);

			$tags=explode(" ",$stag);
			unset($stag);
			$this->trim_array($tags);
			$tags=array_count_values($tags);
			foreach ($tags as $word => $counter)
				{
					if (!empty($word))
					{
						if (!empty($this->RC_tag[$word]))
						{
							$tempCounter=$this->RC_tag[$word];
						} else $tempCounter=0; //patch 20080725 

						$this->RC_tag[$word]=$counter+$tempCounter;
					}
				}
		}
	

		if (!empty($metaKey))
		{
			if ($this->RC_key_asword)
			{
				$this->validate($metaKey);
				$metaKey=$this->RC_strtolower($metaKey,$this->RC_key_str_lower);
				$metaKeys=explode(" ",$metaKey);
			}else
			{
				$this->validate_key($metaKey);
				$metaKey=$this->RC_strtolower($metaKey,$this->RC_key_str_lower);
				$metaKeys=explode(",",$metaKey);
			}
		unset($metaKey);
		$this->trim_array($metaKeys);
		$metaKeys=array_count_values($metaKeys);

		foreach ($metaKeys as $key => $counter)
				{
					if (!empty($key))
					{
						if (!empty($this->RC_key[$key]))
						{
							$tempCounter=$this->RC_key[$key];
						} else $tempCounter=0;
						$this->RC_key[$key]=$counter+$tempCounter;
					}
				}
			}	

	return true;
	}
	return false;
}

function createCloudArray ()
{
	$database = &JFactory::getDBO();
	if ($this->debug) 
	{	
		if ($this->RC_cache) $isCache=RC_YES; else $isCache=RC_NO;
		echo ("PHP= ".phpversion()." charset=".$this->encoding."<br> RafCloud cache = ".$isCache."<br>");
	}
	$this->resetStat();
	$stag=" ";
	$metaKey=" ";
	$database -> setQuery("UPDATE #__rafcloud_stat SET new=0");
	$database -> query();
	$this->runTime("Start");
	$this->loadPlugins($stag,$metaKey);
	//$this->runTime("Plugins");


if ($this->RC_cache)
{
	$this->addWord($this->RC_tag);
	$this->runTime("Words");
	if ($this->RC_config->getValue("RC_key_asword"))
		$this->addKeyWord($this->RC_key);
	else 	$this->addKey($this->RC_key);

}
else
{
//word
	if ((!empty($stag))&&($this->RC_config->getValue("RC_enabled")>0))
	{



		$this->validate($stag);
		$stag=$this->RC_strtolower($stag,$this->RC_str_lower);

		$tags=explode(" ",$stag);
		unset($stag);
		$this->trim_array($tags);
		$tags=array_count_values($tags);
		$this->addWord($tags);
		$this->runTime("Words");
	}
//key
	if ((!empty($metaKey))&&($this->RC_config->getValue("RC_key_enabled")>0))
	{
		if ($this->RC_config->getValue("RC_key_asword"))
		{
			$this->validate($metaKey);
			$metaKey=$this->RC_strtolower($metaKey,$this->RC_key_str_lower);
			$tags=explode(" ",$metaKey);
			unset($metaKey);
			$this->trim_array($tags);
			$tags=array_count_values($tags);
			$this->addKeyWord($tags);
		}else
		{
			$this->validate_key($metaKey);
			$metaKey=$this->RC_strtolower($metaKey,$this->RC_key_str_lower);
			$metaKeys=explode(",",$metaKey);
			unset($metaKey);
			$this->trim_array($metaKeys);
			$metaKeys=array_count_values($metaKeys);
			$this->addKey($metaKeys);
		}
	}

}
	$this->runTime("Keys");
	$this->addWhiteList();
	$this->runTime("Whitelist");
	$this->setFontSize();
	$this->runTime("Font size");
	$this->eraseZeroCounter();
	$this->runTime("Erase 0 counter");
}

function addWhiteList()
{
	$database = &JFactory::getDBO();
	$RC_whitelist  = $this->RC_config->getValue("RC_whitelist");
	$RC_min_counter = $this->RC_config->getValue("RC_min_counter");
	$RC_key_whitelist = $this->RC_config->getValue("RC_key_whitelist");
	$RC_key_min_counter = $this->RC_config->getValue("RC_key_min_counter");

	if ((!empty($RC_whitelist))&&($this->RC_config->getValue("RC_enabled")>0))
	{
		$this->validate($RC_whitelist);
		$words=explode(" ",$RC_whitelist);
		$this->trim_array($words);
		foreach ($words as $word)
		{
			$this->saveWord($word,$RC_min_counter,1,0,4);
		}
	}
	if ((!empty($RC_key_whitelist))&&($this->RC_config->getValue("RC_key_enabled")>0))
	{
		$keys=explode(",",preg_replace("/[.\-:><()!?\n]/", " ", $RC_key_whitelist));
		$this->trim_array($keys);
		foreach ($keys as $key)
		{
			$this->saveWord($key,$RC_key_min_counter,1,0,5);
		}
	}
}

function setFontSize()
{
	$database = &JFactory::getDBO();
	$RC_max_font = $this->RC_config->getValue("RC_max_font");
	$RC_min_font = $this->RC_config->getValue("RC_min_font");

	$database->setQuery("SELECT max(counter) as 'maxCount', min(counter) as 'minCount' FROM #__rafcloud_stat WHERE published=1");

	$maxCount=0;
	$minCount=0;
	if($row=$database->loadObject())
	{ 
		$maxCount=$row->maxCount;
		$minCount=$row->minCount;
	}
	if($RC_min_font<=0) $RC_min_font=1;
	if($RC_max_font<$RC_min_font) $RC_max_font=$RC_min_font;

	$database->setQuery("SELECT * FROM #__rafcloud_stat WHERE published=1 ORDER BY counter DESC");
	if ($rows=$database->loadObjectList())
	{
		foreach($rows as $row)
		{
			$diff=$maxCount-$minCount;
			if ($diff>0)
			{
				$fontDiff=$RC_max_font-$RC_min_font;
				$odn=$row->counter-$minCount;
				$fontSize=$RC_min_font+intval($odn*$fontDiff/$diff);
			} else $fontSize=$RC_min_font;
			$database->setQuery("UPDATE #__rafcloud_stat SET fontSize=".$fontSize." WHERE word='".$row->word."'");
			$database->query();

		}
	}
}

function pluginTag($plugin,&$stag,&$metaKey)
{
	$runMe=true;
	$loadWord=$this->RC_config->getValue("RC_enabled");
	$loadKey=$this->RC_config->getValue("RC_key_enabled");
	if( is_file( JPATH_SITE  ."/administrator/components/com_rafcloud/plugins/".$plugin ) ) 
	{
		if ($this->RC_cache) {$stag=null; $metaKey=null;}
		include( JPATH_SITE  ."/administrator/components/com_rafcloud/plugins/".$plugin );
		$this->runTime($plugin);
	} else return false;
return true;
}


function loadPlugins (&$stag,&$metaKey)
{
	$database = &JFactory::getDBO();

	$query = "SELECT * FROM #__rafcloud_plugins WHERE published=1";
	$database->setQuery( $query );
	if ($rows = $database->loadObjectList())
	{
		foreach($rows as $row)
		{
			$this->pluginTag($row->plugin,$stag,$metaKey);
		}
	}
return true;
}

function checkWord($word,&$excluded)
{
	$RC_min_len = $this->RC_config->getValue("RC_min_len");
	$RC_max_len = $this->RC_config->getValue("RC_max_len");
	$strlength = JString::strlen($word);
	if ($strlength<=$RC_min_len) return false;
	if ($strlength>=$RC_max_len) return false;
	if (empty ($word)) return false;
	if (!empty($excluded)) if (in_array($word,$excluded)) return false;
return true;
}

function checkKey($key,&$excluded)
{
	$RC_key_min_len = $this->RC_config->getValue("RC_key_min_len");
	$RC_key_max_len = $this->RC_config->getValue("RC_key_max_len");
	$RC_blacklist=$this->RC_config->getValue("RC_blacklist");
	$strlength = JString::strlen($key);
	if ($strlength<=$RC_key_min_len) return false;
	if ($strlength>=$RC_key_max_len) return false;
	if (empty ($key)) return false;
	if (!empty($RC_blacklist)) if (RC_stripos($RC_blacklist,$key)!==FALSE) return false;
return true;
}


function RC_strtolower($temptag,$func)
{
	if ($func==2){
		return JString::strtolower($temptag);
	}  //problem with encoding
	if ($func==1)
		return strtolower($temptag);
	return $temptag;
}


function trim_array(&$arr){
	array_walk($arr, 'RC_trim_value');
}

function eraseZeroCounter()
{
	$database = &JFactory::getDBO();
	$database -> setQuery("DELETE FROM #__rafcloud_stat WHERE published=0 and counter=0");
	$database -> query();
}

function correctPHPversion()
{
   	if (version_compare(phpversion(), '5.0.0')<0) 
		return false; 
	else 
		return true;
}

function UTF_decode($var) 
{
	$var=iconv("UTF-8","ISO-8859-1",$var);
	$var=html_entity_decode($var, ENT_QUOTES, 'ISO-8859-1');
	return iconv("ISO-8859-1","UTF-8",$var);
}


function validate(&$stag)
{
	$stag=strip_tags($stag);

	$replace = array("&nbsp;","&bdquo;","&rdquo;","&ndash;","&quot;");
	$stag=str_replace($replace," ",$stag);

	//begin patch - bug in PHP 4  http://bugs.php.net/bug.php?id=25670
	if (!$this->correctPHP){
		$stag = $this->UTF_decode($stag); 
	}else
	{
		$stag=html_entity_decode($stag,ENT_QUOTES,$this->encoding);
	}
	//end patch

	if (empty($this->RC_preg_replace))
		$stag=preg_replace("/[,.\-:><()!?\n\"'{}]/", " ", $stag); 
	else
		$stag=preg_replace($this->RC_preg_replace, " ", $stag); 
}

function validate_key(&$skey)
{
	$skey=strip_tags($skey);

	$replace = array("&nbsp;","&bdquo;","&rdquo;","&ndash;","&quot;");
	$skey=str_replace($replace," ",$skey);

	//begin patch - bug in PHP 4 http://bugs.php.net/bug.php?id=25670 
	if (!$this->correctPHP)
	{
		$skey = $this->UTF_decode($skey); 
	}else
	{
		$skey=html_entity_decode($skey,ENT_QUOTES,$this->encoding);
	}
	//end patch
	if (empty($this->RC_key_preg_replace))
		$skey=preg_replace("/[.\-:><()!?\n\"']/", " ", $skey); 
	else
		$skey=preg_replace($this->RC_key_preg_replace, " ", $skey); 

}

function resetStat()
{
	$database = &JFactory::getDBO();
	$database -> setQuery("UPDATE #__rafcloud_stat SET counter=0,type=0");
	$database -> query();
}

function saveWord($word,$counter,$whitelist_on=0,$published=0,$type=1)
{

	$database = &JFactory::getDBO();

	$word=trim($word);
	$wordLenght=JString::strlen($word);
	$database->setQuery("SELECT * FROM #__rafcloud_stat WHERE word='".$word."'");
	if ($row=$database->loadObject())
	{
		if (($row->type==1)&&($type==2)) 
		{
			$counter+=$row->counter; //patch 03-06-2008 - word/key problem
			$type=3;
		}
		if ($whitelist_on==1)
		{
			$database -> setQuery("UPDATE #__rafcloud_stat SET published=1,type='".$type."' WHERE word='".$word."'");
			$database -> query();
		}else
		{
			if ($row->counter!=$counter)
			{
				$database -> setQuery("UPDATE #__rafcloud_stat SET counter='".$counter."', type='".$type."' WHERE word='".$word."'");
				$database -> query();
			}
		}

	}else
	{
		if ($whitelist_on==1) $pub=1; else $pub=$published;
		$database -> setQuery("INSERT INTO #__rafcloud_stat (word,counter,published,dateAdd,wordLenght,new,type) VALUES ('".$word."',".$counter.",'".$pub."',now(),$wordLenght,1,'".$type."')");
		$database -> query();
	}
}
}
?>