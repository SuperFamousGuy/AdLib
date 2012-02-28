<?php

define('PHPEXT', '.php');
define('JSONEXT', '.json');

function array2Json($array) {return json_encode($array);}
function json2Array($json) {return json_decode($json, 1);}
function buildArray($style, $data) {return array($style => $data);}

function handleSaveFile($array = false, $style = false, $clear = false) {
    $post_data = array();
    foreach($array as $k => $v) {
        if(!isset($post_data[$v['name']])) {
            $post_data[$v['name']] = $v['value'];
        } else {
            $current = array($post_data[$v['name']], $v['value']);
            $current = implode(',', $current);
            $post_data[$v['name']] = $current;
        }
    }
    $file = '../../vertex' . JSONEXT;
    $jsonData = array();
    $jsonData['vertexFramework'] = array();
    $currentValues = array();
    $check = '';
    if (file_exists($file)) {
        $check = file_get_contents($file);
        $file_data = json2Array($check);
        foreach($file_data['vertexFramework'] as $key => $data){
            if($key == $style) {
                unset($file_data['vertexFramework'][$key]);
            } else {
                $jsonData['vertexFramework'][$key] = $data;
            }
        }
        
    }
    $i = 0;
    foreach($post_data as $key => $value){
        $jsonData['vertexFramework'][$style][$key] = $value;
        $i++;
    }
    if($clear) {
        unset($jsonData['vertexFramework'][$style]);
    }
    if($array != false) {
        $data = array2Json($jsonData);
        $file = fopen($file, 'w');
        fwrite($file, $data);
        fclose($file);
        $msg = array('message' => 'Your settings were saved');
        return $data;
        //return array2Json($msg);
    }
    $msg = array('message' => 'There was an error while saving your configuration');
    return array2Json($msg);
}

$post = $_POST;
header('Content-type: application/json');
//print array2Json($post);
//print_r($post['clear']);

print handleSaveFile($post['vertex'], $post['style_name'], (isset($post['clear']) ? $post['clear'] : false));

?>