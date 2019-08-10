<?php
/**
 * @file init.php
 * @dir: admin/manage/users
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

function get_widget(){
	global $widget;
	
	$gadget = array();	
	$gadget[] = array('title' => 'Terakhir online','desc' => gadget_users('user_last_update'));	
	$gadget[] = array('title' => 'Baru terdaftar','desc' => gadget_users());	
	
	$widget = array(
		'gadget'	=> $gadget,
		'help_desk' => 'tool ini mempermudah anda memanage user atau akun website'
	);
	return;
}
add_action('the_actions_menu', 'get_widget');

if(!function_exists('gadget_users')){
	function gadget_users( $order_by = 'user_registered' ){
		global $db, $login;
		
		$sql_select	= $db->select("users", null ,"ORDER BY $order_by DESC LIMIT 10");
		
		$show = '<link href="admin/manage/users/style-widget.css" rel="stylesheet" />';
		$show.= '<ul class="user_registered" style="overflow:auto; max-height:200px;">';
		
		$warna = 'white';
		while($row = $db->fetch_array($sql_select)){		
		$warna 	= ( $warna == 'white' ) ? 'gray' : 'white';
			
			$avatar_img_profile = avatar_url($row['user_login']);
			$show.= '<li class="'.$warna.'">';
			$show.= '<a id="popup" data-type="show" title="Detail User" href="?request&load=libs/ajax/user.php&amp;aksi=detail&user_id='.$row['ID'].'">';
			$show.= '<div class="user_registered_img"><img alt="" src="?request&load=libs/timthumb.php&src='.$avatar_img_profile.'&w=80&h=80&zc=1" height="30" width="30" style="margin:1px;cursor:pointer;"></div>';
			$show.= '<div class="user_registered_img_data"><div class="user_registered_author">'.$row['user_author'].'</div>';
			
			$date_stamp = '';
			if( $order_by == 'user_last_update' ) 
				$date_stamp = date_stamp($row['user_last_update']);
			else
				$date_stamp = date_stamp($row['user_registered']);
			
			$show.= '<div class="user_registered_timstamp">'.$date_stamp.'</div>';
			$show.= '</div></a>';
			$show.= '<div style="clear:both;"></div></li>';
		}
		$show.= '</ul>';
		return $show;
	}
}

if(!function_exists('del_users')){
	function del_users($id){
		global $db;
		$db->delete("users",array('ID' => $id));
	}
}

