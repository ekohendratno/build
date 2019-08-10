<?php 
/**
 * @fileName: query.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;
/**
 * Is the query for the robots file?
 *
 * @return bool
 */
function is_robots() {
	return false;
}
/**
 * Is the query a 404 (returns no results)?
 *
 * @return bool
 */
function is_home() {
	return false;
}
/**
 * Is the query a 404 (returns no results)?
 *
 * @return bool
 */
function is_404() {
	return false;
}
/**
 * Is the query a login (returns no results)?
 *
 * @return bool
 */
function is_login() {		
	if( isset($_GET['login']) ) return true;	
}
/**
 * Is the query a admin (returns no results)?
 *
 * @return bool
 */
function is_admin() {		
	global $login;
	
	if( isset($_GET['admin']) && $login->cek_login() )	{
		return true;
	}
		
}
/**
 * Is the query a request (returns no results)?
 *
 * @return bool
 */
function is_request( $values = false ) {	

	if( $values && isset($_GET['request']) ) 
		$values = $_GET['request'];
		
	elseif( isset($_GET['request']) )
		$values = true;
	
	return $values;		
}
/**
 * Is the query a sys (returns no results)?
 *
 * @return bool
 */
function is_sys() {
	if( isset($_GET['sys']) ) return true;
}
/**
 * Is the query a apps (returns no results)?
 *
 * @return bool
 */
function is_apps( $values = false ) {	

	if( $values && isset($_GET['apps']) ) 
		$values = $_GET['apps'];
		
	elseif( isset($_GET['apps']) )
		$values = true;
	
	return $values;	
}
/**
 * Is the query a load (returns no results)?
 *
 * @return bool
 */
function is_load( $values = false ) {	

	if( $values && isset($_GET['load']) ) 
		$values = $_GET['load'];
		
	elseif( isset($_GET['load']) )
		$values = true;
	
	return $values;	
}
/**
 * Is the query a query string
 *
 * @return bool
 */
function is_query() {
	if( isset($_SERVER['QUERY_STRING']) ) 
		return $_SERVER['QUERY_STRING'];
}
/**
 * Is the query for a feed?
 *
 * @param string|array $feeds
 * @return bool
 */
function is_feed( $feeds = '' ) {
	return false;
}
/**
 * Retrieve variable in the Query class.
 *
 * @param string $var
 * @return mixed
 */
function get_query_var($var) {
	//global $query;

	//return $query->get($var);
	return apply_filters('get_query_var',$_GET[$var]);
}
/**
 * Retrieve variable in the Query class.
 *
 * @param string $var
 * @return mixed
 */
function pos_query_var($var) {
	//global $query;

	//return $query->pos($var);
}
