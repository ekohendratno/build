<?php

function get_post( $where, $order = false ){
	global $iw, $db;
	$q = $db->select('post', $where, $order );
	return $q;
}

function page( $param, $id, $type='page'){
	global $db;
	$type = esc_sql( $type );
	$id   = esc_sql( (int) $id );
	
	$post = $db->fetch_array( get_post( compact('type','id') ));
	if(empty($post['id'])){
		return false;
	}else{
		return $post[$param];
	}
}

function the_sidebar_active( $param ){
	return layout( $param );
}

function the_main_page(){
	return the_main_content();
}

if(!function_exists('post_item_id')){
	function post_item_id($act,$id){
		global $db;
		
		$engine =  new engine;		
		$set_rewrite = get_option('rewrite');
		
		if( $set_rewrite == 'clear-slash' || $set_rewrite == 'clear-strip' ):
		$selftitle = filter_clear($id);
		
		if( $act == 'page' ){
			$q = $db->select("post", array('type'=>'page','status'=>1));
			while($data 	= $db->fetch_array($q)){
			if($data['sefttitle'] == $selftitle){
				$id = $data['id'];
			}}
		}
		elseif( $act == 'item' ){
			$q				= $db->select("post", array('type'=>'post','status'=>1));
			while($data 	= $db->fetch_array($q)){
				if($data['sefttitle'] == $selftitle){
					$id = $data['id'];
			}}
		}
		elseif( $act == 'category' ){
			$q				= $db->select("post_topic");
			while($data 	= $db->fetch_array($q)){
				if($engine->judul($data['topic']) == $selftitle){
					$id=$data['id'];
			}}
		}
		endif;
		return filter_int( $id );
	}
}



function classic_soft_widgets_init() {
if (function_exists('register_sidebar'))
{
	register_sidebar(array(
		'name'			=> 'Home/Page Left',
	    'before_widget'	=> '',
	    'after_widget'	=> '</div>',
	    'before_title'	=> '<div class="bg-head-box"><h1 class="head"><div class="head_title">',
	    'after_title'	=> '</div></h1></div><div class="box">',
	));	
	register_sidebar(array(
		'name'			=> 'Home Right',
	    'before_widget'	=> '',
	    'after_widget'	=> '</div>',
	    'before_title'	=> '<div class="bg-head-box"><h1 class="head"><div class="head_title">',
	    'after_title'	=> '</div></h1></div><div class="box">',
	));	
}}
add_action( 'widgets_init', 'classic_soft_widgets_init' );
