<?php
/**
 * @file menu.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $iw, $login;

if( 'libs/ajax/theme.php' == is_load( true )  
&& $login->cek_login() 
&& $login->login_level('admin') ):

$_GET['theme'] = !isset($_GET['theme']) ? null : $_GET['theme'];

$response['status'] = 1;

header('Content-type: application/json');
echo json_encode($response);

endif;