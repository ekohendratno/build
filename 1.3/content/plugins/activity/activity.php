<?php
/**
 * @file: activity-records.php
 * @dir: content/plugins/activity/
 */
 
/*
Plugin Name: Activity Records
Plugin URI: http://cmsid.org/#
Description: Plugin bla bla bla
Author: Eko Azza
Version: 1.2
API Key: 5oeoKF5VAuoVkc7Q0VHM
Author URI: http://cmsid.org/
*/ 

if(!defined('_iEXEC')) exit;

function activity_records(){
	
ob_start();
?>
<style type="text/css">
.tab_activity_records
{
	padding:0;
}
.tab_activity_records ul.ul-box
{
	
}
ul.activity_records
{
	margin: 0;
	padding: 0;
	float: left;
	list-style: none;
	height: 25px;
	margin-left:3px;
	margin-right:0;
	margin-top:2px;
}
ul.activity_records li 
{
	float: left;
	margin: 0;
	padding: 0;
	height: 24px;
	line-height: 24px;
	border: 1px solid #ddd;
	margin-right:2px;
	overflow: hidden;
	font-weight:normal;
    border-top-left-radius: 2px;
    border-top-right-radius: 2px;
    -moz-border-radius-topleft: 2px;
    -moz-border-radius-topright: 2px;
}
ul.activity_records li a
{
	text-decoration: none;
	display: block;
	padding: 0 5px 0 5px;
	outline: none;
}
ul.activity_records li a:hover 
{
	background: #f2f2f2;
    border-top-left-radius: 2px;
    border-top-right-radius: 2px;
    -moz-border-radius-topleft: 2px;
    -moz-border-radius-topright: 2px;
}
html ul.activity_records li.active,
html ul.activity_records li.active a:hover
{
	background: #f2f2f2;
	border-bottom: 1px solid #ccc;
	border-bottom-style:dotted;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	getLoad('activity_view','?request&load=activity/data.php&plg=yes');	
});	
</script>
<div id="activity_view"></div>
<?php
		
$activity_records_box = ob_get_contents();
ob_end_clean();	
return $activity_records_box;

}

function activity_records_echo(){ 
	echo activity_records(); 
} 

add_dashboard_widget( 'activity_records', 'Activity Records', 'activity_records_echo', array('href'=>'?request&plg=yes&load=activity/data.php&aksi=edit', 'data-type'=>'edit') );

function activity_records_widget_init(){
	global $widget;
	
	if( checked_option( 'activity_record_echo_limit' )  ) $activity_record_echo_limit = get_option('activity_record_echo_limit');
	else $activity_record_echo_limit = 50; //limit default
	
	$add_style = 'style="max-height:350px;"';
	
	$widget = array();
	$widget['gadget'][] = array(
		'title' => 'Activity Records',
		'desc' 	=> activity_records($activity_record_echo_limit,$add_style)
	);
	return;
}

function activity_recods_init(){
	
	if ( !class_exists('activity_recods') )
		require( plugin_path . '/activity/class.php' );

	if( is_sys_values() == 'options' && !get_query_var('go') )
		add_action('add_templates_manage', 'activity_records_widget_init');
	
}	
add_action('plugins_loaded', 'activity_recods_init');

//add_activity('lorem_ipsum','lorem ipsum');
function add_activity( $activity_name, $activity, $icon = null, $u_name = null ){
	$activity_recods = new activity_recods();
	$activity_recods->add_activity( $activity_name, $activity, $icon, $u_name );
}

function get_activity_all( $where = null, $order_by = null, $limit = 10, $add_style = null ){
	$activity_recods = new activity_recods();
	
	$warna 	= 'white';
	$i = 0;
	$limit = $limit - 1;
	
	if( !empty( $where['activity_date'] ) ) 
		$activity_date = $where['activity_date']; 
	
	$get_activity_all = $activity_recods->get_activity_all( $where = null, $order_by = null );
	
	$get_activity_all = array_multi_sort($get_activity_all, array('activity_date' =>SORT_DESC, 'clock' => SORT_DESC));
	
	$show_activity = true;
	foreach( $get_activity_all as $xy){
		$warna 	= ( $warna == 'white' ) ? 'gray' : 'white';
		
		if( $activity_date && $xy['activity_date'] != $activity_date )
			$show_activity = false;
		
		if( $i <= $limit && $show_activity ){
			$li .= '<li class="'.$warna.'"><img src="'. plugin_url . '/activity/img/' . $xy['activity_img'] . '.png" style="float:left; width:20px; height:20px; margin-right:5px;"><div style="margin-left:28px; ">' . $xy['activity'];
			$li .= '<div style="clear:both;"></div>';
			$li .= '<strong>' . $xy['user_id'] . '</strong>, ' . time_stamp($xy['time'] );
			//$li .= $xy['user_id'].', '.$xy['time'].', ';
			//$li .= datetimes( $xy['activity_date'] , false);
			$li .= '<div style="clear:both; padding-bottom:5px;"></div></li>';
		}
		$i = ($i + 1);
	}
	$ul = '<ul class="sidemenu" '.$add_style.'>';
	$ul.= $li . '</ul>';
		
	if( $i == 0 ) $ul = '<div class="padding"><p id="error_no_ani">No data recording</p></div>';
	elseif( $activity_date && empty($li) ) $ul = '<div class="padding"><p id="message_no_ani">No data found</p></div>';
			
	return $ul;
}

function get_activity_now( $limit = 10, $add_style = null ){	
	return get_activity_all( array( 'activity_date' => date('Y-m-d') ), 'ORDER BY activity_date DESC', $limit, $add_style );
}

function get_activity_me( $limit = 10, $add_style = null ){
	global $login;
	
	$user_id = $login->exist_value('username');	
	return get_activity_all( compact( 'user_id' ), 'ORDER BY activity_date DESC', $limit, $add_style);
}


