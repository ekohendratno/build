<?php
/**
 * @file image-upload.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $iw, $login;

if( 'libs/ajax/image-upload.php' == is_load( true ) && isset($_FILES['file']['name'])
&& $login->cek_login() && $login->login_level('admin') ):

$thumb = esc_sql( $_FILES['file'] );
$thumb = hash_image( $thumb );

copy($thumb['tmp_name'], upload_path . $thumb['name']);
						
echo '<img src="' . $iw->base_url . 'content/uploads/' . $thumb['name'].'" />';	

endif;
?>