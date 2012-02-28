<?php 
/*======================================================================*\
|| #################################################################### ||
|| # Package - Joomla Template based on YJSimpleGrid Framework          ||
|| # Copyright (C) 2010  Youjoomla LLC. All Rights Reserved.            ||
|| # license - PHP files are licensed under  GNU/GPL V2                 ||
|| # license - CSS  - JS - IMAGE files  are Copyrighted material        ||
|| # bound by Proprietary License of Youjoomla LLC                      ||
|| # for more information visit http://www.youjoomla.com/license.html   ||
|| # Redistribution and  modification of this software                  ||
|| # is bounded by its licenses                                         ||
|| # websites - http://www.youjoomla.com | http://www.yjsimplegrid.com  ||
|| #################################################################### ||
\*======================================================================*/
if ($turn_header_block_off == 2 ){ ?>
 <!--header-->
  <div id="header" style="height:<?php echo $logo_height?>;">
  <?php if ($turn_logo_off == 2 ){ ?>
    <div id="logo" class="png" style="height:<?php echo $logo_height?>;width:<?php echo $logo_out?>%;">
     <?php if ($turn_seo_off == 1 ){ ?>
      <h1><a href="<?php echo $yj_base ?>" style="height:<?php echo $logo_height?>;" title="<?php echo $tags?>"><?php echo $seo ?></a> </h1>
     <?php }else{ ?>
      <a href="<?php echo $yj_base ?>" style="height:<?php echo $logo_height?>;"></a>
      <?php } ?>
    </div>
    <!-- end logo -->
   <?php } ?>
<?php require( TEMPLATEPATH.DS."layouts/grids/yjsg_header.php");?>

<?php if($enable_menu=="true") : ?>
<?php if($topmenu_off == 2 || $itemid == 0 ) {?>
    <!--top menu-->
<div id="topmenu_holder" style="margin-left:<?php echo $logo_width?>;margin-top:<?php echo ($logo_height - 55); ?>px;">
    <div class="top_menu" style="font-size:<?php echo $css_font; ?>;">
        <div id="horiznav" class="horiznav<?php if ($text_direction == 1) { ?> horiz_rtl<?php } ?>"><?php echo $topmenu; ?></div>
    </div>
</div>
    <!-- end top menu -->
<?php } ?>
<?php endif; ?>
<?php if($enable_menu=="false") : ?>
<div id="topmenu_holder">
<?php if($this->countModules('custommenu')) : ?><div><jdoc:include type="modules" name="custommenu" style="rounded" /></div><?php endif;?>
</div>
<?php endif; ?>

  </div>
  <!-- end header -->
<?php } ?>