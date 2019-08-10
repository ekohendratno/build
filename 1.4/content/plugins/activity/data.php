<?php
/**
 * @file data.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $login;

if( 'activity/data.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') 
):

if( checked_option( 'activity_record_echo_limit' )  ) $activity_record_echo_limit = get_option('activity_record_echo_limit');
else $activity_record_echo_limit = 50; //limit default

switch($_GET['aksi']){
	default:
?>
<script type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){
	
$(".tab_activity_records").hide();
$(".tab_activity_records:first").show();
$("ul.activity_records li:first").addClass("active").show();
$("ul.activity_records li").click(function() {
	$("ul.activity_records li").removeClass("active");
	$(this).addClass("active");
	$(".tab_activity_records").hide();
	var activeTab = $(this).find("a").attr("href");
	$(activeTab).slideDown('slow');
	return false;
});

});
/* ]]> */
</script>	
<div style="clear:both"></div>
<ul class="activity_records">
	<li class="active"><a href="#recod-all">Semua</a></li>
	<li><a href="#recod-now">Sekarang</a></li>
	<li><a href="#recod-me">Saya</a></li>
</ul>
<div style="clear:both"></div>
<div class="tabs-content">
	<div id="recod-all" class="tab_activity_records" style="display: block; ">
	<?php echo get_activity_all( null, null, $activity_record_echo_limit )?>
	</div>
	<div id="recod-now" class="tab_activity_records" style="display: none; ">
	<?php echo get_activity_now( $activity_record_echo_limit )?>
	</div>
	<div id="recod-me" class="tab_activity_records" style="display: none; ">
	<?php echo get_activity_me( $activity_record_echo_limit )?>
	</div>
</div>
<div style="clear:both"></div>
<?php
	break;
	case 'edit':
if( isset($_POST['txtShow']) ){
	$activity_record_echo_limit = filter_int( $_POST['txtShow'] );
	if( checked_option( 'activity_record_echo_limit' ) ){
		set_option( 'activity_record_echo_limit', $activity_record_echo_limit );
		$response['status'] = 1;
		$response['msg'] = 'Edit success.';
	}else{
		add_option( 'activity_record_echo_limit', $activity_record_echo_limit );
		$response['status'] = 1;
		$response['msg'] = 'Add success.';
	}
	header('Content-type: application/json');	
	echo json_encode($response);
}else{
?>
<script>
/* <![CDATA[ */
$(document).ready(function(){
	$('button#submitProcessClear').click(function() {
		$.ajax({ 
			type: 'POST', 
			url: BASE_URL + '/?request&plg=yes&load=activity/data.php&aksi=delete', 
			data: 'submitProcessClear=1', 
			success: function(data) {}
		});
	});
});
</script>

<div class="padding">
<form method="post" action="">
<label for="txtShow">Limit Show :</label>
<input id="txtShow" name="txtShow" type="text" style="width:50px" value="<?php echo $activity_record_echo_limit;?>" /> or <button class="red" id="submitProcessClear" name="submitProcessClear">Hapus semua jajak aktivitas</button>
</form>
</div>
<?php
}
	break;
	case 'delete':
	if( isset($_POST['submitProcessClear']) ){
		$db->truncate('stat_activity');
		$response['status'] = 1;
		$response['msg'] = 'Clear data success.';
	}else{
		$response['status'] = 3;
		$response['msg'] = 'Clear data error.';
	}
	header('Content-type: application/json');	
	echo json_encode($response);
	break;
}
endif;
?>