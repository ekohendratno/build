<?php
/**
 * @file load.thumb.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

if( 'thumb.php' == is_load( true ) && 'post' == is_apps( true ) ):
	crop_image( 'content/uploads/post/' );
endif;

