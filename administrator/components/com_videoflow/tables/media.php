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


class TableMedia extends JTable

{

	var $id 	= null;

	var $cat	= null;

	var $title	= null;

	var $details	= null;

	var $file 	= null;

	var $medialink  = null; 

	var $type	= null;

	var $pixlink	= null;

	var $server	= null; 

	var $views      = null;

	var $dateadded  = null;

	var $published  = null;

	var $download   = null;

	var $recommended = null;

	var $tags        = null;

	var $lastclick   = null;

	var $favoured    = null;
	
	var $rating      = null; 
	
	var $votes       = null; 
	
	var $downloads   = null;

	var $userid      = null; 

	function __construct( &$_db )
	{
	parent::__construct( '#__vflow_data', 'id', $_db );
		
	$now =& JFactory::getDate();
		
	$this->set( 'dateadded', $now->toMySQL() );
	}

}