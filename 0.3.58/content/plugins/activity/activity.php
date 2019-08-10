<?php
/**
 * @file: activity-records.php
 * @dir: content/plugins
 */
 
/*
Plugin Name: Activity Records
Plugin URI: http://cmsid.org/#
Description: Plugin bla bla bla
Author: Eko Azza
Version: 1.1.0
Author URI: http://cmsid.org/
*/ 

if(!defined('_iEXEC')) exit;

function activity_records( $activity_record_echo_limit = null, $add_style = null ){
	
	$box_content = '
	<div style="clear:both"><br></div>
	<ul class="activity_records">
	<li class="active"><a href="#recod-all">All</a></li>
	<li><a href="#recod-now">Now</a></li>
	<li><a href="#recod-me">Me</a></li>
	</ul>
	<div style="clear:both"></div>
	<div class="tabs-content">
	<div id="recod-all" class="tab_activity_records" style="display: block; ">
	'.get_activity_all( null, null, $activity_record_echo_limit, $add_style ).'
	</div>
	<div id="recod-now" class="tab_activity_records" style="display: none; ">
	'.get_activity_now( $activity_record_echo_limit, $add_style ).'
	</div>
	<div id="recod-me" class="tab_activity_records" style="display: none; ">
	'.get_activity_me( $activity_record_echo_limit, $add_style ).'
	</div>
	</div>
	<div style="clear:both"></div>';
		
	return $box_content;
}

function activity_records_echo(){ 
global $db;

if( checked_option( 'activity_record_echo_limit' )  ) $activity_record_echo_limit = get_option('activity_record_echo_limit');
else $activity_record_echo_limit = 50; //limit default


$dp_content = '<div class="padding">';
$dp_content.= '<label for="txtActivityRecords">Limit Show :</label>';
$dp_content.= '<input id="txtActivityRecords" name="txtActivityRecords" type="text" style="width:50px" value="'. $activity_record_echo_limit.'" />';
$dp_content.= '</div>';

$dp_footer = '<div style="float:left"><input id="rec_submit" type="submit" name="submitActivityRecords" value="Submit" class="button on l" /><input type="reset" name="Reset" value="Reset" class="button r" /></div>
<div style="float:right"><input onclick="return confirm(\'Are You sure delete all records?\')" id="rec_submit" type="submit" name="submitActivityRecordsClear" value="Set to Empty" class="button red" /></div>';

$setting = array(
	'dp_id' => 'activity_records',
	'dp_title' => 'Pengaturan Activity Records',
	'dp_content' => $dp_content,	
	'dp_footer' => $dp_footer
);
add_dialog_popup( $setting );
?>

<div style="clear:both"></div>
<?php 
if( isset($_POST['submitActivityRecords']) ){
	$activity_record_echo_limit = $_POST['txtActivityRecords'];
	if( checked_option( 'activity_record_echo_limit' ) ) set_option( 'activity_record_echo_limit', $activity_record_echo_limit );
	else add_option( 'activity_record_echo_limit', $activity_record_echo_limit );
	
	redirect('?admin');
}

if( isset($_POST['submitActivityRecordsClear']) ){
	
	$clear = $db->truncate('stat_activity');
	
	if( $clear )
	redirect('?admin');
}

echo activity_records($activity_record_echo_limit);
 
} 

add_dashboard_widget( 'activity_records', 'Activity Records', 'activity_records_echo', true );

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

	$sql = "CREATE TABLE IF NOT EXISTS `".DB_PRE."stat_activity` (
			`activity_id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` varchar(30) NOT NULL,
			`activity_name` varchar(80) NOT NULL,
			`activity_value` longtext NOT NULL,
			`activity_img` text NOT NULL,
			`activity_date` date NOT NULL,
			PRIMARY KEY (`activity_id`) )";
	
	if ( !class_exists('activity_recods') )
		require( plugin_path . '/activity/class-activity.php' );

	if( is_sys_values() == 'options' )
		add_action('add_templates_manage', 'activity_records_widget_init');
	
}	
add_action('plugins_loaded', 'activity_recods_init');