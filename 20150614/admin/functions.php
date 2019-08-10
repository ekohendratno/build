<?php 
/**
 * @fileName: functions.php
 * @dir: admin/templates/
 */
if(!defined('_iEXEC')) exit;


if( !function_exists('add_activity') ){
	function add_activity(){}
}

function the_notif(){
	global $db;
	
	if( get_query_var('x') == 'splash' ){
		if( checked_option( 'splash' ) ) set_option( 'splash', 1 );
		else add_option( 'splash', 1 );
		
		redirect('?admin');
	}
?>

			
				<!--ROW COLUMN FIRST END-->
				<!--QUICK PANEL END-->
            	<div class="row">	
				
                	<div class="col-md-12">
                    	<div class="panel panel-default">
						
  <div class="panel-body panel-quick">

	<div class="col-md-3 panel-quick-start">
        <div class="cols">
        	<strong>Memulai</strong>
            <div class="clearfix"></div>
            <a href="?admin=single&amp;sys=appearance&amp;go=theme-editor&amp;theme=portal" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Custom situs</a>
            <div class="clearfix clr2"></div>or <a href="?admin&amp;sys=appearance">ubah tampilan</a>
        </div>
	</div>
	<div class="col-md-2 panel-quick-second">
        <div class="cols">
        	<strong>Versions</strong>
            <div class="clearfix"></div>
			<span>Current Version 3.00 build 100</span>
            <a title="" data-original-title="Information Pembaruan" href="#" data-url="?request&amp;apps=yes&amp;load=libs/ajax/latest.php" data-type="show" class="btn btn-info btn-xs modal-show"><span class="glyphicon glyphicon-refresh"></span> Check Updates</a>
            <div class="clearfix"></div>
        </div>
	</div>
	<div class="col-md-3 panel-quick-three">
        <div class="cols">
        	<strong>Langkah berikutnya</strong>
            <div class="clearfix"></div>
            <ul>
            <li><a href="?admin=single&amp;apps=post&amp;go=add&amp;type=post">Tulis sebuah posting</a></li>
            <li><a href="?admin=single&amp;apps=post&amp;go=add&amp;type=page">Tulis sebuah halaman</a></li>
            <li><a href="http://localhost/cmsid/build/1.4.sample">Lihat situs</a></li>
            </ul>
        </div>
	</div>
	<div class="col-md-4 panel-quick-four">
        <div class="cols">
        	<strong>Lainnya</strong>
            <div class="clearfix"></div>
            <ul>
            <li>Atur <a href="?admin&amp;sys=options">option</a> atau <a href="?admin&amp;sys=appearance&amp;go=widgets">widget</a> atau <a href="?admin&amp;sys=appearance&amp;go=menus">menu</a></li>
            <li><a id="popup" data-type="edit" href="?request&amp;apps=yes&amp;load=post/setting.php" title="Pengaturan Post">Mati atau hidupkan komentar</a></li>
            <li><a href="http://cmsid.org/page-langkah-pertama-menggunakan-cmsid.html">Pelajari lebih lanjut untuk memulai</a></li>
            </ul>
    	</div>
	</div>
    
                        
                        </div>
                        </div>
                        
                        
                    </div>
					
                </div>
				<!--QUICK PANEL END-->
				<!--ROW COLUMN FIRST END-->
<?php
}
add_action('the_notif','the_notif');

function restrict_access(){
	global $login;
	
	if( !$login->check() or $login->level('user') ){
		redirect('?login');
	}
}
add_action('the_head_admin','restrict_access');

function the_menuaction($li,$il){
	global $widget, $sidebar_default;

	if( isset($widget[m]) && count($widget[m]) > 0 && !empty($widget[m]) ) {
		foreach($widget[m] as $k => $v)	echo $li. $v[l] . "'>" . $v[t] . $il;		
	}else{
		
	
	$plugins 	= get_dir_plugins();
	foreach($plugins as $key => $val){
		$name = get_plugins_name($key);
		$key2 = str_replace( $name .'/', '' , $key );
		
	 	if( !empty($name)
		&& file_exists( plugin_path .'/'. $name . '/admin.php' )
		&& get_plugins( $key ) == 1 ){
			
		$plugins_new[$key] = array('t' => $val['Name'], 'l' => '?admin&s=plugins&go=setting&plugin_name='.$name.'&file=/'.$key2);
		}
	}
	
	foreach($sidebar_default as $k => $v){
		/*if( get_sys_cheked( $k ) )*/ $sidebar_menus[$k] = array('t' => $v[t], 'l' => $v[l]);
	}
	
	$sidebar_menus = parse_args($plugins_new,$sidebar_menus);	
	$sidebar_menus = array_multi_sort($sidebar_menus, array('t' => SORT_ASC));
	foreach($sidebar_menus as $k => $v)	echo $li. $v[l] . "'>" . $v[t] . $il;	
	
	}
}

function add_templates( 
	$templates_content, 
	$templates_title = null, 
	$templates_header_menu = null, 
	$widget_manual = null, 
	$form = null, 
	$templates_footer = null){
	
	do_action('add_templates');	
	
	return add_templates_content_position( 
	$templates_content, 
	$templates_title, 
	$templates_header_menu, 
	$widget_manual, 
	$form,
	$templates_footer);
}

function add_templates_content_position( 
	$templates_content, 
	$templates_title = null, 
	$templates_header_menu = null, 
	$widget_manual = null, 
	$form = null, 
	$templates_footer = null){
		
	global $widget;
	
	do_action('add_templates_content_position');	
	
	if( !empty($widget_manual) ) $widgetx = $widget_manual;
	else $widgetx = $widget;	
		
	$widget_avalable = false;
	if( count($widgetx['gadget']) > 0 && !empty($widgetx['gadget'][0]) )
		$widget_avalable = true;	
	
	$add_templates_content_widget = _add_templates_content_widget( $widgetx );
	$add_templates_content = _add_templates_content( 
		$templates_content, 
		$templates_title, 
		$templates_header_menu, 
		$templates_footer);
		
	$col_md_number = 10;
	if( is_sys() && $widget_avalable ){ $col_md_number = 7;}
	if( is_sys() && $widget_avalable && is_admin_values() == 's' ){ $col_md_number = 9; }
	if( is_sys() && $widget_avalable && is_admin_values() == 'f' ){ $col_md_number = 12; }
	if( is_admin_values() == '404' ){ $col_md_number = 12; }
	
	$content = '';
	
	$content.= "<div class=\"col-md-$col_md_number\">";
	$content.= $add_templates_content;
	$content.= "</div>";	
	
	if( ((is_admin_values() == 's' || is_admin_values() != 'f') && $widget_avalable ) ){
		
	$content.= "<div class=\"col-md-3\">";
	$content.= $add_templates_content_widget;
	$content.= "</div>";	
	
	}
	
	
	if( !empty($form) )
		echo sprintf('<form %s>%s</form>', $form, $content);
	else
		echo $content;
		
	return;
}

function _add_templates_content( 
	$templates_content, 
	$templates_title = null, 
	$templates_header_menu = null,
	$templates_footer = null){
	global $widget;
	
	do_action('add_templates_content');
	
	$content = '<div class="panel panel-default">';
    $content.= '<div class="panel-heading">';
	$content.= '<strong>'.$templates_title.'</strong>';
	
	if( !empty($templates_header_menu) ):
	$content.= '<div class="pull-right btn-toolbar">';
	$content.= '<div class="btn-group pull-right">';

	$content.= '<a href="#" class="btn btn-primary btn-xs">Save</a>';
	$content.= '<a href="#" class="btn btn-danger btn-xs">Delete</a>';
	$content.= '<a href="#" class="btn btn-default btn-xs">Draf</a>';
	
	$content.= '</div>';
	$content.= '</div>';
	endif;
	
	$content.= '</div>';
    $content.= '<div class="panel-body">';
	$content.= $templates_content;
    $content.= '</div>';
	
	
	if( !empty($templates_footer) ):
	$content.= '<div class="panel-footer">';	
	$content.= $templates_footer;		
	$content.= '</div>';
	endif;
    $content.= '</div>';
	
	return $content;
}

function _add_templates_content_widget( $current_widget = null){
	
	if( !is_array($current_widget['gadget']) )
		return false;
		
	$content = '';
	foreach($current_widget['gadget'] as $box){
		
	$content = '<div class="panel panel-default">';
    $content.= '<div class="panel-heading">';
	$content.= '<strong>'.$box['title'].'</strong>';
	
	if( !empty($box['menu']) ):
	$content.= '<div class="pull-right">';

	$content.= '<a href="#" data-perform="panel-collapse" class="pull-right"><i class="glyphicon glyphicon-resize-small"></i></a>';
	
	$content.= '</div>';
	endif;
	
	$content.= '</div>';
    $content.= '<div class="panel-body">';
	$content.= $box['desc'];
    $content.= '</div>';
	
	
	if( !empty($box['foot']) ):
	$content.= '<div class="panel-footer">';	
	$content.= $box['foot'];		
	$content.= '</div>';
	endif;
    $content.= '</div>';

	}
	
	return $content;
}

