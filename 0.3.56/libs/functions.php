<?php 
/**
 * @fileName: functions.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;

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
 * Memanggil pengaturan dari table options
 *
 * @param string|int $option
 * @return string|int|false
 */
function get_option($option, $default = false){
	global $db;
	
	if( empty($option) )
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
 * Gets the copunt apps and plugins.
 *
 * @return number
 */
function get_counted( $get_ = 'app' ){
	
	if( $get_ == 'app' ) return count( get_mu_apps() );
	elseif( $get_ == 'plg' ) return count( get_noactive_and_valid_plugins() );
	else return false;	
}
/**
 * Mengetahui protokol
 *
 * @return true|false
 */
function is_ssl() {
	if ( isset($_SERVER['HTTPS']) ) {
		if ( 'on' == strtolower($_SERVER['HTTPS']) )
			return true;
		if ( '1' == $_SERVER['HTTPS'] )
			return true;
	} elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
		return true;
	}
	return false;
}
/**
 * Merge user defined arguments into defaults array.
 *
 * @param string|array
 * @param array $defaults
 * @return array
 */
function parse_args( $args, $defaults = '' ) {
	if ( is_object( $args ) )
		$r = get_object_vars( $args );
	elseif ( is_array( $args ) )
		$r =& $args;
	else
		parse_string( $args, $r );

	if ( is_array( $defaults ) )
		return array_merge( $defaults, $r );
	return $r;
}
/**
 * Gets the current locale.
 *
 * @return string
 */
function get_locale() {
	global $locale;
	
	if ( empty( $locale ) )
		$locale = 'en_US';

	return apply_filters( 'locale', $locale );
}

/**
 * Memvalidasi berkas
 *
 * @param string $file
 * @param array $allowed_files
 * @return int
 */
function validate_file( $file, $allowed_files = '' ) {
	if ( false !== strpos( $file, '..' ) )
		return 1;

	if ( false !== strpos( $file, './' ) )
		return 1;

	if ( ! empty( $allowed_files ) && ! in_array( $file, $allowed_files ) )
		return 3;

	if (':' == substr( $file, 1, 1 ) )
		return 2;

	return 0;
}
/**
 * String to pos clone
 *
 * @return true|false
 */
function stripost($haystack, $needle, $offset=0){
	
	if( !function_exists('stripos') ) 
		$return = strpos(strtoupper($haystack), strtoupper($needle), $offset);
	else 
		$return = stripos($haystack, $needle, $offset=0);
	
	if ($return === false) return false; 
	else return true; 
}
/**
 * Query security for ilegal operation
 *
 * @return false
 */
function query_security(){
	$attacked = array('ad_click','%20union%20','/*','*/union/*','c2nyaxb0','+union+','cmd=','&cmd','exec','execu','concat');
				
	if( is_query() && ( !stripost( is_query(), $attacked[0]) ) ) :
		if( stripost( is_query(), $attacked[1] ) or 
			stripost( is_query(), $attacked[2] ) or 
			stripost( is_query(), $attacked[3] ) or 
			stripost( is_query(), $attacked[4] ) or 
			stripost( is_query(), $attacked[5] ) or (
			stripost( is_query(), $attacked[6] ) and !
			stripost( is_query(), $attacked[7] )) or (
			stripost( is_query(), $attacked[8] ) and !
			stripost( is_query(), $attacked[9] )) or 
			stripost( is_query(), $attacked[10] ))
			die('Ilegal Operation');
	endif;
	return true;
}

function get_file_data( $file, $default_headers, $context = '' ) {
	$fp 		= fopen( $file, 'r' );
	$file_data 	= fread( $fp, 8192  ); //8kiB
	fclose( $fp );
	
	foreach ( $default_headers as $field => $regex ) {
		preg_match( '/' . preg_quote( $regex, '/' ) . ':(.*)$/mi', $file_data, ${$field});
		if ( !empty( ${$field} ) )
			${$field} = cleanup_header(${$field}[1]);
		else
			${$field} = '';
	}

	$data = compact( array_keys( $default_headers ) );

	return $data;
}

function save_to_file($file){
	$content =  stripslashes(trim ($_POST['content']));
	// Let's make sure the file exists and is writable first.
		if (is_writable($file)) {
		   if (!$handle = @fopen($file, 'w+')) {
				echo'<div class="info">Can\'t read a file ('.get_file_name($file).')</div>';
				exit;
		   }
		   if (fwrite($handle, $content) === FALSE) {
				$return='<div id="error">Can\'t write a file('.get_file_name($file).')</div>';
			   
			   exit;
		   } 
			   //clearstatcache($handle);
			fflush($handle);
			fclose($handle);
			echo '<div id="success">Success save to file ('.get_file_name($file).')</div>'; 
		} else {
		    echo '<div class="error">File $file can\'t write</div>';		   
		}
}



function get_option_array_widget(){
	$arrayx = array(); 
	
	$arrayx["inactive_widgets"]= array();
	$arrayx["sidebar-1"]= array("archives-1","categories-1");
	$arrayx["sidebar-2"]= array("archives-1"); 
	$arrayx["sidebar-3"]= array("archives-1");
	$arrayx["sidebar-4"]= array("archives-1"); 
	$arrayx["sidebar-5"]= array(); 
	$arrayx["sidebar-6"]= array();
	return $arrayx;
}

//setting widget
function get_option_array_widget_item(){
	$arrayx = array(); 
	$arrayx[1] = array("title" == "", "count" == "0", "dropdown" == "0");
	$arrayx[2] = array("title" == "", "count" == "0", "dropdown" == "0");
	$arrayx["_multiwidget"] = 1; 
	return $arrayx;
}

function submit_button( $text = null, $type = 'primary', $name = 'submit', $wrap = true, $other_attributes = null ) {
	echo get_submit_button( $text, $type, $name, $wrap, $other_attributes );
}

function get_submit_button( $text = null, $type = 'primary large', $name = 'submit', $wrap = true, $other_attributes = null ) {
	if ( ! is_array( $type ) )
		$type = explode( ' ', $type );

	$button_shorthand = array( 'primary', 'small', 'large' );
	$classes = array( 'button' );
	foreach ( $type as $t ) {
		if ( 'secondary' === $t || 'button-secondary' === $t )
			continue;
		$classes[] = in_array( $t, $button_shorthand ) ? 'button-' . $t : $t;
	}
	$class = implode( ' ', array_unique( $classes ) );

	if ( 'delete' === $type )
		$class = 'button-secondary delete';

	$text = $text ? $text : 'Save Changes';

	$id = $name;
	if ( is_array( $other_attributes ) && isset( $other_attributes['id'] ) ) {
		$id = $other_attributes['id'];
		unset( $other_attributes['id'] );
	}

	$attributes = '';
	if ( is_array( $other_attributes ) ) {
		foreach ( $other_attributes as $attribute => $value ) {
			$attributes .= $attribute . '="' .$value . '" '; // Trailing space is important
		}
	} else if ( !empty( $other_attributes ) ) { // Attributes provided as a string
		$attributes = $other_attributes;
	}

	$button = '<input type="submit" name="' . $name . '" id="' . $id . '" class="' . $class;
	$button	.= '" value="' . $text . '" ' . $attributes . ' />';

	if ( $wrap ) {
		$button = '<p class="submit">' . $button . '</p>';
	}

	return $button;
}
/**
 * Menghapus direktori folder
 *
 * @param string $dirname
 * @return true|false
 */
function delete_directory($dirname) {
   if(is_dir($dirname))
      $dir_handle = opendir($dirname);
   if(!isset($dir_handle))
      return false;
   while($file = readdir($dir_handle)) {
      if ($file != "." && $file != "..") {
         if (!is_dir($dirname."/".$file))
            unlink($dirname."/".$file);
         else
            delete_directory($dirname.'/'.$file);       
      }
   }
   closedir($dir_handle);
   rmdir($dirname);
   return true;
}

/**
 * Mengecek tanggal dan waktu berdasarkan kata
 *
 * @param int $session_time
 * @return string
 */
function time_stamp($session_time, $language = 'id'){ 
	 
	$time_difference 	= time() - $session_time ; 
	$seconds 			= $time_difference ; 
	$minutes 			= round($time_difference / 60 );
	$hours 				= round($time_difference / 3600 ); 
	$days 				= round($time_difference / 86400 ); 
	$weeks 				= round($time_difference / 604800 ); 
	$months 			= round($time_difference / 2419200 ); 
	$years 				= round($time_difference / 29030400 ); 
	
	
	if( $language == 'id' ):
		$lang[0] = 'satu';
		$lang[1] = 'detik';
		$lang[2] = 'menit';
		$lang[3] = 'jam';
		$lang[4] = 'hari';
		$lang[5] = 'minggu';
		$lang[6] = 'bulan';
		$lang[7] = 'tahun';
		$lang[8] = 'yg lalu';
	else:
		$lang[0] = 'one';
		$lang[1] = 'seconds';
		$lang[2] = 'minutes';
		$lang[3] = 'hours';
		$lang[4] = 'day';
		$lang[5] = 'week';
		$lang[6] = 'month';
		$lang[7] = 'years';
		$lang[8] = 'ago';
	endif;
	
	if($seconds <= 60){
	$retval = "$seconds $lang[1] $lang[8]"; 
	}else if($minutes <=60){
		if($minutes==1) $retval = "$lang[0] $lang[2] $lang[8]"; 
		else $retval = "$minutes $lang[2] $lang[8]"; 
	}
	else if($hours <=24){
	   if($hours==1) $retval = "$lang[0] $lang[3] $lang[8]";
	   else $retval = "$hours $lang[3] $lang[8]";
	}
	else if($days <=7){
	  if($days==1) $retval = "$lang[0] $lang[4] $lang[8]";
	  else $retval = "$days $lang[4] $lang[8]";	  
	}
	else if($weeks <=4){
	  if($weeks==1) $retval = "$lang[0] $lang[5] $lang[8]";
	  else $retval = "$weeks $lang[5] $lang[8]";
	}
	else if($months <=12){
	   if($months==1) $retval = "$lang[0] $lang[6] $lang[8]";
	   else $retval = "$months $lang[6] $lang[8]";   
	}	
	else{
		if($years==1) $retval = "$lang[0] $lang[7] $lang[8]";
		else $retval = "$years $lang[7] $lang[8]";	
	}
	
	return $retval;	
	
}

/**
 * Pengurutan array berdasarkan kolom nama array
 *
 * @param array $array_sort
 * @param array $cols_sort
 * @return array
 */
function array_multi_sort($array_sort, $cols_sort = array() ){
    $colarr = array();
    foreach ($cols_sort as $col => $order) {
        $colarr[$col] = array();
        foreach ($array_sort as $k => $row) { 
			$colarr[$col]['_'.$k] = strtolower($row[$col]); 
		}
    }
    $eval = 'array_multisort(';
    foreach ($cols_sort as $col => $order) {
        $eval .= '$colarr[\''.$col.'\'],'.$order.',';
    }
    $eval = substr($eval,0,-1).');';
    eval($eval);
    $ret = array();
    foreach ($colarr as $col => $arr) {
        foreach ($arr as $k => $v) {
            $k = substr($k,1);
            if (!isset($ret[$k])) $ret[$k] = $array_sort[$k];
            $ret[$k][$col] = $array_sort[$k][$col];
        }
    }
    return $ret;

}

function upload_img_post($thumb,$uploadDir = '', $resize = 650, $quality = 120){
		global $iw;
		if(!empty($thumb['name'])):
			
		$myfile 	 = $thumb; //image name
		$uploadDir 	 = upload_path . $uploadDir; //directory upload file
		$data_upload = compact('myfile','uploadDir');
			
		if( function_exists('uploader') ) :
		if( in_array($thumb['type'],array_keys($iw->image_allaw)) ):
			
		//upload file function
		if( uploader($data_upload) ):
			
		$path 	 = $uploadDir . $thumb['name']; // dir & name path image for upload
		$type 	 = $iw->image_allaw[$thumb['type']]; //type image is allow
			
		$data_resize = compact('path','type','resize','quality');
		//resize if file is image allaw function
		if(function_exists('resize_image'))
		resize_image($data_resize);
		endif;
		endif;
		endif;
		endif;
}

function del_img_post($file,$path = ''){
		
		$path = upload_path . $path;
		if(!empty($file)):
		if(file_exists($path.$file))
			unlink($path.$file);
		endif;
}


	
function array_merge_simple( $array1, $array2 ){
	$merged = array();
	
	if( !empty($array1) )
	foreach ( $array1 as $key => $value ){
		$merged [$key] = $value;
	}
	  
	if( !empty($array2) )
	foreach ( $array2 as $key => $value ){
		$merged [$key] = $value;
	}
	
	return $merged;
}

function object_merge_simple( $array1, $array2 ){
	$merged = array();
	
	if( !empty($array1) )
	foreach ( $array1 as $key => $value ){
		$merged[$key] = $value;
	}
	  
	if( !empty($array2) )
	foreach ( $array2 as $key => $value ){
		$merged[$key] = $value;
	}
	
	return (object) $merged;
}


function avatar_url( $user_login, $w = 80, $h = 80, $zc = 1 ){
	global $login;
	
	if( valid_mail($user_login) && $user_email = $user_login ){
		$where = compact('user_email');				
	}
	else
	{			
		$where = compact('user_login');
	}	
	
	$field = $login->username_cek( $where );
	
	if(get_option('avatar_type') == 'gravatar'){
		$avatar_img_profile = get_gravatar($field->user_email);
	}elseif(get_option('avatar_type') == 'computer'){
		$avatar_img_profile = 'default.png';
			
		if( file_exists('content/uploads/avatar_'.$field->user_avatar) ): 
			$avatar_img_profile = $field->user_avatar;
		endif;
			
		$avatar_img_profile = content_url('/uploads/avatar_' . $avatar_img_profile);
	}else{
		$avatar_img_profile = content_url('/uploads/avatar_default.png');
	}
	
	$retval_url = '?request&load=libs/timthumb.php';
	$retval_url.= '&src='.$avatar_img_profile;
	$retval_url.= '&w='.$w;
	$retval_url.= '&h='.$h;
	$retval_url.= '&zc='.$zc;
	
	return $retval_url;
}
