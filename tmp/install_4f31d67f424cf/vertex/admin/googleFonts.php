<?php
/*
 *Shape 5 Google Fonts List
 */
$googleFonts = array();
$googleFonts['Allan'] = 'Allan';
$googleFonts['Allerta'] = 'Allerta';
$googleFonts['Allerta Stencil'] = 'Allerta Stencil';
$googleFonts['Anonymous Pro'] = 'Anonymous Pro';
$googleFonts['Anton'] = 'Anton';
$googleFonts['Arial'] = 'Arial';
$googleFonts['Arimo'] = 'Arimo';
$googleFonts['Arvo'] = 'Arvo';
$googleFonts['Astloch'] = 'Astloch';
$googleFonts['Bentham'] = 'Bentham';
$googleFonts['Bevan'] = 'Bevan';
$googleFonts['Buda'] = 'Buda';
$googleFonts['Cabin'] = 'Cabin';
$googleFonts['Calligraffitti'] = 'Calligraffitti';	
$googleFonts['Cantarell'] = 'Cantarell';
$googleFonts['Cardo'] = 'Cardo';	
$googleFonts['Carme'] = 'Carme';	
$googleFonts['Cherry Cream Soda'] = 'Cherry Cream Soda';
$googleFonts['Chewy'] = 'Chewy';
$googleFonts['Coda'] = 'Coda';	
$googleFonts['Coming Soon'] = 'Coming Soon';
$googleFonts['Comfortaa'] = 'Comfortaa';
$googleFonts['Copse'] = 'Copse';
$googleFonts['Corben'] = 'Corben';
$googleFonts['Cousine'] = 'Cousine';
$googleFonts['Covered By Your Grace'] = 'Covered By Your Grace';
$googleFonts['Crafty Girls'] = 'Crafty Girls';
$googleFonts['Crimson Text'] = 'Crimson Text';
$googleFonts['Crushed'] = 'Crushed';
$googleFonts['Cuprum'] = 'Cuprum';	
$googleFonts['Dancing Script'] = 'Dancing Script';
$googleFonts['Droid Sans'] = 'Droid Sans';
$googleFonts['Droid Sans Mono'] = 'Droid Sans Mono';
$googleFonts['Droid Serif'] = 'Droid Serif';
$googleFonts['Expletus Sans'] = 'Expletus Sans';
$googleFonts['Fontdiner Swanky'] = 'Fontdiner Swanky';
$googleFonts['Geo'] = 'Geo';
$googleFonts['Goudy Bookletter 1911'] = 'Goudy Bookletter 1911';	
$googleFonts['Gruppo'] = 'Gruppo';			
$googleFonts['Homemade Apple'] = 'Homemade Apple';
$googleFonts['Helvetica'] = 'Helvetica';
$googleFonts['IM Fell'] = 'IM Fell';
$googleFonts['Inconsolata'] = 'Inconsolata';
$googleFonts['Irish Growler'] = 'Irish Growler';
$googleFonts['Josefin Slab'] = 'Josefin Slab';
$googleFonts['Josefin Sans'] = 'Josefin Sans';
$googleFonts['Josefin Sans Std Light'] = 'Josefin Sans Std Light';
$googleFonts['Just Another Hand'] = 'Just Another Hand';
$googleFonts['Just Me Again Down Here'] = 'Just Me Again Down Here';	
$googleFonts['Kenia'] = 'Kenia';
$googleFonts['Kranky'] = 'Kranky';
$googleFonts['Kreon'] = 'Kreon';
$googleFonts['Kristi'] = 'Kristi';
$googleFonts['Lato'] = 'Lato';
$googleFonts['Lekton'] = 'Lekton';
$googleFonts['Lobster'] = 'Lobster';
$googleFonts['Luckiest Guy'] = 'Luckiest Guy';
$googleFonts['Mako'] = 'Mako';
$googleFonts['Meddon'] = 'Meddon';
$googleFonts['Merriweather'] = 'Merriweather';
$googleFonts['Molengo'] = 'Molengo';
$googleFonts['Mountains of Christmas'] = 'Mountains of Christmas';
$googleFonts['Neucha'] = 'Neucha';
$googleFonts['Neuton'] = 'Neuton';
$googleFonts['Nobile'] = 'Nobile';
$googleFonts['OFL Sorts Mill Goudy TT'] = 'OFL Sorts Mill Goudy TT';
$googleFonts['Old Standard TT'] = 'Old Standard TT';
$googleFonts['Open Sans'] = 'Open Sans';
$googleFonts['Open Sans Condensed'] = 'Open Sans Condensed:300';
$googleFonts['Orbitron'] = 'Orbitron';
$googleFonts['Oswald'] = 'Oswald';
$googleFonts['Permanent Marker'] = 'Permanent Marker';
$googleFonts['Philosopher'] = 'Philosopher';
$googleFonts['PT Sans'] = 'PT Sans';
$googleFonts['PT Serif'] = 'PT Serif';
$googleFonts['Puritan'] = 'Puritan';
$googleFonts['Questrial'] = 'Questrial';
$googleFonts['Radley'] = 'Radley';	
$googleFonts['Raleway'] = 'Raleway';
$googleFonts['Reenie Beanie'] = 'Reenie Beanie';
$googleFonts['Rock Salt'] = 'Rock Salt';
$googleFonts['Sans-Serif'] = 'Sans-Serif';
$googleFonts['Schoolbell'] = 'Schoolbell';
$googleFonts['Slackey'] = 'Slackey';
$googleFonts['Sniglet'] = 'Sniglet';
$googleFonts['Sunshiney'] = 'Sunshiney';
$googleFonts['Syncopate'] = 'Syncopate';
$googleFonts['Tangerine'] = 'Tangerine';
$googleFonts['Tinos'] = 'Tinos';
$googleFonts['Ubuntu'] = 'Ubuntu';
$googleFonts['UnifrakturCook'] = 'UnifrakturCook';
$googleFonts['UnifrakturMaguntia'] = 'UnifrakturMaguntia';
$googleFonts['Unkempt'] = 'Unkempt';
$googleFonts['Vibur'] = 'Vibur';	
$googleFonts['Vollkorn'] = 'Vollkorn';
$googleFonts['VT323'] = 'VT323';
$googleFonts['Walter Turncoat'] = 'Walter Turncoat';	
$googleFonts['Yanone Kaffeesatz'] = 'Yanone Kaffeesatz';

//$googleFonts[''] = '';

asort($googleFonts);

function Search($googleFonts, $term) {
    if (is_array($googleFonts)) {
        //print $term;
        $return_array = array();
        if ($term == '') {
            $return_array = $googleFonts;
        } else {
            $count = count($googleFonts);
            $i = 0;
            foreach ($googleFonts as $k => $v) {
                $k = '&' . $k;
                $exists = stripos($k, $term) ? true : false;
                if ($exists) {
                    $value = str_replace('&', '', $k);
                    $label = ucwords(str_replace('_', ' ', $v));
                    $return_array[] = array('key' => $value, 'value' => $label);
                }
                $i++;
            }
        }
        return $return_array;
    }
    return false;
}

if(isset($_POST['search'])) {
    $returnArray = Search($googleFonts, (isset($_POST['term']) ? $_POST['term'] : ''));
    $count = count($googleFonts);
    header('Content-type: application/json');
    echo json_encode($returnArray);
}

?>