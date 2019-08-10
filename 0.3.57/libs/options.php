<?php 
/**
 * @fileName: options.php
 * @dir: libs/
 */
if(!defined('_iEXEC')) exit;
/**
 * Memanggil pengaturan dari table options
 *
 * @param string|int $option
 * @return string|int|false
 */
function get_option( $option, $default = false ){
	global $db;
	
	if( empty( $option ) )
		return false;
	
	$option	= esc_sql( $option );
	
	$sql	= $db->select( "options", array('option_name' => $option),'LIMIT 1' );
	$obj 	= $db->fetch_obj( $sql );
		
	if( is_object($obj) )
		return $obj->option_value;
	else 
		return $default;
	
	return apply_filters( 'option_' . $option, maybe_unserialize( $obj->option_value ) );
}
/**
 * Mengecek options
 *
 * @param string|int $option
 * @return string|int|false
 */
function checked_option( $option ){
	$option = get_option($option);
	
	if( !empty($option) ) return true;
	else return false;
}
/**
 * Memperbaharui pengaturan dari table options
 *
 * @param string|int $option
 * @param string|int $value
 */
function set_option($option, $value = ''){
	global $db;
	
	if( empty($option) )
	return false;			
		
	$option	= esc_sql( $option );
	$value	= esc_sql( $value );
			
	$db->update( "options",  array('option_value' => $value),  array('option_name' => $option) );
	return;
}
/**
 * Menambahkan pengaturan ke table options
 *
 * @param string|int $option
 * @param string|int $value
 */
function add_option($option, $value = ''){
	global $db;
	
	if( empty($option) )
	return false;
		
	$option	= esc_sql( $option );
	$value	= esc_sql( $value );
		
	$db->insert( "options", array('option_value' => $value, 'option_name' => $option) );
}