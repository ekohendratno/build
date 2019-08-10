<?php
/**
 * @file: disk-memory-usage.php
 * @dir: content/plugins
 */
 
/*
Plugin Name: Lazy Load
Plugin URI: http://cmsid.org/#
Description: Lazy load images to improve page load times. Uses jQuery.sonar to only load an image when it's visible in the viewport.
Author: TechCrunch 2011 Redesign team, and Jake Goldman (10up LLC)
Version: 0.5
Author URI: http://cmsid.org/
*/ 

if(!defined('_iEXEC')) exit;

function lazyload_control_js(){
	?>
	<script src="<?php echo plugins_url();?>/lazy-load/js/lazy-load.js"></script>
	<script src="<?php echo plugins_url();?>/lazy-load/js/jquery.sonar.min.js"></script>
    <?php
}

function lazyload_images_add_placeholders() {
	global $the_content;
	// Don't lazy-load if the content has already been run through previously
	if ( false !== strpos( $the_content, 'data-lazy-src' ) )
		return $the_content;
		
	// In case you want to change the placeholder image
	$placeholder_image = apply_filters( 'lazyload_images_placeholder_image', plugins_url( 'images/1x1.trans.gif' ) );

	// This is a pretty simple regex, but it works
	$the_content = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-lazy-src="${2}"${3}><noscript><img${1}src="${2}"${3}></noscript>', $placeholder_image ), $the_content );

	return $the_content;

}

add_action('the_head', 'lazyload_control_js');
add_action('the_content','lazyload_images_add_placeholders');