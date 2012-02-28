<link rel="stylesheet" href="<?php echo $LiveSiteUrl ?>templates/system/css/system.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $LiveSiteUrl ?>templates/system/css/general.css" type="text/css" />

<link href="<?php echo $s5_directory_path ?>/css/template_default.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $s5_directory_path ?>/css/template.css" rel="stylesheet" type="text/css" />

<?php if($mobile==true){ ?>
<link href="<?php echo $s5_directory_path ?>/css/mobile_device.css" rel="stylesheet" type="text/css" />
<?php } ?>

<link href="<?php echo $s5_directory_path ?>/css/com_content.css" rel="stylesheet" type="text/css" />

<link href="<?php echo $s5_directory_path ?>/css/editor.css" rel="stylesheet" type="text/css" />

<?php if($s5_thirdparty == "enabled") { ?>
<link href="<?php echo $s5_directory_path ?>/css/thirdparty.css" rel="stylesheet" type="text/css" />
<?php } ?>

<?php if($s5_language_direction == "1") { ?>
<link href="<?php echo $s5_directory_path ?>/css/template_rtl.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $s5_directory_path ?>/css/editor_rtl.css" rel="stylesheet" type="text/css" />
<?php if($mobile==true){ ?>
<link href="<?php echo $s5_directory_path ?>/css/mobile_device_rtl.css" rel="stylesheet" type="text/css" />
<?php } ?>
<?php } ?>

<?php if(($s5_fonts != "Arial") || ($s5_fonts != "Helvetica")|| ($s5_fonts != "Sans-Serif")) { ?>
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=<?php echo $s5_fonts;?>" />
<?php } ?>




<?php if ($s5_multibox  == "yes" || $s5_scrolltotop  == "yes") { 
s5_mootools_call();
} ?>

<?php if ($s5_multibox  == "yes") { ?>
<link href="<?php echo $s5_directory_path ?>/css/multibox/multibox.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $s5_directory_path ?>/css/multibox/ajax.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $s5_directory_path ?>/js/multibox/overlay.js"></script>
<script type="text/javascript" src="<?php echo $s5_directory_path ?>/js/multibox/multibox.js"></script>
<script type="text/javascript" src="<?php echo $s5_directory_path ?>/js/multibox/AC_RunActiveContent.js"></script>
<?php } ?>


<link href="<?php echo $s5_directory_path ?>/favicon.ico" rel="shortcut icon" type="image/x-icon" />

<?php if($s5_font_resizer == "yes" && $mobile==false) { ?>
<script type="text/javascript" src="<?php echo $s5_directory_path ?>/js/s5_font_adjuster.js"></script>
<?php } ?>

