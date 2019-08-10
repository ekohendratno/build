<?php 
/**
 * @fileName: sidebar.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;

	
function set_sidebar_box( $html, $sidebar_title, $sidebar_content ){	
	$html = addslashes($html);
	$html = "\$html=\"".$html."\";";
    eval($html);
    echo $html;
}

function set_sidebar( $html, $posision = false ){
	global $iw, $db;
	
	$total 	  	= 0;
	$num	  	= 0;	
	$posision 	= esc_sql( $posision );				
	$app_value 	= esc_sql( get_query_var('com') );
	
	if( isset($app_value) ){
	
	$query_sidebar_action = $db->select('sidebar_action',array('aplikasi'=>$app_value));
	$num = $db->num($query_sidebar_action);
			
	$query_sidebar_relation = $db->query('	
	SELECT * 
	FROM `'		. $iw->pre.'sidebar_action` 
	LEFT JOIN `'. $iw->pre.'sidebar` 
	ON (`'		. $iw->pre.'sidebar`.`id` = `'
				. $iw->pre.'sidebar_action`.`id_sidebar`) 
	WHERE `'	. $iw->pre.'sidebar`.`aplikasi` = "1" 
	AND `'		. $iw->pre.'sidebar_action`.`aplikasi` = "'. $app_value.'" 
	AND `'		. $iw->pre.'sidebar_action`.`posisi` = "'. $posision.'" 
	ORDER BY `'	. $iw->pre.'sidebar_action`.`order`');
									
	$total = $db->num($query_sidebar_relation);
	while ($query_sidebar_view = $db->fetch_assoc($query_sidebar_relation)) {
		if($query_sidebar_view['type']!=='app'){ 
			set_sidebar_box( $html, $query_sidebar_view['title'], $query_sidebar_view['coder'] );
		}else{		
			if( file_exists( application_path .  $query_sidebar_view['file'] )  && $query_sidebar_view['type']=='app'){					
				if( isset($widget) ){									
					include application_path . $query_sidebar_view['file'];					
				}else{	
											
					ob_start();
					include application_path . $query_sidebar_view['file'];
					$out = ob_get_contents();
					ob_end_clean(); 
					
					set_sidebar_box( $html, $query_sidebar_view['title'], @$out );
					$out = '';
				}
			}
		}
	}
	
	// end isset apps	
	}		
	
	if( empty($total) or $total == 0 && empty($num) or $total == 0 ) {
			
	$query_sidebar = $db->select('sidebar', array('status'=>1,'position'=>$posision),'ORDER BY ordering');
					
	while ($query_sidebar_view = $db->fetch_assoc($query_sidebar)) {	
		if($query_sidebar_view['type']!=='app'){
			set_sidebar_box( $html, $query_sidebar_view['title'], $query_sidebar_view['coder'] );
		}else{		
				if( file_exists( application_path .  $query_sidebar_view['file'] )  
				&& $query_sidebar_view['type']=='app'){	
								
					if( isset($widget) ){									
						include application_path . $query_sidebar_view['file'];					
					}else{	
												
						ob_start();
						include application_path . $query_sidebar_view['file'];
						$out = ob_get_contents();
						ob_end_clean(); 
						
						set_sidebar_box( $html, $query_sidebar_view['title'], @$out );
						$out = '';
					}
					
				}
			}
		}
	}
}

function set_sidebar_menu( $html, $posision = false ){
	global $iw, $db, $login;	
	
	$posision = esc_sql($posision);	
	if ($login->cek_login() && ($login->login_level('admin') or $login->login_level('user')) ){
	
	if( $posision == 0 ){
	$boxcontent = '<ul class="sidemenu">';  
	
	$query_sidebar_menu = $db->select("sidebar_menu_user",array('status'=>1), 'ORDER BY ordering asc');
			
	while( $sidebar_menu_view = $db->fetch_array($query_sidebar_menu) ){
		$boxcontent .= '<li>';
		
		if( $sidebar_menu_view['title'] == 'Logout' ){
	 		$title = '<a onclick="return confirm(\'Are You sure logout?\')" class="main-menu-act" href="'.$iw->base_url.$sidebar_menu_view['url'].'"><b>'.$sidebar_menu_view['title'].'</b>';		
		}else{
	 		$title = '<a class="main-menu-act" href="'.$iw->base_url.$sidebar_menu_view['url'].'">'.$sidebar_menu_view['title'];
		}
				
		$boxcontent .= $title.'</a></li>';
	}
	
	if( $login->login_level('admin') ){
		$boxcontent .= '<li><a class="main-menu-act" href="'.$iw->base_url.'?admin">Administrator</a></li>';
	}
			
	$boxcontent.='</ul>';
	set_sidebar_box( $html, 'Menu User', $boxcontent );
	//end position
	}
	//end author
	}
	
	
	$query_sidebar_menu = $db->select("sidebar_menu",array('position'=>$posision,'status'=>1));			
	while ( $sidebar_menu_view = $db->fetch_array($query_sidebar_menu) ) {
				
	$status = 1;
	$orderby = $sidebar_menu_view['id'];
	$where_sidebar_menu_sub = compact('status','position','orderby');				
	$query_sidebar_menu_sub = $db->select('sidebar_menu_sub',$where_sidebar_menu_sub);
												
	$boxcontent	 = '<ul class="sidemenu">';
				
	while( $sidebar_menu_sub_view = $db->fetch_array($query_sidebar_menu_sub) ){
					
	$boxcontent .= '<li><a class="main-menu-act" href="' . $iw->base_url . $sidebar_menu_sub_view['url'] . '">';
	$boxcontent .= $sidebar_menu_sub_view['title'];
	$boxcontent .= '</a></li>';
				
	}
				
	$boxcontent .= '</ul>';
	set_sidebar_box( $html, $sidebar_menu_view['title'], $boxcontent );	
	}
}

