<?php
/**
 * @file data.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $login;

if( 'phpids/data.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') 
):

if( checked_option( 'phpids_limit' )  ) $phpids_limit = get_option('phpids_limit');
else $phpids_limit = 10;


switch( $_GET['aksi'] ){
	default:
?>

<script type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){
	
$(".tab_phpids").hide();
$(".tab_phpids:first").show();
$("ul.phpids li:first").addClass("active").show();
$("ul.phpids li").click(function() {
	$("ul.phpids li").removeClass("active");
	$(this).addClass("active");
	$(".tab_phpids").hide();
	var activeTab = $(this).find("a").attr("href");
	$(activeTab).slideDown('slow');
	return false;
});

});
/* ]]> */
</script>
<div style="clear:both"></div>
<ul class="phpids">
	<li class="active"><a href="#phpids-now">Sekarang</a></li>
	<li><a href="#phpids-ip">IP</a></li>
	<li><a href="#phpids-impact">Pengaruh</a></li>
</ul>
<div style="clear:both"></div>
<div class="tabs-content">
	<div id="phpids-now" class="tab_phpids" style="display: block; ">
	<?php echo phpids_monitor( 'now', $phpids_limit );?>
	</div>
	<div id="phpids-ip" class="tab_phpids" style="display: none; ">
	<?php echo phpids_monitor( 'ip', $phpids_limit );?>
	</div>
	<div id="phpids-impact" class="tab_phpids" style="display: none; ">
	<?php echo phpids_monitor( 'impact', $phpids_limit );?>
	</div>
</div>
<div style="clear:both"></div>

<?php 
	break;
	case 'edit':
if( isset($_POST['txtShow']) ){
	$txt_phpids_limit = filter_int( $_POST['txtShow'] );
	if( checked_option( 'phpids_limit' ) ){
		set_option( 'phpids_limit', $txt_phpids_limit );
		$response['status'] = 1;
		$response['msg'] = 'Edit success.';
	}else{
		add_option( 'phpids_limit', $txt_phpids_limit );
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
			url: BASE_URL + '/?request&plg=yes&load=phpids/data.php&aksi=delete', 
			data: 'submitProcessClear=1', 
			success: function(data) {}
		});
	});
});
</script>

<div class="padding">
<form method="post" action="">
<label for="txtShow">Jumlah yang di tampilkan</label>
<input id="txtShow" name="txtShow" type="text" style="width:50px" value="<?php echo $phpids_limit;?>" /> or 
<button class="red" id="submitProcessClear" name="submitProcessClear">Hapus semua jejak rekaman</button>
</form>
</div>
<?php
}
	break;
	case 'delete':
	if( isset($_POST['submitProcessClear']) ){
		$db->truncate('phpids');
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