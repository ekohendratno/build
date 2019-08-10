<?php
/**
 * @file file-upload.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $iw, $login;

if( 'libs/ajax/file-upload.php' == is_load( true ) && isset($_FILES['file']['name'])
&& $login->cek_login() && $login->login_level('admin') ):

$file = esc_sql( $_FILES['file'] );
$file = hash_files( $file );

copy($file['tmp_name'], upload_path . $file['name']);
					
echo '<a href="' . $iw->base_url . 'content/uploads/' . $file['name'].'" >'.get_filename_at($file['name']).'</a>';	

endif;	
?>