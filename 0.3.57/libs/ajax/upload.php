<?php
/**
 * @file upload.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $login;

if( 'libs/ajax/upload.php' == is_load_values() 
&& isset( $_FILES['file']['name'] )
&& $login->user_check() && $login->login_level('admin') ):

$file = esc_sql( $_FILES['file'] );
$file = hash_files( $file );

copy($file['tmp_name'], upload_path .'/'. $file['name']);
					
echo '<a href="' .site_url('content/uploads/' . $file['name']).'" >'.get_filename_at($file['name']).'</a>';

endif;	
?>