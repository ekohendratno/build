<?php
/*
 * @copyright	Copyright (C) 2010 Open Source, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
 
if (!defined("_iEXEC")):
define('_iEXEC', true);

if( !isset( $iLoad ) ){
	session_start();
	
	ob_start();

	$iLoad = true;
	$dir_name_file = dirname(__FILE__);
	
	/** menentukan abs_path berdasarkan direktori file*/
	if (DIRECTORY_SEPARATOR=='/') $absolute_path = $dir_name_file.'/'; 
	else $absolute_path = str_replace('\\', '/',$dir_name_file).'/'; 
	  
	if ( !defined( 'abs_path' ) ) define( 'abs_path',  $absolute_path );
	
	/** menentukan libs berdasarkan direktori libs*/
	define( 'libs', 'libs' );
	
	/** memanggil kebutuhan system dan themes*/
	require_once( abs_path . libs . '/required.php' );
	
}

endif;