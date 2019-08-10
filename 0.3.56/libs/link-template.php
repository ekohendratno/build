<?php 
/**
 * @fileName: link-template.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;
/**
 * Mengambil url untuk situs tertentu
 *
 * @param string $path
 * @param string $scheme
 * @return string
*/
function get_site_url( $path = '', $scheme = null ) {
	$orig_scheme = $scheme;
	if ( !in_array( $scheme, array( 'http', 'https' ) ) ) {
		if ( ( 'account' == $scheme ) && force_ssl_admin() )
			$scheme = 'https';
		elseif ( ( 'admin' == $scheme ) && force_ssl_admin() )
			$scheme = 'https';
		else
			$scheme = ( is_ssl() ? 'https' : 'http' );
	}

	$url = get_option( 'siteurl' );

	if ( 'http' != $scheme )
		$url = str_replace( 'http://', "{$scheme}://", $url );

	if ( !empty( $path ) && is_string( $path ) && strpos( $path, '..' ) === false )
		$url .= '/' . ltrim( $path, '/' );

	return apply_filters( 'site_url', $url, $path, $orig_scheme );
}
/**
 * Retrieve the home url for a given site.
 *
 * @param  string $path
 * @param  string $scheme
 * @return string
*/
function get_home_url( $path = '', $scheme = null ) {
	$orig_scheme = $scheme;

	if ( !in_array( $scheme, array( 'http', 'https' ) ) )
		$scheme = is_ssl() && !is_admin() ? 'https' : 'http';

	$url = get_option( 'home' );

	if ( 'http' != $scheme )
		$url = str_replace( 'http://', "$scheme://", $url );

	if ( !empty( $path ) && is_string( $path ) && strpos( $path, '..' ) === false )
		$url .= '/' . ltrim( $path, '/' );

	return apply_filters( 'home_url', $url, $path, $orig_scheme );
}
/**
 * Retrieve the url to the admin area for a given site.
 *
 * @param string $path
 * @param string $scheme
 * @return string
*/
function get_admin_url( $path = '', $scheme = 'admin' ) {
	$url = get_site_url('/', $scheme);

	if ( !empty($path) && is_string($path) && strpos($path, '..') === false )
		$url .= ltrim($path, '/');

	return apply_filters('admin_url', $url, $path);
}
/**
 * Mengambil url untuk situs saat ini
 *
 * @param string $path
 * @param string $scheme
 * @return string
*/
function site_url( $path = '', $scheme = null ) {
	return get_site_url($path, $scheme);
}
/**
 * Retrieve the home url for the current site.
 *
 * @param  string $path
 * @param  string $scheme
 * @return string
*/
function home_url( $path = '', $scheme = null ) {
	return get_home_url($path, $scheme);
}
/**
 * Retrieve the url to the admin area for the current site.
 *
 * @param string $path
 * @param string $scheme
 * @return string
*/
function admin_url( $path = '', $scheme = 'admin' ) {
	return get_admin_url($path, $scheme);
}
/**
 * Retrieve the url to the includes directory.
 *
 * @param string $path
 * @return string
*/
function includes_url($path = '') {
	$url = site_url() . '/' . libs . '/';

	if ( !empty($path) && is_string($path) && strpos($path, '..') === false )
		$url .= ltrim($path, '/');

	return apply_filters('includes_url', $url, $path);
}
/**
 * Mengambil url untuk direktori kontent
 *
 * @param string $path
 * @return string
*/
function content_url($path = '') {
	$url = content_url;
	if ( 0 === strpos($url, 'http') && is_ssl() )
		$url = str_replace( 'http://', 'https://', $url );

	if ( !empty($path) && is_string($path) && strpos($path, '..') === false )
		$url .= '/' . ltrim($path, '/');

	return apply_filters('content_url', $url, $path);
}
/**
 * Mengambil url untuk direktori plugin
 *
 * @param string $path
 * @param string $plugin
 * @return string
*/
function plugins_url($path = '', $plugin = '') {
	$url = plugin_url;

	if ( 0 === strpos($url, 'http') && is_ssl() )
		$url = str_replace( 'http://', 'https://', $url );

	if ( !empty($plugin) && is_string($plugin) ) {
		$folder = dirname(plugin_basename($plugin));
		if ( '.' != $folder )
			$url .= '/' . ltrim($folder, '/');
	}

	if ( !empty($path) && is_string($path) && strpos($path, '..') === false )
		$url .= '/' . ltrim($path, '/');

	return apply_filters('plugins_url', $url, $path, $plugin);
}