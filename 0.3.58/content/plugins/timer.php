<?php
/**
 * @file: timer.php
 * @dir: content/plugins
 */
 
/*
Plugin Name: Timer
Plugin URI: http://cmsid.org/#
Description: Plugin bla bla bla
Author: Eko Azza
Version: 1.1.0
Author URI: http://cmsid.org/
*/ 

if(!defined('_iEXEC')) exit;
/*
 * Mengeset plugin timer
 */
function set_plugin_timer(){
	echo 'aku plugin timer<br />';
}
/*
 * Mengeset plugin timer
 */
function set_plugin_timer2(){
	echo 'aku plugin timer2<br />';
}

/*
 * Menambahkan plugin timer ke action head
 */
//add_action('the_head', 'set_plugin_timer');
//add_action('the_head', 'set_plugin_timer2');
//add_action('plugins_loaded', 'set_plugin_timer2');