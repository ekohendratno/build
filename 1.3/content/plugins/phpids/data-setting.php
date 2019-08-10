<?php
if( checked_option( 'phpids_limit' )  ) $phpids_limit = get_option('phpids_limit');
else $phpids_limit = 10;
?>
<div class="padding">
<label for="txtShow">Jumlah yang di tampilkan</label>
<input id="txtShow" name="txtShow" type="text" style="width:50px" value="<?php echo $phpids_limit;?>" />
</div>
<?php
if( isset($_POST['submitPHPids']) ){
	$txt_phpids_limit = (int)$_POST['txtShow'];
	if( checked_option( 'phpids_limit' ) ) set_option( 'phpids_limit', $txt_phpids_limit );
	else add_option( 'phpids_limit', $txt_phpids_limit );
}

if( isset($_POST['submitPHPidsClear']) ){	
	$clear = $db->truncate('phpids');
}

?>