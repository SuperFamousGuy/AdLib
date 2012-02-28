<?php

define('PHPEXT', '.php');
define('JSONEXT', '.json');
define('VERTEX_PATH', dirname(__FILE__));
define('BASE_PATH', dirname(dirname(dirname(dirname(dirname(__FILE__))))));

function cLog($msg){
    print "<script type='text/javascript'>console.log('$msg');</script>";
}

class vertexDefaults {
    //Main
    var $templateName = 'vertex';
    var $templatePath = 'admin/';
    var $details = array();
    var $idPrefix = 'pane_';
    var $adminLayout = '';
    var $templateXml = '../../xml/Specific.xml';
    var $vertexXml = '../../xml/Vertex.xml';
    var $vertexVersion = 0;
    var $img_path = '';
    var $vLang = array();
    var $vMenu = array();
    var $count = 0;
    var $form = '<form id="{ID}_form" class="vertex-admin-form" method="post" action="saveOptions.php">{DATA}</form>';
    var $submit = '<input class="v-submit" type="submit" value="Submit" />';
    var $wrapper = '<div id="{ID}" class="{CLASS}">{DATA}</div>';
    var $menu = '<ul class="{CLASS}">{MENU}</ul>';
    var $fieldsetWrap = '<div class="{CLASS}" id="{ID}"><h2 class="{CLASS2}">{TITLE}</h2>{DATA}</div>';
    var $itemTemplate = '<div class="vItem"><div class="vItemName">{LABEL}</div><div class="vItemValue">{ITEM}</div></div>';
    var $currentValue = array();
    var $googleFonts;
    var $defaults = array();
    var $headScript = '';
    var $headCss = '';
    var $preloaded = array();
    
    function loadDefaults() {
        $this->defaults['panel_wrap'] = 'vertex-admin-wrap';
        $this->defaults['panel'] = 'vertex-admin-panel';
        $this->defaults['panel_title'] = 'vertex-admin-panel-title';
        $this->defaults['top_menu'] = 'vertex-admin-menu';
        $this->defaults['main_menu'] = 'fader-tabs';
    }
}

class Vertex {
    function __construct($cms) {
        
        $this->loadPositions(1, 'logo');
    }
    function loadPositions($num, $position) {
        $positions = '';
        for($i = 0; $num < $i; $i++) {
            $positions .= $this->vertexLoadModule($position);
        }
        return $positions;
    }
    function vertexLoadModule($position) {
        $module = require('positions_folder/' . $position . PHPEXT);
    }
}

class vertexCore extends vertexDefaults {
    function buildSpacer($spacer) {
        $build = '';
        $name = $spacer['name'];
        $type = explode(':', $spacer['type']);
        $label = $spacer['label'];
        if (preg_match("/TPL/i", $label)) {$label = isset($this->vLang["$label"]) ? $this->vLang["$label"] : $label;}
        $build .= '<div class="v-display ' . $type[0] . ' ' . (isset($type[1]) ? $type[1] : 'notice') . '"><img src="' . $this->img_path . '/' . (isset($type[1]) ? $type[1] : 'notice') . '.png" alt="' . ucfirst((isset($type[1]) ? $type[1] : 'notice')) . '" /><div>' . $label . '</div></div>';
        return $build;
    }
    function buildSelect($select, $stype) {
        $build = '';
        $name = $select['name'];
        $type = explode(':', $select['type']);
        $desc = $select['description'];
        $options = $select['option'];
        $value = isset($this->currentValue["$name"]) ? $this->currentValue["$name"] : $select['default'];
        $value = explode(',', $value);
        if (preg_match("/TPL/i", $desc)) {$desc = isset($this->vLang["$desc"]) ? $this->vLang["$desc"] : $desc;}
        $label = $select['label'];
        if (preg_match("/TPL/i", $label)) {$label = isset($this->vLang["$label"]) ? $this->vLang["$label"] : $label;}
        $label = str_replace('_', ' ', $label);
        $label = '<label for="' . $name . '">' . $label . '</label><span class="vFloatDesc">' . $desc . '</span>';
        $tmpSelect = '<select id="' . $name . '" name="' . $name . '"' . ((isset($type[1]) ? $type[1] : '') == 'multible' ? ' multiple="multiple"' : '') . '>';
        if(!preg_match("/fonts/i", $name)) {
            foreach($select->option as $option){
                $val = array();
                if($stype == false){
                    $val = explode(':', $option);
                } else {
                    $val[0] = (string)$option['value'];
                    $val[1] = (string)$option;
                    if (preg_match("/TPL/i", $val[1])) {$val[1] = isset($this->vLang["$val[1]"]) ? $this->vLang["$val[1]"] : $val[1];}
                    $val2 = $val[1];
                }
                $tmpSelect .= '<option value="' . $val[0] . '"' . (in_array($val[0], $value) ? ' selected="selected"' : '') . '>' . $val2 . '</option>';
            }
        } else {
            foreach($this->googleFonts as $key => $font){
                if (preg_match("/TPL/i", $font)) {$font = isset($this->vLang["$font"]) ? $this->vLang["$font"] : $font;}
                $tmpSelect .= '<option value="' . $key . '"' . (in_array($key, $value) ? ' selected="selected"' : '') . '>' . $font . '</option>';
            }
        }
        
        $tmpSelect .= '</select>';
        $tmp = $this->itemTemplate;
        $build = str_replace('{LABEL}', $label, $tmp);
        $build = str_replace('{ITEM}', $tmpSelect, $build);
        return $build;
    }
    function buildMenuSelect($select, $stype) {
        $build = '';
        $name = $select['name'];
        $type = explode(':', $select['type']);
        $desc = $select['description'];
        $options = $select['option'];
        $value = isset($this->currentValue["$name"]) ? $this->currentValue["$name"] : $select['default'];
        $value = explode(',', $value);
        if (preg_match("/TPL/i", $desc)) {$desc = isset($this->vLang["$desc"]) ? $this->vLang["$desc"] : $desc;}
        $label = $select['label'];
        if (preg_match("/TPL/i", $label)) {$label = isset($this->vLang["$label"]) ? $this->vLang["$label"] : $label;}
        $label = str_replace('_', ' ', $label);
        $label = '<label for="' . $name . '">' . $label . '</label><span class="vFloatDesc">' . $desc . '</span>';
        $tmpSelect = '';
        $tmp = $this->itemTemplate;
        $build = str_replace('{LABEL}', $label, $tmp);
        $build = str_replace('{ITEM}', $tmpSelect, $build);
        return $build;
    }
    function buildMenuItems($select, $stype) {
        $build = '';
        $name = $select['name'];
        $type = explode(':', $select['type']);
        $desc = $select['description'];
        $options = $select['option'];
        $value = isset($this->currentValue["$name"]) ? $this->currentValue["$name"] : $select['default'];
        $value = explode(',', $value);
        if (preg_match("/TPL/i", $desc)) {$desc = isset($this->vLang["$desc"]) ? $this->vLang["$desc"] : $desc;}
        $label = $select['label'];
        if (preg_match("/TPL/i", $label)) {$label = isset($this->vLang["$label"]) ? $this->vLang["$label"] : $label;}
        $label = str_replace('_', ' ', $label);
        $label = '<label for="' . $name . '">' . $label . '</label><span class="vFloatDesc">' . $desc . '</span>';
        $tmpSelect = '';
        $tmp = $this->itemTemplate;
        $build = str_replace('{LABEL}', $label, $tmp);
        $build = str_replace('{ITEM}', $tmpSelect, $build);
        return $build;
    }
    
    function buildRadio($radio) {
        $build = '';
        $name = $radio['name'];
        $value = isset($this->currentValue["$name"]) ? $this->currentValue["$name"] : $radio['default'];
        $type = explode(':', $radio['type']);
        $desc = $radio['description'];
        if (preg_match("/TPL/i", $desc)) {$desc = isset($this->vLang["$desc"]) ? $this->vLang["$desc"] : $desc;}
        $label = $radio['label'];
        if (preg_match("/TPL/i", $label)) {$label = isset($this->vLang["$label"]) ? $this->vLang["$label"] : $label;}
        $label = str_replace('_', ' ', $label);
        $label = '<label for="' . $name . '">' . $label . '</label><span class="vFloatDesc">' . $desc . '</span>';
        $vars = $radio['vars'];
        $vars = explode('|', $vars);
        $vals = explode(':', $vars[0]);
        $labels = explode(':', $vars[1]);
        if (preg_match("/TPL/i", $labels[0])) {$labels[0] = isset($this->vLang["$labels[0]"]) ? $this->vLang["$labels[0]"] : $labels[0];}
        if (preg_match("/TPL/i", $labels[1])) {$labels[1] = isset($this->vLang["$labels[1]"]) ? $this->vLang["$labels[1]"] : $labels[1];}
        $tmpRadio = '<input id="' . $name . '" type="' . $type[0] . '" name="' . $name . '" value="' . $vals[0] . '" ' . ($value == $vals[0] ? ' checked="checked"' : '') . ' /> ' . $labels[0] . '
        <input type="' . $type[0] . '" name="' . $name . '" value="' . $vals[1] . '"' . ($value == $vals[1] ? ' checked="checked"' : '') . '/> ' . $labels[1] . '';
        $tmp = $this->itemTemplate;
        $build = str_replace('{LABEL}', $label, $tmp);
        $build = str_replace('{ITEM}', $tmpRadio, $build);
        return $build;
    }
    function buildText($text) {
        $build = '';
        $name = $text['name'];
        $value = isset($this->currentValue["$name"]) ? $this->currentValue["$name"] : $text['default'];
        $type = explode(':', $text['type']);
        $desc = $text['description'];
        if (preg_match("/TPL/i", $desc)) {$desc = isset($this->vLang["$desc"]) ? $this->vLang["$desc"] : $desc;}
        $label = $text['label'];
        if (preg_match("/TPL/i", $label)) {$label = isset($this->vLang["$label"]) ? $this->vLang["$label"] : $label;}
        $label = str_replace('_', ' ', $label);
        $label = '<label for="' . $name . '">' . $label . '</label><span class="vFloatDesc">' . $desc . '</span>';
        $input = '<input id="' . $name . '" name="' . $name . '" type="' . $type[0] . '" size="' . (isset($type[1]) ? $type[1] : '30') . '" maxlength="' . (isset($type[2]) ? $type[2] : '200') . '" value="' . $value . '" />';
        $tmp = $this->itemTemplate;
        $build = str_replace('{LABEL}', $label, $tmp);
        $build = str_replace('{ITEM}', $input, $build);
        return $build;
    }
    function buildTextarea($textarea) {
        $build = '';
        $name = $textarea['name'];
        $value = isset($this->currentValue["$name"]) ? $this->currentValue["$name"] : $textarea['default'];
        $cols = isset($textarea['cols']) ? $textarea['cols'] : '10';
        $rows =  isset($textarea['rows']) ? $textarea['rows'] : '10';
        $desc = $textarea['description'];
        if (preg_match("/TPL/i", $desc)) {$desc = isset($this->vLang["$desc"]) ? $this->vLang["$desc"] : $desc;}
        $label = $textarea['label'];
        if (preg_match("/TPL/i", $label)) {$label = isset($this->vLang["$label"]) ? $this->vLang["$label"] : $label;}
        $label = str_replace('_', ' ', $label);
        $label = '<label for="' . $name . '">' . $label . '</label><span class="vFloatDesc">' . $desc . '</span>';
        $input = '<textarea id="' . $name . '" name="' . $name . '" cols="' . $cols . '" rows="' . $rows . '">' . $value . '</textarea>';
        $tmp = $this->itemTemplate;
        $build = str_replace('{LABEL}', $label, $tmp);
        $build = str_replace('{ITEM}', $input, $build);
        return $build;
    }
    function vertexLoadScript($templatePath, $type, $load = false){
        $scripts = array();
        $scripts[0] = $templatePath . 'jquery.vertexAdmin.min.js';
        $scripts[1] = $templatePath . 'jquery.vertexAdmin.core.min.js';
        foreach($scripts as $script){
            if($load) {
                if(preg_match("($load)i", $script)) {
                    $tmp = '<script type="text/javascript" src="' . $script . '"></script>';
                    $copy = $this->headScript;
                    $this->headScript = $copy . $tmp;
                    $this->preloaded["$script"] = $load;
                }
            } else {
                if(!isset($this->preloaded["$script"])){
                    $tmp = '<script type="text/javascript" src="' . $script . '"></script>';
                    $copy = $this->headScript;
                    $this->headScript = $copy . $tmp;
                }
            }
        }
    }
    function vertexLoadCss($templatePath, $type){
        $csss = array();
        $csss[0] = 'admin/vertex.css';
        
        foreach($csss as $css){
            $tmp = '<link href="' . $css . '" rel="stylesheet" type="text/css" />';
            $copy = $this->headCss;
            $this->headCss = $copy . $tmp;
        }
    }
    function vertexBuildAbout($title){
        $html = str_replace('{TITLE}', $title, $this->fieldsetWrap);
        $html = str_replace('{CLASS}', $this->defaults['panel'], $html);
        $html = str_replace('{CLASS2}', $this->defaults['panel_title'], $html);
        $html = str_replace('{ID}', 'pane_about', $html);
        require('vertexAbout' . PHPEXT);
        $html = str_replace('{DATA}', $about_file, $html);
        return $html;
    }
}

class vertexAdmin extends vertexCore {
    function __construct($vertexXML = false, $templateName = false, $templateXML = false, $templatePath = false, $img_path = false) {
        if($vertexXML) {$this->vertexXml = $vertexXML;}
        if($templateName) {$this->templateName = $templateName;}
        if($templatePath) {$this->templatePath = $templatePath;}
        require('googleFonts' . PHPEXT);
        $this->googleFonts = $googleFonts;
        if($templateXML) {$this->templateXml = $templateXML;}
        if($img_path) {$this->img_path = $img_path;}
        $this->loadDefaults();
    }
    function handleSaveFile($file = false, $style = false) {
        $file = $file . JSONEXT;
        if (file_exists($file)) {
            $check = file_get_contents($file);
            $file_data = $this->json2Array($check);
            if(is_array($file_data) && isset($file_data['vertexFramework'][$style])) {
                foreach($file_data['vertexFramework'][$style] as $key => $val){
                    $this->currentValue[$key] = $val;
                }
            }
        }
    }
    function object2Array($object) {return @json_decode(@json_encode($object), 1);}
    function array2Json($array) {return @json_encode($array);}
    function json2Array($json) {return json_decode($json, 1);}
    function findLang($lang_file) {
        if (file_exists(VERTEX_PATH . '/../../../../language/' . $lang_file)) {
            //cLog('Language file location: ' . '../../../../language/' . $lang_file);
            return '../../../../language/' . $lang_file;
        } elseif(file_exists(VERTEX_PATH . '/../../xml/language/' . $lang_file)) {
            //cLog('Language file location: ' . '../../xml/language/' . $lang_file);
            return '../../xml/language/' . $lang_file;
        } elseif(file_exists(VERTEX_PATH . '/../../language/' . $lang_file)) {
            //cLog('Language file location: ' . '../../language/' . $lang_file);
            return '../../language/' . $lang_file;
        } else {
            return false;
        }
    }
    function admin_lang($lang_file, $type = 'vertex') {
        $lang_file = $this->findLang($lang_file);
        if ($lang_file) {
            $lang_file = file($lang_file);
            foreach ($lang_file as $item) {if (@preg_match('/(.+)="(.+)"/', $item, $matches)) {$this->vLang[$matches[1]] = $matches[2];}}
        } else {
            if($type == 'vertex') {exit('Vertex Launguage file not found');} else {exit('Template Launguage file not found');}
        }
    }
    function getJoomlaParams() {
        if (file_exists($this->templateXml)) {
            $this->templateXml = simplexml_load_file($this->templateXml, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->admin_lang($this->templateXml->languages->language, 'joomla');
            $i = 0;
            $i2 = 0;
            $admin_options = array();
            $fieldsets = $this->templateXml->config->fields;
            $htmlData = '';
            foreach($fieldsets->fieldset as $key => $fieldset){
                $tmp = '';
                $html = '';
                $arraykey = 'vertex_page' . $i;
                $tab_title = $fieldset['label'];
                if (preg_match("/TPL/i", $tab_title)) {$tab_title = isset($this->vLang["$tab_title"]) ? $this->vLang["$tab_title"] : $tab_title;}
                $k = $this->idPrefix . strtolower(str_replace(' ', '_', $tab_title));
                $this->vMenu[$k] = $tab_title;
                $html = str_replace('{TITLE}', $tab_title, $this->fieldsetWrap);
                $html = str_replace('{CLASS}', $this->defaults['panel'], $html);
                $html = str_replace('{CLASS2}', $this->defaults['panel_title'], $html);
                $html = str_replace('{ID}', $k, $html);
                
                $admin_options[$arraykey] = array();
                $admin_options[$arraykey]['title'] = $tab_title;
                $admin_options[$arraykey]['id'] = $arraykey;
                foreach($fieldset as $key => $item){
                    $admin_options[$arraykey]['items'][] = $this->vertexBuildAdmin($item, true);
                    $tmp .= $this->vertexBuildAdmin($item, true);
                }
                
                $html = str_replace('{DATA}', $tmp, $html);
                $htmlData .= $html;
                $i++;
            }
            $this->count = $i;
        } else {
            exit('Template XML file not found');
        }
        return $htmlData;
    }
    function vertexLoadAdmin($style = 'default'){
        if (file_exists($this->vertexXml)) {
            $this->vertexXml = simplexml_load_file($this->vertexXml, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->details = $this->vertexXml->details;
            $this->admin_lang($this->vertexXml->languages->language);
            $this->vertexVersion = $this->details->frameworkVersion;
            cLog('Vertex Version: ' . $this->vertexVersion);
            $this->handleSaveFile('../../vertex', $style);
            $i = 0;
            $i2 = 0;
            $admin_options = array();
            $fieldsets = $this->vertexXml->admin;
            $htmlTmp = '';
            $htmlData = '';
            $htmlTmp .= $this->getJoomlaParams();
            if($this->count > 0) {
                $i = $this->count;
            }
            foreach($fieldsets->fieldset as $key => $fieldset){
                $tmp = '';
                $html = '';
                $arraykey = 'vertex_page' . $i;
                $tab_title = $fieldset['label'];
                if (preg_match("/TPL/i", $tab_title)) {$tab_title = isset($this->vLang["$tab_title"]) ? $this->vLang["$tab_title"] : $tab_title;}
                $k = $this->idPrefix . strtolower(str_replace(' ', '_', str_replace(':', '', $tab_title)));
                $this->vMenu[$k] = $tab_title;
                $html = str_replace('{TITLE}', $tab_title, $this->fieldsetWrap);
                $html = str_replace('{CLASS}', $this->defaults['panel'], $html);
                $html = str_replace('{CLASS2}', $this->defaults['panel_title'], $html);
                $html = str_replace('{ID}', $k, $html);
                
                $admin_options[$arraykey] = array();
                $admin_options[$arraykey]['title'] = $tab_title;
                $admin_options[$arraykey]['id'] = $arraykey;
                foreach($fieldset as $key => $item){
                    $admin_options[$arraykey]['items'][] = $this->vertexBuildAdmin($item, true);
                    $tmp .= $this->vertexBuildAdmin($item, true);
                }
                $html = str_replace('{DATA}', $tmp, $html);
                $htmlTmp .= $html;
                $i++;
            }
            $htmlData = str_replace('{CLASS}', $this->defaults['panel_wrap'], $this->wrapper);
            $htmlData = str_replace('{ID}', 'vertex_fader', $htmlData);
            $this->vMenu['pane_about'] = 'About';
            $htmlTmp .= $this->vertexBuildAbout('About');
            $menus = $this->vertexBuildMenus();
            $htmlData = str_replace('{DATA}', $menus . $htmlTmp, $htmlData);
            $htmlForm = str_replace('{ID}', 'vertex_admin', $this->form);
            $htmlForm = str_replace('{DATA}', $htmlData, $htmlForm);
        } else {
            exit('Vertex XML file not found');
        }
        $this->vertexDisplayAdmin($htmlForm);
        return $this->adminLayout;
    }
    function vertexBuildMenus() {
        $menu_built = '';
        $menu1 = '';
        $menu2 = '';
        $i = 0;
        foreach($this->vMenu as $k => $item) {
            $k = str_replace(':', '', $k);
            if($i < 6) {
                $menu1 .= "<li class='panel-tab'><a href='#$k' class='a-tab'>$item</a></li>";
            } else if($i > 5) {
                $menu2 .= "<li class='panel-tab'><a href='#$k' class='a-tab'>$item</a></li>";
            }
            $i++;
        }
        $menu3 = str_replace('{CLASS}', $this->defaults['top_menu'], $this->menu);
        $menu3 = str_replace('{MENU}', $menu1, $menu3);
        $menu4 = str_replace('{CLASS}', $this->defaults['main_menu'], $this->menu);
        $menu4 = str_replace('{MENU}', $menu2, $menu4);
        $menu_built = $menu3 . $menu4;
        return $menu_built;
    }
    function vertexBuildAdmin($item, $stype) {
        $item_built = '';
        if(preg_match("/spacer/i", $item['type'])) {
            $item_built .= $this->buildSpacer($item);
        }
        if(preg_match("/text/i", $item['type']) && !preg_match("/textarea/i", $item['type']) ) {
            $item_built .= $this->buildText($item);
        }
        if(preg_match("/textarea/i", $item['type'])) {
            $item_built .= $this->buildTextarea($item);
        }
        if(preg_match("/radio/i", $item['type'])) {
            $item_built .= $this->buildRadio($item);
        }
        if(preg_match("/select/i", $item['type'])) {
            $item_built .= $this->buildSelect($item, $stype);
        }
        if(preg_match("/menuitems/i", $item['type'])) {
            $item_built .= $this->buildMenuItems($item, $stype);
        }
        if(preg_match("/menu_list/i", $item['type'])) {
            $item_built .= $this->buildMenuSelect($item, $stype);
        }
        return $item_built;
    }
    function vertexDisplayAdmin($htmlWrap) {
        print($htmlWrap);
    }
}

?>