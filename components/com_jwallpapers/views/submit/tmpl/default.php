<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: default.php 217 2010-03-12 15:18:42Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted Access' );

JHTML::_ ( 'behavior.mootools' );
?>
<div class="componentheading<?php echo $this->class_suffix; ?>"><?php
echo JTEXT::_ ( 'SUBMIT_PICTURE' );
?></div>
<?php
echo $this->loadTemplate ( 'picture_form' );
?>
