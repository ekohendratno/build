<?php 
/**
 * @fileName: general-template.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;

function iw_favicon(){
	global $iw;
	echo "<link rel=\"icon\" href=\"$iw->base_url/favicon.ico\" type=\"image/x-icon\">\n";
	echo "<link rel=\"shortcut icon\" href=\"$iw->base_url/favicon.ico\" type=\"image/x-icon\">\n";
}
/**
 * Fire the iw_head action
 *
 * @calls 'iw_head'
 */
function iw_head() {
	do_action('iw_head');
}
/**
 * Fire the iw_head admin action
 *
 * @calls 'iw_head'
 */
function iw_head_login() {
	do_action('iw_head_login');
}
/**
 * Fire the iw_head admin action
 *
 * @calls 'iw_head'
 */
function iw_head_admin() {
	do_action('iw_head_admin');
}
/**
 * Fire the iw_head admin action
 *
 * @calls 'iw_footer'
 */
function iw_footer_admin() {
	do_action('iw_footer_admin');
}
/**
 * Fire the iw_head request action
 *
 * @calls 'iw_head'
 */
function iw_head_request() {
	do_action('iw_head_request');
}
/**
 * Display a noindex meta tag.
 */
function no_robots() {
	echo "<meta name='robots' content='noindex,nofollow' />\n";
}
/**
 * Display a noindex meta tag if required by the blog configuration.
 */
function noindex() {
	if ( '0' == get_option('site_public') )
		no_robots();
}
/**
 * Renders an editor.
 *
 * @param string $content
 * @param string $editor_id
 * @param array $settings
 */
function iw_editor( $content, $editor_id, $settings = array() ) {
		
	if ( ! class_exists( 'wysywigEditor' ) )
		require( abs_path .  libs . '/class-editor.php' );
	
	wysywigEditor::editor_settings($editor_id,$settings);
	wysywigEditor::editor($content, $editor_id, $settings);
}

/**
 * Display or retrieve page title for all areas of blog.
 *
 * @param string $sep
 * @param bool $display
 * @param string $seplocation
 * @return string|null
 */
function iw_title($display = true) {
	$title = esc_sql( $GLOBALS['iw_title'] );
	
	if( empty($title) ) 
		$title = get_info( 'name' );
	
	$title = apply_filters( 'the_title', $title );
	
	if ( $display )
		echo $title;
	else
		return $title;
}
/**
 * Menampilkan judul manager
 *
 * @return file
 */
function the_title_manager(){
	
	$title = 'Administrator &bull; ';
	
	if( is_sys() )
		$title.= uc_first( get_query_var('sys') );
		
	elseif( is_apps() )
		$title.= uc_first( get_query_var('apps') );
		
	else $title = 'Dashboard';
	
	return $title;
	
}
/**
 * Display or retrieve page title admin for all areas.
 *
 * @param string $sep
 * @param bool $display
 * @param string $seplocation
 * @return string|null
 */
function the_admin_title($display = true) {
	
	$title = the_title_manager();	
	$title = apply_filters( 'the_title', $title );
	
	if ( $display )
		echo $title;
	else
		return $title;
}

function set_meta( $title, $desc, $key ){
	global $iw_title, $iw_desc, $iw_key;
				
	$iw_title	= $title;
	$iw_desc 	= limittxt(htmlentities(strip_tags($desc)),320);
	$iw_key		= empty($key) ? implode(',',explode(' ',htmlentities(strip_tags($title)))) : $key;
}
/**
 * Retrieve information about the blog.
 *
 * @param string $show
 * @param string $filter
 * @return string
 */
function get_info( $show = '', $display = false, $filter = 'display' ) {

	switch( $show ) {
		case 'home' :
		case 'siteurl' :
		case 'url' :
			$output = home_url();
			break;
		case 'description':
			$output = esc_sql( $GLOBALS['iw_desc'] );
			
			if( empty($output) )
			$output = get_option('sitedescription');
			
			break;
		case 'keywords':
			$output = esc_sql( $GLOBALS['iw_key'] );
			
			if( empty($output) )
			$output = get_option('sitekeywords');
			
			break;
		case 'rss_url':
			$output = get_feed_link('rss');
			break;
		case 'pingback_url':
			$output = get_option('siteurl') .'/?pingback';
			break;
		case 'stylesheet_url':
			$output = get_stylesheet_uri();
			break;
		case 'template_directory':
		case 'template_url':
			$output = get_template_directory_uri();
			break;
		case 'admin_email':
			$output = get_option('admin_email');
			break;
		case 'charset':
			$output = get_option('site_charset');
			if ('' == $output) $output = 'UTF-8';
			break;
		case 'html_type' :
			$output = get_option('html_type');
			break;
		case 'version':
			global $iw_version;
			$output = $iw_version;
			break;
		case 'language':
			$output = get_locale();
			$output = str_replace('_', '-', $output);
			break;
		case 'text_direction':
			if ( function_exists( 'is_rtl' ) ) {
				$output = is_rtl() ? 'rtl' : 'ltr';
			} else {
				$output = 'ltr';
			}
			break;
		case 'name':
		default:
			$output = get_option('sitename');
			break;
	}

	$url = true;
	if (strpos($show, 'url') === false &&
		strpos($show, 'directory') === false &&
		strpos($show, 'home') === false)
		$url = false;

	if ( 'display' == $filter ) {
		if ( $url )
			$output = apply_filters('siteinfo_url', $output, $show);
		else
			$output = apply_filters('siteinfo', $output, $show);
	}

	if ( $display )
		echo $output;
	else
		return $output;
}
/**
 * Display the language attributes for the html tag.
 *
 * @param string $doctype
 */
function language_attributes($doctype = 'html') {
	$attributes = array();
	$output = '';

	if ( function_exists( 'is_rtl' ) )
		$attributes[] = 'dir="' . ( is_rtl() ? 'rtl' : 'ltr' ) . '"';

	if ( $lang = get_info('language') ) {
		if ( get_option('html_type') == 'text/html' || $doctype == 'html' )
			$attributes[] = "lang=\"$lang\"";

		if ( get_option('html_type') != 'text/html' || $doctype == 'xhtml' )
			$attributes[] = "xml:lang=\"$lang\"";
	}

	$output = implode(' ', $attributes);
	$output = apply_filters('language_attributes', $output);
	echo $output;
}
/**
 * Checks if current locale is RTL.
 *
 * @since 3.0.0
 * @return bool Whether locale is RTL.
 */
function is_rtl() {
	$text_direction = 'ltr';
	return 'rtl' == $text_direction;
}
/**
 * Load file template.
 *
 * @param string $name
 */
function get_front( $name = null ) {
	do_action( 'get_front', $name );

	$templates = array();
	if ( isset($name) )
		$templates[] = "frontpage-{$name}.php";

	$templates[] = 'frontpage.php';

	// Backward compat code will be removed in a future release
	if ('' == locate_template($templates, true))
		load_template( abs_path . libs . '/theme-compat/frontpage.php');
}
/**
 * Load file template.
 *
 * @param string $name
 */
function get_page( $name = null ) {
	do_action( 'get_page', $name );

	$templates = array();
	if ( isset($name) )
		$templates[] = "page-{$name}.php";

	$templates[] = 'page.php';

	// Backward compat code will be removed in a future release
	if ('' == locate_template($templates, true))
		load_template( abs_path . libs . '/theme-compat/page.php');
}
/**
 * Load file template.
 *
 * @param string $name
 */
function get_page_error() {

	$templates = array();
	if ( isset($name) )
		$templates[] = "404-{$name}.php";

	$templates[] = '404.php';

	// Backward compat code will be removed in a future release
	if ('' == locate_template($templates, true))
		load_template( abs_path . libs . '/theme-compat/404.php');
}