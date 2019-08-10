<?php 
/**
 * @fileName: default-filters.php
 * @dir: libs/
 */
if(!defined('_iEXEC')) exit;

foreach ( array( 'siteinfo', 'the_title' ) as $f ) {
	add_filter( $f, 'esc_html' );
}

add_action( 'do_robots', 'do_robots' );
add_action( 'the_head', 'noindex', 1 );

add_action( 'the_head', 'set_stats' );
add_action( 'the_head', 'set_stats_ref' );
add_action( 'the_head', 'set_stats_browser' );

add_action( 'the_head', 'set_country_stat' );
add_action( 'the_head_login', 'set_country_stat' );
add_action( 'the_head_request', 'set_country_stat' );

add_action( 'the_head', 'the_favicon' );

add_action( 'the_head', 'query_security' );
add_action( 'the_head_login', 'query_security' );
add_action( 'the_head_admin', 'query_security' );

add_action( 'the_head_admin', 'loaded_component' );

