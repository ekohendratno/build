<?php
if( checked_option( 'activity_record_echo_limit' )  ) $activity_record_echo_limit = get_option('activity_record_echo_limit');
else $activity_record_echo_limit = 50; //limit default
?>
<div class="padding">
<label for="txtActivityRecords">Limit Show :</label>
<input id="txtActivityRecords" name="txtActivityRecords" type="text" style="width:50px" value="<?php echo $activity_record_echo_limit;?>" />
</div>

<div style="clear:both"></div>
<?php 
if( isset($_POST['submitActivityRecords']) ){
	$activity_record_echo_limit = $_POST['txtActivityRecords'];
	if( checked_option( 'activity_record_echo_limit' ) ) set_option( 'activity_record_echo_limit', $activity_record_echo_limit );
	else add_option( 'activity_record_echo_limit', $activity_record_echo_limit );
}

if( isset($_POST['submitActivityRecordsClear']) ){	
	$clear = $db->truncate('stat_activity');
}

?>