<?php
if( checked_option( 'disk_limit' )  ) $disk_limit = get_option('disk_limit');
else $disk_limit = 50; //desk default

?>

<div class="padding">
<label for="txtDiskLimit">Disk Your Host Limit : </label>
<input id="txtDiskLimit" name="txtDiskLimit" type="text" style="width:50px" value="<?php echo $disk_limit;?>" /> MByte
</div>
<?php

if( isset($_POST['submitDiskLimit']) ){
	$txt_disk_limit = $_POST['txtDiskLimit'];
	if( checked_option( 'disk_limit' ) ) set_option( 'disk_limit', $txt_disk_limit );
	else add_option( 'disk_limit', $txt_disk_limit );
	
	redirect('?admin');
}