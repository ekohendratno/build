<!DOCTYPE html>
<html lang="en">  
<head>
<meta charset="utf-8"> 
<title><?php the_login_title()?></title>

<meta name="description" content="">
<meta name="author" content="">
<meta name="viewport" content="width=device-width, initial-scale=1.0">  

<link href="libs/css/reset.css" rel="stylesheet" />
<link href="libs/css/element.css" rel="stylesheet" />
<link href="libs/css/forms.css" rel="stylesheet" />
<link href="libs/css/animate.css" rel="stylesheet" />
<link href="libs/css/login.css" rel="stylesheet" />
<link href="libs/css/colors.css" rel="stylesheet" />
<link href="libs/css/drop-shadow.css" rel="stylesheet" />

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
<?php the_head_login()?>
<body>
<?php global $login, $class_country;?>

<div class="codrops-top">
<a href="./"><strong>&laquo; Previous Home </strong></a>
<?php if( $login->user_check() && $login->login_level('admin') ):?>
<span class="right"><a href="./?admin"><strong>Previous Manage &raquo;</strong></a></span>
<?php endif;?>
<div style="clear:both"></div>
</div>

<div id="wrap">
<?php
switch($_GET['go']){
default:

if( isset($_POST['login']) ){
	$username 		= filter_txt($_POST['username']);
	$password 		= filter_txt($_POST['password']);	
	$remember 		= filter_int($_POST['remember']);	
	
	$login->sign_in( compact('username','password','remember') );
}
?>
<div id="login_box">
<div id="login_head">Masuk</div>
<?php if( $login->user_check() ):?>
<div id="message_no_ani">
Anda sedang login,<br><br> 
<ul>
    <li>Tekan <a href="?login&go=logout" onClick="return confirm('Are you sure logout?')">logout</a> untuk keluar dari log.</li>
    <li>Silahkan <a href="?login&go=profile">atur profile</a> anda</li>
</ul>
</div><br>
<?php else:
	
$image_url = includes_url('/img/avatar_default.png');
if( get_option('avatar_type') == 'gravatar' )
	$image_url = 'http://www.gravatar.com/avatar/?d=mm';
		
?>
<div id="img_box"><img src="<?php echo $image_url;?>" class="avatar_img"/></div>
<form method="post" action="" id="form">
<div style="margin-bottom:6px">
<label>Username</label>
<input type="text" name="username"  id="username" class="input user" placeholder="Alamat email atau Username"/>
<label>Kata Sandi</label>
<input type="password" name="password" id="password" class="input passcode" placeholder="Kata sandi"/>
<label for="remember">Remember Me</label>
<input name="remember" value="1" id="remember" type="checkbox" style="width:14px">
</div>
<input type="submit" name="login" value="Masuk"/> 
</form>
<?php endif;?>
</div>
<div class="footer_log">
<a class="left" href="./?login&go=lost">Lupa kata sandi?</a>
<?php if( get_option('account_registration') > 0 ):?>
<a class="right" href="./?login&go=signup">New Member</a>
<?php endif;?>
</div>
<?php
break;
case'signup':

if( isset($_POST['signup']) ){
	$username 		= filter_txt($_POST['username']);
	$password 		= filter_txt($_POST['password']);	
	
	$email 			= filter_txt($_POST['email']);
	$sex 			= filter_txt($_POST['sex']);
	$chekterm 		= filter_int($_POST['chekterm']);
	$country 		= filter_txt($_POST['country']);		
	$repassword 	= filter_txt($_POST['repassword']);
		
	$login->sign_up( compact('username','email','password','repassword','sex','country','chekterm') );	
}
?>
<style type="text/css">
#login_box {margin-top: 0px;}
</style>
<div id="login_box">
<div id="login_head">Daftar</div>
<?php if( get_option('account_registration') < 1 ):?>
<div id="message_no_ani">
<strong>Form pendaftaran telah di nonaktifkan</strong><br><br>
Maaf anda tidak dapat melanjutkan registrasi/pendaftaran ke website ini.<br><br> 
Silahkan hubungi <a href="mail:<?php echo get_option('admin_email');?>">administrator</a> untuk info lebih lanjut
</div><br>
<?php else:?>
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
        <option value="l">Laki laki</option>
        <option value="p">Perempuan</option>
</select><br>
<label>Saya tinggal di</label><br>
<select name="country"><?php $class_country->country_list(); ?></select><br>
<label for="term">Saya setuju <a href="?login&go=tos">peraturan ini?</a></label>
<input name="chekterm" value="1" id="term" type="checkbox" style="width:14px">
</div>
<input type="submit" name="signup" value="Daftar" id="signup-button"/>
</form>
<?php endif;?>
</div>
<div class="footer_log"><a class="left" href="./?login">Login</a><a class="right" href="./?login&go=lost">Lupa kata sandi?</a></div>
<?php

break;
case'activation':	

if( $login->user_check() ) redirect( do_links('login') );
else{
$keys = filter_txt($_GET['keys']);

if(isset ($_POST['submit_activ'])){
	$codeaktivasi = filter_txt($_POST['codeaktivasi']);
	
	$login->activation($codeaktivasi);
}
?>
<div id="login_box">
<div id="login_head">Account Activation</div>
<form method="post" action="">
<label>Code Aktivasi</label><br>
<input type="text" name="codeaktivasi" value="<?php echo $keys;?>" style="width:95%">
<input type="submit" class="button" name="submit_activ" value="Activation Now"/>
</form>
</div>
<div class="footer_log"><a class="left" href="./?login">Login</a></div>
<?php
}
break;
case'profile':
if( ! $login->user_check() ) redirect( do_links('login') );

$user_login = $login->exist_value('username');

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
if ( isset($_POST['deactive']) ){
	$login->deactivate_account();
}
if (isset($_POST['submit'])){
	$user_id	= filter_txt($_POST['user_id']);
	$username	= filter_txt($_POST['username']);
	$author		= filter_txt($_POST['author']);
	$email		= filter_txt($_POST['email']);
	$thumb		= $_FILES['thumb'];
	$sex		= filter_txt($_POST['sex']);
	$country	= filter_txt($_POST['country']);
	$province	= filter_txt($_POST['province']);
	$website	= filter_txt($_POST['website']);
	
	$userdata	= compact('username','email','sex','author','user_id','thumb','country','province','website');	
	$login->update_user($userdata);
}
?>
<div id="login_box">
<div id="login_head">Profile Saya</div>

<form method="post" action="" id="form" enctype="multipart/form-data">
<div style="float:left; width:35%;">
<label>Foto Profile</label>
<div id="gravatar_block">
<a href="http://www.gravatar.com/" title="Clik for Change Gravatar" target="_blank">
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
<div style="clear:both"></div>
<div style="margin-top:20px; background:#f2f2f2; border:1px solid #eee; padding:10px; padding-left:5px; padding-right:5px; text-align:center">You Level : <strong><?php echo strtoupper( $r['user_level'] )?></strong></div>
<?php if( 'admin' != $r['user_level'] ):?>
<div style="margin-top:20px; background:#f2f2f2; border:1px solid #eee; padding:10px; padding-left:5px; padding-right:5px; text-align:center">
<input type="submit" name="deactive" value="Non Aktifkan User Saya" class="button red" onClick="return confirm('Are you sure deactive your account?\n\nAnda dapat mengaktifkan kembali akun anda suatu saat nanti dengan masuk ke form lupa sandi.')"/>
</div>
<?php endif;?>
</div>
<div style="float:right; width:55%; border-left:1px solid #f2f2f2; padding-left:5px;">
<label>Nama Pengguna</label>
<input type="hidden" name="username" value="<?php echo $r['user_login']?>">
<input type="hidden" name="user_id" value="<?php echo $r['ID']?>">
<input type="text" name="username" class="input user disable" value="<?php echo $r['user_login']?>" disabled/><br />
<label>Email</label><span class="required">*</span>
<input type="text" name="email" class="input user" value="<?php echo $r['user_email']?>"/><br />
<label>Nama Panggilan</label><span class="required">*</span>
<input type="text" name="author"  class="input user" value="<?php echo $r['user_author']?>"/><br />
<label>Saya seorang</label><span class="required">*</span><br />
<select name="sex">
      <?php
	  $sex = $r['user_sex'];
	  if( $sex== 'l' ):
	  ?>
        <option value="0">Pilih Jenis kelamin</option>
        <option value="l" selected="selected">Laki laki</option>
        <option value="p">Perempuan</option>
      <?php
	  elseif( $sex== 'p' ):
	  ?>
        <option value="0">Pilih Jenis kelamin</option>
        <option value="l">Laki laki</option>
        <option value="p" selected="selected">Perempuan</option>
      <?php
	  else:
	  ?>
        <option value="0" selected="selected">Pilih Jenis kelamin</option>
        <option value="p">Laki laki</option>
        <option value="l">Perempuan</option>
      <?php
	  endif;
	  ?>
      </select><br>
<label>Saya tinggal di</label><span class="required">*</span><br>
<select name="country"><?php $class_country->country_list($r['user_country']); ?></select><br>
<label>Provinsi</label>
<input type="text" name="province"  class="input user" value="<?php echo $r['user_province']?>"/><br />
<label>Website</label><br />
<textarea name="website" class="input user" style="height:50px;"><?php echo $r['user_url']?></textarea><br />
</div>
<div style="clear:both"></div>
<input type="submit" name="submit" value="Perbaharui" class="button blue l"/><input type="reset" name="Reset" value="Clear" class="button r"/>
</form>
<div style="clear:both"></div>
</div>
<div class="footer_log">
<a class="left" href="./?login&go=pass">Ubah kata sandi?</a>
<a class="right" onClick="return confirm('Are you sure logout?')" href="./?login&go=logout">Log Out</a>
</div>
<?php
break;
case'pass':
if( ! $login->user_check() ) redirect();

if (isset($_POST['submit'])){
	$old_pass	= filter_txt($_POST['old_pass']);
	$new_pass	= filter_txt($_POST['new_pass']);
	$rep_pass	= filter_txt($_POST['rep_pass']);
	
	$data = compact('old_pass','new_pass','rep_pass');
	$login->change_password( $data );
}
?>
<div id="login_box" class="drop-shadow lifted">
<div id="login_head">Ubah Kata sandi?</div>
<form method="post" action="" id="form">
<label>Kata sandi lama</label>
<input type="password" name="old_pass" id="password" class="input passcode"/><br/>
<label>Kata sandi baru</label>
<input type="password" name="new_pass" id="newpassword" class="input passcode"/><br/>
<label>Ulangi kata sandi baru</label>
<input type="password" name="rep_pass" id="renewpassword" class="input passcode"/><br/>
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
<input type="text" name="email"  id="email" class="input user" placeholder="Alamat email kamu"/><br />
<input type="submit" name="submit_send" value="Minta sandi baru"/>
</form>
</div>
<div class="footer_log">
<?php if( ! $login->user_check() ): ?>
<a class="left" href="./?login">Masuk</a>
<?php else:?>
<a class="left" href="./?login&go=profile">Profile</a>
<?php endif;?>
</div>
<?php
break;
case'logout':
?>
<div id="login_box">
<div id="login_head">Logout?</div>
<?php 
if( $login->user_check() ) $login->login_out();
else redirect();
?>
</div>
<?php
break;
case'tos':
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
<div id="login_box">
<div id="login_head">Term of use</div>
<strong>Persyaratan Layanan</strong>
<p>  Terakhir dimodifikasi: 1 Maret 2012</p><br />
<strong>Selamat datang di situs kami </strong><br />
<p>
  Terima kasih telah menggunakan produk dan layanan (&quot;Layanan&quot;) kami. Layanan disediakan oleh CMSID.org (&quot;CMSID&quot;), yang berlokasi di Bandar Lampung, Indonesia.<br />
  Dengan menggunakan Layanan kami, berarti Anda menyetujui persyaratan ini. Bacalah dengan saksama.<br />
Layanan kami sangat beragam, sehingga terkadang persyaratan tambahan atau persyaratan produk (termasuk persyaratan usia) dapat berlaku. Persyaratan tambahan tersedia pada Layanan yang relevan, dan persyaratan tambahan tersebut menjadi bagian dari perjanjian Anda dengan kami jika Anda menggunakan Layanan tersebut.</p>
<p>&nbsp;</p>
<strong>Menggunakan Layanan kami</strong>
<p>Anda harus mematuhi kebijakan apa pun yang tersedia untuk Anda di dalam Layanan.<br />
  <br />
  Jangan menyalahgunakan Layanan kami. Misalnya, jangan mengganggu Layanan kami atau mencoba mengaksesnya menggunakan metode selain antarmuka dan petunjuk yang kami berikan. Anda dapat menggunakan Layanan kami hanya jika diizinkan oleh undang-undang, termasuk undang-undang serta peraturan kontrol ekspor dan ekspor ulang yang berlaku. Kami dapat menangguhkan atau menghentikan penyediaan Layanan kami bagi Anda jika Anda tidak mematuhi persyaratan atau kebijakan kami, atau jika kami mendapati perilaku yang tidak semestinya.<br />
  <br />
Menggunakan Layanan kami tidak memberikan Anda kepemilikan atas hak kekayaan intelektual apa pun di Layanan kami atau konten yang Anda akses. Anda tidak boleh menggunakan konten dari Layanan kami kecuali jika mendapatkan izin dari pemiliknya atau diizinkan oleh hukum. Persyaratan ini tidak memberi Anda hak untuk menggunakan merek atau logo apa pun yang digunakan dalam Layanan kami. Jangan menghapus, mengaburkan, atau mengubah pemberitahuan masalah hukum apa pun yang ditampilkan atau disertakan pada Layanan kami.</p>
<p>&nbsp;</p>
<strong>Perlindungan Privasi dan Hak Cipta</strong>
<p>Kebijakan privasi Google menjelaskan cara kami memperlakukan data pribadi Anda dan melindungi privasi saat Anda menggunakan Layanan kami. Dengan menggunakan Layanan kami, berarti Anda setuju bahwa Google dapat menggunakan data tersebut menurut kebijakan privasi kami.</p>
<p>&nbsp;</p>
<strong>Konten Anda di Layanan kami</strong>
<p>Beberapa Layanan kami memungkinkan Anda mengirim konten. Anda mempertahankan kepemilikan atas hak kekayaan intelektual yang Anda miliki dalam konten tersebut. Singkat kata, apa yang menjadi milik Anda akan tetap menjadi milik Anda.</p>
<p>&nbsp;</p>
<strong>Tentang Perangkat Lunak di Layanan kami</strong>
<p>Jika Layanan memerlukan atau berisi perangkat lunak yang dapat diunduh, perangkat lunak ini dapat diperbarui secara otomatis di perangkat Anda saat versi atau fitur baru telah tersedia. Beberapa Layanan memungkinkan Anda menyesuaikan setelan pembaruan otomatis.</p>
<p>&nbsp;</p>
<strong>Memodifikasi dan Menghentikan Layanan kami</strong>
<p>Kami terus mengubah dan menyempurnakan Layanan. Kami dapat menambah atau menghapus fungsi maupun fitur, dan kami juga dapat menangguhkan atau menghentikan Layanan sekaligus.</p>
</div>
<div class="footer_log">
<?php if( ! $login->user_check() ): ?>
<a class="left" href="./?login">Masuk</a>
<?php else:?>
<a class="left" href="./?login&go=profile">Profile</a>
<?php endif;?>
</div>
<?php
break;
}
?>
</div>
</body>
</html>