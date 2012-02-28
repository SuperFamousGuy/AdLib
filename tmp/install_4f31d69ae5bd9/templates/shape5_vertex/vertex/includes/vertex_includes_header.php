<?php
// Mobile device settings
if ($s5_mobile_device_enable_disable == "enabled") {
	require(dirname(__FILE__)."/../../vertex/mobile_device_detect.php");
	mobile_device_detect();
	if(isset($_GET['switch'])){
		$mobile = $_GET['switch']; // should be either 1 for true or empty for false
		setcookie('switch',$_GET['switch']); // set a cookie
		if(isset($_SERVER['HTTP_REFERER'])){ // if the referer is set send the user there
			header('Location:'.$_SERVER['HTTP_REFERER']);
			exit;
		}
	}else if(isset($_COOKIE['switch'])){ // if the cookie is set use it
		$mobile = $_COOKIE['switch'];
	}else{ // else use the function to detect if it's a mobile or not
		$mobile = mobile_device_detect();
	}
}
if ($s5_mobile_device_enable_disable == "disabled") {$mobile = false;}
if ($mobile==true) { require(dirname(__FILE__)."/../../vertex/mobile_device_menu.php");}
?>

<meta http-equiv="Content-Type" content="text/html;" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<?php if($mobile==true){ ?>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=1;" />
<meta name="apple-touch-fullscreen" content="YES" />
<?php } ?>

<?php if ($mobile == false && $s5_show_menu == "show") { require(dirname(__FILE__)."/../../vertex/call_menu.php"); } ?>
<?php require(dirname(__FILE__)."/../../vertex/css_and_js.php"); ?>