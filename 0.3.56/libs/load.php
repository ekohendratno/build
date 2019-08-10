<?php 
/**
 * @fileName: load.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;
/**
 * Mengecek magic quote
 *
 * @return bool
 */

function handle_register_globals(){
	if ( ini_get('register_globals') == 1 )
	die("<h1>Error Register Globals</h1><p><i>register_globals</i> is enabled. System requires this configuration directive to be disable. Your site may not secure when <i>register_globals</i> is enabled");
}
/**
 * Memanggil class database
 *
 * @global $db
 */
function require_mysql_db() {
	global $db, $iw;	
	
	if ( !class_exists('config') && file_exists( abs_path . libs  . '/config.php' ) )
		require_once( abs_path . libs  . '/config.php' );

	require_once( abs_path . libs . '/class-mysql.php' );
	if ( file_exists( front_path  . '/class-mysql.php' ) )
		require_once( front_path  . '/class-mysql.php' );
		
	if ( isset( $db ) )
		return;
		
	$iw = new config;
	$db = new mysql( $iw->db_user, $iw->db_password, $iw->db_name, $iw->db_host, $iw->pre );		
}
/**
 * Membuat pembatas autentikasi pengguna
 */
function site_authentication() {
	global $login;
	
	if ( !class_exists('activity_recods') )
		require( abs_path . libs . '/activity.php' );
	
	if ( !class_exists('login') )
		require( abs_path . libs . '/class-login.php' );
		
	$login = new login;
}
/**
 * Membuat pembatas autentikasi pengguna
 */
function site_anonymise_geoip() {
	global $country_geoip,$class_country;
		
	if ( ! class_exists( 'get_country_geoip_list' ) ):
		require( abs_path .  libs . '/geoip/geoip.php' );		
		require( abs_path .  libs . '/class-country.php' );
		
		$country_geoip = get_country_geoip_list();
		$class_country = new country;
		
	endif;
}
/**
 * Membuat statistik situs
 */
function site_anonymise_stats() {
		
	if ( ! class_exists( 'stats' ) )
		require( abs_path .  libs . '/class-stats.php' );
}
/**
 * Medaftarkan plugins dan aplikasi
 */
function loaded_component() {
		
	require( abs_admin_path . '/plugin.php' );
	require( abs_admin_path . '/application.php' );
	
}
/**
 * Medaftarkan array file plugin
 *
 * @return array
 */
function get_mu_plugins( $mu_plugins_root = plugin_path ) {
	$mu_plugins = array();

	// Files in icontent/plugins directory
	$mu_plugins_dir = @opendir( $mu_plugins_root );
	$mu_plugins_files = array();
	if ( $mu_plugins_dir ) {
		while (($file = readdir( $mu_plugins_dir ) ) !== false ) {
			if ( substr($file, 0, 1) == '.' )
				continue;
			if ( is_dir( $mu_plugins_root.$file ) ) {
				
				$plugins_subdir = @opendir( $plugin_root.$file );
				if ( $plugins_subdir ) {
					while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
						if ( substr($subfile, 0, 1) == '.' )
							continue;
						if ( substr($subfile, -4) == '.php' )
							$plugin_files[] = "$file/$subfile";
					}
				}
				
					$mu_plugins_files[] = $file.'/'.$file.'.php';
			} else {
				if ( substr($file, -4) == '.php' )
					$mu_plugins_files[] = $file;
			}
		}
	} else {
		return $mu_plugins;
	}

	@closedir( $mu_plugins_dir );
	@closedir( $mu_plugins_subdir );
	
	return $mu_plugins_files;
}
/**
 * Medaftarkan array file aplikasi
 *
 * @return array
 */
function get_mu_apps() {
	$mu_app = array();
	if ( !is_dir( application_path ) )
		return $mu_app;
	if ( ! $dh = opendir( application_path ) )
		return $mu_app;
	while ( ( $app = readdir( $dh ) ) !== false ) {		
		if ( !is_dir( $app ) && substr( $app, -4 ) != '.php' )
			$mu_app[] = application_path . '/' . $app .'/'. $app .'.php';
	}
	closedir( $dh );
	sort( $mu_app );
	
	return $mu_app;
}

/**
 * Mengaktifkan array file plugin
 *
 * @return array
 */
function get_active_and_valid_plugins() {	
	$json = new JSON();
	/*
	
	$active_plugins = array( 'plugins1.php' => '1', 'plugins2.php' => '0' );
	
	output:
	{"plugins1.php":"1","plugins2.php":"0"}
		
	 */
	$plugins = array();
	$active_plugins = get_option( 'active_plugins');
	$active_plugins = $json->decode( $active_plugins );
	$active_plugins = (array) $active_plugins;
	
	if ( empty( $active_plugins ) || defined( 'installing' ) )
		return $plugins;
	
	$mu_plugins = get_mu_plugins();
	
	foreach ( $active_plugins as $pluginName => $pluginStatus ) {
		if ( file_exists( plugin_path . $pluginName )
			&& ! validate_file( $pluginName )
			&& '.php' == substr( $pluginName, -4 )
			&& in_array( $pluginName, $mu_plugins )
			&& 1 == $pluginStatus 
			)
		$plugins[] = plugin_path . $pluginName;		
	}
	return $plugins;
}
/**
 * Mengaktifkan array file plugin
 *
 * @return array
 */
function get_noactive_and_valid_plugins() {	
	$json = new JSON();
	/*
	
	$active_plugins = array( 'plugins1.php' => '1', 'plugins2.php' => '0' );
	
	output:
	{"plugins1.php":"1","plugins2.php":"0"}
		
	 */
	$plugins = $mu_plugins_active = array();
	$active_plugins = get_option( 'active_plugins');
	$active_plugins = $json->decode( $active_plugins );
	$active_plugins = (array) $active_plugins;
	
	if ( empty( $active_plugins ) || defined( 'installing' ) )
		return $plugins;
	
	$mu_plugins = get_mu_plugins();
	
	foreach ( $active_plugins as $pluginName => $pluginStatus ) {
		if( '.php' == substr( $pluginName, -4 ) && 1 == $pluginStatus )
		$plugins[] = $pluginName;	
	}
	
	foreach( $mu_plugins as $v){
		if( 'index.php' != $v && !in_array($v,$plugins) )
		$mu_plugins_active[] = $v;
	}
	
	return $mu_plugins_active;
}
/**
 * mengecek kebutuhan php dan ekstensi mysql database
 *
 */
function check_php_mysql_versions() {
	global $required_php_version, $version_system;
	
	$php_version = phpversion();
	if ( version_compare( $required_php_version, $php_version, '>' ) )
		die( sprintf( 'PHP server Anda adalah versi %1$s tetapi sistem %2$s ini, membutuhkan lebih dari versi %3$s.', $php_version, $version_system, $required_php_version ) );

	if ( !extension_loaded( 'mysql' ) )
		die( 'Extensi MySQL pada PHP anda bermasalah / tidak ada' );
		
	if ( !function_exists( 'extract' ) )
		die( 'Fungsi extract pada PHP anda bermasalah / tidak ada' );
}
/**
 * menghidupkan register_globals yang mati
 *
 * @return null, jika register_globals PHP di nonaktifkan
 */
function unregister_globals(){
	if( !ini_get( 'register_globals' ))
	return;
	
	$php_version = phpversion();
	
	if ($php_version < '4.1.0') { 
        $_GET = $HTTP_GET_VARS; 
        $_POST = $HTTP_POST_VARS; 
        $_SERVER = $HTTP_SERVER_VARS; 
	} 
	if ($php_version >= '4.0.4pl1' && strstr($_SERVER["HTTP_USER_AGENT"],'compatible')) { 
			if (extension_loaded('zlib')) { 
					ob_end_clean(); 
					ob_start('ob_gzhandler'); 
			} 
	} else if ($php_version > '4.0') { 
			if (strstr($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip')) { 
					if (extension_loaded('zlib')) { 
							$do_gzip_compress = TRUE; 
							ob_start(); 
							ob_implicit_flush(0); 
							//header('Content-Encoding: gzip'); 
					} 
			} 
	} 
	
	//kill register_globals
	if (ini_get('register_globals') == 1){
				
	if (is_array($_REQUEST)) foreach(array_keys($_REQUEST) as $var_to_kill) unset($$var_to_kill);
	if (is_array($_SESSION)) foreach(array_keys($_SESSION) as $var_to_kill) unset($$var_to_kill);
	if (is_array($_SERVER))  foreach(array_keys($_SERVER)  as $var_to_kill) unset($$var_to_kill);
																			unset( $var_to_kill);
	}
	
	if( isset( $_REQUEST['GLOBALS'] ) )
	die( 'GLOBALS overwrite attempt detected' );
	
	//variable yang tidak di unset
	$no_unset = array( 'GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
	
	$input = array_merge( $_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, isset( $_SESSION ) && is_array( $_SESSION ) ? $_SESSION : array() );
	
	foreach ( $input as $k => $v){
		if( !in_array( $k , $no_unset ) && isset( $GLOBALS[$k] ) ){
			$GLOBALS[$k] = null;
			unset( $GLOBALS[$k] );
		}
	}
}
/**
 * menghidupkan register_globals yang mati
 *
 * @return null, jika register_globals PHP di nonaktifkan
 */
function fix_server_vars(){
	global $PHP_SELF;
	
	$default_server_value = array(
		'SERVER_SOFTWARE' 	=> '',
		'REQUEST_URI' 		=> '',
	);
	
	$_SERVER = array_merge( $default_server_value, $_SERVER );
	//fix IIS agar jalan di PHP ISAPI
	if( empty( $_SERVER['REQUEST_URI'] ) || ( php_sapi_name() != 'cgi-fcgi' && preg_match( '/^Microsoft-IIS\//', $_SERVER['SERVER_SOFTWARE'] ) ) ){
		//IIS mode rewrite
		if ( isset( $_SERVER['HTTP_X_ORIGINAL_URL'] ) ) {
			$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
		}
		//IIS isapi rewrite
		else if ( isset( $_SERVER['HTTP_X_REWRITE_URL'] ) ) {
			$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
		} else {
			//gunakan PATH_INFO jika tidak ditemukan PATH_INFO
			if ( !isset( $_SERVER['PATH_INFO'] ) && isset( $_SERVER['ORIG_PATH_INFO'] ) )
				$_SERVER['PATH_INFO'] = $_SERVER['ORIG_PATH_INFO'];
				
			//IIS + PHP konfigurasi PATH_INFO
			if ( isset( $_SERVER['PATH_INFO'] ) ) {
				if ( $_SERVER['PATH_INFO'] == $_SERVER['SCRIPT_NAME'] )
					$_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'];
				else
					$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'] . $_SERVER['PATH_INFO'];
			}
			//query string jika tidak kosong
			if ( ! empty( $_SERVER['QUERY_STRING'] ) ) {
				$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
			}
		}
	}
	
	//fix untuk PHP pada CGI
	if ( isset( $_SERVER['SCRIPT_FILENAME'] ) && ( strpos( $_SERVER['SCRIPT_FILENAME'], 'php.cgi' ) == strlen( $_SERVER['SCRIPT_FILENAME'] ) - 7 ) )
		$_SERVER['SCRIPT_FILENAME'] = $_SERVER['PATH_TRANSLATED'];
		
	//fix untuk Dreamhost dan PHP yang lainnya pada CGI host
	if ( strpos( $_SERVER['SCRIPT_NAME'], 'php.cgi' ) !== false )
		unset( $_SERVER['PATH_INFO'] );
		
	//fix jika PHP_SELF kosong
	$PHP_SELF = $_SERVER['PHP_SELF'];
	if ( empty( $PHP_SELF ) )
		$_SERVER['PHP_SELF'] = $PHP_SELF = preg_replace( '/(\?.*)?$/', '', $_SERVER["REQUEST_URI"] );
}
/**
 * Mematikan web dengan pesan perbaikan
 */
function maintenance() {
	if ( !file_exists( asb_path . '.maintenance' ) || defined( 'installing' ) )
		return;

	global $upgrading;

	include( asb_path . '.maintenance' );
	
	if ( ( time() - $upgrading ) >= 600 )
		return;

	if ( file_exists( content_path . '/maintenance.php' ) ) {
		require_once( content_path . '/maintenance.php' );
		die();
	}

	$protocol = $_SERVER["SERVER_PROTOCOL"];
	if ( 'HTTP/1.1' != $protocol && 'HTTP/1.0' != $protocol )
		$protocol = 'HTTP/1.0';
	header( "$protocol 503 Service Unavailable", true, 503 );
	header( 'Content-Type: text/html; charset=utf-8' );
	header( 'Retry-After: 600' );
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Pemeliharaan</title>
	</head>
	<body>
		<h1>Dalam masa pemeliharaan tidak dalam kurun waktu yang di tetapkan. Periksa kembali dalam satu menit.</h1>
	</body>
	</html>
<?php
	die();
}
/**
 * memulai waktu microtime
 *
 * @global int $timestart
 * @return bool
 */
function timer_start(){
	global $timestart;
		$mtime = explode( ' ', microtime() );
	$timestart = $mtime[1] + $mtime[0];
	return true;
}
/**
 * menampilkan waktu dari awal halaman dipanggil
 *
 * @global int $timestart
 * @global int $timeend
 *
 * @param int $display
 * @param int $precision
 * @return float
 */
function timer_stop( $display = 0, $precision = 3 ){
	global $timestart, $timeend;
	
		$mtime = microtime();
		$mtime = explode( ' ', $mtime );
	  $timeend = $mtime[1] + $mtime[0];
	$timetotal = $timeend - $timestart;
			$r = number_format( $timetotal, $precision );
			
	if ( $display )
		echo $r;
	return $r;
}
/**
 * mengatur kesalahan php dan menagani mode debug
 */
function debug_mode(){
	
	if( debug ){
		if ( defined( 'E_DEPRECATED' ) )
			error_reporting( E_ALL & ~E_DEPRECATED & ~E_STRICT );
		else
			error_reporting( E_ALL );
			
		if ( debug_display )
			ini_set( 'display_errors', 1 );

		if ( debug_log ) {
			ini_set( 'log_errors', 1 );
			ini_set( 'error_log', content_path . 'debug.log' );
		}
	} else {
		if ( defined( 'E_RECOVERABLE_ERROR' ) )
			error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
		else
			error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );
	}
}
/**
 * Jalankan sementara sanitasi konten.
 *
 * @param array $array
 * @return array
 */
function add_magic_quotes( $array ){
	foreach ( (array) $array as $k => $v ) {
		if ( is_array( $v ) ) {
			$array[$k] = add_magic_quotes( $v );
		} else {
			$array[$k] = addslashes( $v );
		}
	}
	return $array;
}
/**
 * Tambahkan tanda kutip ke $ _GET, $ _POST, $ _COOKIE dan $ _SERVER
 *
 */
function magic_quotes(){
	// jika tersedia slashes, strip
	if ( get_magic_quotes_gpc() ) {
		$_GET    = stripslashes_deep( $_GET    );
		$_POST   = stripslashes_deep( $_POST   );
		$_COOKIE = stripslashes_deep( $_COOKIE );
	}

	// lewati $db
	$_GET    = add_magic_quotes( $_GET    );
	$_POST   = add_magic_quotes( $_POST   );
	$_COOKIE = add_magic_quotes( $_COOKIE );
	$_SERVER = add_magic_quotes( $_SERVER );

	// memaksa REQUEST pada GET + POST.
	$_REQUEST = array_merge( $_GET, $_POST );
}

function extractTo(&$array, $type = EXTR_OVERWRITE, $prefix = ''){
		/**
		 *  Is the array really an array?
		 */
		if (!is_array ($array))
		{
			return trigger_error ('extract_nested (): First argument should be an array', E_USER_WARNING);
		}
	
		/**
		 *  If the prefix is set, check if the prefix matches an acceptable regex pattern 
		 * (the one used for variables)
		 */
		if (!empty ($prefix) && !preg_match ('#^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$#', $prefix))
		{
			return trigger_error ('extract_nested (): Third argument should start with a letter or an underscore', E_USER_WARNING);
		}
	
		/**
		 * Check if a prefix is necessary. If so and it is empty return an error.
		 */
		if (($type == EXTR_PREFIX_SAME || $type == EXTR_PREFIX_ALL || $type == EXTR_PREFIX_IF_EXISTS) && empty ($prefix))
		{
			return trigger_error ('extract_nested (): Prefix expected to be specified', E_USER_WARNING);
		}
	
		/**
		 * Make sure the prefix is oke
		 */
		$prefix = $prefix . '_';
	
		/**
		 *  Loop thru the array
		 */
		foreach ($array as $key => $val)
		{
			/**
			 *  If the key isn't an array extract it as we need to do
			 */
			if (!is_array ($array[$key]))
			{
				switch ($type)
				{
					default:
					case EXTR_OVERWRITE:
						$GLOBALS[$key] = $val;
					break;
					case EXTR_SKIP:
						$GLOBALS[$key] = isset ($GLOBALS[$key]) ? $GLOBALS[$key] : $val;
					break;
					case EXTR_PREFIX_SAME:
						if (isset ($GLOBALS[$key]))
						{
							$GLOBALS[$prefix . $key] = $val;
						}
						else
						{
							$GLOBALS[$key] = $val;
						}
					break;
					case EXTR_PREFIX_ALL:
						$GLOBALS[$prefix . $key] = $val;
					break;
					case EXTR_PREFIX_INVALID:
						if (!preg_match ('#^[a-zA-Z_\x7f-\xff]$#', $key{0}))
						{
							$GLOBALS[$prefix . $key] = $val;
						}
						else
						{
							$GLOBALS[$key] = $val;
						}
					break;
					case EXTR_IF_EXISTS:
						if (isset ($GLOBALS[$key]))
						{
							$GLOBALS[$key] = $val;
						}
					break;
					case EXTR_PREFIX_IF_EXISTS:
						if (isset ($GLOBALS[$key]))
						{
							$GLOBALS[$prefix . $key] = $val;
						}
					break;
					case EXTR_REFS:
						$GLOBALS[$key] =& $array[$key];
					break;
				}
				
			}
			
			/**
			 *  The key is an array... use the function on that index
			 */
			else
			{
				extractTo($array[$key], $type, $prefix);
			}
		}
}