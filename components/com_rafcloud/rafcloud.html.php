<?php
/**
* @version 3.0
* @package Raf Cloud
* @copyright Copyright (C) 2007 Skorp. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Raf Cloud is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @Author: Rafal Blachowski (Skorp) <http://joomla.royy.net>
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

/* next version - unstable
class rafcloud_html {

function display( &$rows, $params, $pageNav, $limitstart, $limit, $total, $totalRows, $searchword ) {
		global $mosConfig_hideCreateDate;
		global $mosConfig_live_site, $option, $Itemid;

		$c 			= count ($rows);
		$image 		= mosAdminMenus::ImageCheck( 'google.png', '/images/M_images/', NULL, NULL, 'Google', 'Google', 1 );
		$searchword = urldecode( $searchword );
		
				// number of matches found
				echo '<br/>';
				eval ('echo "'._CONCLUSION.'";');

				?>
				<a href="http://www.google.com/search?q=<?php echo $searchword; ?>" target="_blank">
					<?php echo $image; ?></a>
			</td>
		</tr>
		</table>
		
		<br />
		
		<div align="center">
			<?php
			echo $pageNav->writePagesCounter();

			$ordering 		= strtolower( strval( mosGetParam( $_REQUEST, 'ordering', 'newest' ) ) );
			$searchphrase 	= strtolower( strval( mosGetParam( $_REQUEST, 'searchphrase', 'any' ) ) );
			
			$searchphrase	= htmlspecialchars($searchphrase);

			$link = $mosConfig_live_site ."/index.php?option=$option&amp;Itemid=$Itemid&amp;searchword=$searchword&amp;searchphrase=$searchphrase&amp;ordering=$ordering";
			echo $pageNav->getLimitBox( $link );
			?>
		</div>
		<table class="contentpaneopen<?php echo $params->get( 'pageclass_sfx' ); ?>">
		<tr class="<?php echo $params->get( 'pageclass_sfx' ); ?>">
			<td>
				<?php
				$z		= $limitstart + 1;
				$end 	= $limit + $z;
				if ( $end > $total ) {
					$end = $total + 1;
				}
				for( $i=$z; $i < $end; $i++ ) {
					$row = $rows[$i-1];
					if ($row->created) {
						$created = mosFormatDate ($row->created, _DATE_FORMAT_LC);
					} else {
						$created = '';
					}
					?>
					<fieldset>
						<div>
							<span class="small<?php echo $params->get( 'pageclass_sfx' ); ?>">
								<?php echo $i.'. ';?>
							</span>
							<?php
							if ( $row->href ) {
								$row->href = ampReplace( $row->href );
								if ($row->browsernav == 1 ) {
									?>
									<a href="<?php echo sefRelToAbs($row->href); ?>" target="_blank">
									<?php
								} else {
									?>
									<a href="<?php echo sefRelToAbs($row->href); ?>">
									<?php
								}
							}

							echo $row->title;

							if ( $row->href ) {
								?>
								</a>
								<?php
							}
							if ( $row->section ) {
								?>
								<br/>
								<span class="small<?php echo $params->get( 'pageclass_sfx' ); ?>">
									(<?php echo $row->section; ?>)
								</span>
								<?php
							}
							?>
						</div>

						<div>
							<?php echo ampReplace( $row->text );?>
						</div>

						<?php
						if ( !$mosConfig_hideCreateDate ) {
							?>
							<div class="small<?php echo $params->get( 'pageclass_sfx' ); ?>">
								<?php echo $created; ?>
							</div>
							<?php
						}
						?>
					</fieldset>
					<br/>
					<?php
				}
				?>
			</td>
		</tr>	
		<?php
	}

}
*/

?>