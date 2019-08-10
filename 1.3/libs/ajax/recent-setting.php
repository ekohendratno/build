<div class="padding">
<?php
if( checked_option( 'recent_reg_limit' )  ) $recent_reg_limit = get_option('recent_reg_limit');
else $recent_reg_limit = 10;

if( isset($_POST['submitRecReg']) ){
	$txt_recent_reg_limit = $_POST['txtShow'];
	if( checked_option( 'recent_reg_limit' ) ) set_option( 'recent_reg_limit', $txt_recent_reg_limit );
	else add_option( 'recent_reg_limit', $txt_recent_reg_limit );
}
?>
<label for="txtShow">Jumlah yang di tampilkan</label>
<input id="txtShow" name="txtShow" type="text" style="width:50px" value="<?php echo $recent_reg_limit;?>" />
</div>