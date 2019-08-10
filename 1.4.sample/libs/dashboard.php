<?php 
/**
 * @fileName: dashboard.php
 * @dir: libs/
 */
if(!defined('_iEXEC')) exit;

function dashboard() {
	global $screen_layout_columns;

	$hide2 = $hide3 = $hide4 = '';
	switch ( $screen_layout_columns ) {
		case 4:
			$width = 'width:25%;';
			break;
		case 3:
			$width = 'width:33.333333%;';
			$hide4 = 'display:none;';
			break;
		case 2:
			$width = 'width:50%;';
			$hide3 = $hide4 = 'display:none;';
			break;
		default:
			$width = 'width:100%;';
			$hide2 = $hide3 = $hide4 = 'display:none;';
	}
	do_action('the_notif');
	
	echo '<div id="dashboard-widgets" class="metabox-holder">';
	echo "\t<div class='column column0' id='column0' style='$width'>\n";
	do_meta_boxes( 'normal', '' );

	echo "\t</div><div class='column column1' id='column1' style='{$hide2}$width'>\n";
	do_meta_boxes( 'side', '' );
	
	echo '</div>';
	echo '<div style="clear:both;"></div>';
	echo '</div>';
}
	
function dashboard_update_info(){ 
	global $version_system, $version_project, $version_beta;
    ?>	
	<div class="padding">
	<p>Versi system anda <?php echo $version_system . ' '.$version_project.' '.$version_beta;?>, pastikan versi yang anda pakai adalah versi terbaru, agar situs anda aman dan mengurangi kemungkinan masalah yang ada pada situs anda.</p>
	<div style="margin-top:5px"><a id="popup" title="Information" href="?request&amp;load=libs/ajax/latest.php" data-type="show" class="button popupCore black icon-latest-upgrade">Cek Pembaruan Terbaru</a></div>
	<div style="clear:both"></div>
	<br /></div>
 <?php
}


function dashboard_feed_news(){ 
?>
<!--start-tabs-->
<div id="feed_news_view"></div>
<!--end-tabs-->
<?php
}

function dashboard_quick_post(){ 
?>
<div class="padding"><div style="clear:both"></div>    
<?php

if(isset($_POST['post_publish']) || isset($_POST['post_draf'])){
	
	$title 		= filter_txt($_POST['title']);
	$category 	= filter_int($_POST['category']);
	
	if(get_option('text_editor')=='classic') $isi = nl2br2($_POST['isi']);
	else $isi = $_POST['isi'];
	
	$tags 		= filter_txt($_POST['tags']);
	$date 		= date('Y-m-d H:i:s');
	
	if(isset($_POST['post_draf'])) $status = 0;
	else $status = 1;
	
	$type 		= 'post';
	$approved	= 1;
	
	$data = compact('title','category','type','isi','tags','date','status');
	add_quick_post($data);
}
?>
<form action="" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td colspan="2"><input type="text" id="judul" name="title" placeholder="Judul Posting" required style="width:97%;" /></td>
    </tr>
    <tr>
      <td colspan="2"><?php the_editor('','editor_quick_post', array('editor_name' => 'isi','editor_style' => 'height:100px;width:97%;'), array( 'toolbar' => 'simple', 'css' => 'wym-simple.css') );?></td>
    </tr>
    <tr>
      <td width="45%">
      <select name="category">
      <option value="">Pilih Category</option>
	  <?php echo list_category_op();?>
      </select></td>
      <td width="45%" align="right"><input id="tags" type="text" name="tags" placeholder="Tag ex: news,top,etc." /></td>
    </tr>
    <tr>
      <td colspan="2"><div class="left"><input type="submit" name="post_draf" value="Save Draf" class="button l black"/><input type="reset" value="Reset" class="button r"/></div><div class="right"><input type="submit" name="post_publish" value="Publish" class="button on blue"/></div></td>
    </tr>
  </table>

</form>

</div>
<?php
}

function dashboard_recent_registration(){ 
?>
<!--start-tabs-->
<div id="recent_reg_view"></div>
<!--end-tabs-->
<?php

}

function dashboard_init() {
do_action('dashboard_init');
	
?>
<script type="text/javascript">
var base_url = '<?php echo site_url();?>';

$(document).ready(function(){	
getLoad('recent_reg_view','?request&load=libs/ajax/recent.php');
getLoad('feed_news_view','?request&load=libs/ajax/feed.php');
 
});

function updateWidgetData(){
	var sortorder = new Array();
	$('#dashboard-widgets').each(function(){
		var dwa = $(this);	
		$('.column .meta-box-sortables').each(function(i){		
			var sortorder_by = $(this).attr('id').replace(/-sortables/i,'');
			$('.dragbox', this).each(function(i){
				
				if( 'normal' == sortorder_by )
					sortorder.push( {normal:$(this).attr('id')} );				
				else if( 'side' == sortorder_by )
					sortorder.push( {side:$(this).attr('id')} );
				
			});
		});	
	});
	
	var normal_array = new Array();
	var side_array = new Array();
	for(i=0; i < sortorder.length; i++){
		if( sortorder[i].normal ) normal_array.push( sortorder[i].normal );
		else if( sortorder[i].side ) side_array.push( sortorder[i].side );
	}
	
	var normal_string = '';
	var side_string = '';
	for(i=0; i < normal_array.length; i++){
		normal_string+= normal_array[i]+',';
	}
	
	for(i=0; i < side_array.length; i++){
		side_string+= side_array[i]+',';
	}
	
	var set_sortorder = {normal:normal_string,side:side_string};
	//console.log(set_sortorder);
			
	//Pass sortorder variable to server using ajax to save state
	//$.post('irequest.php?auto', 'sort='+$.toJSON(sortorder));
	//autosave(sortorder);
	$.post( base_url +'/?request=dashboard', 'data='+$.toJSON( set_sortorder ), function(response){});
		/*	   
		var winHeight = $(window).height();
		var winWidth = $(window).width();
		$('#redactor_modal_console').css({
			top: '15%',
			left: winWidth / 2 - $('#redactor_modal_console').width() / 2
		});
        $('#redactor_modal_overlay_loading,#redactor_modal_console').show().fadeOut('slow');*/
	
}

function show_empty_container(){
	$(".column .meta-box-sortables").each(function(index, element) {
		var t = $(this);
		if ( !t.children('.gd:visible').length )
			t.addClass('empty-container');
		else
			t.removeClass('empty-container');
	});
}
</script>	
<?php
}

function dashboard_setup() {
	global $current_screen;
	$current_screen->render_screen_meta();
	
	add_dashboard_widget( 'dashboard_update_info', 'Information', 'dashboard_update_info' );
	add_dashboard_widget( 'dashboard_quick_post', 'Quick Post', 'dashboard_quick_post' );
	add_dashboard_widget( 'dashboard_recent_registration', 'Recent Registration', 'dashboard_recent_registration', array('href'=>'?request&load=libs/ajax/recent.php&aksi=edit', 'data-type'=>'edit') );
	add_dashboard_widget( 'dashboard_feed_news', 'Feed News', 'dashboard_feed_news', array('href'=>'?request&load=libs/ajax/feed.php&aksi=edit', 'data-type'=>'edit') );
}

function add_dashboard_widget( $widget_id, $widget_name, $callback, $setting = null ) {

	$side_widgets = array('dashboard_quick_post', 'dashboard_recent_registration');

	$location = 'normal';
	if ( in_array($widget_id, $side_widgets) )
		$location = 'side';

	$priority = 'core';
	if ( 'dashboard_update_info' === $widget_id )
		$priority = 'high';

	add_meta_box( $widget_id, $widget_name, $callback, $location, $priority, $setting );
}

function add_meta_box( $id, $title, $callback, $context = 'advanced', $priority = 'default', $setting = null ) {
	global $meta_boxes;
	//call do_meta_boxes in screen.php

	if ( !isset($meta_boxes) )
		$meta_boxes = array();
	if ( !isset($meta_boxes[$context]) )
		$meta_boxes[$context] = array();

	foreach ( array_keys($meta_boxes) as $a_context ) {
		foreach ( array('high', 'core', 'default', 'low') as $a_priority ) {
			if ( !isset($meta_boxes[$a_context][$a_priority][$id]) )
				continue;

			if ( 'core' == $priority ) {
				if ( false === $meta_boxes[$a_context][$a_priority][$id] )
					return;
				if ( 'default' == $a_priority ) {
					$meta_boxes[$a_context]['core'][$id] = $meta_boxes[$a_context]['default'][$id];
					unset($meta_boxes[$a_context]['default'][$id]);
				}
				return;
			}
			
			if ( empty($priority) ) {
				$priority = $a_priority;
			} elseif ( 'sorted' == $priority ) {
				$title = $meta_boxes[$a_context][$a_priority][$id]['title'];
				$callback = $meta_boxes[$a_context][$a_priority][$id]['callback'];
				$setting = $meta_boxes[$a_context][$a_priority][$id]['setting'];
			}
			
			if ( $priority != $a_priority || $context != $a_context )
				unset($meta_boxes[$a_context][$a_priority][$id]);
		}
	}

	if ( empty($priority) )
		$priority = 'low';

	if ( !isset($meta_boxes[$context][$priority]) )
		$meta_boxes[$context][$priority] = array();

	$meta_boxes[$context][$priority][$id] = array('id' => $id, 'title' => $title, 'callback' => $callback, 'setting' => $setting);
}

