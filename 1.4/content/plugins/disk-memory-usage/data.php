<?php
/**
 * @file data.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $login;

if( 'disk-memory-usage/data.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') 
):

if( checked_option( 'disk_limit' )  ) $disk_limit = get_option('disk_limit');
else $disk_limit = 50; //desk default

if( isset($_POST['txtDiskLimit']) ){
	$txt_disk_limit = filter_int( $_POST['txtDiskLimit'] );
	if( checked_option( 'disk_limit' ) ){
		set_option( 'disk_limit', $txt_disk_limit );
		$response['status'] = 1;
		$response['msg'] = 'Edit success.';
	}else{
		add_option( 'disk_limit', $txt_disk_limit );
		$response['status'] = 1;
		$response['msg'] = 'Add success.';
	}
	header('Content-type: application/json');	
	echo json_encode($response);
}else{
?>
<div class="padding">
<form>
<label for="txtDiskLimit">Disk Your Host Limit : </label>
<input id="txtDiskLimit" name="txtDiskLimit" type="text" style="width:50px" value="<?php echo $disk_limit;?>" /> MByte
</form>
</div>
<?php
}
endif;