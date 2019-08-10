<?php
/**
 * @file: shoutbox.php
 * @dir: content/plugins
 */
 
/*
Plugin Name: Shoutbox
Plugin URI: http://cmsid.org/#
Description: Plugin widget untuk shoutbox 
Author: Eko Azza
Version: 2.3
Author URI: http://cmsid.org/
*/ 

if(!defined('_iEXEC')) exit;

add_action('widget_shoutbox_form', 'shoutbox_register');
function shoutbox_register() {
	?>
	<script src="<?php echo plugins_url();?>/shoutbox/js/xmlhttp.js"></script>
	<script src="<?php echo plugins_url();?>/shoutbox/js/prototype.js"></script>
	<script src="<?php echo plugins_url();?>/shoutbox/js/shoutbox.js" language="javascript"></script>
    <?php
}
function widget_shoutbox_form(){
	do_action('widget_shoutbox_form');
?>
<form id="formShoutBox">
    <table width="100%">
        <tr><td colspan="2">
			<div id="divShoutBoxList" style="border:1px solid #ddd;overflow:auto;height:250px; min-width:150px; padding:3px;">
			<center><div id="loading" align="center"></div>
        	<img alt="wait.." src="<?php echo plugins_url();?>/shoutbox/waiting.gif" />
        	</center>
		</div>
        </td></tr>
        <tr><td>Nama<span class="req">*</span></td><td>
        <input type="text" name="nama" id="nama" style="width:60%">
        </td></tr>
        <tr><td>E-Mail<span class="req">*</span></td><td>
        <input type="text" name="email" id="email" style="width:60%">
        </td></tr>
        <tr><td valign="top">Pesan<span class="req">*</span></td><td>
        <textarea style="width:90%; height:40px" name="pesan" id="pesan" onKeyPress="check_length(this.form); onKeyDown=check_length(this.form);"></textarea>
        </td></tr>
        <tr><td valign="top">&nbsp;</td><td>
        <input type="text" value=225 name=text_num disabled="disabled" size="3" readonly > huruf lagi
        </td></tr>
        <tr><td valign="top">&nbsp;</td><td>
        <input name="submitButton" type="submit" id="submitButton" value="Kirim">
        </td></tr>
    </table>
</form>
<?php
}

class Widget_Shoutbox extends Widgets {

	function __construct() {
		$widget_ops = array('classname' => 'widget_shoutbox', 'description' => "Shout your message in box" );
		parent::__construct('shoutbox', 'Shoutbox', $widget_ops);
	}

	function widget( $args ) {
	global $login;
		extract($args);
		$title = 'Shoutbox';

		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title;
			
		widget_shoutbox_form();
			
		echo $after_widget;
	}
}

register_widget('Widget_Shoutbox');

function shoutbox_widget_init(){
	global $widget;
	
	$widget = array();
	$widget['gadget'][] = array(
		'title' => 'Shoutbox Today',
		'desc' 	=> shoutbox_message( 'today' )
	);
	return;
}

if(is_sys_values() == 'plugins' 
&& get_query_var('go') == 'setting' 
&& get_query_var('plugin_name') == 'shoutbox' )
   add_action('add_templates_manage', 'shoutbox_widget_init');
	
function shoutbox_message( $type = 'all', $template = null ){
	global $db;
	
	if( checked_option( 'shoutbox_echo_limit' )  ) $shoutbox_echo_limit = get_option('shoutbox_echo_limit');
	else $shoutbox_echo_limit = 50; //limit default
	
	$warna = 'white';
	
	$message = '<ul class="sidemenu" style="max-height:400px;">';
	
	$add_query = '';
	if( $type == 'today' ) 
	$add_query = "WHERE DATE(`waktu`) = CURDATE()";
	
	$sql = $db->query( "SELECT * FROM $db->shoutbox $add_query ORDER BY waktu DESC LIMIT $shoutbox_echo_limit" );
	
	if( $db->num($sql) < 1 )
	$message .= '<div class="padding"><div id="message_no_ani">No comment</div></div>';
	
	while( $row = $db->fetch_obj( $sql ) ){
		$warna 	= ( $warna == 'white' ) ? 'gray' : 'white';
		
		$data = array(
			'template'	=> $template,
			'warna'		=> $warna,
			'row'		=> $row
		);
		
		$message .= template_shoutbox_message( $data );
	}
	$message .= '<ul>';
	
	return $message;
}

function template_shoutbox_message($data){
	extract($data,EXTR_SKIP);
	
	$content = '';
	switch( $template ){
		default:
			$content .= '<li class="'.$warna.'"><img src="'.get_gravatar($row->email).'" style="float:left; width:40px; height:40px; margin-right:5px;" class="radius">'.$row->nama. ', ' .date_stamp($row->waktu) . '<br>';
			$content .= '<div style="float:left; width:60%; padding-top:4px;">';
			$content .= '<a href="?admin&sys=plugins&go=setting&plugin_name=shoutbox&file=/shoutbox.php&act=del&id='.$row->id.'" class="button button4 red" onclick="return confirm(\'Are You sure delete this post?\')">Hapus</a>';
			$content .= '</div>'; 
			$content .= '<div style="clear:both; padding-bottom:5px;"></div>'; 
			$content .= '<p>'.$row->pesan.'</p></li>';
		break;
		case "widget":
			$content .= '<li class="'.$warna.'">';
			$content .= '<div style="float:left; width:12%; height:100%;">'; 
			$content .= '<img src="'.get_gravatar($row->email).'" style="float:left; width:40px; height:40px; margin-right:5px;" class="radius">';
			$content .= '</div>';
			$content .= '<div style="float:left; width:70%; height:100%;">'; 
			$content .= '<strong>'.$row->nama. '</strong>, ' .date_stamp($row->waktu);
			$content .= '<br>';
			$content .= $row->pesan;
			$content .= '</div>';
			$content .= '<div style="float:right; width:50px; height:100%;">';
			$content .= '<a href="?admin&sys=plugins&go=setting&plugin_name=shoutbox&file=/shoutbox.php&act=del&id='.$row->id.'" class="button button4 red" onclick="return confirm(\'Are You sure delete this post?\')" style="float:right;">Hapus</a>';
			$content .= '</div>'; 
			$content .= '<div style="clear:both; padding-bottom:5px;"></div>'; 
			$content .= '</li>';
		break;
	}
	return $content;
}

function shoutbox_filter( $text = '', $target = '_blank' ){
	//filter link
	$text = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $text));
    $data = '';
    foreach( explode(' ', $text) as $str){
        if (preg_match('#^http?#i', trim($str)) || preg_match('#^www.?#i', trim($str))) {
            $data .= '<a href="'.$str.'" target="'.$target.'">click here</a> ';
        } else {
            $data .= $str .' ';
        }
    }
    return trim($data);
}


function shoutbox_records(){
	
ob_start();
?>
<style type="text/css">
.tab_shoutbox_records
{
	padding:0;
}
.tab_shoutbox_records ul.ul-box
{
	
}
ul.shoutbox_records
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
ul.shoutbox_records li 
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
ul.shoutbox_records li a
{
	text-decoration: none;
	display: block;
	padding: 0 5px 0 5px;
	outline: none;
}
ul.shoutbox_records li a:hover 
{
	background: #f2f2f2;
    border-top-left-radius: 2px;
    border-top-right-radius: 2px;
    -moz-border-radius-topleft: 2px;
    -moz-border-radius-topright: 2px;
}
html ul.shoutbox_records li.active,
html ul.shoutbox_records li.active a:hover
{
	background: #f2f2f2;
	border-bottom: 1px solid #ccc;
	border-bottom-style:dotted;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
	getLoad('shoutbox_view','?request&load=shoutbox/data.php&plg=yes&aksi=widget');	
});	
</script>
<div id="shoutbox_view"></div>
<?php
		
$shoutbox_records_box = ob_get_contents();
ob_end_clean();	
return $shoutbox_records_box;

}

function shoutbox_widget_echo(){ 
	echo shoutbox_records(); 
} 

add_dashboard_widget( 'shoutbox_widget', 'Shoutbox Message', 'shoutbox_widget_echo', array('href'=>'?request&plg=yes&load=shoutbox/data.php&aksi=edit', 'data-type'=>'edit') );