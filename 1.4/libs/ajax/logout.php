<?php
/**
 * @file user.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;


global $login;

if( 'libs/ajax/logout.php' == is_load_values() ):

if( !empty($_POST['submitProcessClear']) ){
	$login->login_out(true);
	$response['status'] = 2;
	$response['msg'] = 'Logout and clear data log success, please wait for redirect.';
	
	header('Content-type: application/json');	
	echo json_encode($response);
}else{
?>
<div class="padding">
<form action="" method="post">
Yakin ingin keluar dari administrator?
<input type="hidden" name="submitProcessClear" value="1">
</form>
</div>
<?php
}

endif;
?>