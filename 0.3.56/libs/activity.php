<?php 
/**
 * @fileName: activity.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;


/**
 * Add a function activity.
 *
 * @param string $activity_name
 * @param string $activity
 */

class activity_recods{
	
	function __construct(){}

	public function add_activity( $activity_name, $activity, $activity_img = null, $u_name = null ){
		global $login; 	
		
		$json = new JSON();
		$add_activity = array();	
			
		$time = time();
		$clock = date("H:i:s");
		$activity_date = date("Y-m-d");	
		
		if( !$login->cek_login() && empty($u_name) )
			return false;
		elseif( !$login->cek_login() && !empty($u_name) )
			$user_id = esc_sql($u_name);
		else 
			$user_id = $login->exist_value('user_name');
			
		if( !empty($activity) )
		$activity = str_replace( abs_path,'',$activity);
			
		$add_activity[] = compact( 'activity', 'time', 'clock'  );					
		$where_activity = compact('user_id', 'activity_name','activity_img','activity_date');
		
		$data_activity = $this->get_item_activity( $where_activity, $add_activity[0] );
		
		if( $data_activity['total'] > 0 ) :  			
			$entry_activity = $where_activity + array('activity_value' => $data_activity['value'] );
			$this->entry_activity($entry_activity, true);
		else :							
			$entry_activity = $where_activity + array('activity_value' => $add_activity );
			$this->entry_activity($entry_activity);
		endif;
		
	}
	
	/**
	 * Get item activity where optional.
	 *
	 * @param array $where
	 * @param array $add_activity
	 */
	public function get_item_activity( $where = null, $add_activity = null ){
		extract($add_activity, EXTR_SKIP);	
		$json = new JSON();
		
		$get_activity_data = $this->get_activity( $where );
		
		$res = array();
		
		if( !empty($get_activity_data['value']) && $get_activity_data['total'] > 0 ):
		
		$get_activity = $json->decode( $get_activity_data['value'] );
		
		foreach( $get_activity as $item_activity){
			$res[] = array('activity' => $item_activity->{'activity'}, 'time' => $item_activity->{'time'}, 'clock' => $item_activity->{'clock'});
		}
		
		endif;
		
		$res[] = array('activity' => $activity, 'time' => $time, 'clock' => $clock);
		
		return array( 'total' => $get_activity_data['total'], 'value' => $res );
	}
	
	/**
	 * Get activity where optional.
	 *
	 * @param array $where
	 */
	public function get_activity( $where = false ){
		extract($where, EXTR_SKIP);
		global $db;
		
		$add_query_where = '';
		
		if( !empty($user_id) && !empty($activity_name) && !empty($activity_date) ){
			
			$user_id = esc_sql( $user_id );	
			$activity_name = esc_sql( $activity_name );	
			$activity_date = esc_sql( $activity_date );	
			
			$add_query_where = compact('user_id','activity_name','activity_date');
		}
		
		$sql 	= $db->select( "stat_activity", $add_query_where );		
		$obj 	= $db->fetch_obj( $sql );
		$total 	= $db->num($sql);
		
		$retval = array( 'total' => $total, 'value' => $obj->activity_value );
		
		return $retval;
	}
	
	/**
	 * Entry activity using data
	 *
	 * @param array $data
	 * @param boolean $update_action
	 */
	public function entry_activity( $data, $update_action = false ){
		extract( $data, EXTR_SKIP);
		
		global $db; 
		
		$json = new JSON();
		
		$activity_value = $json->encode($activity_value);
		
		if( $update_action ) :
			$db->update('stat_activity',compact('activity_value','activity_img'), compact('user_id','activity_name','activity_date'));
		else :
			$db->insert('stat_activity',compact('user_id','activity_name','activity_img','activity_date','activity_value'));
		endif;
		
	}
	
	public function get_activity_all( $where = null, $order_by = null ){
		global $db;
			
		$json 	= new JSON();
		$retval_get_activity = array();	
			
		$sql = $db->select( "stat_activity", $where, $order_by );		
		while( $obj = $db->fetch_obj( $sql ) ){
			
			if( empty($obj->activity_value) )
				return false;
				 
			$get_activity = $json->decode( $obj->activity_value );
						
			foreach( $get_activity as $xy){
				$activity_img = 'default';
				if( file_exists( libs_path . 'img/activity/'.$obj->activity_img.'.png') ) 
					$activity_img = $obj->activity_img;
					
				$retval_get_activity[] = array(
					'activity_name' => $obj->activity_name,
					'activity_img' => $activity_img,
					'activity' => $xy->{'activity'},
					'user_id' => $obj->user_id,
					'time' => $xy->{'time'},
					'clock' => $xy->{'clock'},
					'activity_date' => $obj->activity_date
					);
			}
		
		}
			
		return $retval_get_activity;
	}

}


//add_activity('lorem_ipsum','lorem ipsum');
function add_activity( $activity_name, $activity, $icon = null, $u_name = null ){
	$activity_recods = new activity_recods();
	$activity_recods->add_activity( $activity_name, $activity, $icon, $u_name );
}

function get_activity_all( $where = null, $order_by = null, $limit = 10, $add_style = null ){
	$activity_recods = new activity_recods();
	
	$warna 	= '';
	$i = 0;
	
	$get_activity_all = $activity_recods->get_activity_all( $where = null, $order_by = null );
	$retval = '<ul class="sidemenu" '.$add_style.'>';
	
	$get_activity_all = array_multi_sort($get_activity_all, array('activity_date' =>SORT_DESC, 'clock' => SORT_DESC));
	
	foreach( $get_activity_all as $xy){
		$warna 	= empty ($warna) ? ' style="background:#f9f9f9"' : '';	
		
		if( $i <= $limit ){
			$retval .= '<li'.$warna.'><img src="libs/img/activity/'.$xy['activity_img'].'.png" style="float:left; width:20px; height:20px; margin-right:5px;"><div style="margin-left:28px; ">'.$xy['activity'];
			$retval .= '<div style="clear:both;"></div>';
			$retval .= '<strong>'.$xy['user_id'].'</strong>, '.time_stamp($xy['time']);
			//$retval .= $xy['user_id'].', '.$xy['time'].', ';
			//$retval .= datetimes( $xy['activity_date'] , false);
			$retval .= '<div style="clear:both; padding-bottom:5px;"></div></li>';
		}
		$i = ($i + 1);
	}
		
	if( $i == 0 ) $retval .= '<div class="padding"><p id="error_no_ani">No data recording</p></div>';
	
	$retval .= '</ul>';
			
	return $retval;
}

function get_activity_now( $limit, $add_style ){	
	return get_activity_all( array( 'activity_date' => date('Y-m-d') ), 'ORDER BY activity_date DESC', $limit, $add_style );
}

function get_activity_me( $limit, $add_style ){
	global $login;
	
	$user_id = $login->exist_value('user_name');	
	return get_activity_all( compact( 'user_id' ), 'ORDER BY activity_date DESC', $limit, $add_style);
}

