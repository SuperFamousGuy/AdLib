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

class HTML_rafcloud {

	function showWords( &$rows, &$pageNav, $option, $search, $sort, $orderby,$showPublished) {
		global $my, $eraseDes,$RC_version;
		//mosCommonHTML::loadOverlib(); RAF
		?>
			    <script type="text/javascript"><!--
	    function reorder(order, sort){
	    	document.adminForm.orderby.value=order;
	    	document.adminForm.ordering.value=sort;
	    	submitbutton();
	    } //-->
	    </script>
<p align="left"><a target="_blank" href="http://www.joomla.royy.net">Raf Cloud v. <?php echo $RC_version;?></a></p>
		<form action="index2.php" method="post" name="adminForm" enctype="multipart/form-data">
		<table class="adminheading">
		<tr><TD align="center"><?php if($eraseDes) echo(RC_ERASE_DES);?></TD></tr>
		<tr>
			<th colspan="2" class="inbox"><?php echo RC_WORD_LIST ?></th>
		</tr>
		<tr>
			<td><?php echo RC_FILTER ?>:
				<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
			</td>
		</tr>
	</table>
		<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		<tr>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $rows ); ?>);" />
			</th>
			<th class="title" width="70"><a href="javascript:reorder('word', '<?php if($sort == "ASC" && $orderby == "word")  echo "DESC"; else echo "ASC"; ?>');"><?php echo RC_WORDS ?></a></th>
			<th class="title" width="40"><a href="javascript:reorder('wordLenght', '<?php if($sort == "DESC" && $orderby == "wordLenght") echo "ASC"; else echo "DESC"; ?>');"><?php echo RC_WORD_LENGHT ?></a></th>
			<th width="50"></th>
			<th class="title" width="40"><a href="javascript:reorder('published', '<?php if($sort == "DESC" && $orderby == "published") echo "ASC"; else echo "DESC"; ?>');"><?php echo RC_PUBLISHED ?>?</a></th>
			<th class="title" width="40"><a href="javascript:reorder('type', '<?php if($sort == "DESC" && $orderby == "counter") echo "ASC"; else echo "DESC"; ?>');"><?php echo RC_TYPE ?></a></th>
			<th class="title" width="40"><a href="javascript:reorder('counter', '<?php if($sort == "DESC" && $orderby == "counter") echo "ASC"; else echo "DESC"; ?>');"><?php echo RC_COUNTER ?></a></th>
			<th class="title" width="40"><a href="javascript:reorder('fontSize', '<?php if($sort == "DESC" && $orderby == "fontSize") echo "ASC"; else echo "DESC"; ?>');"><?php echo RC_FONTSIZE ?></a></th>
			<th class="title" width="65"><a href="javascript:reorder('dateAdd', '<?php if($sort == "DESC" && $orderby == "dateAdd") echo "ASC"; else echo "DESC"; ?>');"><?php echo RC_ADDED ?></a></th>
			<th class="title" width="40"><a href="javascript:reorder('new', '<?php if($sort == "DESC" && $orderby == "new") echo "ASC"; else echo "DESC"; ?>');"><?php echo RC_NEW ?></a></th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			$task 	= $row->published ? 'unpublish' : 'publish';
			$img 	= $row->published ? 'publish_g.png' : 'publish_x.png';
			$alt 	= $row->published ? 'Published' : 'Unpublished';
			?>
		<tr class="row<?php echo $k; ?>">
		<td>
			<input type="checkbox" id="cb<?php echo $i;?>" name="cid[]" value="<?php echo $row->id; ?>" onClick="isChecked(this.checked);">
		</td>
		<td>
			 <?php echo $row->word; ?>
		</td>
		<td><?php echo $row->wordLenght; ?></td>
		<td align="center">
				<?php if ($row->published==0) {?>
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','addBlacklist')">
				<?php echo RC_BLACKLIST_ADD ?>
				</a> <?php }?>
		</td>
		<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
		</td>
		<td><?php 
		switch($row->type)
		{
			case 1: echo RC_WORD; break;
			case 2: echo RC_KEY; break;
			case 3: echo RC_WORD_KEY; break;
			case 4: echo RC_W_WORD; break;
			case 5: echo RC_W_KEY; break;
		}
		?>
	</td>
                <td><?php echo $row->counter; ?></td>
                <td><?php echo $row->fontSize; ?></td>
                <td><?php echo $row->dateAdd; ?></td>
                <td><?php if($row->new) echo ("<img src=\"images/tick.png\" width=\"12\" height=\"12\" border=\"0\">"); ?></td>
		</tr>
              <?php
		$k = 1 - $k;
              	}?>
</table>

			<?php echo $pageNav->getListFooter(); ?>
			<input type="hidden" name="option" value="<?php echo $option; ?>" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
		  	<input type="hidden" name="orderby" value="<?php echo $orderby; ?>" />
		 	<input type="hidden" name="ordering" value="<?php echo $sort; ?>" />
</form>
<?php
	}


function showPlugins(&$rows, &$pageNav, $option)
{
		global $my,$RC_version;

	//	mosCommonHTML::loadOverlib(); //RAF
		?>
			    <script type="text/javascript"><!--
	    function reorder(order, sort){
	    	document.adminForm.orderby.value=order;
	    	document.adminForm.ordering.value=sort;
	    	submitbutton();
	    } //-->
	    </script>
<p align="left"><a target="_blank" href="http://www.joomla.royy.net">Raf Cloud v. <?php echo $RC_version;?></a> </p>
	<form action="index2.php" method="post" name="adminForm">
	<table class="adminheading">
		<tr>
			<th colspan="2" class="inbox"><?php echo RC_PLUGINS ?></th>
		</tr>
		
	</table>
	<table cellpadding="4" cellspacing="0" border="0" width="100%" class="adminlist">
		<tr>
			<th width="20">
			</th>
			<th><?php echo RC_PLUGINS_DES ?></th>
			<th><?php echo RC_PLUGINS_PUBL ?></th>
			<th><?php echo RC_PLUGINS_FILE ?></th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count( $rows ); $i < $n; $i++) {
			$row = &$rows[$i];
			$message = $row->plugin;
			$message = strip_tags($message);
			if (strlen($message) > 80) $message = substr($message, 0 , 78) . " ...";
			$task 	= $row->published ? 'unpublishPlugin' : 'publishPlugin';
			$img 	= $row->published ? 'publish_g.png' : 'publish_x.png';
			$alt 	= $row->published ? 'Published' : 'Unpublished';
			?>
		<tr class="row<?php echo $k; ?>">
		<td>
			<input type="checkbox" id="pl<?php echo $i;?>" name="plid[]" value="<?php echo $row->plugin; ?>" onClick="isChecked(this.checked);">
		</td>
		<td>
			<?php echo $row->descr; ?>
		</td>
		<td align="center">
				<a href="javascript: void(0);" onclick="return listItemTask('pl<?php echo $i;?>','<?php echo $task; ?>')">
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
		</td>
		<td>
			<?php echo $row->plugin; ?>
		</td>
		</tr>
		<?php
		$k = 1 - $k;
		}?>
	</table>
			<input type="hidden" name="option" value="<?php echo $option; ?>" />
			<input type="hidden" name="task" value="plugins" />
			<input type="hidden" name="boxchecked" value="0" />
	</form>
		<form enctype="multipart/form-data" action="index2.php" method="post" name="filename">
		<table class="adminheading">

		<tr>
			<td><?php echo RC_UPLOAD_PLUGIN_DES;?><input class="inputbox" type="file" name="rcfile" size="63" />
			<input class="button" type="submit" value="<?php echo RC_UPLOAD?>" />
			</td>
		</tr>
		<tr><TD><?php echo RC_NEED_PLUGIN; ?></TD></tr>
	
</table>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="upload"/>
</form>
<?php
}

function settings( $option ,&$RC_config) {

	global $RC_version;

	jimport('joomla.html.pane');
	$tabs =& JPane::getInstance('tabs', array('startOffset'=>0));

	$RC_config->setValue("RC_debug", session_id(),'config');
	
	if(is_file(JPATH_SITE."/administrator/components/com_rafcloud/runlog.php"))
		require(JPATH_SITE."/administrator/components/com_rafcloud/runlog.php");

	if ($rows=$RC_config->getValues())
	{
		foreach($rows as $row)
		{
		if (!empty($row))
		{
			//$val="\$".$row->RC_key." = \$row->RC_value;";
			//eval($val);
			$val=strval($row->RC_key);
			$$val=$row->RC_value;
		}
		}
	}

	if ($rows=$RC_config->getValues('scheduler'))
	{
		foreach($rows as $row)
		{
		if (!empty($row))
		{
			//$val="\$".$row->RC_key." = \$row->RC_value;";
			//eval($val);
			$val=strval($row->RC_key);
			$$val=$row->RC_value;
		}
		}
	}

	if ($RC_on_cache==null) $RC_on_cache=true;

	$old_settings=false;
	if(is_file(JPATH_SITE."/administrator/components/com_rafcloud/settings.php"))
	{
		$old_settings=true;
		include(JPATH_SITE."/administrator/components/com_rafcloud/settings.php");
	}
	$endline   = array("\r\n", "\n", "\r");
	?>
<SCRIPT LANGUAGE="JavaScript">
function loadWords()
{
    	document.adminForm.blacklist.value=document.adminForm.blacklist.value+"<?php if(!empty($RC_blacklist)) echo(","); echo JString::str_ireplace($endline,' ',RC_DEFAULT_BLACKLIST_WORDS) ;?>";
}
</script>
<p><font color=red><?php if($old_settings) echo RC_OLD_CONFIG ;?></font></p>
<p align="left"><a target="_blank" href="http://www.joomla.royy.net">Raf Cloud v. <?php echo $RC_version;?></a> </p>
	<p><?php echo RC_MSG_REMEMBER ;?></p>
<table>
<tr><TD>
<strong><?php echo RC_DONATION ;?>:</strong>
</TD></tr><td align="center">
<form action='https://www.paypal.com/cgi-bin/webscr' method='post' target='_blank'>
<input type='hidden' name='cmd' value='_xclick'>
<input type='hidden' name='business' value='paypal&#64royy.net'>
<input type='hidden' name='item_name' value='www.joomla.royy.net'>
<input type='hidden' name='no_note' value='1'>
<input type='hidden' name='amount'  value='5'>
<input type='hidden' name='currency_code' value='EUR'>
<input type='hidden' name='tax' value='0'>
<input type='image' src='https://www.paypal.com/images/x-click-but04.gif' target='_blank' border='0' name='submit' alt='Make payments with PayPal - its fast, free and secure!'>
</FORM>
</TD></tr></table>

	<table class="adminheading"><tr><th nowrap class="config"><?php echo RC_CONFIGURATION ;?></th>
	</tr></table>
  	<form action="index2.php" method="POST" name="adminForm">
<?php
       echo $tabs->startPane("configPane");
       echo $tabs->startPanel(RC_TAB_WORDS, "words");
?>
  <table width="100%" cellpadding="3" cellspacing="0" class="adminForm" style="border:1px solid #CCCCCC;">

    <tr>
      <td width="19%"><strong><?php echo RC_DEFAULT_ENABLE ;?>:</strong></td>
      <td>
      	<input type="radio" name="words_enabled" value="1" <?php if ($RC_enabled) echo "checked"; ?> /><?php echo RC_YES ;?>
      	<input type="radio" name="words_enabled" value="0" <?php if (!$RC_enabled) echo "checked"; ?> /><?php echo RC_NO ;?>			</td>
			<td width="53%"></td>
	</tr>
    <tr>
      <td width="19%"><strong><?php echo RC_DEFAULT_PUBLISHED ;?>:</strong></td>
      <td>
      	<input type="radio" name="published" value="1" <?php if ($RC_published) echo "checked"; ?> /><?php echo RC_YES ;?>
      	<input type="radio" name="published" value="0" <?php if (!$RC_published) echo "checked"; ?> /><?php echo RC_NO ;?>			</td>
			<td width="53%"></td>
	</tr>
    <tr>
      <td><strong><?php echo RC_DEFAULT_MIN_COUNTER ;?>:</strong></td>
      <td>
      	<input type="text" style="width: 60px;" name="mincounter" value="<?php echo $RC_min_counter; ?>"/> 		</td>
			<td><?php echo RC_DEFAULT_MIN_COUNTER_DES ;?></td>
	</tr>
    <tr>
      <td><strong><?php echo RC_DEFAULT_MIN_LEN ;?>:</strong></td>
      <td>
      	<input type="text" style="width: 60px;" name="minlen" value="<?php echo $RC_min_len; ?>"/> 		</td>
			<td><?php echo RC_DEFAULT_MIN_LEN_DES ;?></td>
	</tr>
    <tr>
      <td><strong><?php echo RC_DEFAULT_MAX_LEN ;?>:</strong></td>
      <td>
      	<input type="text" style="width: 60px;" name="maxlen" value="<?php echo $RC_max_len; ?>"/> 		</td>
			<td><?php echo RC_DEFAULT_MAX_LEN_DES ;?></td>
	</tr>
   <tr>

      <td><strong><?php echo RC_DEFAULT_WHITELIST ;?>:</strong></td>
      <td>
      	<textarea rows=5 cols=50 name="whitelist"><?php echo $RC_whitelist; ?></textarea> </td>
			<td valign="top">
	<?php echo RC_DEFAULT_WHITELIST_DES ;?>
</td>
	</tr>

<tr>
      <td><strong><?php echo RC_DEFAULT_PREG ;?></strong></td>
      <td>
      	<input type="text" style="width: 200px;" name="replace_pattern" value="<?php echo $RC_preg_replace; ?>"/> 		</td>
			<td><?php echo RC_DEFAULT_PREG_DES ;?></td>
</tr>
<tr><TD>
<strong><?php echo RC_DEFAULT_STRTOLOWER ;?></strong>
</TD><td>
<SELECT name="str_lower">
<option value="1" <?php if ($RC_str_lower==1) echo ("selected");?> >strtolower</option>
<option value="2" <?php if ($RC_str_lower==2) echo ("selected");?> >mb_strtolower (binary-safe)</option>
<option value="3" <?php if ($RC_str_lower==3) echo ("selected");?> >--------------------------</option>
</SELECT>

</td><TD>
<?php echo RC_DEFAULT_STRTOLOWER_DESC ;?>
</TD></tr>

<tr><td height="30px" colspan="3"></td></tr>
</table>
<?php
        echo $tabs->endPanel();
       echo $tabs->startPanel(RC_TAB_KEYS, "keys");
?>
  <table width="100%" cellpadding="3" cellspacing="0" class="adminForm" style="border:1px solid #CCCCCC;">
  	<form action="index2.php" method="POST" name="adminForm">
    <tr>
      <td width="19%"><strong><?php echo RC_KEYS_ENABLE ;?>:</strong></td>
      <td>
      	<input type="radio" name="key_enabled" value="1" <?php if ($RC_key_enabled) echo "checked"; ?> /><?php echo RC_YES ;?>
      	<input type="radio" name="key_enabled" value="0" <?php if (!$RC_key_enabled) echo "checked"; ?> /><?php echo RC_NO ;?>			</td>
			<td width="53%"></td>
	</tr>
    <tr>
    <tr>
      <td width="19%"><strong><?php echo RC_KEYS_PUBLISHED ;?>:</strong></td>
      <td>
      	<input type="radio" name="key_published" value="1" <?php if ($RC_key_published) echo "checked"; ?> /><?php echo RC_YES ;?>
      	<input type="radio" name="key_published" value="0" <?php if (!$RC_key_published) echo "checked"; ?> /><?php echo RC_NO ;?>			</td>
			<td width="53%"></td>
	</tr>
    <tr>
      <td width="19%"><strong><?php echo RC_KEY_ASWORD ;?>:</strong></td>
      <td>
      	<input type="radio" name="key_asword" value="1" <?php if ($RC_key_asword) echo "checked"; ?> /><?php echo RC_YES ;?>
      	<input type="radio" name="key_asword" value="0" <?php if (!$RC_key_asword) echo "checked"; ?> /><?php echo RC_NO ;?>			</td>
			<td width="53%"><?php echo RC_KEY_ASWORD_DES ;?></td>
	</tr>
    <tr>

    <tr>
      <td><strong><?php echo RC_KEY_MIN_COUNTER ;?>:</strong></td>
      <td>
      	<input type="text" style="width: 60px;" name="key_mincounter" value="<?php echo $RC_key_min_counter; ?>"/> 		</td>
			<td><?php echo RC_KEY_MIN_COUNTER_DES ;?></td>
	</tr>
    <tr>
      <td><strong><?php echo RC_KEY_MIN_LEN ;?>:</strong></td>
      <td>
      	<input type="text" style="width: 60px;" name="key_minlen" value="<?php echo $RC_key_min_len; ?>"/> 		</td>
			<td><?php echo RC_KEY_MIN_LEN_DES ;?></td>
	</tr>
    <tr>
      <td><strong><?php echo RC_KEY_MAX_LEN ;?>:</strong></td>
      <td>
      	<input type="text" style="width: 60px;" name="key_maxlen" value="<?php echo $RC_key_max_len; ?>"/> 		</td>
			<td><?php echo RC_KEY_MAX_LEN_DES ;?></td>
	</tr>
   <tr>
      <td><strong><?php echo RC_DEFAULT_WHITELIST ;?>:</strong></td>
      <td>
      	<textarea rows=5 cols=50 name="key_whitelist"><?php echo $RC_key_whitelist; ?></textarea> </td>
			<td valign="top">
	<?php echo RC_KEY_WHITELIST_DES ;?>
</td>
	</tr>

<tr>
      <td><strong><?php echo RC_DEFAULT_PREG ;?></strong></td>
      <td>
      	<input type="text" style="width: 200px;" name="key_replace_pattern" value="<?php echo $RC_key_preg_replace; ?>"/> 		</td>
			<td><?php echo RC_KEY_PREG_DES ;?></td>
</tr>
<tr><TD>
<strong><?php echo RC_DEFAULT_STRTOLOWER ;?></strong>
</TD><td>
<SELECT name="key_str_lower">
   <option value="1" <?php if ($RC_key_str_lower==1) echo ("selected");?> >strtolower</option>
<option value="2" <?php if ($RC_key_str_lower==2) echo ("selected");?> >mb_strtolower (binary-safe)</option>
<option value="3" <?php if ($RC_key_str_lower==3) echo ("selected");?> >--------------------------</option>
</SELECT>

</td><TD>
<?php echo RC_DEFAULT_STRTOLOWER_DESC ;?>
</TD></tr>

<tr><td height="30px" colspan="3"></td></tr>
</table>
<?php
        echo $tabs->endPanel();
	echo $tabs->startPanel(RC_GENERAL, "general");
?>
  <table width="100%" cellpadding="3" cellspacing="0" class="adminForm" style="border:1px solid #CCCCCC;">

    <tr>
      <td><strong><?php echo RC_CACHE ;?>:</strong></td>
      <td>
      	     	<input type="radio" name="cache" value="1" <?php if ($RC_on_cache) echo "checked"; ?> /><?php echo RC_YES ;?>
      	<input type="radio" name="cache" value="0" <?php if (!$RC_on_cache) echo "checked"; ?> /><?php echo RC_NO ;?>			</td>
			<td><?php echo RC_CACHE_DES ;?></td>
	</tr>
    <tr>

    <tr>
      <td><strong><?php echo RC_DEFAULT_MIN_FONT ;?>:</strong></td>
      <td>
      	<input type="text" style="width: 60px;" name="minfont" value="<?php echo $RC_min_font; ?>"/> 		</td>
			<td><?php echo RC_DEFAULT_MIN_FONT_DES ;?></td>
	</tr>
    <tr>
      <td><strong><?php echo RC_DEFAULT_MAX_FONT ;?>:</strong></td>
      <td>
      	<input type="text" style="width: 60px;" name="maxfont" value="<?php echo $RC_max_font; ?>"/> 		</td>
			<td><?php echo RC_DEFAULT_MAX_FONT_DES ;?></td>
	</tr>
</table>
<table width="100%" cellpadding="3" cellspacing="0" class="adminForm" style="border:1px solid #CCCCCC;"><TR>
      <td><strong><?php echo RC_DEFAULT_BLACKLIST ;?>:</strong></td>
      <td>
      	<textarea rows=30 cols=80 name="blacklist"><?php echo $RC_blacklist; ?></textarea> </td>
			<td valign="top">
	<?php echo RC_DEFAULT_BLACKLIST_DES ;?><br>
<input type="button" onClick="loadWords()" name="loadBlacklist" value="<?php echo RC_DEFAULT_BLACKLIST_LOAD ;?>"><br>
</td>
	</tr>
</table>
<?php
        echo $tabs->endPanel();
	echo $tabs->startPanel(RC_TAB_SCHEDULER, "scheduler");
?>
<table>
<tr><TD>
<strong><?php echo RC_DEFAULT_RUN ;?>:</strong>
</td><td colspan="2"><?php echo RC_DEFAULT_RUN_INFO ;?>
<div style="background: #F1FEFE; border: 1px solid #DDDDEE; padding: 5px;">
<?php echo RC_DEFAULT_RUN_CODE ;?></div></td></tr>
<tr><TD>
<strong><?php echo RC_DEFAULT_RUN_PERIOD ;?>:</strong></td>
      <td>
      	<input type="text" style="width: 20px;" name="run_period" value="<?php echo $RC_run_period; ?>"/> 
	<SELECT name="period_unit">
   <option value="1" <?php if ($RC_run_period_unit==1) echo ("selected");?> ><?php echo RC_HOURS; ?></option>
<option value="2" <?php if ($RC_run_period_unit==2) echo ("selected");?> ><?php echo RC_DAYS; ?></option>
 </SELECT>
<td>
<?php echo RC_DEFAULT_RUN_PERIOD_DES ;?></td>
</td></tr>

<tr>
<td><strong><?php echo RC_DEFAULT_RUN_DATE ;?></strong></td></td>
<TD>
<input type="text" style="width: 20px;" name="run_day" value="<?php echo $RC_run_day; ?>"/>-<input type="text" style="width: 20px;" name="run_month" value="<?php echo $RC_run_month; ?>"/>-<input type="text" style="width: 30px;" name="run_year" value="<?php echo $RC_run_year; ?>"/> 
</TD>
<td>
<?php echo RC_LAST_RUN; ?>: <?php if (isset($RC_runlog)) echo date ("d-m-Y  G:i",$RC_runlog);?><br>
<?php echo RC_NEXT_RUN; ?>: <?php if (isset($RC_nextrun)) echo date ("d-m-Y  G:i",$RC_nextrun);?><br>
<INPUT type="checkbox" name="resetrun" value="resetrun" title="<?php echo RC_CLEAR_RUN; ?>"> - <?php echo RC_CLEAR_RUN; ?>
</td>
</tr>
<tr>
<td>
</td>
<td>
<input type="text" style="width: 20px;" name="run_hour" value="<?php echo $RC_run_hour; ?>"/>:<input type="text" style="width: 20px;" name="run_minute" value="<?php echo $RC_run_minute; ?>"/> 
</td>
<td>
<?php echo RC_DEBUG_MODE; ?> <a target="_blank" href="index2.php?option=com_rafcloud&debug=1&hash=<?php  echo $RC_debug;?>">DEBUG</a>
</td>
</tr>
<tr>
<td><strong><?php echo RC_DEFAULT_ADMIN_EMAIL ;?></strong></td>
      <td>
      	<input type="text" style="width: 250px;" name="admin_email" value="<?php echo $RC_admin_email; ?>"/> 		</td>
			<td><?php echo RC_DEFAULT_ADMIN_EMAIL_DES ;?></td>
</tr>
    <tr>
      <td><strong><?php echo RC_DEFAULT_LIMIT ;?></strong></td>
      <td>
      	<input type="text" style="width: 30px;" name="run_limit" value="<?php echo $RC_run_limit; ?>"/> 		</td>
			<td><?php echo RC_DEFAULT_LIMIT_DES ;?></td>
</tr>


  	<input type="hidden" name="option" value="<?php echo $option; ?>">
  	<input type="hidden" name="task" value="saveconfig">

  </table>
<?php
        echo $tabs->endPanel();
	echo $tabs->startPanel(RC_TAB_TOOLS, "tools");
?>
<table>
<tr>
<td>
<?php echo RC_RUN_DEBUG; ?> <a target="_blank" href="<?php echo  str_replace("administrator/","",JURI::base());?>/index2.php?option=com_rafcloud&debug=1&hash=<?php  echo $RC_debug;?>">DEBUG</a>
</td>
</tr>
<tr><TD>
<strong><?php echo RC_REMOVE ;?></strong>
</TD><td>
<SELECT name="remove_database">
<option value="0">-------------------------------</option>
<option value="1"><?php echo RC_REMOVE_DATABASE ;?></option>
</SELECT>
<INPUT type="checkbox" name="remove_database_1" title="<?php echo RC_REMOVE_ACC; ?>"> - <?php echo RC_REMOVE_ACC; ?>
</td><TD>
</TD></tr></table>
<?php
        echo $tabs->endPanel();
	echo $tabs->startPanel(RC_SEF, "sef");
?>
<table>
<tr><TD>
<strong><?php echo RC_SH404SEFPREF ;?></strong>
</TD><td>
<input type="text" style="width: 50px;" name="sh404p" value="<?php echo $RC_sh404sef_prefix; ?>"/>
</td><TD><?php echo RC_SH404SEFPREF_DES ;?>
</TD></tr>
<tr><TD><strong><?php echo RC_SH404SEFLINK ;?></strong></TD><td>
<SELECT name="sh404link">
   <option value="0" <?php if ($RC_sh404sef_link==0) echo ("selected");?> ><?php echo RC_SH404SEF_ID; ?></option>
<option value="1" <?php if ($RC_sh404sef_link==1) echo ("selected");?> ><?php echo RC_SH404SEF_WORD; ?></option>
<option value="2" <?php if ($RC_sh404sef_link==2) echo ("selected");?> ><?php echo RC_SH404SEF_BOTH; ?></option>
 </SELECT>
</td><td></td></tr>

</table>
<?php
        echo $tabs->endPanel();
 echo $tabs->endPane();
//	echo $tabs->startPanel("Donations", "donations");
?>
  </form>

<?php
      //  echo $tabs->endPanel();
     //   echo $tabs->endPane();
	}
}
?>
