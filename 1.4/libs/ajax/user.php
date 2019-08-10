<?php
/**
 * @file user.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;


global $login, $db, $class_country;

if( 'libs/ajax/user.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') 
):

switch($_GET['aksi']){
	default:
	case 'detail':
if( !empty($_GET['user_id']) ){

$user_id = filter_int( $_GET['user_id'] );
$row = $db->fetch_obj( $db->query("SELECT * FROM $db->users WHERE ID='$user_id'") );
$avatar_img_profile = avatar_url($row->user_login,200,200);

if( $row < 1 ){
	echo '<div class="padding"><div id="error">ID error, akun not found</div></div>';
}else{
?>
<div class="padding" style="width:400px;">
<table width="100%" border="0" cellspacing="2" id="table">
  <tr class="head">
    <td colspan="3" style="text-align:center;"><img alt="" src="<?php echo $avatar_img_profile?>" height="200" width="200" style="-moz-border-radius: 3px;-khtml-border-radius: 3px;-webkit-border-radius: 3px;border-radius: 3px;"></td>
  </tr>
  <tr class="isi gray">
    <td width="24%">User Login</td>
    <td width="2%"><strong>:</strong></td>
    <td width="74%"><?php echo $row->user_login;?></td>
  </tr>
  <tr class="isi">
    <td>Name</td>
    <td><strong>:</strong></td>
    <td><?php echo $row->user_author;?></td>
  </tr>
  <tr class="isi gray">
    <td>Email</td>
    <td><strong>:</strong></td>
    <td><?php echo $row->user_email;?></td>
  </tr>
  <tr class="isi">
    <td>Sex</td>
    <td><strong>:</strong></td>
    <td><?php if( $row->user_sex == 'p' ) echo 'Perempuan'; elseif( $row->user_sex == 'l' ) echo 'Laki-laki'; else echo 'Unknow';?></td>
  </tr>
  <tr class="isi gray">
    <td>Last Online</td>
    <td><strong>:</strong></td>
    <td><?php echo date_stamp( $row->user_last_update );?></td>
  </tr>
  <tr class="isi">
    <td>Registered</td>
    <td><strong>:</strong></td>
    <td><?php echo date_stamp( $row->user_registered );?></td>
  </tr>
  <tr class="isi gray">
    <td>Status</td>
    <td><strong>:</strong></td>
    <td><?php if( $row->user_status == 0 ) echo 'Non Active'; elseif( $row->user_status == 1 ) echo 'Active'; else echo 'Unknow';?></td>
  </tr>
  <tr class="isi">
    <td>Provinsi</td>
    <td><strong>:</strong></td>
    <td><?php echo $row->user_province;?></td>
  </tr>
</table>
</div>
<?php
}
}else{
	echo '<div id="error">ID user is empty</div>';
}
	break;
	case 'add':
	
if(!function_exists('add_member')){
	function add_member($data){
	global $db;		
	extract($data, EXTR_SKIP);
		
	$user_registered 	= date('Y-m-d H:i:s');
	$user_last_update 	= $user_registered;
	
	if( empty($user_login) ) $msg[] = 'The user name empty, '; 
	if( empty($user_email) ) $msg[] = 'The email empty, '; 
	elseif( !valid_mail( $user_email ) ) $msg[] = 'The email not valid, '; 
	if( empty( $user_pass_new ) || empty( $user_pass_rep ) ){ 
		$msg[] = 'The password is empty, ';
	}else{ 
		$user_pass_new 	= md5($user_pass_new);
		$user_pass_rep 	= md5($user_pass_rep);
		
		if( $user_pass_new !== $user_pass_rep ) $msg[] = 'The password not match, ';
		else $user_pass = esc_sql($user_pass_rep);
	}
	
	if( empty($user_author) ) $msg[] = 'The author empty, '; 
	if( empty($user_country)) $msg[] = 'The country field not select, '; 
		
	if( is_array($msg))	{
		$msg_text = '';
		foreach($msg as $val){
			$msg_text.= $val;
		}
	}
	
	$response['status'] = 3;
	$response['msg'] = $msg_text;	
	
	if( empty($msg) ):
	
		$userdata = compact('user_login','user_pass','user_email','user_sex','user_author','user_status','user_status','user_level','user_country','user_registered','user_last_update');
		$db->insert( 'users', $userdata );
		$response['status'] = 1;
		$response['msg'] = 'Berhasil menambahkan member beru';	
		add_activity('manager_users',"menambah member name:$user_author level:$user_level",'user');
	
	endif;
	
	header('Content-type: application/json');	
	echo json_encode($response);
	}
}

if (isset($_POST['username'])){
	
	$user_login			= filter_txt($_POST['username']);
	$user_email			= filter_txt($_POST['email']);
	$user_pass_new		= filter_txt($_POST['newpassword']);
	$user_pass_rep		= filter_txt($_POST['repassword']);
	$user_author		= filter_txt($_POST['author']);
	$user_sex			= filter_txt($_POST['sex']);
	$user_level			= filter_txt($_POST['level']);
	$user_status		= filter_int($_POST['status']);
	$user_country		= filter_txt($_POST['country']);
	
	$userdata = compact('user_login','user_pass_new','user_pass_rep','user_email','user_sex','user_author','user_status','user_level','user_country');
	add_member($userdata);

}else{
?>
<div class="padding" style="width:400px;">
<form>
<table width="100%" border="0" cellspacing="2">
  <tr>
    <td width="27%">User Name</td>
    <td width="2%"><strong>:</strong></td>
    <td width="71%"><input type="text" name="username" value="" style="width:95%"></td>
  </tr>
  <tr>
    <td>E-Mail</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="email" value="" style="width:95%"></td>
  </tr>
  <tr>
    <td>Author Name</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="author" value="" style="width:95%"></td>
  </tr>
  <tr>
    <td>New Password</td>
    <td><strong>:</strong></td>
    <td><input type="password" name="newpassword" value="" style="width:95%"></td>
  </tr>
  <tr>
    <td>Retry Password</td>
    <td><strong>:</strong></td>
    <td><input type="password" name="repassword" value="" style="width:95%"></td>
  </tr>
  <tr>
    <td>Seorang</td>
    <td><strong>:</strong></td>
    <td><select name="sex">
          <option value="p">Perempuan</option>
          <option value="l">Laki laki</option>
        </select></td>
  </tr>
  <tr>
    <td>Level</td>
    <td><strong>:</strong></td>
    <td><select name="level">
          <option value="user">User</option>
          <option value="admin">Admin</option>
        </select></td>
  </tr>
  <tr>
    <td>Status</td>
    <td><strong>:</strong></td>
    <td><select name="status">
          <option value="0">Inactive</option>
          <option value="1">Active</option>
        </select></td>
  </tr>
  <tr>
    <td>Country</td>
    <td><strong>:</strong></td>
    <td><select name="country">
          <?php $class_country->country_list(); ?>
        </select></td>
  </tr>
</table>
</form>
</div>
<?php
}
	break;
	case 'edit':

$to = filter_txt( $_GET[to] );
if( !empty($_GET['user_id']) ){
	$user_id = filter_int( $_GET['user_id'] );
	$row = $db->fetch_obj( $db->query("SELECT * FROM $db->users WHERE ID='$user_id'") );

if( $row < 1 ){
	echo '<div class="padding"><div id="error">ID error, akun not found</div></div>';
}else{
	
//edit data=========================================================
if( $to == 'data' ){	
if(!function_exists('edit_member')){
	function edit_member($data, $user_id){
	global $db;		
	extract($data, EXTR_SKIP);
	
	if( empty($user_login) ) $msg[] = 'The user name empt, '; 
	if( empty($user_email) ) $msg[] = 'The email empty, '; 
	elseif( !valid_mail( $user_email ) ) $msg[] = 'The email not valid, ';	
	if( empty($user_author) ) $msg[] = 'The author empty, '; 
	if( empty($user_country) ) $msg[] = 'The country field not select, '; 
		
	if( is_array($msg))	{
		$msg_text = '';
		foreach($msg as $val){
			$msg_text.= $val;
		}
	}
	
	$response['status'] = 3;
	$response['msg'] = $msg_text;	
	
	if( empty($msg) ):
	
		$db->update( 'users', $data, array( 'ID' => $user_id ) );	
		$response['status'] = 1;
		$response['msg'] = 'Berhasil memperbarui data member';
		add_activity('manager_users',"memperbarui data member name:$user_author level:$user_level",'user');
	
	endif;
	
	
	header('Content-type: application/json');	
	echo json_encode($response);
	
	}
}
	
if (isset($_POST['username'])){
	
	$user_login			= filter_txt($_POST['username']);
	$user_email			= filter_txt($_POST['email']);
	$user_author		= filter_txt($_POST['author']);
	$user_sex			= filter_txt($_POST['sex']);
	$user_level			= filter_txt($_POST['level']);
	$user_status		= filter_int($_POST['status']);
	$user_country		= filter_txt($_POST['country']);
	$user_province		= filter_txt($_POST['province']);
	
	$userdata = compact('user_login','user_email','user_sex','user_author','user_status','user_level','user_country','user_province');
	edit_member($userdata, $user_id );

}else{
?>
<div class="padding" style="width:400px;">
<form>
<table width="100%" border="0" cellspacing="2">
  <tr>
    <td width="27%">User Name</td>
    <td width="2%"><strong>:</strong></td>
    <td width="71%"><input type="text" name="username" value="<?php echo $row->user_login?>" style="width:95%"></td>
  </tr>
  <tr>
    <td>E-Mail</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="email" value="<?php echo $row->user_email?>" style="width:95%"></td>
  </tr>
  <tr>
    <td>Author Name</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="author" value="<?php echo $row->user_author?>" style="width:95%"></td>
  </tr>
  <tr>
    <td>Seorang</td>
    <td><strong>:</strong></td>
    <td><select name="sex">
          <option value="p"<?php if( $row->user_sex == 'p' ) echo 'selected'; ?>>Perempuan</option>
          <option value="l"<?php if( $row->user_sex == 'l' ) echo 'selected'; ?>>Laki laki</option>
        </select></td>
  </tr>
  <tr>
    <td>Level</td>
    <td><strong>:</strong></td>
    <td><select name="level">
          <option value="user"<?php if( $row->user_level == 'user' ) echo 'selected'; ?>>User</option>
          <option value="admin"<?php if( $row->user_level == 'admin' ) echo 'selected'; ?>>Admin</option>
        </select></td>
  </tr>
  <tr>
    <td>Status</td>
    <td><strong>:</strong></td>
    <td><select name="status">
          <option value="0"<?php if( $row->user_status == 0 ) echo 'selected'; ?>>Inactive</option>
          <option value="1"<?php if( $row->user_status == 1 ) echo 'selected'; ?>>Active</option>
        </select></td>
  </tr>
  <tr>
    <td>Country</td>
    <td><strong>:</strong></td>
    <td><select name="country">
          <?php $class_country->country_list($row->user_country); ?>
        </select></td>
  </tr>
  <tr>
    <td>Provinsi</td>
    <td><strong>:</strong></td>
    <td><input type="text" name="province" value="<?php echo $row->user_province?>" style="width:95%;"></td>
  </tr>
</table>
</form>
</div>
<?php
}
//edit data=========================================================
//edit password=====================================================
}elseif( $to == 'password' ){
if(!function_exists('__change_password')){
	function __change_password($data){
		global $db,$login;		
		extract($data, EXTR_SKIP);
		
		$ID 		= esc_sql($user_id);
		$newpass	= esc_sql($newpass);
		$old_pass	= esc_sql($oldpass);
		$repass		= esc_sql($repass);
		
		$oldpass	= md5($oldpass);
		$user_pass	= md5($newpass);
		
		if(empty($newpass) || empty($repass)) $msg[] = 'New & Re Password is empty, ';
		
		if($newpass != $repass) $msg[] = 'Invalid New Password & Re Password not match, ';
		
		$field = $login->data( compact('ID') );
		if($field->user_pass != $oldpass) $msg[] = 'Invalid Old Password not match, ';
		
		if( is_array($msg))	{
			$msg_text = '';
			foreach($msg as $val){
				$msg_text.= $val;
			}
		}
		
		$response['status'] = 3;
		$response['msg'] = $msg_text;
	
		if(empty($msg)){
			if( $db->update('users', compact('user_pass'), compact('ID') ) ){
				$response['status'] = 1;
				$response['msg'] = 'The Password success to change';
				add_activity('manager_users',"mengubah kata sandi",'user');
			}else{
				$response['status'] = 3;
				$response['msg'] = 'Error to editing password';
			}
		}
		header('Content-type: application/json');	
		echo json_encode($response);
	}
}
if (isset($_POST['oldpass'])){
	$oldpass	= filter_txt($_POST['oldpass']);
	$newpass	= filter_txt($_POST['newpass']);
	$repass		= filter_txt($_POST['repass']);
	
	$data = compact('oldpass','newpass','repass') + array('user_id' => $user_id);
	__change_password($data);	
}else{	
?>
<div class="padding" style="width:400px;">
<form>
<table width="100%" border="0" cellspacing="2">
  <tr>
    <td width="27%">Old Password</td>
    <td width="2%"><strong>:</strong></td>
    <td width="71%"><input type="password" name="oldpass" value="" style="width:95%"></td>
  </tr>
  <tr>
    <td>New Password</td>
    <td><strong>:</strong></td>
    <td><input type="password" name="newpass" value="" style="width:95%"></td>
  </tr>
  <tr>
    <td>Re Password</td>
    <td><strong>:</strong></td>
    <td><input type="password" name="repass" value="" style="width:95%"></td>
  </tr>
</table>
</form>
</div>
<?php	
}
}else{
	echo '<div id="error">Editing define to user unknow</div>';
}
//edit password=====================================================
}
}else{
	echo '<div id="error">ID user is empty</div>';
}
	break;
}
endif;
?>