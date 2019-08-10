<?php 
/**
 * @fileName: default-filters.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;

//add_filter( 'the_title', 'get_the_title' );

foreach ( array( 'siteinfo', 'iw_title' ) as $f ) {
	add_filter( $f, 'esc_html' );
}

foreach ( array( 'body_layout', 'global_layout' ) as $f ) {
	add_filter( $f, 'filter_int' );
}

add_action( 'do_robots', 'do_robots' );
add_action( 'iw_head', 'noindex', 1 );

add_action( 'iw_head', 'set_stats' );
add_action( 'iw_head', 'set_stats_ref' );
add_action( 'iw_head', 'set_stats_browser' );

add_action( 'iw_head', 'set_country_stat' );
add_action( 'iw_head_login', 'set_country_stat' );
add_action( 'iw_head_request', 'set_country_stat' );

add_action( 'iw_head', 'iw_favicon' );
add_action( 'iw_head_login', 'iw_favicon' );
add_action( 'iw_head_admin', 'iw_favicon' );

add_action( 'iw_head', 'query_security' );
add_action( 'iw_head_login', 'query_security' );
add_action( 'iw_head_request', 'query_security' );

add_action( 'iw_head_admin', 'loaded_component' );

