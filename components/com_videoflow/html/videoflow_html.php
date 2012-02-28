<?php

//VideoFlow - Joomla Multimedia System for Facebook//
/**
* @ Version 1.1.4
* @ Copyright (C) 2008 - 2011 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow is free software
* @ Visit http://www.fidsoft.com for support
* @ Kirungi Fred Fideri and Fidsoft accept no responsibility arising from use of this software 
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
class VideoflowHTML {

function uploadForm($obj=null)
{
global $vparams;
$cmes = JText::_('COM_VIDEOFLOW_CONT_STEP2'); 
echo '<script language="javascript" type="text/javascript">var cmes = "'.$cmes.'"; </script>'; 
?>

<fieldset class="vf_forms">
<legend><? echo JText::_( 'COM_VIDEOFLOW_THUMB_FILE' ); ?> </legend>
<? echo JText::_( 'COM_VIDEOFLOW_UPLOAD_STEP1' ); ?> <br/>
                <form action="index.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
                     <div id="f1_upload_process" style="text-align:center;"><?php echo JText::_('COM_VIDEOFLOW_UPLOADING'); ?><br /><img src="<?php echo JURI::root().'components/com_videoflow/utilities/images/loader.gif'; ?>" /></div>
                     <div id="f1_upload_form" style="text-align:center;"><br />
                         <label>File Name:  
                              <input name="myfile" id="myfile" type="file" size="30" title=".JPG, .PNG, .GIF" accept="jpg, png, gif"/>
                         </label>
                         <label>
                             <input type="submit" name="submitBtn" class="sbtn" value="Upload" />
                             <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $vparams->maxthumbsize; ?>" />
                             <input type="hidden" name="UPLOAD_FILE_TYPE" value="image" />
                             <input type="hidden" name="id" value="<?php echo $obj->id; ?>" />
                             <input type="hidden" name="option" value="com_videoflow" />
                             <input type="hidden" name="task" value="saveThumb" />
                         </label>
                     </div>   
                <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                 </form>
</fieldset>
<?php
if ($vparams->upsys == 'swfupload') self::swfUploadForm($obj); else self::pluploadForm($obj);
}


function swfUploadForm ($obj=null)
{
global $vparams; 

jimport( 'joomla.utilities.utility' );

$session = & JFactory::getSession();
$doc =& JFactory::getDocument();
$vcss = JURI::root().'components/com_videoflow/utilities/css/vf_upload.css';
$doc->addStyleSheet( $vcss, 'text/css', null, array() );
$fcss = JURI::root().'components/com_videoflow/utilities/css/vf_forms.css';
$doc->addStyleSheet( $fcss, 'text/css', null, array() );
$fupload = JURI::root().'components/com_videoflow/utilities/js/fupload.js';
$doc->addScript($fupload);
$swfupload = JURI::root().'components/com_videoflow/utilities/js/swfupload.js';
$doc->addScript($swfupload);
$queue = JURI::root().'components/com_videoflow/utilities/js/swfupload.queue.js';
$doc->addScript($queue);
$fileprocess = JURI::root().'components/com_videoflow/utilities/js/fileprogress.js';
$doc->addScript($fileprocess);
$handlers = JURI::root().'components/com_videoflow/utilities/js/handlers.js';
$doc->addScript($handlers);

$fbuser = JRequest::getInt('fbuser');


$flashinitiate = '
	var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "'.JURI::root().'components/com_videoflow/utilities/swf/swfupload.swf",
				upload_url: "index.php?option=com_videoflow&task=saveUpload&'.JUtility::getToken().'=1",
				post_params: {"option" : "com_videoflow", "task" : "saveUpload", "user_id" : "'.$obj->userid.'", "fb_user" : "'.$fbuser.'",
			        "media_id" : "'.$obj->id.'", "'.$session->getName().'" : "'.$session->getId().'", "format" : "raw"},
				file_size_limit : "'.$vparams->maxmedsize.'MB",
				file_types : "*.flv; *.mp4; *.swf; *.3g2; *.3gp; *.mov; *.mp3; *.aac; *.jpg; *.gif; *.png",
				file_types_description : "Media Files",
				file_upload_limit : 0,
				file_queue_limit : 1,
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel",
					vflowMode : "fRefresh",
					userId : "'.$obj->userid.'",
					mediaId : "'.$obj->id.'"
				},
				debug: false,

				button_image_url: "'.JURI::root().'components/com_videoflow/utilities/images/uploadimage.png",
				button_width: "100",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: "<span class=\"theFont\">Select File</span>",
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete
			};

			swfu = new SWFUpload(settings);
	     };
    ';
$doc->addScriptDeclaration($flashinitiate);

?>

<fieldset class="vf_forms">
<legend><? echo JText::_( 'COM_VIDEOFLOW_MEDIA_FILE' ); ?> </legend>
<br />
<?php echo JText::_( 'COM_VIDEOFLOW_UPLOAD_STEP2' ); ?> <br />
<br />
<div id="scontent">
	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
		<div class="fieldset flash" id="fsUploadProgress">
		<span class="legend"><? echo JText::_( 'COM_VIDEOFLOW_UPLOAD_STATUS' ); ?></span>
		</div>
		<div id="divStatus"></div>
		<div>
		<span id="spanButtonPlaceHolder"></span>
		<input id="btnCancel" type="button" value="<? echo JText::_( 'COM_VIDEOFLOW_CANCEL_UPLOADS' ); ?>" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
		</div>
	</form>
</div>
</fieldset>
<?php
}

function pluploadForm ($obj=null)
{
global $vparams; 
$session = & JFactory::getSession();
$doc =& JFactory::getDocument();
$vcss = JURI::root().'components/com_videoflow/utilities/plupload/css/plupload.queue.css';
$doc->addStyleSheet( $vcss, 'text/css', null, array() );
$fcss = JURI::root().'components/com_videoflow/utilities/css/vf_forms.css';
$doc->addStyleSheet( $fcss, 'text/css', null, array() );
$gooq = 'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js';
$doc->addScript($gooq);
$plufull = JURI::root().'components/com_videoflow/utilities/plupload/js/plupload.full.min.js';
$doc->addScript($plufull);
$jq = JURI::root().'components/com_videoflow/utilities/plupload/js/jquery.plupload.queue.min.js';
$doc->addScript($jq);
$fbuser = JRequest::getInt('fbuser');
$upurl = JURI::root().'index.php?option=com_videoflow&task=saveXpload&user_id='.$obj->userid.'&media_id='.$obj->id.'&'.$session->getName().'='.$session->getId().'&'.JUtility::getToken().'=1';
$maxmedsize = $vparams->maxmedsize.'mb';
$redir = JRoute::_('index.php?option=com_videoflow&task=getStatus&cid='.$obj->id.'&userid='.$obj->userid.'&tmpl=component&file=');
$plpd = "
$(document).ready(function() {
	$('#vfx_uploader').pluploadQueue({
		// General settings
		runtimes : 'flash,html5,html4',
		url : '$upurl',
		max_file_size : '$maxmedsize',
		chunk_size : '1mb',
		unique_names : false,
		// Specify what files to browse for
		filters : [
			{title : 'Media Files', extensions : 'jpg,gif,png,mp3,swf,mp4,flv'}
		],

		// Flash URL
		flash_swf_url : '".JURI::root().'components/com_videoflow/utilities/plupload/js/plupload.flash.swf'."'

		});

    var uploader = $('#vfx_uploader').pluploadQueue();
    
  // autostart
    uploader.bind('FilesAdded', function(up, files) {
      if (up.files.length > 1) {
      var xrem = up.files.length - 1;
      up.files.splice(0,xrem);
      }
      uploader.start();
    });

  // after upload
    uploader.bind('FileUploaded', function(up, file, res) {
        if(up.total.queued == 0) {
        window.location = '$redir' + file.name; 
        }
    });
});
";

$doc->addScriptDeclaration($plpd);
?>
<fieldset class="vf_forms">
<legend><? echo JText::_( 'COM_VIDEOFLOW_MEDIA_FILE' ); ?> </legend>
<?php echo JText::_( 'COM_VIDEOFLOW_UPLOAD_STEP2' ); ?> <br />
	<div id="vf_plupload">
        <div id="vfx_uploader" style="height: 200px;">
	<p><?php echo JText::_('COM_VIDEOFLOW_NO_HTML5');?></p>
	</div>
	<div style="padding:4px 8px";> <?php echo JText::_('COM_VIDEOFLOW_BE_COOL'); ?></div>
	<br style="clear: both" />
    </div>
</fieldset>
<?php
}



function addForm()
{
$doc = &JFactory::getDocument();
$css = JURI::root().'components/com_videoflow/utilities/css/vf_forms.css';
$doc->addStyleSheet( $css, 'text/css', null, array() );
global $vparams;
$user = &JFactory::getUser();
?>

	<script language="javascript" type="text/javascript">
	<!--
  function fieldcheck(myform) {
  var v = document.forms[myform];
  if (myform == "addForm") {    
    var myfield = v.embedlink.value;
    var alerttext = "<?php echo JText::_( 'COM_VIDEOFLOW_PROVIDE_URL'); ?>";
  } else if (myform == "uploadForm") {
    var myfield = v.title.value;
    var alerttext = "<?php echo JText::_( 'COM_VIDEOFLOW_PROVIDE_TITLE'); ?>";
  }
  if (myfield == ""){
  alert( alerttext );
  } else { 
      document.forms[myform].submit();
    }
  }
		//-->
	</script>

<fieldset class="vf_forms">
<legend><? echo JText::_( 'COM_VIDEOFLOW_EMDED_OPTION' ); ?> </legend>
<?php
if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $auth = $user->getAuthorisedGroups();
    if (in_array(8, $auth) || in_array(7, $auth)) $usertype = 'Administrator';
    } else {
    $usertype = $user->usertype;    
    }

if (!$vparams->useradd && $usertype != 'Super Administrator' && $usertype != 'Administrator') {
echo '<br/>'.JText::_( 'COM_VIDEOFLOW_FEATURE_DISABLED' ). '<br/><br/>';
} else {
echo JText::_( 'COM_VIDEOFLOW_EMBED_URL' ); 
?>
<br/>
<br/>
<br/>
<div>
 <form id="addForm" name="addForm" action="<?php JRoute::_('index.php?&tmpl=component'); ?>" method="post">
 <table class="vftable">
          <tr>	
          <td>
	  <input type="text" size="70" maxsize="80" name="embedlink" value="" />	
	  </td>
          <td>
          <button type="button" onclick="fieldcheck('addForm')" name="upsubmit"><? echo JText::_( 'COM_VIDEOFLOW_APPLY' ); ?></button>
          <button type="button" onclick="window.parent.document.getElementById('sbox-window').close();"><? echo JText::_( 'COM_VIDEOFLOW_CANCEL' ); ?></button>
          </td>
          </tr>
  </table> 
	<input type="hidden" name="option" value="com_videoflow" />
  <input type="hidden" name="task" value="addmedia" /> 
  </form>
</div>
<?php
}
?>
</fieldset>
<br/>
<br/>
<br/>
<fieldset class="vf_forms">
<legend><? echo JText::_( 'COM_VIDEOFLOW_UPLOAD_OPTION' ); ?> </legend>
<?php 
if (!$vparams->showpro || !$vparams->userupload && ($usertype != 'Super Administrator' && $usertype != 'Administrator')) {
echo '<br/>'.JText::_( 'COM_VIDEOFLOW_FEATURE_DISABLED' ). '<br/><br/>';
} else {
echo JText::_( 'COM_VIDEOFLOW_TITLE_CONT' );
?> 
<br/>
<br/>
<br/>
<div>
 <form id="uploadForm" name="uploadForm" action="<?php JRoute::_('index.php?&tmpl=component'); ?>" method="post">
 <table class="vftable">
          <tr>	
          <td>
	  <input type="text" size="70" maxsize="80" name="title" value="" />	
	  </td>
          <td>
          <button onclick="fieldcheck('uploadForm'); return false" name="upsubmit"><? echo JText::_( 'COM_VIDEOFLOW_APPLY' ); ?></button>
          <button type="button" onclick="window.parent.document.getElementById('sbox-window').close();"><? echo JText::_( 'COM_VIDEOFLOW_CANCEL' ); ?></button>
          </td>
          </tr>
  </table> 
     <input type="hidden" name="option" value="com_videoflow" />
  <input type="hidden" name="task" value="uploadmedia" /> 
  </form>
</div>
<?php
}
?>
</fieldset>
<?php
}

function editForm($row) {
 global $vparams;
$doc = &JFactory::getDocument();
$css = JURI::root().'components/com_videoflow/utilities/css/vf_forms.css';
$doc->addStyleSheet( $css, 'text/css', null, array() );
    $pixpreview = $this->escape($row->pixlink);
    if (!empty($pixpreview)) {
         if ($row -> server == 'local' && stripos($row->pixlink, 'http') === FALSE) {  
         $pixpreview = JURI::root().$vparams->mediadir.'/_thumbs/'.$row->pixlink;
         } else {
         $pixpreview = $row->pixlink;
         }
       } 
    if (empty($pixpreview)){
    $pixpreview = JURI::root().'components/com_videoflow/players/vflow.gif';
    }

$user = & JFactory::getUser();
if (version_compare(JVERSION, '1.6.0', 'ge')) {
    $auth = $user->getAuthorisedGroups();
    if (in_array(8, $auth) || in_array(7, $auth)) $usertype = 'Administrator';
    } else {
    $usertype = $user->usertype;    
    }
$frontside = JRequest::getBool('fr'); 
$auto = JRequest::getBool ('auto'); 
if ($frontside) {
  $vtask = 'saveEdit';
} else if ($auto) {
  $vtask = 'saveFlash';
} else {
  $vtask = 'saveRemote';
}
if (empty($row->id)) $row->id = '';

 ?>

	<form enctype="multipart/form-data" action="index.php?&tmpl=component" method="post" name="adminForm">
	<div class="col100">
	  <fieldset class="vf_forms">
	  <legend><?php echo JText::_( 'COM_VIDEOFLOW_MEDIA_DETAILS' ); ?></legend>
          <table class="admintable" style="width:100%; border:none;">
          <tr>
          <td class="adminvthumb">
          <img src="<? echo $pixpreview; ?>" height=60 />
          </td>
          </tr>
          </table>
          <table class="admintable">
          <tr>	
          <td class="key">
	  <label for="title">
	  <?php echo JText::_( 'COM_VIDEOFLOW_MEDIA_TITLE' ); ?>:
	  </label>
	  </td>
          <td>
          <input type="text" size="70" maxsize="100" name="title" value="<?php echo $row->title; ?>" />
          </td>
          </tr>
          <tr>
          <td class="key">
	  <label for="published">
	  <?php echo JText::_( 'COM_VIDEOFLOW_PUBLISHED' ); ?>:
	  </label>
	  </td>
            <td> 
            <?php echo JHTML::_('select.genericlist', $row->bselect, 'published', null, 'value', 'text', '1'); ?>
            </td>
            </tr>
            <?php 
            if ($usertype == 'Super Administrator' || $usertype == 'Administrator') {
            ?>
            <tr>
            <td class="key">
	  <label for="featured">
	  <?php echo JText::_( 'COM_VIDEOFLOW_FEATURED' ); ?>:
	  </label>
	  </td>
            <td> 
            <?php echo JHTML::_('select.genericlist', $row->bselect, 'recommended', null, 'value', 'text', '0'); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	  <label for="date">
	  <?php echo JText::_( 'COM_VIDEOFLOW_DATE' ); ?>:
	  </label>
	  </td>
            <td> 
            <input type="text" size="40" maxsize="80" name="dateadded" value="<?php echo $row->dateadded; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	  <label for="userid">
	  <?php echo JText::_( 'COM_VIDEOFLOW_USERID' ); ?>:
	  </label>
	  </td>
            <td> 
            <input type="text" size="10" maxsize="20" name="userid" value="<?php echo $row->userid; ?>" />
            </td>
            </tr>
            <?php
            } else {
            ?>
            <input type="hidden" name="userid" value="<?php echo $row->userid; ?>" >
            <input type="hidden" name="dateadded" value="<? echo $row->dateadded; ?>">
            <?php
            }
            ?>
            <tr>
            <td class="key">
	  <label for="category">
	  <?php echo JText::_( 'COM_VIDEOFLOW_CAT' ); ?>:
	  </label>
	  </td>
            <td>
            <?php echo JHTML::_('select.genericlist', $row->catlist, 'cat', null, 'catid', 'name', $row->selcat); ?>
            </td>
            </tr>
            <tr>
            <td class="key">
	  <label for="tags">
	  <?php echo JText::_( 'COM_VIDEOFLOW_TAGS' ); ?>:
	  </label>
	  </td>
            <td>
            <input type="text" size="70" maxsize="100" name="tags" value="<?php echo $row->tags; ?>" />
            </td>
            </tr>
            <tr>
            <td class="key">
	  <label for="description">
	  <?php echo JText::_( 'COM_VIDEOFLOW_DESC' ); ?>:
	  </label>
	  </td>
            <td>
            <textarea name="details" cols="45" rows="4" value="" wrap="soft"><?php echo stripslashes($row->details); ?></textarea>
            </td>
            </tr>  
          </table> 
          <table class="admintable" style="width:100%;">
            <tr>
            <td class="adminvthumb">
            <button onclick="submit()" name="submit_button"><? echo JText::_( 'COM_VIDEOFLOW_SAVE' ); ?></button> 
            <?php
	       if (version_compare(JVERSION, '1.6.0', 'ge')) {
	       echo '<button type="button" onclick="window.parent.SqueezeBox.close();">'.JText::_('COM_VIDEOFLOW_CANCEL').'</button>';
	       } else {
	       echo '<button type="button" onclick="window.parent.document.getElementById(\'sbox-window\').close();">'.JText::_('COM_VIDEOFLOW_CANCEL').'</button>';
	       }
	     ?>
            </td>
            </tr>
          </table>
          <input type="hidden" name="medialink" value="<?php echo $row->medialink; ?>" />
          <input type="hidden" name="file" value="<?php echo $row->file; ?>" />
          <input type="hidden" name="pixlink" value="<? echo $row->pixlink; ?>">
          <input type="hidden" name="type" value="<?php echo $row->type; ?>" />
          <input type="hidden" name="server" value="<? echo $row->server; ?>">
          <input type="hidden" name="id" value="<? echo $row->id; ?>" />
          <input type="hidden" name="option" value="com_videoflow" />
          <input type="hidden" name="task" value="<?php echo $vtask; ?>" />
      </fieldset>
  </div>          
 	<?php echo JHTML::_( 'form.token' ); ?>
  </form>
	<div class="clr"></div>
<?php	
//self::initFB();
}    

function emailForm($media)
{
global $vparams;
$app = &JFactory::getApplication();
if (empty($vparams->adminmail)) $vparams->adminmail = $app->getCfg ('mailfrom'); 
$enotice =  JText::_('COM_VIDEOFLOW_EMAIL_FRIEND');
$action = JText::_('SEND');
$vtask = JRequest::getCmd('task');
if ($vtask == 'report'){
$enotice = JText::_('COM_VIDEOFLOW_REPORT_THIS_TO_ADMIN');
$action = JText::_('COM_VIDEOFLOW_EREPORT');
}
if ($vtask == 'eshare'){
$enotice = JText::_('COM_VIDEOFLOW_INVITE_FRIEND');
$action = JText::_('COM_VIDEOFLOW_EINVITE');
}

JDocument::setTitle ($media->title);
if ($vtask == 'email') {
$elink = $media->elink;
} else {     
$elink = base64_encode ($media->elink);
}
    if (!empty($media->pixlink)) {
         if (stripos($media->pixlink, 'http://') === FALSE) {  
         $media->pixlink = JURI::root().$vparams->mediadir.'/_thumbs/'.$media->pixlink;
         } 
      } else {
    $media->pixlink = JURI::root().'components/com_videoflow/players/vflow.gif';
    }

		?>
		<script language="javascript" type="text/javascript">
		function submitbutton() {
			var form = document.frontendForm;
			if (form.email.value == "" || form.youremail.value == "") {
				alert( '<?php echo JText::_("COM_VIDEOFLOW_WARN_EADDRESSES"); ?>' );
				return false;
			}
			return true;
		}
		</script>
		
    <div style="padding: 20px; background-color: #EDEDED; font-size:12px;">
    <title><?php echo $media->title; ?> </title>
		<form action="index.php?option=com_videoflow&task=emailsend&tmpl=component" name="frontendForm" method="post" onSubmit="return submitbutton();">
		<div style="margin:auto; text-align:center;"><img src="<?php echo $media->pixlink; ?>" height="75" vspace="5"><br />
		<p><b><?php echo $media->title; ?></b><br />
		<i><?php echo $enotice; ?></i>
    </p>
    </div>
		    <table class="vftable">
		    <?php 
		    if ($vtask != 'report'){
		    ?>
		    <tr>
		        <td height="27"><?php echo JText::_("COM_VIDEOFLOW_FRIEND_NAME"); ?></td>
		        <td><input type="text" name="friendname" class="inputbox" size="30"></td>
		    </tr>
		    <tr>
			<td width="130"><?php echo JText::_("COM_VIDEOFLOW_FRIEND_EMAIL"); ?></td>
			<td><input type="text" name="email" class="inputbox" size="30" /></td>
		    </tr>
		    <?php
		    }
		    ?>
        <tr>
			      <td height="27"><?php echo JText::_('COM_VIDEOFLOW_YOUR_NAME'); ?></td>
            <td><input type="text" name="yourname" class="inputbox" size="30" /></td>
		    </tr>
		    <tr>
			      <td><?php echo JText::_('COM_VIDEOFLOW_YOUR_EMAIL'); ?></td>
			      <td><input type="text" name="youremail" class="inputbox" size="30" /></td>
		    </tr>
		    <tr>
			      <td><?php echo JText::_('COM_VIDEOFLOW_EMESSAGE_TITLE'); ?></td>
			      <td><input type="text" name="subject" class="inputbox" maxlength="100" size="30" /></td>
		    </tr>
        <tr>
            <td><?php echo JText::_('COM_VIDEOFLOW_YOUR_MESSAGE'); ?></td>
			      <td><textarea name="personalmessage" class="inputbox" rows="3" cols="35"></textarea></td></tr>
		    <tr>
			      <td colspan="2">&nbsp;</td>
		   </tr>
		   <tr>
			      <td colspan="2">
            <input type="submit" name="submit" class="button" value="<?php echo $action; ?>" />&nbsp;&nbsp;
	    <?php
	       if (version_compare(JVERSION, '1.6.0', 'ge')) {
	       echo '<input type="button" name="cancel" value="'.JText::_('COM_VIDEOFLOW_ECANCEL').'" class="button" onclick="window.parent.SqueezeBox.close();" />';
	       } else {
	       echo '<input type="button" name="cancel" value="'.JText::_('COM_VIDEOFLOW_ECANCEL').'" class="button" onclick="window.parent.document.getElementById(\'sbox-window\').close();" />';
	       }
	     ?>
			     </td>
		  </tr>
		  </table>
	<input type="hidden" name="id" value="<?php echo $media->id; ?>" />
	<input type="hidden" name="elink" value="<?php echo $elink; ?>" />
	<input type="hidden" name="title" value="<?php echo $media->title; ?>">
	<?php 
  echo JHTML::_( 'form.token' ); 
  if ($vtask == 'report'){
  echo '<input type="hidden" name="friendname" value="Admin" />';
  echo '<input type="hidden" name="email" value="'.$vparams->adminmail.'" />';
  }
  ?>
	</form>
	</div>
  <?php
  }
}