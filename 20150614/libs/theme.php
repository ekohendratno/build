<?php 
/**
 * @fileName: theme.php
 * @dir: libs/
 */
if(!defined('_iEXEC')) exit;


/**
 * Retrieve path of admin template in current or parent template.
 *
 * @return string
 */
function get_template_load( $parameter = 'index' ) {
	return get_query_template( $parameter );
}
/**
 * Retrieve path to a template
 *
 * @param string $type
 * @param array $templates
 * @return string
 */
function get_query_template( $file_template, $templates = array() ) {
	$file_template = preg_replace( '|[^a-z0-9-]+|', '', $file_template );

	if ( empty( $templates ) )
		$templates = array("{$file_template}.php");

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
	
	if( is_admin() || is_login() ) $template_path = admin_path;
	elseif(  is_request() ) $template_path = admin_path;
	else $template_path = template_path;
	
	$template_path_detault = theme_path .'/'. default_theme;
	
	foreach ( (array) $template_names as $template_name ) {
		
		if ( !$template_name )
			continue;
		if ( file_exists($template_path . '/' . $template_name)) {
			$located = $template_path . '/' . $template_name;
			break;
		} else if ( file_exists( $template_path_detault . $template_name) ) {
			$located = $template_path_detault . $template_name;
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
	if( isset($_SESSION['theme']) 
	&& !empty($_SESSION['theme'])
	 )
		$get_template = (string) $_SESSION['theme'];
	else	
		$get_template = get_option('template');
		
	//if(!file_exists(get_template_directory().'/index.php') )
		//$get_template = default_theme;
		
	return apply_filters('template', $get_template);
	
}
/**
 * Retrieve path to themes directory.
 *
 * @param string $stylesheet_or_template
 * @return string
 */
function get_theme_root( $template_name = false ) {
	
	if ( $template_name )
		$theme_root = content_path . '/themes';	
		
	return apply_filters( 'theme_root', $theme_root );
}
/**
 * Retrieve template directory URI.
 *
 * @return string
 */
function get_template_directory_uri( $display = false ) {
	$template = get_template();
	$theme_root_uri = get_theme_root_uri( $template );
	$template_dir_uri = "$theme_root_uri/$template";

	$retval = apply_filters( 'template_directory_uri', $template_dir_uri, $template, $theme_root_uri );
	
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
function get_theme_root_uri( $template_name ) {
	
	if ( $template_name )
	$theme_root_uri = content_url( '/themes' );

	return apply_filters( 'theme_root_uri', $theme_root_uri );
}
/**
 * Menampilkan konten utama
 *
 * @return file
 */
function the_content( $dispaly = true ){		
	global $the_title, $the_desc, $the_key, $the_content;
	
	do_action('the_title');
	do_action('the_desc');
	do_action('the_key');
	do_action('the_content');
	
	if( $dispaly )
		echo $the_content;
	else
		return $the_content;
}

function the_contents(){
	
	$path = theme_path .'/'. get_option('template');
	//load page search
	if( $p = get_query_var('s') ){
		$file = $path .'/page-search.php';
		if( file_exists( $file ) ){
			require_once( $file );
			return true;
		}
	}elseif( $p = get_query_var('p') ){
		
		$file =  $path ."/page";
		if( $p == 'page' && file_exists( "$file.php" ) ){
			require_once( "$file.php" );
			return true;
		}
		if( $p != 'page' && file_exists( "$file-$p.php" ) ){
			include "$file-$p.php";
			return true;
		}
		else
		{
			//load view error
			include "$path/404.php";
			return true;
		}
	}
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
	$file_included = manage_path .'/'. $file_included;
	
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
	$file_included = manage_path .'/'. $file_included;
	
	if( file_exists( $file_included ) )
	include_once( $file_included );
	return;
}

/**
 * Menampilkan konten manager
 *
 * @return file
 */
function the_main_manager($li,$il){
	
	do_action('the_main_manager');
	
	if( get_sys_cheked( get_query_var('s') ) 
	&& $values = is_sys_values() )
	{
		get_sys_included( $values, 'functions' );
		get_sys_included( $values );
	}
	else 
	{
		if(get_sys_cheked( get_query_var('s') ) == false 
		&& get_query_var('s') )
		{
			header("location:?admin=404");
			exit;
		}else{
			if( is_admin_values() == '404' ){
				if( file_exists(admin_path . "/404.php") )
				include admin_path . "/404.php";
			}else{
				set_current_screen();
				add_screen_option('layout_columns', array('max' => 4, 'default' => 2) );
				
				dashboard_init();
				dashboard_setup();
				print("$li");
				
				dashboard();
				
				print("$il");
			}
			return;
		}
	}
	
}
?>