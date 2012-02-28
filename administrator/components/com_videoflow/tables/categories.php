<?php

//VideoFlow - Joomla Multimedia System for Facebook//

/**
* @ Version 1.1.4 
* @ Copyright (C) 2008 - 2011 Kirungi Fred Fideri at http://www.fidsoft.com
* @ VideoFlow is free software
* @ Visit http://www.fidsoft.com for support
* @ Kirungi Fred Fideri and Fidsoft accept no responsibility arising from use of this software 
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
**/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );


class TableCategories extends JTable {
	var $id				= null;
	var $name    	= null;
	var $pixlink  = null;
	var $desc     = null;
	var $date     = null;

function __construct( &$_db )
	{
	parent::__construct( '#__vflow_categories', 'id', $_db );
		
	$now =& JFactory::getDate();
		
	$this->set( 'date', $now->toMySQL() );
	}
}