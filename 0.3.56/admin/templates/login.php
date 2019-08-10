<!DOCTYPE html>
<html lang="en">  
<head>
<meta charset="utf-8"> 
<title>Authentication</title>

<meta name="description" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">  

<link href="admin/templates/css/reset.css" rel="stylesheet" />
<link href="admin/templates/css/element.css" rel="stylesheet" />
<link href="admin/templates/css/forms.css" rel="stylesheet" />
<link href="admin/templates/css/animate.css" rel="stylesheet" />
<link href="admin/templates/css/login.css" rel="stylesheet" />
<link href="admin/templates/css/colors.css" rel="stylesheet" />
<link href="admin/templates/css/drop-shadow.css" rel="stylesheet" />

<script type="text/javascript" src="libs/js/jquery.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
	$("#username").focus();
	$("#username").keyup(function(){
		
		var email = $(this).val();	
		if( email ){
			$.ajax({
			type: "POST",
			url: "?request&load=libs/ajax/avatar.php",
			data: 'email='+ email,
			cache: false,			
			success: function(html){				
				$("#img_box").html("<img src='"+html+"' class='avatar_img' />");
			}
		});
	
	}});
	
	$('#gravatar').click(function(){		
		$('#gravatar_block').show();
		$('#avatar_block').hide();
	});
	
	$('#computer').click(function(){
		$('#gravatar_block').hide();
		$('#avatar_block').show();
	});	
	
	window.setTimeout("$('#success,#message,#error').fadeOut('slow')",5000);	
});

</script>
<?php iw_head_login()?>
<body>

<div class="codrops-top">
<a href="./">
<strong>&laquo; Previous Home </strong>
</a>
<?php if( $login->cek_login() && $login->login_level('admin') ){?>
<span class="right">
<a href="./?admin">
<strong>Previous Manage &raquo;</strong>
</a>
</span>
<?php }?>
<div style="clear:both"></div>
</div>

<div id="wrap">
<!--<div id="box_animation">-->
<?php 


global $login, $class_country;

switch($_GET['go']){
default:

if( isset($_POST['login']) ){
	$username 		= filter_txt($_POST['username']);
	$password 		= filter_txt($_POST['password']);	
	$remember 		= filter_int($_POST['remember']);	
	
	$login->sign_in( compact('username','password','remember') );
}
?>
<div id="login_box" class="drop-shadow lifted">
<div id="login_head">Masuk</div>
<?php
if( $login->cek_login() ) redirect( do_links('') );
else{
	
$image_url = content_url('/uploads/avatar_default.png');
if( get_option('avatar_type') == 'gravatar' )
	$image_url = 'http://www.gravatar.com/avatar/?d=mm';
		
?>
<div id="img_box"><img src="<?php echo $image_url;?>" class="avatar_img"/></div>
<form method="post" action="" id="form">
<div style="margin-bottom:6px">
<label>Username</label>
<input type="text" name="username"  id="username" class="input user"/>
<label>Kata Sandi</label>
<input type="password" name="password" id="password" class="input passcode"/>
<label for="remember">Remember Me</label>
<input name="remember" value="1" id="remember" type="checkbox" style="width:14px">
</div>
<input type="submit" name="login" value="Masuk"/> 
</form>
<?php }?>
</div>
<div class="footer_log">
<a class="left" href="./?login&go=lost">Lupa kata sandi?</a>
<a class="right" href="./?login&go=signup">New Member</a>
</div>
<?php
break;
case'signup':
?>
<?php
if( isset($_POST['signup']) ){
	$username 		= filter_txt($_POST['username']);
	$password 		= filter_txt($_POST['password']);	
	
	$email 			= filter_txt($_POST['email']);
	$sex 			= filter_int($_POST['sex']);
	$chekterm 		= filter_int($_POST['chekterm']);
	$country 		= filter_txt($_POST['country']);		
	$repassword 	= filter_txt($_POST['repassword']);
		
	$login->sign_up( compact('username','email','password','repassword','sex','country','chekterm') );	
}
?>
<style type="text/css">
#login_box {margin-top: 0px;}
</style>
<div id="login_box" class="drop-shadow lifted">
<div id="login_head">Daftar</div>
<?php
if( $login->cek_login() ) redirect( do_links('') );
else{
?>
<form method="post" action="" id="form">
<div style="margin-bottom:6px">
<label>Username</label>
<input type="text" name="username"  id="username" class="input user"/>
<label>Kata Sandi</label>
<input type="password" name="password" id="password" class="input passcode"/>
<label>Ulangi Kata Sandi</label>
<input type="password" name="repassword" id="repassword" class="input passcode"/>
<label>Email</label>
<input type="text" name="email" id="email" class="input user"/>
<label>Saya seorang</label><br>
<select name="sex">
        <option value="0">Pilih Jenis kelamin</option>
        <option value="1">Perempuan</option>
        <option value="2">Laki laki</option>
</select><br>
<label>Saya tinggal di</label><br>
<select name="country"><?php $class_country->country_list(); ?></select><br>
<label for="term">Saya setuju <a href="?login&go=term">peraturan ini?</a></label>
<input name="chekterm" value="1" id="term" type="checkbox" style="width:14px">
</div>
<input type="submit" name="signup" value="Daftar" id="signup-button"/>
</form>
<?php }?>
</div>
<div class="footer_log"><a class="left" href="./?login">Login</a><a class="right" href="./?login&go=lost">Lupa kata sandi?</a></div>
<?php
break;
case'profile':
if( ! $login->cek_login() ) redirect( do_links('login') );

$user_login = $login->exist_value('user_name');

$q	= $db->select( 'users', compact('user_login') );
$r  = $db->fetch_array($q);
?>
<style type="text/css">
#login_box {
	margin-top:20px;
	width:500px;
}
#wrap{
	width:565px;
}
</style>
<?php
if (isset($_POST['submit'])){
	$user_id	= filter_txt($_POST['user_id']);
	$username	= filter_txt($_POST['username']);
	$author		= filter_txt($_POST['author']);
	$email		= filter_txt($_POST['email']);
	$thumb		= $_FILES['thumb'];
	$sex		= filter_int($_POST['sex']);
	$country	= filter_txt($_POST['country']);
	$province	= filter_txt($_POST['province']);
	$website	= filter_txt($_POST['website']);
	
	$userdata	= compact('username','email','sex','author','user_id','thumb','country','province','website');	
	$login->update_user($userdata);
}
?>
<div id="login_box" class="drop-shadow lifted">
<div id="login_head">Profile</div>

<form method="post" action="" id="form" enctype="multipart/form-data">
<div style="float:left; width:35%;">
<label>Foto Profile</label>
<div id="gravatar_block">
<a href="http://www.gravatar.com/" title="Ubah Avatar" target="_blank">
<img src="<?php echo get_gravatar( $r['user_email'], null, 180 )?>" class="avatar_img_profile"/>
</a>
</div>
<div style="" id="avatar_block">
<?php 
$avatar_img_profile = 'default.png';
if( file_exists('content/uploads/avatar_'.$r['user_avatar']) ): 
	$avatar_img_profile = $r['user_avatar'];
endif;
?>
<img src="?request&load=libs/timthumb.php&src=<?php echo content_url('/uploads/avatar_'.$avatar_img_profile)?>&w=180&h=180&zc=1" class="avatar_img_profile"/>
<div id="file">Chose file</div><input type="file" name="thumb" style="width:168px"/>
</div>

<input type="radio" name="choose" value="computer" id="computer" checked="checked" class="radio"/>Computer
<input type="radio" name="choose" value="gravatar" id="gravatar" class="radio"/>Gravatar

</div>
<div style="float:right; width:55%; border-left:1px solid #f2f2f2; padding-left:5px;">
<label>Nama Pengguna</label>
<input type="hidden" name="username" value="<?php _e($r['user_login'])?>">
<input type="hidden" name="user_id" value="<?php _e($r['ID'])?>">
<input type="text" name="username" class="input user disable" value="<?php _e($r['user_login'])?>" disabled/><br />
<label>Email</label><span class="required">*</span>
<input type="text" name="email" class="input user" value="<?php _e($r['user_email'])?>"/><br />
<label>Nama Panggilan</label><span class="required">*</span>
<input type="text" name="author"  class="input user" value="<?php _e($r['user_author'])?>"/><br />
<label>Saya seorang</label><span class="required">*</span><br />
<select name="sex">
      <?php
	  $sex = (int)$r['user_sex'];
	  if($sex==0):
	  ?>
        <option value="0">Pilih Jenis kelamin</option>
        <option value="1" selected="selected">Perempuan</option>
        <option value="2">Laki laki</option>
      <?php
	  elseif($sex==1):
	  ?>
        <option value="0">Pilih Jenis kelamin</option>
        <option value="1">Perempuan</option>
        <option value="2" selected="selected">Laki laki</option>
      <?php
	  else:
	  ?>
        <option value="0" selected="selected">Pilih Jenis kelamin</option>
        <option value="1">Perempuan</option>
        <option value="2">Laki laki</option>
      <?php
	  endif;
	  ?>
      </select><br>
<label>Saya tinggal di</label><span class="required">*</span><br>
<select name="country"><?php $class_country->country_list($r['user_country']); ?></select><br>
<label>Provinsi</label>
<input type="text" name="province"  class="input user" value="<?php _e($r['user_province'])?>"/><br />
<label>Website</label><br />
<textarea name="website" class="input user" style="height:50px;"><?php _e($r['user_url'])?></textarea><br />
</div>
<div style="clear:both"></div>
<input type="submit" name="submit" value="Perbaharui" class="button blue l"/><input type="reset" name="Reset" value="Clear" class="button r"/>
</form>
<div style="clear:both"></div>
</div>
<div class="footer_log">
<a class="left" href="./?login&go=pass">Ubah kata sandi?</a>
<a class="right" href="./?login&go=logout">Log Out</a>
</div>
<?php
break;
case'pass':
if( ! $login->cek_login() ) redirect();

if(!function_exists('change_password')){
	function change_password($data){
		global $login;		
		extract($data, EXTR_SKIP);
		
		$user_login	= esc_sql( $login->exist_value('user_name') );
		$newpass	= esc_sql( $newpass );
		$old_pass	= esc_sql( $oldpass );
		$repass		= esc_sql( $repass );
		
		$oldpass	= md5($oldpass);
		$user_pass	= md5($newpass);
		
		if(empty($newpass) || empty($repass)) $msg[] = '<strong>ERROR</strong>: New or RePassword is empty</a>';		
		if($newpass != $repass) $msg[] = '<strong>ERROR</strong>: Invalid New Password & Re Password not match</a>';
		
		$field = $login->username_cek( compact('user_login') );
		if($field->user_pass != $oldpass) $msg[] = '<strong>ERROR</strong>: Invalid Old Password not match</a>';
		
		if( is_array($msg))	{
			foreach($msg as $val){
				_e('<div id="error">'.$val.' </div>');
			}
		}
		if(empty($msg)){
			$update = $login->change_password(compact('user_pass'),compact('user_login'));
			if($update) _e('<div id="success">The Password success to change</div>');
		}
	}
}

if (isset($_POST['submit'])){
	$oldpass	= filter_txt($_POST['oldpass']);
	$newpass	= filter_txt($_POST['newpass']);
	$repass		= filter_txt($_POST['repass']);
	
	$data = compact('oldpass','newpass','repass');
	change_password($data);
}
?>
<div id="login_box" class="drop-shadow lifted">
<div id="login_head">Kata sandi?</div>
<form method="post" action="" id="form">
<label>Kata sandi lama</label>
<input type="password" name="oldpass" id="password" class="input passcode"/><br/>
<label>Kata sandi baru</label>
<input type="password" name="newpass" id="newpassword" class="input passcode"/><br/>
<label>Ulangi kata sandi baru</label>
<input type="password" name="repass" id="renewpassword" class="input passcode"/><br/>
<input type="submit" name="submit" value="Perbaharui"/>
</form>
</div>
<div class="footer_log">
<a class="left" href="./?login&go=profile">Ke Profile</a>
<a class="right" href="./?login&go=lost">Lupa kata sandi?</a>
</div>
<?php
break;
case'lost':
if (isset ($_POST['submit_send'])){
	$user_email = filter_txt($_POST['email']);
	
	$login->lost_password($user_email);
}
?>
<div id="login_box" class="drop-shadow lifted">
<div id="login_head">Lupa sandi?</div>
<form method="post" action="" id="form">
<label>Email</label>
<input type="text" name="email"  id="email" class="input user"/><br />
<input type="submit" name="submit_send" value="Minta sandi baru"/>
</form>
</div>
<div class="footer_log">
<?php if( ! $login->cek_login() ): ?>
<a class="left" href="./?login">Masuk</a>
<?php else:?>
<a class="left" href="./?login&go=profile">Profile</a>
<?php endif;?>
</div>
<?php
break;
case'activation':	
$keys = filter_txt($_GET['keys']);

if( !empty($keys) ){
if(isset ($_POST['submit_activ'])){
	$codeaktivasi = filter_txt($_POST['codeaktivasi']);
	
	$login->activation($codeaktivasi);
}
?>
<div id="login_box" class="drop-shadow lifted">
<div id="login_head">Account Activation</div>
<form method="post" action="">
<label>Code Aktivasi</label><br>
<input type="text" name="codeaktivasi" value="<?php _e($keys);?>" style="width:95%">
<input type="submit" class="button" name="submit_activ" value="Activation Now"/>
</form>
</div>
<div class="footer_log"><a class="left" href="./?login">Login</a></div>
<?php
}else{
	redirect();
}
break;
case'logout':
?>
<div id="login_box" class="drop-shadow lifted">
<div id="login_head">Logout?</div>
<?php 
if( $login->cek_login() ) $login->login_out();
else redirect();
?>
</div>
<?php
break;

}
?>
<!--</div>-->
</div>

</body>
</html>
