<?php

// List Module for VideoFlow //
/**
* @ Version 1.1.1 
* @ Copyright (C) 2008 - 2010 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow List Module is free software
* @ Requires VideoFlow Multimedia Component 
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/	

defined('_JEXEC') or die('Direct Access to this location is not allowed.');
JHTML::_('behavior.modal', 'a.modal-vflow');
$doc = &JFactory::getDocument();
$css = '.vflowlistmodule a:link, a:visited, a:active {text-decoration: none;}
       .vflowlistmodule a:hover, a:focus {text-decoration: underline;}
       .vflowlistmodule {border: 1px solid #EDEDED;}';
$doc->addStyleDeclaration($css);
if ($lightboxsys == 'multibox' && $modloc == 'joomla' && $listtype != 'categories') {
$css2 = JURI::root().'components/com_videoflow/views/videoflow/tmpl/multibox/multibox.css';
$doc->addStyleSheet( $css2, 'text/css', null, array() );
  if (!empty($moo)) {
  $moofile=JURI::root().'components/com_videoflow/views/videoflow/tmpl/multibox/mootools.js';
  $doc->addScript( $moofile );
  }
$overlay = JURI::root().'components/com_videoflow/views/videoflow/tmpl/multibox/overlay.js';
$doc->addScript( $overlay );
$multibox = JURI::root().'components/com_videoflow/views/videoflow/tmpl/multibox/multibox.js';
$doc->addScript( $multibox );
}
if (!empty($jeffects) && !empty($jeffectsclass) && $modloc == 'joomla') $doc->addScript($jeffects);
$mstyle = 'margin:auto; text-decoration:none;';
if (!empty($bgroundc)) $mstyle .= ' background-color:'.$bgroundc.';';
if (!empty($borderc)) $mstyle .= ' border-color:'.$borderc.';';
if (!empty($borders) || $borders === "0") $mstyle .= ' border-width:'.$borders.'px; border-style:solid;';
if (!empty($texts)) $mstyle .= ' font-size:'.$texts.';';

    
$lstyle = 'padding:4px;';
if (!empty($lbgroundc)) $lstyle .= ' background-color:'.$lbgroundc.';';
if (!empty($lborderc)) $lstyle .= ' border-color:'.$lborderc.';';
if (!empty ($lborders)) $lstyle .= ' border-width:'.$lborders.'px; border-style:solid;';
if (!empty($ltextc)) $lstyle .= ' color:'.$ltextc.';';
if (!empty($ltexts)) $lstyle .= ' font-size:'.$ltexts.';';
$lstyle .= ' font-weight:bold;';

if (!empty($flowid)) {
$vfid = '&Itemid='.$flowid;
} else {
$vfid = '';
}

 
 if (is_array($data)){    
    $columni=0;
    $mbox=1;
    $mboxx = 1000;    
    echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" class=\"vflowlistmodule\" style=\"text-align:center; $mstyle\">";
	  if ($internaltitle) {
    echo '<tr><td align="'.$ltexta.'" style="'.$lstyle.'; text-align:'.$ltexta.';"><div style="text-align:'.$ltexta.';">'.JText::_($label).'</div></td></tr>';
	  }
    echo "<tr><td>";
    echo "<table align='center' style='border: 0px; padding-left:4px; text-align:center;'";
    echo "<tr>";
  	foreach ($data as $media) {
			$columni=$columni+1;
			$vid = $media->id;
			$vhit = $media->views;
			$vtitle = stripslashes($media->title);
			$vpix = $media->pixlink;
			if (!empty($vpix)) {
         if (stristr($vpix, 'http') === FALSE) {  
         $vpix = JURI::root().$vparams->mediadir.'/_thumbs/'.$vpix;
         }
       } else if (file_exists(JPATH_ROOT.DS.$vparams->mediadir.DS.'_thumbs'.DS.$media->title.'.jpg')) {
       $vpix = JURI::root().$vparams->mediadir.'/_thumbs/'.$media->title.'.jpg';
       } else {
       $vpix = JURI::root().'components/com_videoflow/players/vflow.jpg';
       } 
			$catid=$media->catname;
			$addeddate=$media->dateadded;
			$addeddate = JHTML::_('date', $addeddate, '%d-%m-%Y');
			if (strlen($vtitle)>$titlelength) {
					$vshorttitle=substr($vtitle,0,$titlelength)."...";
			} else {
					$vshorttitle=$vtitle;
			}
      if ($lightboxsys == 'multibox'){
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$media->id).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_xmbox'.$mbox.'" class="vf_xmbox" title="'.stripslashes($vtitle).'">
                   <img width="'.$thumbwidth.'" height="'.$thumbheight.'" class="'.$jeffectsclass.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vpix.'"/>
                   <div class="vflowBoxDesc vf_xmbox'.$mbox.'"></div> </a>';
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$media->id).'" rel="width:'.$vboxwidth.',height:'.$vboxheight.'" id="vf_xmboxx'.$mboxx.'" class="vf_xmboxx" title="'.stripslashes($vtitle).'">'.stripslashes($vshorttitle).'
                   <div class="vflowTboxDesc vf_xmboxx'.$mboxx.'"></div> </a>';
           if ($media->type == 'jpg' || $media->type == 'png' || $media->type == 'gif') {
           if (empty($media->medialink)) $media->medialink = JURI::root().$vparams->mediadir.'/photos/'.$media->file;
           $thumblink = '<a href="'.$media->medialink.'" id="vf_xmbox'.$mbox.'" class="vf_xmbox" title="'.stripslashes($vtitle).'">
                   <img width="'.$thumbwidth.'" height="'.$thumbheight.'" class="'.$jeffectsclass.'" class="'.$jeffectsclass.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vpix.'"/>
                   <div class="vflowBoxDesc vf_xmbox'.$mbox.'"></div> </a>'; 
           $titlelink = '<a href="'.$media->medialink.'" id="vf_xmboxx'.$mboxx.'" class="vf_xmboxx" title="'.stripslashes($vtitle).'">'.stripslashes($vshorttitle).'
                   <div class="vflowTboxDesc vf_xmboxx'.$mboxx.'"></div></a>'; 
          }
          if ($lightboxmode == 0){
          $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&id='.$media->id.$vfid).'">'.stripslashes($vshorttitle).'</a>';
          }          
      } elseif ($lightboxsys == 'joomla'){
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$media->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">
                    <img width="'.$thumbwidth.'" height="'.$thumbheight.'" class="'.$jeffectsclass.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vpix.'"/></a>';
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&tmpl=component&layout=lightbox&id='.$media->id).'" class="modal-vflow" rel="{handler: \'iframe\', size: {x: '.$vboxwidth.', y: '.$vboxheight.'}}">'.stripslashes($vshorttitle).'</a>';
           if ($media->type == 'jpg' || $media->type == 'png' || $media->type == 'gif') {
           if (empty($media->medialink)) $media->medialink = JURI::root().$vparams->mediadir.'/photos/'.$media->file;
           $thumblink = '<a href="'.$media->medialink.'" id="modal-vflow'.$mbox.'" class="modal-vflow">
                   <img width="'.$thumbwidth.'" height="'.$thumbheight.'" class="'.$jeffectsclass.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vpix.'"/></a>'; 
          
           $titlelink = '<a href="'.$media->medialink.'" id="modal-vflow'.$mbox.'" class="modal-vflow">'.stripslashes($vshorttitle).'</a>';
          }
          if ($lightboxmode == 0){
          $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&id='.$media->id.$vfid).'">'.stripslashes($vshorttitle).'</a>';
          }    
      } else {
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&id='.$media->id.$vfid).'">
                    <img width="'.$thumbwidth.'" height="'.$thumbheight.'" class="'.$jeffectsclass.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vpix.'"/></a>';      
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=play&id='.$media->id.$vfid).'">'.stripslashes($vshorttitle).'</a>';      
      }
      
     if ($modloc == 'facebook') {
      $thumblink = '<a href="'.$vparams->canvasurl.'&task=play&id='.$media->id.'&fb=1'.'">
                    <img width="'.$thumbwidth.'" height="'.$thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vpix.'"/></a>';      
      $titlelink = '<a href="'.$vparams->canvasurl.'&task=play&id='.$media->id.'&fb=1'.'">'.stripslashes($vshorttitle).'</a>';      
     }
     
     if ($listtype == 'categories') {
      $thumblink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=cats&cat='.$media->id.$vfid.'&sl=categories').'">
                    <img width="'.$thumbwidth.'" height="'.$thumbheight.'" class="'.$jeffectsclass.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vpix.'"/></a>';      
      $titlelink = '<a href="'.JRoute::_('index.php?option=com_videoflow&task=cats&cat='.$media->id.$vfid.'&sl=categories').'">'.stripslashes($vshorttitle).'</a>';      
          if ($modloc == 'facebook') {
          $thumblink = '<a href="'.$vparams->canvasurl.'&task=cats&cat='.$media->id.'&vf=1'.'">
                    <img width="'.$thumbwidth.'" height="'.$thumbheight.'" style="border:'.$iborders.'px solid; border-color:'.$iborderc.';" src="'.$vpix.'"/></a>';      
          $titlelink = '<a href="'.$vparams->canvasurl.'&task=cats&cat='.$media->id.'&vf=1'.'">'.stripslashes($vshorttitle).'</a>';      
          }
     }

				echo '<td style="text-align:center">';
				echo '<div style="margin-bottom:10px; margin-top:5px; padding-right:4px;">';
				if ($titlepos == "top"){
					echo "<div style='text-align:center;'>".$titlelink."</div>";
				}
				 echo "<div>".$thumblink."</div>";					
					if ($titlepos == "bottom"){
					echo "<div style='text-align:center;'>".$titlelink."</div>";    
          }
				echo '</div>';	
				echo "</td>";
	 
				if ($columni == $vfcolumns){
				echo "</tr><tr>";
				$columni = 0;
				}
		  $mbox++;
		  $mboxx;
    }
		echo "</tr></table>";
		
    echo "</td></tr>";
		
		if (!empty($seemore) && $modloc == 'joomla') {
    $stask = $listtype;
    if ($listtype == 'weeklyview') $stask = 'popular';
    echo "<tr><td style='text-align:".$stexta."'><div style='padding:2px 8px; font-size:94%; text-align:".$stexta.";'><a href='".JRoute::_('index.php?option=com_videoflow&task='.$stask.$vfid)."'>".JText::_('See more')."</a></div></td></tr>";
    echo "</td></tr>";
    }    
    echo "</tbody></table>";
}	

if ($lightboxsys == 'multibox' && $modloc == 'joomla' && $listtype != 'categories') {
?>
<script type="text/javascript">
						
			var vfmbox = {};
			window.addEvent('domready', function(){
				vfmbox = new MultiBox('vf_xmbox', {descClassName: 'vflowBoxDesc', useOverlay: true});
			});
			
			
			var vfmboxx = {};
			window.addEvent('domready', function(){
				vfmboxx = new MultiBox('vf_xmboxx', {descClassName: 'vflowTboxDesc', useOverlay: true});
			});
	
		</script>
<?php
}