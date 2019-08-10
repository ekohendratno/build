<?php
/**
 * @fileName: config.php
 * @setting ketentuan website
 * 
 * isi sesuai dengan hak akses ke mysql server anda
 */
 
//not direct access
if(!defined('_iEXEC')) exit;

/**
 * define base_url_config
 * mendefinisikan direktori url base
 */
class config
{
	/*
	 *************** Basic Setting *************
	 */

	//nama host mysql db
	var $db_host 		= 'localhost';
	//nama pengguna mysql db
	var $db_user 		= 'root';
	//kata sandi mysql db	
	var $db_password 	= '';
	//nama database mysql	
	var $db_name 		= 'cmsid_22_0_356';
	//nama awal table
	var $pre 			= 'iw_';
	//web url base
	var $base_url 		= 'http://localhost/cmsid/build/0.3.56/';  
	
	
	var $image_allaw	= array(
    'image/png' 		=> '.exe',
    'image/x-png' 		=> '.png',
    'image/gif' 		=> '.gif',
    'image/jpeg' 		=> '.jpg',
    'image/pjpeg' 		=> '.jpg');
	
	var $file_allaw		= array("txt","csv","htm","html","xml", 
    "css","doc","xls","rtf","ppt","pdf","swf","flv","avi", 
    "wmv","mov","jpg","jpeg","gif","png"); 
	
}