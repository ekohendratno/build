<?php 
/**
 * @fileName: theme.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;

/**
 * Retrieve current theme directory.
 *
 * @return string
 */
function get_template_directory() {
	$template = get_template();
	$theme_root = get_theme_root( $template );
	$template_dir = "$theme_root/$template";

	return apply_filters( 'template_directory', $template_dir, $template, $theme_root );
}
/**
 * Retrieve name of the current theme.
 *
 * @return string
 */
function get_template() {	
	global $login;
	
	$get_template = get_option('template');

	return apply_filters('template', $get_template);
	
}
/**
 * Retrieve path to themes directory.
 *
 * @param string $stylesheet_or_template
 * @return string
 */
function get_theme_root( $stylesheet_or_template = false ) {
	
	if ( $stylesheet_or_template )
		$theme_root = content_path . '/themes';	
		
	return apply_filters( 'theme_root', $theme_root );
}

//========================================================================

/**
 * Retrieve stylesheet directory path for current theme.
 *
 * @return string
 */
function get_stylesheet_directory() {
	$stylesheet = get_stylesheet();
	$theme_root = get_theme_root( $stylesheet );
	$stylesheet_dir = "$theme_root/$stylesheet";

	return apply_filters( 'stylesheet_directory', $stylesheet_dir, $stylesheet, $theme_root );
}
/**
 * Retrieve name of the current stylesheet.
 *
 * @return string
 */
function get_stylesheet() {
	
	$get_stylesheet = get_option('stylesheet');
	
	return apply_filters('stylesheet', $get_stylesheet);
}

//========================================================================
/**
 * Retrieve path of login template in current or parent template.
 *
 * @return string
 */
function get_login_template() {
	return get_query_template( 'login' );
}
/**
 * Retrieve path of admin template in current or parent template.
 *
 * @return string
 */
function get_admin_template() {
	return get_query_template( 'admin' );
}
/**
 * Retrieve path of request template in current or parent template.
 *
 * @return string
 */
function get_request_template() {
	return get_query_template( 'request' );
}
/**
 * Retrieve path of index template in current or parent template.
 *
 * @return string
 */
function get_index_template() {	
	return get_query_template( 'index' );
}
/**
 * Retrieve path to a template
 *
 * @param string $type
 * @param array $templates
 * @return string
 */
function get_query_template( $type, $templates = array() ) {
	$type = preg_replace( '|[^a-z0-9-]+|', '', $type );

	if ( empty( $templates ) )
		$templates = array("{$type}.php");

	return locate_template( $templates );
}
/**
 * Retrieve the name of the highest priority template file that exists.
 *
 * @param string|array $template_names
 * @param bool $load
 * @param bool $require_once
 * @return string
 */
function locate_template($template_names, $load = false, $require_once = true ) {	
	$located = '';
	
	if( is_admin() || is_login() ) $template_path = admin_tpl;
	elseif(  is_request() ) $template_path = admin_tpl;
	else $template_path = template_path;
	
	$template_path_detault = theme_path . '/' . default_theme;
	
	foreach ( (array) $template_names as $template_name ) {
		
		if ( !$template_name )
			continue;
		if ( file_exists($template_path . '/' . $template_name)) {
			$located = $template_path . '/' . $template_name;
			break;
		} else if ( file_exists( $template_path_detault .'/'. $template_name) ) {
			$located = $template_path_detault.'/'. $template_name;
			break;
		}
	}

	if ( $load && '' != $located )
		load_template( $located, $require_once );

	return $located;
}
/**
 * Require the template file with environment.
 *
 * @param string $_template_file
 * @param bool $require_once
 */
function load_template( $_template_file, $require_once = true ) {
	global $login, $db, $version_system;

	if ( $require_once )
		require_once( $_template_file );
	else
		require( $_template_file );
}

/* -------------------------------
 * ----- Admin Theme Manager -----
 * ------------------------------- */
 
/**
 * Mengcek aplikasi yang dimasukkan
 *
 * @param $option string
 * @param $included true|false
 * @return include file | name file
 */
function get_apps_cheked($option_first, $manager = false, $file = 'manage'){
	
	if( $manager ) $option_second = $file;
	else $option_second = $option_first;
	
	$file_included = $option_first .'/'. $option_second .'.php';
	$file_included = application_path . $file_included;
	
	if( file_exists( $file_included ) )
	return true;
}
/**
 * Memanggil aplikasi yang dimasukkan
 *
 * @param $option string
 * @param $included true|false
 * @return include file | name file
 */
function get_apps_included($option_first, $manager = false, $file = 'manage'){
	
	if( $manager ) $option_second = $file;
	else $option_second = $option_first;
	
	$file_included = $option_first .'/'. $option_second .'.php';
	$file_included = application_path . $file_included;
	
	include_once( $file_included );
	return;
}
/**
 * Mengcek system yang dimasukkan
 *
 * @param $option string
 * @param $included true|false
 * @return include file | name file
 */
function get_sys_cheked($option, $file = 'manage'){
	
	$file_included = $option .'/'.$file.'.php';
	$file_included = manage_path . $file_included;
	
	if( file_exists( $file_included ) )
	return true;
}
/**
 * Memanggil system yang dimasukkan
 *
 * @param $option string
 * @param $included true|false
 * @return include file | name file
 */
function get_sys_included($option, $file = 'manage'){
	
	$file_included = $option .'/'.$file.'.php';
	$file_included = manage_path . $file_included;
	
	include_once( $file_included );
	return;
}
/**
 * Menampilkan konten utama
 *
 * @return file
 */
function the_main_content(){	
	global $iw_title, $iw_desc, $iw_key, $iw_loader;
	
	echo $iw_loader;
}
/**
 * Memanggil system yang dimasukkan
 *
 * @param $option string
 * @param $included true|false
 * @return include file | name file
 */
function get_home_included(){
	
	$file_included = '/home.php';
	$file_included = admin_tpl . $file_included;
	
	include_once( $file_included );
	return;
}
/**
 * Menampilkan konten manager
 *
 * @return file
 */
function the_main_manager(){
	
	if( is_sys() && get_sys_cheked( get_query_var('sys') ) )
		get_sys_included( get_query_var('sys') );
		
	elseif( is_apps() && get_apps_cheked( get_query_var('apps'), true ) )
		get_apps_included( get_query_var('apps'), true );
		
	else get_home_included();
	
}
/**
 * Menampilkan init manager
 *
 * @return file
 */
function the_init_manager(){
	
	if( is_sys() && get_sys_cheked( get_query_var('sys'), 'init' ) )
		get_sys_included( get_query_var('sys'), 'init' );
		
	elseif( is_apps() && get_apps_cheked( get_query_var('apps'), true, 'init' ) )
		get_apps_included( get_query_var('apps'), true, 'init' );
}
add_action( 'iw_head_admin', 'the_init_manager' );

function the_main_oops(){
	if ( file_exists( content_path . '/oops.php' ) ) {
		require_once( content_path . '/oops.php' );
		die();
	}
	?>
    <div id="oops_body" class="drop-shadow lifted">
    <div class="oops_logo">Ups maaf!</div>
    <div class="oops_content">
    <div style="clear:both"></div>
    <div class="oops_logo_atentions">!</div>
    <p style="margin-left:60px;">
    <strong>Halaman tidak ditemukan!</strong><br />
    Ups halaman yang Anda cari telah dipindahkan atau tidak ada lagi..<br />
    Silakan coba halaman lain tetapi jika Anda tidak dapat menemukan apa yang Anda butuhkan, beritahu kami.<br /><br />
    <a href="?admin" class="button">&laquo;&laquo; Kembali ke halaman utama</a><br /><br />
    </p>
    <div style="clear:both"></div>
    </div>
    </div>
    <?php
}
/**
 * Retrieve URI of current theme stylesheet.
 *
 * @return string
 */
function get_stylesheet_uri() {
	$stylesheet_dir_uri = get_stylesheet_directory_uri();
	$stylesheet_uri = $stylesheet_dir_uri . '/style.css';
	return apply_filters('stylesheet_uri', $stylesheet_uri, $stylesheet_dir_uri);
}
/**
 * Retrieve stylesheet directory URI.
 *
 * @return string
 */
function get_stylesheet_directory_uri( $display = false ) {
	$stylesheet = get_stylesheet();
	$theme_root_uri = get_theme_root_uri( $stylesheet );
	$stylesheet_dir_uri = "$theme_root_uri/$stylesheet";

	$retval = apply_filters( 'stylesheet_directory_uri', $stylesheet_dir_uri, $stylesheet, $theme_root_uri );
	
	if ( $display )
		echo $retval;
	else
		return $retval;
}
/**
 * Retrieve URI for themes directory.
 *
 * @param string $stylesheet_or_template
 * @return string
 */
function get_theme_root_uri( $stylesheet_or_template = false ) {
	if ( $stylesheet_or_template ) {
		if ( $theme_root = get_raw_theme_root($stylesheet_or_template) )
			$theme_root_uri = content_url( $theme_root );
		else
			$theme_root_uri = content_url( 'themes' );
	} else {
		$theme_root_uri = content_url( 'themes' );
	}

	return apply_filters( 'theme_root_uri', $theme_root_uri, get_option('siteurl'), $stylesheet_or_template );
}
/**
 * Get the raw theme root relative to the content directory with no filters applied.
 *
 * @param string $stylesheet_or_template
 * @return string
 */
function get_raw_theme_root( $stylesheet_or_template, $no_cache = false ) {
	global $wp_theme_directories;

	if ( count($wp_theme_directories) <= 1 )
		return '/themes';

	$theme_root = false;

	// If requesting the root for the current theme, consult options to avoid calling get_theme_roots()
	if ( !$no_cache ) {
		if ( get_option('stylesheet') == $stylesheet_or_template )
			$theme_root = get_option('stylesheet_root');
		elseif ( get_option('template') == $stylesheet_or_template )
			$theme_root = get_option('template_root');
	}

	if ( empty($theme_root) ) {
		$theme_roots = get_theme_roots();
		if ( !empty($theme_roots[$stylesheet_or_template]) )
			$theme_root = $theme_roots[$stylesheet_or_template];
	}

	return $theme_root;
}
/**
 * Retrieve theme roots.
 *
 * @return array|string
 */
function get_theme_roots( $stylesheet_or_template = false ) {
	
	if ( $stylesheet_or_template )
		$theme_root = content_url . '/themes';	
		
	return apply_filters( 'theme_root', $theme_root );
}