<?php
/**
 * @file image-thumb.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $iw, $login;

if( 'libs/ajax/image-thumb.php' == is_load( true ) && !empty($_GET[src]) 
&& $login->cek_login() && $login->login_level('admin') ):

crop_image( upload_path );
	
endif;

