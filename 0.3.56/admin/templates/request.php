<?php 
/**
 * @fileName: request.php
 * @dir: admin/templates/
 */
if(!defined('_iEXEC')) exit;

iw_head_request();

global $login;

/**
 * updateing request dashboard setup
 */
if( is_request( true ) == 'dashboard' ){
	if( $login->cek_login() && $login->login_level('admin') )
		set_dashboard_admin( $_POST["data"] );
}
	

/**
 * cheking file loaded
 */
function include_exist_loaded( $caling_file = '' ){	
	if( file_exists( $caling_file ) )
		return true;
}
/**
 * loaded file on system
 *
 * using:
 * ?request&load=$load.php / libarary
 * ?request&load=$load.php&apps=$apps /applications
 */
function get_loaded_system( $caling_file = '', $get_load, $get_apps ){	

	if( is_load() && is_apps() )
	$caling_file = application_path . $get_apps .'/'.$get_load;	
	elseif( is_load() )
	$caling_file = abs_path . $get_load;	
	
	if( include_exist_loaded( $caling_file ) )	
		include( $caling_file );
}

if( is_load() or ( is_load() && is_apps() ) ):
	get_loaded_system(null, is_load( true ), is_apps( true ) );
endif;