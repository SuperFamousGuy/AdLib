<?php

$dir = dirname(dirname(__FILE__));
function json2Array($json) {return json_decode($json, 1);}
function getCurrentAlias(){$menu = &JSite::getMenu();}
function getTemplateName($template) {
    $db = JFactory::getDBO();
    $query = "SELECT * FROM #__template_styles WHERE template = '$template';";
    $db->setQuery($query);
	$result = $db->loadAssocList();
	$titles = array();
	$i = 0;
    $home_id = 0;
	foreach($result as $k => $style) {
		$ids[] = $style['id'];
		$titles[$style['id']] = $style['title'];
        if($style['home'] == 1) {
            $home_id = $style['id'];
        }
		$i++;
	}
	$ids = implode(",", $ids);
    $u_main = JURI::root();
    $u = JFactory::getURI();
    $u = $u->toString();
    $u = explode($u_main, $u);
    $com = $u[1];
    $alias = getCurrentAlias();
    $query2 = "SELECT * FROM #__menu WHERE template_style_id IN (". $ids .") AND alias = '$alias'";
    $db->setQuery($query2);
    $result2 = $db->loadAssocList();
    $i2 = 0;
	$id = 0;
    //print_r($result2);
    foreach($result2 as $k => $item) {
		if($item['link'] == $com || preg_match("/" . $item['alias'] . "/i", $alias)) {
			$id = $item['template_style_id'];
            $i2++;
		}
	}
    //print_r($id);
    if($i2 == 0) {
        $id = $home_id;
    }
    //print_r($titles[$id]);
    return $titles[$id];
}

function handleJSONFile($file = false, $style = false, $dir = false) {
    $config = array();
    if (file_exists($dir . '/' . $file)) {
        $check = file_get_contents($dir . '/' . $file);
        $file_data = json2Array($check);
        foreach($file_data['vertexFramework'][$style] as $key => $val){
            $key = str_replace('xml_', '', $key);
            $config[$key] = $val;
        }
    }
    return $config;
}

if (file_exists($dir . '/templateDetails.xml')) {
    $template_xml = simplexml_load_file($dir . '/templateDetails.xml', 'SimpleXMLElement', LIBXML_NOCDATA);
    $template_name = $template_xml->name;
} else {
    $template_name = 'blank';
}

$style_name = getTemplateName($template_name);
$file = 'vertex.json';
$params = handleJSONFile($file, $style_name, $dir);
foreach($params as $k => $v){
    $$k = $v;
}

$s5_lr_tab1_text = str_replace(" ","&nbsp;",$s5_lr_tab1_text);
$s5_lr_tab2_text = str_replace(" ","&nbsp;",$s5_lr_tab2_text);	
$s5_urlforSEO = $s5_seourl;

?>