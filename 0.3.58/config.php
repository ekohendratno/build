<?php
/**
 * @fileName: config.php
 * @setting ketentuan website
 * 
 * isi sesuai dengan hak akses ke mysql server anda
 */
 
//not direct access
if(!defined('_iEXEC')) exit;


/*
*************** Basic Setting *************
*/

//nama host mysql db
define('DB_HOST', 'localhost');
//nama pengguna mysql db
define('DB_USER', 'root');
//kata sandi mysql db	
define('DB_PASS', '');
//nama database mysql	
define('DB_NAME', 'cmsid_22_0_358');
//nama awal table
define('DB_PRE', 'iw_');