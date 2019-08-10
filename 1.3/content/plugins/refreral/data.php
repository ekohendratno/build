<?php
/**
 * @file data.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $login;

if( 'refreral/data.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') 
):

if( checked_option( 'referal_limit' )  ) $referal_limit = get_option('referal_limit');
else $referal_limit = 10;

if( isset($_POST['txtShow']) ){	
	$txt_phpids_limit = filter_int( $_POST['txtShow'] );
	if( checked_option( 'referal_limit' ) ){
		set_option( 'referal_limit', $txt_phpids_limit );
		$response['status'] = 1;
		$response['msg'] = 'Edit success.';
	}else{
		add_option( 'referal_limit', $txt_phpids_limit );
		$response['status'] = 1;
		$response['msg'] = 'Add success.';
	}
	header('Content-type: application/json');	
	echo json_encode($response);
}elseif( isset($_POST['submitReferalClear']) ){	
	if( $db->truncate('stat_urls') ){
		$response['status'] = 1;
		$response['msg'] = 'Clear data success.';
	}else{
		$response['status'] = 3;
		$response['msg'] = 'Clear data error.';
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
			url: BASE_URL + '/?request&plg=yes&load=refreral/data.php', 
			data: 'submitProcessClear=1', 
			success: function(data) {}
		});
	});
});
</script>
<div class="padding">
<form method="post" action="">
<label for="txtShow">Jumlah yang di tampilkan</label>
<input id="txtShow" name="txtShow" type="text" style="width:50px" value="<?php echo $referal_limit;?>" /> or 
<button class="red" id="submitProcessClear" name="submitProcessClear">Hapus semua jejak rekaman</button>
</form>
</div>
<?php
}
endif;
?>