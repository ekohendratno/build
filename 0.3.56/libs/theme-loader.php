<?php 
/**
 * @fileName: theme-loader.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;

if ( defined('use_themes') && use_themes ) :
	$template = false;
	if( is_request() ) : $template = get_request_template();
	elseif( is_login() ) : $template = get_login_template();
	elseif( is_admin() ) : $template = get_admin_template();
	else :
	
	ob_start();
	
	if( !get_query_var('com') ) get_front();
	else{
		if( get_query_var('com') == 'page' ) get_page();
		else{
			if( get_apps_cheked( get_query_var('com') ) ) {
				get_apps_included( get_query_var('com'), true, 'func' );
				get_apps_included( get_query_var('com') );
			}
			else 
				get_page_error();
		}
	}
		
	$iw_loader = ob_get_contents();
	ob_end_clean();	
		
	$template = get_index_template();
	
	endif;
		
	if ( $template )
		include( $template );
	return;
	
endif;