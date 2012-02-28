<?php



/**

* Author: Tobias Grahn

* Email: info@joohopia.com

* Module: jPop

* Based on jQuery by Marius Stanciu

* Version: 1.0.0

**/

// no direct access



defined( '_JEXEC' ) or die( 'Restricted access' );

$path = 'modules/mod_jpop/';

$compurla = JURI::base() . $path;



JHTML::stylesheet('jquery.notty.css',$compurla.'css/');

$jpophead =  $params->get('jpophead', "");

$jpopulr =  $params->get('jpopurl', "");

$jpoptext =  $params->get('jpoptext', "");

$jpoptimer =  $params->get('jpoptimer', "");

$jpoppos =  $params->get('jpoppos', "");

switch ($jpoppos) {

   case "1" :

$jpoptop="top";

$jpopleft="left";

   break;

   case "2" :

$jpoptop="top";

$jpopleft="right";

   break;

   case "3" :

$jpoptop="bottom";

$jpopleft="left";

   break;

    case "4" :

$jpoptop="bottom";

$jpopleft="right";

   break;

   default :

$jpoptop="bottom";

$jpopleft="right";

   break;

   }

$document = &JFactory::getDocument();

$document->addScript($compurla.'js/jquery-1.4.3.min.js' );
$document = &JFactory::getDocument();

$document->addScript($compurla.'js/jquery.notty.js' );
$document = &JFactory::getDocument();

$document->addScript($compurla.'js/jquery.timer.js' );
if ($jpopulr!=""){

$jpophead = "<a href='".$jpopulr."'>".$jpophead."</a>";}

$jpophead = $jpophead."<br/></div><div class='minijpg' ><a href='http://www.joohopia.com?jpop=1.0.0' alt='joomla modules' title='joomla module' id='minijpg'>jPop from Joohopia</a></div><div>";

$jpophead=  str_replace('\n', '<br/>', json_encode($jpophead));

$jpoptext=  str_replace('\n', '<br/>', json_encode($jpoptext));
/*<script type="text/javascript" src="<?php echo ($compurla) ?>js/jquery.notty.js"></script>

<script type="text/javascript" src="<?php echo ($compurla) ?>js/jquery.timer.js"></script>*/
?>



<style type="text/css">

.minijpg a, #minijpg {

	font-size:7px;

	color:#663;

}

#nottys {

	top:auto;

<? echo($jpoptop) ?>: 20px;

<? echo($jpopleft) ?>: 20px;

	width: 280px;

	z-index: 999;

}

.pop a:link, .pop a:visited {

	color: white;

	text-shadow: black 0px 1px 2px;

	/*font: inherit;*/

cursor: default;

	text-decoration:none;

	background-color:inherit;

}
.pop a:hover {
	color:#C30;}

</style>

<script type="text/javascript">
$baus =<?php echo($jpophead) ?>;
$raus =<?php echo ($jpoptext)?>;
jQuery.noConflict(); 
                      jQuery(document).ready(function()
                                        {                                        
 													jQuery.notty({
                                                        content: $baus,
                                                        title: $raus,
														showTime: false
                                                   	 });
													return false;
      									 var timer = jQuery.timer(function() {	 	});
												timer.once(<?php echo ($jpoptimer) ?>);
																						});
(jQuery); 
</script>

