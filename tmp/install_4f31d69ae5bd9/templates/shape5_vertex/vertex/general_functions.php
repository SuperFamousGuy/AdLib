<?php

/* pulls from admin if URL entered in admin area */
if ($s5_urlforSEO  == ""){ 
$LiveSiteUrl = JURI::root();}
if ($s5_urlforSEO  != ""){ 
$LiveSiteUrl = "$s5_urlforSEO/";}

/* template directory URL used index.php */
$s5_template_name = $this->template;
$s5_directory_path = $LiveSiteUrl."templates/".$s5_template_name;
$s5_multibox_path = "templates/".$s5_template_name."/js/multibox/";
?>
<script type="text/javascript">
var s5_multibox_path = "<?php echo $s5_multibox_path ?>";
</script>
<?php

/* If browser calls */
$br = strtolower($_SERVER['HTTP_USER_AGENT']);
$browser = "other";

if(strrpos($br,"msie 6") > 1) {
$browser = "ie6";} 

if(strrpos($br,"msie 7") > 1) {
$browser = "ie7";} 

if(strrpos($br,"msie 8") > 1) {
$browser = "ie8";} 

if(strrpos($br,"msie 9") > 1) {
$browser = "ie9";} 

if(strrpos($br,"opera") > 1) {
$browser = "opera";} 


/* Hides frontpage component area when enabled in admin */
$s5_show_component = "yes";

jimport( 'joomla.version' );
$version = new JVersion();
$version_number = 'version_'.$version->getShortVersion();

if(!empty($s5_hide_component_items)) {  
	$s5_hide_component_items = explode(',', $s5_hide_component_items);
	$s5_hide_component_array_count = sizeof($s5_hide_component_items);
	for ($s5_hide_component_array_holder = 0; $s5_hide_component_array_holder < $s5_hide_component_array_count; $s5_hide_component_array_holder++) {
		if ($s5_hide_component_items[$s5_hide_component_array_holder] == JSite::getMenu()->getActive()->id) {
			$s5_show_component = "no";
		}
	}
}


// Change a hex color
function change_Color($color, $dif)
{
 $color = str_replace('#','', $color);
 $rgb = '';
 if (strlen($color) != 6) {
  // reduce the default amount a little
  $dif = ($dif==20)?$dif/10:$dif;
  for ($x = 0; $x < 3; $x++) {
   $c = hexdec(substr($color,(1*$x),1)) - $dif;
   $c = ($c < 0) ? 0 : dechex($c);
   $rgb .= $c;
  }
 } else {
  for ($x = 0; $x < 3; $x++) {
   $c = hexdec(substr($color, (2*$x),2)) - $dif;
   $c = ($c < 0) ? 0 : dechex($c);
   $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
  }
 }
 return ''.$rgb;
}

?>