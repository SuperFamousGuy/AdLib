<?php
/*
# "VOTItaly" Plugin for Joomla! 1.5.x - Version 1.2
# License: http://www.gnu.org/copyleft/gpl.html
# Authors: Luca Scarpa & Silvio Zennaro
# Copyright (c) 2006 - 2009 Siloos snc - http://www.siloos.it
# Project page at http://www.joomitaly.com - Demos at http://demo.joomitaly.com
# ***Last update: Aug 27th, 2009***
# Modified by Kirungi Fred Fideri for VideoFlow v. 1.1.x - http://www.videoflow.tv
# ***Last modification: July 2011***
*/


defined( '_JEXEC' ) or die( 'Restricted access' );
 
 
class VideoflowExtraVotitaly
{
 
   	function __construct()
	{
	//	parent::__construct();
	  global $vparams;

		$cid = JRequest::getInt('cid', false);
		$rate = JRequest::getInt ('rating', false);
/** /RETRIEVING VOTITALY PLUGIN PARAMETERS **/

    $vparams->check_dbtable = $vparams->only_registered;

/** /CHECKING FOR DATABASE INTEGRITY **/
	if ($vparams->check_dbtable) {
		$this-> _votitaly_checkDatabaseIntegrity();
	}
/** /CHECKING FOR DATABASE INTEGRITY **/

// calling the _votitaly_storeVote function to submit the rating action
  $status_code = $this->_votitaly_storeVote($cid, $rate); 
	}
   
/**
 * FUNCTION _votitaly_storeVote
 **/
function _votitaly_storeVote($media_id, $user_rating) {
  global $vparams;
  
	$db  = & JFactory::getDBO();	
	$error = 0;
	$message = '';
	$fbuser = JRequest::getInt('fbuser');
		
	/** CHECKING FOR RATING ACCESS **/
	if ($vparams->only_registered) {
	
		$user =& JFactory::getUser();
		if ($user->guest && !empty($fbuser)) {
		 include_once (JPATH_COMPONENT_SITE.DS.'helpers'.DS.'videoflow_user_manager.php');
		 $userobj = VideoFlowUserManager::getVFuserObj ($fbuser);
		 if (!empty($userobj->joomla_id)) $user = & JFactory::getUser($userobj->joomla_id);
		}
		if ($user->guest) {
			$error = 4; // only logged users can vote
		} else {
			// retrieving last rating
			$query = 'SELECT COUNT(id) as num FROM #__vflowreg_rating '
				. ' WHERE media_id='.intval($media_id)
				. '   AND user_id='.intval($user->id);
			if ($vparams->rating_periodical > 0) 
				$query .= '   AND DATE_ADD(submitted, INTERVAL '.intval($vparams->rating_periodical).' HOUR) > NOW() ';

			$db->setQuery($query);			
			if (!$db->query()) {
				$error = 1;
				$message = $db->stderr();
			} else {
				$obj = $db->loadObject();
				if ($obj->num > 0) {
					$error = 5;
				} else {
					// inserting new rating
					$query = 'INSERT INTO #__vflowreg_rating (media_id, user_id, rating, submitted) '
						. ' VALUES ('.intval($media_id).', '.intval($user->id).', '.intval($user_rating).', NOW()) ';
					$db->setQuery($query);			
					if (!@$db->query()) {
						$error = 1;
						$message = $db->stderr();
					}
				}
			}
		}
	}
	/** /CHECKING FOR RATING ACCESS **/
	
	
	
	/** RETRIEVING OLD RATING VALUES **/
	$query = 'SELECT *' .
			' FROM #__vflow_rating' .
			' WHERE media_id = '.(int) $media_id;
	$db->setQuery($query);
	$rating = $db->loadObject();
	
	if (!$rating)	{
		$prev_rating_count = 0;
		$prev_rating_sum = 0;
	} else {
		$prev_rating_count = $rating->rating_count;
		$prev_rating_sum = $rating->rating_sum;		
	}
	/** /RETRIEVING OLD RATING VALUES **/



	/** TRYING TO SUBMIT JOOMLA RATING **/
	if (!$error && $user_rating >= 1 && $user_rating <= 5) {
		$userIP =  $_SERVER['REMOTE_ADDR'];

		if (!$rating) {
			// There are no ratings yet, so lets insert our rating
			$query = 'INSERT INTO #__vflow_rating ( media_id, lastip, rating_sum, rating_count )' .
					' VALUES ( '.(int) $media_id.', '.$db->Quote($userIP).', '.(int) $user_rating.', 1 )';
			$db->setQuery($query);
			if (!$db->query()) {
				$error = 1;
				$message = $db->stderr();
			} else {
				$rating_count = 1;
				$rating_sum = $user_rating;
      }
		} else {
			// if only registered we disable the latest ip check
			if ($userIP != ($rating->lastip) || $vparams->only_registered) {
				// We weren't the first voter so lets add our vote to the ratings totals
				$query = 'UPDATE #__vflow_rating' .
						' SET rating_count = rating_count + 1, rating_sum = rating_sum + '.(int) $user_rating.', lastip = '.$db->Quote($userIP) .
						' WHERE media_id = '.(int) $media_id;
				$db->setQuery($query);
				if (!$db->query()) {
					$error = 1;
					$message = $db->stderr();
				} else {
					$rating_count = $prev_rating_count + 1;
					$rating_sum = $prev_rating_sum + $user_rating;
				}
			} else {
				$error = 2; // already rated (check with ip address)!
			}
		}
    
    //Update VideoFlow media items table as well
        if (!$error){
        $query = 'UPDATE #__vflow_data' .
		' SET rating = '.(int) $rating_sum.', votes = '. (int) $rating_count.
		' WHERE id = '.(int) $media_id;
		$db->setQuery($query);
		if (!$db->query()) {
		$error = 1;
		$message = $db->stderr();
		}
	}	
  } else if (!$error) // at this point we can have error 4
		$error = 3;
	// ... else $error = $error!
	/** /TRYING TO SUBMIT JOOMLA RATING **/
	
	
	/** CALCULATE ACTUAL AVERAGE AND STAR WIDTH **/
	if (!$error) {
		$average = number_format(intval($rating_sum) / intval( $rating_count ),2);
		$width   = $average * 20;
	} else {
		$average = ($prev_rating_count ? number_format(intval($prev_rating_sum) / intval( $prev_rating_count ),2) : 0 );
		$width   = $average * 20;
	}
	/** /CALCULATE ACTUAL AVERAGE AND STAR WIDTH **/

	/** PRINT OUT RATING RESULTS **/
?>
{
	"success": <?php echo ( $error ? "false" : "true" ); ?>, 
	"return_code": <?php echo $error; ?>,
	"message": "<?php echo addslashes($message); ?>",
	"width": <?php echo ( false ? '""' : '"'.$width.'%"' ); ?>,
	"num_votes": "<?php echo ( $error ? $prev_rating_count : $rating_count ); ?>", 
	"average": "<?php echo ( false ? '""' : $average ); ?>", 
	"out_of": "5"
}
<?php
	/** /PRINT OUT RATING RESULTS **/

} // end of _votitaly_storeVote function


/**
 * FUNCTION _votitaly_checkDatabaseIntegrity
 * - this function will try to create the table that will contain all the registered user rating submissions
 **/

function _votitaly_checkDatabaseIntegrity() {

  $db  = & JFactory::getDBO();	
	$query = 'CREATE TABLE IF NOT EXISTS `#__vflowreg_rating` ( '
		. ' 	`id` int(10) unsigned NOT NULL auto_increment, '
		. ' 	`media_id` int(10) unsigned NOT NULL, '
		. ' 	`user_id` int(10) unsigned NOT NULL, '
		. ' 	`rating` tinyint(3) unsigned NOT NULL, '
		. ' 	`submitted` datetime NOT NULL, '
		. '		PRIMARY KEY  (`id`), '
		. '  	KEY `idx_media_id_user_id` (`media_id`,`user_id`) '
		. ' )';
	$db->setQuery($query);	
	
	return $db->query();

}
}