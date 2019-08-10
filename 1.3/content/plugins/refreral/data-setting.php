<?php

if( checked_option( 'referal_limit' )  ) $referal_limit = get_option('referal_limit');
else $referal_limit = 10;
?>
<div class="padding">
<label for="txtShow">Jumlah yang di tampilkan</label>
<input id="txtShow" name="txtShow" type="text" style="width:50px" value="<?php echo $referal_limit;?>" />
</div>
<?php
if( isset($_POST['submitReferal']) ){
	$txt_referal_limit = $_POST['txtShow'];
	if( checked_option( 'referal_limit' ) ) set_option( 'referal_limit', $txt_referal_limit );
	else add_option( 'referal_limit', $txt_referal_limit );
}

if( isset($_POST['submitReferalClear']) ){	
	$clear = $db->truncate('stat_urls');
}

?>