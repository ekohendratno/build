<?php 
/**
 * @fileName: load.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;

initial_constants();

directory_constants();

@ini_set( 'magic_quotes_runtime', 0 );
@ini_set( 'magic_quotes_sybase', 0 );

handle_register_globals();

if( function_exists( 'date_default_timezone_set' ) )
	date_default_timezone_set( 'UTC' );
	
//unregister_globals();

//fix_server_vars();

maintenance();

timer_start();

debug_mode();

require_mysql_db();	

site_anonymise_geoip();

site_anonymise_stats();

site_authentication();	

//globalisasi
global $db, $iw, $login, $country_geoip, $class_country, $version_system, $version_project, $required_php_version, $required_mysql_version;

$GLOBALS['registered_sidebars'] = array();
$GLOBALS['registered_widgets'] = array();
$GLOBALS['registered_widget_controls'] = array();
$GLOBALS['sidebars_widgets'] = array();
$GLOBALS['_sidebars_widgets'] = array();
$GLOBALS['_deprecated_widgets_callbacks'] = array();

require( libs_path . '/vars.php' );
require( libs_path . '/class-error.php' );	
require( libs_path . '/class-json.php' );
require( libs_path . '/class-rss-reader.php' );	
require( libs_path . '/class-paging.php' );	
require( libs_path . '/class-menu.php' );	
require( libs_path . '/functions.php' );	
require( libs_path . '/timezone.php' );
require( libs_path . '/dashboard.php' );

require( libs_path . '/plugin.php' );
require( libs_path . '/default-filters.php' );
require( libs_path . '/formatting.php' );
require( libs_path . '/query.php' );

require( libs_path . '/theme.php' );
require( libs_path . '/general-template.php' );
require( libs_path . '/link-template.php' );
//require( libs_path . '/sidebar.php' );
require( libs_path . '/rewrite.php' );
require( libs_path . '/captcha/captcha.php' );
require( libs_path . '/functions-compatible.php' );

if( is_admin() )
require( libs_path . '/screen.php' );

site_timezone();

plugin_directory_constants();
//cookie_constants();


require( libs_path . '/class-widgets.php' );
require( libs_path . '/default-widgets.php' );	

foreach ( get_active_and_valid_plugins() as $mu_plugin ) {
	include_once( $mu_plugin );
}
unset( $mu_plugin );

do_action( 'plugins_loaded' );

magic_quotes();

templating_constants();

if ( ! defined( 'installing' ) ) {		
	if ( file_exists( template_path . '/functions.php' ) )
		include( template_path . '/functions.php' );
	if ( file_exists( abs_admin_path . '/functions.php' ) )
		include( abs_admin_path . '/functions.php' );
	if ( file_exists( admin_tpl . '/functions.php' ) )
		include( admin_tpl . '/functions.php' );	
}

do_action( 'init' );

