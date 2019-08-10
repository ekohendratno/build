<?php 
/**
 * @fileName: plugin.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;

if( !function_exists('filter_int') ){
function filter_int( $value )	{ 	return _filter('int',$value);}
}
if( !function_exists('filter_txt') ){
function filter_txt( $value )	{ 	return _filter('text',array('string'=>$value)); }
}
if( !function_exists('filter_post') ){
function filter_post( $value )	{ 	return _filter('post',$value); }
}
if( !function_exists('filter_editor') ){
function filter_editor( $value ){ 	return _filter('editor',$value); }
}
if( !function_exists('filter_clear') ){
function filter_clear( $value )	{ 	return _filter('clear',$value); }
}
if( !function_exists('filter_clean') ){
function filter_clean( $value )	{ 	return _filter('clean',$value); }
}
/**
 * Hooks a function on to a specific action.
 *
 * @param string $tag
 * @param callback $function_to_add
 * @param int $priority
 * @param int $accepted_args
 */
if( !function_exists('add_action') ){
function add_action($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
	return add_filter($tag, $function_to_add, $priority, $accepted_args);
}
}
/**
 * Hooks a function or method to a specific filter action.
 *
 * @param string $tag
 * @param callback $function_to_add
 * @param int $priority
 * @param int $accepted_args
 * @return boolean true
 */
if( !function_exists('add_filter') ){
function add_filter($tag, $function_to_add, $priority = 10, $accepted_args = 1) {
	global $filter, $merged_filters;

	$idx = _filter_build_unique_id($tag, $function_to_add, $priority);
	$filter[$tag][$priority][$idx] = array('function' => $function_to_add, 'accepted_args' => $accepted_args);
	unset( $merged_filters[ $tag ] );
	return true;
}
}
/**
 * Execute functions hooked on a specific action hook.
 *
 * @param string $tag
 * @param mixed $arg
 * @return null
 */
if( !function_exists('do_action') ){
function do_action($tag, $arg = '') {
	global $filter, $actions, $merged_filters, $current_filter;

	if ( ! isset($actions) )
		$actions = array();

	if ( ! isset($actions[$tag]) )
		$actions[$tag] = 1;
	else
		++$actions[$tag];

	// Do 'all' actions first
	if ( isset($filter['all']) ) {
		$current_filter[] = $tag;
		$all_args = func_get_args();
		_call_all_hook($all_args);
	}

	if ( !isset($filter[$tag]) ) {
		if ( isset($filter['all']) )
			array_pop($current_filter);
		return;
	}

	if ( !isset($filter['all']) )
		$current_filter[] = $tag;

	$args = array();
	if ( is_array($arg) && 1 == count($arg) && isset($arg[0]) && is_object($arg[0]) ) // array(&$this)
		$args[] =& $arg[0];
	else
		$args[] = $arg;
	for ( $a = 2; $a < func_num_args(); $a++ )
		$args[] = func_get_arg($a);

	// Sort
	if ( !isset( $merged_filters[ $tag ] ) ) {
		ksort($filter[$tag]);
		$merged_filters[ $tag ] = true;
	}

	reset( $filter[ $tag ] );

	do {
		foreach ( (array) current($filter[$tag]) as $the_ )
			if ( !is_null($the_['function']) )
				call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));

	} while ( next($filter[$tag]) !== false );

	array_pop($current_filter);
}
}
/**
 * Check if any action has been registered for a hook.
 *
 * @param string $tag
 * @param callback $function_to_check
 * @return int|boolean
 */
if( !function_exists('has_action') ){
function has_action($tag, $function_to_check = false) {
	return has_filter($tag, $function_to_check);
}
}
/**
 * Check if any filter has been registered for a hook.
 *
 * @param string $tag
 * @param callback $function_to_check
 * @return int|boolean
 */
if( !function_exists('has_filter') ){
function has_filter($tag, $function_to_check = false) {
	global $filter;

	$has = !empty($filter[$tag]);
	if ( false === $function_to_check || false == $has )
		return $has;

	if ( !$idx = _filter_build_unique_id($tag, $function_to_check, false) )
		return false;

	foreach ( (array) array_keys($filter[$tag]) as $priority ) {
		if ( isset($filter[$tag][$priority][$idx]) )
			return $priority;
	}

	return false;
}
}
/**
 * Call the functions added to a filter hook.
 *
 * @param string $tag
 * @param mixed $value
 * @param mixed $var
 * @return mixed
 */
if( !function_exists('apply_filters') ){
function apply_filters($tag, $value) {
	global $filter, $merged_filters, $current_filter;

	$args = array();

	// Do 'all' actions first
	if ( isset($filter['all']) ) {
		$current_filter[] = $tag;
		$args = func_get_args();
		_call_all_hook($args);
	}

	if ( !isset($filter[$tag]) ) {
		if ( isset($filter['all']) )
			array_pop($current_filter);
		return $value;
	}

	if ( !isset($filter['all']) )
		$current_filter[] = $tag;

	// Sort
	if ( !isset( $merged_filters[ $tag ] ) ) {
		ksort($filter[$tag]);
		$merged_filters[ $tag ] = true;
	}

	reset( $filter[ $tag ] );

	if ( empty($args) )
		$args = func_get_args();

	do {
		foreach( (array) current($filter[$tag]) as $the_ )
			if ( !is_null($the_['function']) ){
				$args[1] = $value;
				$value = call_user_func_array($the_['function'], array_slice($args, 1, (int) $the_['accepted_args']));
			}

	} while ( next($filter[$tag]) !== false );

	array_pop( $current_filter );

	return $value;
}
}
/**
 * Execute functions hooked on a specific filter hook, specifying arguments in an array.
 *
 * @param string $tag
 * @param array $args
 * @return mixed
 */
if( !function_exists('apply_filters_ref_array') ){
function apply_filters_ref_array($tag, $args) {
	global $filter, $merged_filters, $current_filter;

	// Do 'all' actions first
	if ( isset($filter['all']) ) {
		$current_filter[] = $tag;
		$all_args = func_get_args();
		_call_all_hook($all_args);
	}

	if ( !isset($filter[$tag]) ) {
		if ( isset($filter['all']) )
			array_pop($current_filter);
		return $args[0];
	}

	if ( !isset($filter['all']) )
		$current_filter[] = $tag;

	// Sort
	if ( !isset( $merged_filters[ $tag ] ) ) {
		ksort($filter[$tag]);
		$merged_filters[ $tag ] = true;
	}

	reset( $filter[ $tag ] );

	do {
		foreach( (array) current($filter[$tag]) as $the_ )
			if ( !is_null($the_['function']) )
				$args[0] = call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));

	} while ( next($filter[$tag]) !== false );

	array_pop( $current_filter );

	return $args[0];
}
}
/**
 * Removes a function from a specified filter hook.
 *
 * @param string $tag
 * @param callback $function_to_remove
 * @param int $priority
 * @param int $accepted_args
 * @return boolean
 */
if( !function_exists('remove_filter') ){
function remove_filter($tag, $function_to_remove, $priority = 10, $accepted_args = 1) {
	$function_to_remove = _filter_build_unique_id($tag, $function_to_remove, $priority);

	$r = isset($GLOBALS['filter'][$tag][$priority][$function_to_remove]);

	if ( true === $r) {
		unset($GLOBALS['filter'][$tag][$priority][$function_to_remove]);
		if ( empty($GLOBALS['filter'][$tag][$priority]) )
			unset($GLOBALS['filter'][$tag][$priority]);
		unset($GLOBALS['merged_filters'][$tag]);
	}

	return $r;
}
}
/**
 * Remove all of the hooks from a filter.
 *
 * @param string $tag
 * @param int $priority
 * @return bool
 */
if( !function_exists('remove_all_filters') ){
function remove_all_filters($tag, $priority = false) {
	global $filter, $merged_filters;

	if( isset($filter[$tag]) ) {
		if( false !== $priority && isset($filter[$tag][$priority]) )
			unset($filter[$tag][$priority]);
		else
			unset($filter[$tag]);
	}

	if( isset($merged_filters[$tag]) )
		unset($merged_filters[$tag]);

	return true;
}
}
/**
 * Retrieve the name of the current filter or action.
 *
 * @return string
 */
if( !function_exists('current_filter') ){
function current_filter() {
	global $current_filter;
	return end( $current_filter );
}
}
/**
 * Gets the basename of a plugin.
 *
 * @param string $file
 * @return string
 * @uses plugin_path
 */
if( !function_exists('plugin_basename') ){
function plugin_basename($file) {
	
	$file = str_replace('\\','/',$file);
	$file = preg_replace('|/+|','/', $file);
	
	$plugin_dir = str_replace('\\','/',plugin_path);
	$plugin_dir = preg_replace('|/+|','/', $plugin_dir);
	
	$mu_plugin_dir = str_replace('\\','/',plugin_path);
	$mu_plugin_dir = preg_replace('|/+|','/', $mu_plugin_dir);
	
	$file = preg_replace('#^' . preg_quote($plugin_dir, '#') . '/|^' . preg_quote($mu_plugin_dir, '#') . '/#','',$file);
	$file = trim($file, '/');
	return $file;
}
}

if( !function_exists('_filter') ){
function _filter( $tag, $value, $html=true ){
	switch( $tag ){
	case'int':
		if (is_numeric ( $value )){
		$r = (int)preg_replace ( '/\D/i', '', $value);
		}
		else {
			$value = ltrim( $value, ';' );
			$value = explode ( ';', $value );
			$r = (int)preg_replace ( '/\D/i', '', $value[0] );
		}
		return $r;
	break;
	case'text':
	/*
	* array(
	* 'string'	=>'1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~`!@#$%^&*()_+,>< .?/:;"\'{[}]|\_-+=',
	* 'type'	=>''
	* );
	*/
	if( !empty( $value['string'] ) ){
		if(!empty($value['type']) && intval( $value['type'] ) == 2){
        	$r = htmlspecialchars( trim( $value['string'] ), ENT_QUOTES );
		} else {
			$r = strip_tags( urldecode( $value['string'] ) );
			$r = htmlspecialchars( trim( $r ), ENT_QUOTES );
		}
		return $r;
	}
	break;
	case'editor':
	if( !empty( $value ) ){
		$value = preg_replace( '[\']', '\'\'', $value );
		$value = preg_replace( '[\'\'/]', '\'\'', $value );
		return $value;
	}
	break;
	case'post':
	if( !empty( $value ) ){
		return htmlspecialchars(get_magic_quotes_gpc() ? $_POST[$value] : addslashes($_POST[$value]));
	}
	break;
	case'clear':
	if( !empty( $value ) ){
		return preg_replace( '/[!"\#\$%\'\(\)\?@\[\]\^`\{\}~\*\/]/', '', $value );
	}
	break;
	case'clean':
	if( !empty( $value ) ){
		$value = preg_replace( "'<script[^>]*>.*?</script>'si", '', $value );
        $value = preg_replace( '/<a\s+.*?href="([^"]+)"[^>]*>([^<]+)<\/a>/is', '\2 (\1)', $value );
        $value = preg_replace( '/<!--.+?-->/', '', $value );
        $value = preg_replace( '/{.+?}/', '', $value );
        $value = preg_replace( '/&nbsp;/', ' ', $value );
        $value = preg_replace( '/&amp;/', ' ', $value );
        $value = preg_replace( '/&quot;/', ' ', $value );		
		$value = preg_replace( '[\']', '&#039;', $value );
		$value = preg_replace( '/&#039;/', '\'\'', $value );
        $value = strip_tags( $value );
        $value = preg_replace("/\r\n\r\n\r\n+/", " ", $value);
        $value = $html ? htmlspecialchars( $value ) : $value;
        return $value;
	}
	break;
	}
}
}
/**
 * Calls the 'all' hook, which will process the functions hooked into it.
 *
 * @param array $args
 * @param string $hook
 */
if( !function_exists('_call_all_hook') ){
function _call_all_hook($args) {
	global $filter;

	reset( $filter['all'] );
	do {
		foreach( (array) current($filter['all']) as $the_ )
			if ( !is_null($the_['function']) )
				call_user_func_array($the_['function'], $args);

	} while ( next($filter['all']) !== false );
}
}
/**
 * Build Unique ID for storage and retrieval.
 *
 * @global array $filter
 * @param string $tag
 * @param callback $function
 * @param int|bool $priority
 * @return string|bool
 */
if( !function_exists('_filter_build_unique_id') ){
function _filter_build_unique_id($tag, $function, $priority) {
	global $filter;
	static $filter_id_count = 0;

	if ( is_string($function) )
		return $function;

	if ( is_object($function) ) {
		$function = array( $function, '' );
	} else {
		$function = (array) $function;
	}

	if (is_object($function[0]) ) {
		if ( function_exists('spl_object_hash') ) {
			return spl_object_hash($function[0]) . $function[1];
		} else {
			$obj_idx = get_class($function[0]).$function[1];
			if ( !isset($function[0]->filter_id) ) {
				if ( false === $priority )
					return false;
				$obj_idx .= isset($filter[$tag][$priority]) ? count((array)$filter[$tag][$priority]) : $filter_id_count;
				$function[0]->filter_id = $filter_id_count;
				++$filter_id_count;
			} else {
				$obj_idx .= $function[0]->filter_id;
			}

			return $obj_idx;
		}
	} else if ( is_string($function[0]) ) {
		return $function[0].$function[1];
	}
}
}