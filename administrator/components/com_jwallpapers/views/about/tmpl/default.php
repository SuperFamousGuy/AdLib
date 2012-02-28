<?php
/**
 * JWallpapers - A lightweight yet powerful image gallery component with community building capabilities
 * 
 * @version 2.0.1 $Id: default.php 318 2010-05-21 13:12:47Z amazeika $
 * @package JWallpapers
 * @copyright Copyright (C) 2009 Arunas Mazeika, http://www.wextend.com. All rights reserved
 * @author Arunas Mazeika
 * @license GNU General Public License v2+ (GNU GPL v2+). See license.php
 * 
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );
JToolBarHelper::title ( JText::_ ( 'ABOUT' ), 'jwallpapers_about' );
?>
<center>
<div class="about_jw"><img
	src="components/<?php
	echo $option;
	?>/images/logo/jwallpapers.png"
	alt="JWallpapers logo" title="JWallpapers">
<h1>JWallpapers 2.0</h1>
<h2>A lightweight yet powerful image gallery component with community
building capabilities</h2>
<h3>Released under the GNU General Public License v2+ (GNU GPL v2+)</h3>

<h2>Copyright &copy; 2009 Arunas Mazeika - All rights reserved</h2>

Developed and maintained by Arunas Mazeika<br />

For more information and support, please visit the official JWallpapers
website at:<br />
<a href="http://www.wextend.com">www.wextend.com</a></div>
</center>
