<?php 
/**
 * @fileName: login.php
 * @dir: admin/
 */
if(!defined('_iEXEC')) exit;
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php the_login_title()?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="libs/css/bootstrap.css" rel="stylesheet" id="bootstrap-css">
    <script src="libs/js/jquery-1.10.2.js"></script>
    <script src="libs/js/bootstrap.min.js"></script>
	<?php the_head_login()?>
</head>
<body>   

<div class="container">   

<?php 

switch( get_query_var('login')){
default:

if( $login->check() ):
	if( $_GET['login'] == 'logout' ){
		$login->login_out();
	}

	$user_login = $login->exist_value('username');
 
	$r  = $db->fetch_array( $db->select( 'users', compact('user_login') ) );
						
	$image_url = content_url('/uploads/avatar_'.$r['user_avatar']);
	if( get_option('avatar_type') == 'gravatar' )
		$image_url = 'http://www.gravatar.com/avatar/?d=mm';
?>
        <div id="loginbox" style="margin-top:20px;" class="mainbox col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">                    
            <div class="panel panel-default" >
                    <div class="panel-heading">
					<a href="?login=profile"><i class="glyphicon glyphicon-chevron-left"></i> Status</a>
					<div class="pull-right"> 
						<a href="?admin" class="pull-right"><i class="glyphicon glyphicon-th-list"></i> Manage Dashboard</a> 
					</div>
					</div>
                    <div class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                                    
							<center>
							<img src="?request&load=libs/timthumb.php&src=<?php echo $image_url;?>&w=100&h=100&zc=1" class="img-circle" alt="Cinque Terre" height="100" width="100" style="margin-bottom:20px;" >
                            <h4><?php echo $r['user_author']?></h4>
							<p class="text-muted">@<?php echo $r['user_login'];?><br>Login Date/Time: <?php echo $r['user_last_update']?></p>
							<a href="?login=logout" id="btn-login" class="btn btn-primary btn-danger btn-lg btn-block">Logout</a>
							
							</center>
				</div>
            </div>    
        </div>
 <?php else:?>
        <div id="loginbox" style="margin-top:20px;" class="mainbox col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">                    
            <div class="panel panel-default" >
                    <div class="panel-body" >
                            
                        <form id="loginform" class="form-horizontal" role="form" action="" method="post">
                                    
                            
						<?php
						if( isset($_POST['login']) ){
							$username 		= filter_txt($_POST['username']);
							$password 		= filter_txt($_POST['password']);	
							$remember 		= filter_int($_POST['remember']);
							
							$login->sign_in( compact('username','password','remember') );
							
							if( count($login->text_message) > 0 ){
							
								if( $login->text_message[type] == 'error' ){
								?>		
                        <div style="display:visible" id="login-alert" class="alert alert-danger col-sm-12"><?php echo $login->text_message[text];?></div>
						<?php	
								}else
								if( $login->text_message[type] == 'success' ){
								?>		
                        <div style="display:visible" id="login-alert" class="alert alert-success col-sm-12"><?php echo $login->text_message[text];?></div>
						<?php	
								}else
								if( $login->text_message[type] == 'message' ){
								?>		
                        <div style="display:visible" id="login-alert" class="alert alert-info col-sm-12"><?php echo $login->text_message[text];?></div>
						<?php	
								}
							}
						}
								
						?>
                            
                            
                           <div class="clearfix"></div>
							<center>
                            <div class="form-group-lg input-group">
							<input id="login-username" type="text" class="form-control" name="username" value="" placeholder="Masukkan pengguna / email" autofocus>
							<input id="login-password" type="password" class="form-control" name="password" placeholder="Masukkan sandi">
							<div class="checkbox pull-left">
							<label>
								<input id="login-remember" type="checkbox" name="remember" value="1"> Remember me
                            </label>
                            </div>
							<button id="btn-login" class="btn btn-primary btn-success btn-lg btn-block" type="submit" name="login">Login</button>
							<!--
							<center>OR</center>
							<button id="btn-fblogin" class="btn btn-primary btn-lg btn-block">Login with Facebook</button>
							-->
							</div>
							<div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="padding-top:15px;" >
                                            Don't have an account! 
                                        <a href="?login=register">
                                            Sign Up Here
                                        </a>
										or
                                        <a href="?login=lost">
                                            Lost
                                        </a>
                                        </div>
                                    </div>
                                </div>   
							</center> 
                        </form>   



                    </div>                     
            </div>  
        </div>
<?php
endif; 
break;
case 'register':
?>
  
        <div id="loginbox" style="margin-top:20px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-default" >
                    <div class="panel-heading">
					<a href="?login"><i class="glyphicon glyphicon-chevron-left"></i> Register</a>
					<div class="pull-right"> 
						<a href="?admin" class="pull-right"><i class="glyphicon glyphicon-th-list"></i> Manage Dashboard</a> 
					</div>
					</div>
                    <div class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" action="" method="post">
                            <div class="form-group">
                                <label for="username" class="col-md-3 control-label">Username</label>
                                <div class="col-md-9">
                                    <input type="username" class="form-control" name="username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-3 control-label">Password</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="passwd" placeholder="Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-md-3 control-label">Retry Password</label>
                                <div class="col-md-9">
                                    <input type="password" class="form-control" name="retrypasswd" placeholder="Retry Password">
                                </div>
                            </div>
							<div class="form-group">
							  <label for="inputEmail" class="col-md-3 control-label">Email</label>
							  <div class="col-md-9">
								<input class="form-control" id="inputEmail" placeholder="Email" type="text">
							  </div>
							</div>
							<div class="form-group">
								<label for="select" class="col-md-3 control-label">Saya seorang</label>
								<div class="col-md-9">
									<select class="form-control" id="select">
									  <option>Laki-laki</option>
									  <option>Perempuan</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="select" class="col-md-3 control-label">Saya di</label>
								<div class="col-md-9">
									<select class="form-control" id="select">
									  <option>Indonesia</option>
									  <option>Luar negeri</option>
									</select>
									<div class="checkbox">
									<label>
										<input id="login-remember" type="checkbox" name="remember" value="1"> Saya setuju <a href="?login=termofuse">peraturan</a> ini?
									</label>
									</div>
								</div>
							</div>  
							
                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="button" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
                                        <span style="margin-left:8px;">or</span>  
                                        <button id="btn-fbsignup" type="button" class="btn btn-primary"><i class="icon-facebook"></i>   Sign Up with Facebook</button>
                                    </div>                                           
                                        
                                </div>
                        </form>   



                    </div>                     
            </div>  
        </div>
<?php
break;
case 'lost':
?>

        <div id="loginbox" style="margin-top:20px;" class="mainbox col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">                    
            <div class="panel panel-default" >
                    <div class="panel-heading">
					<a href="?login"><i class="glyphicon glyphicon-chevron-left"></i> Lost</a>
					</div>
                    <div class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" action="" method="post">
                                    
                            <div class="form-group-lg">
							<input id="login-username" type="text" class="form-control" name="username" value="" placeholder="Masukkan pengguna / email"><br>
							<button id="btn-login" class="btn btn-primary btn-info btn-lg btn-block" type="submit">Sended</button>
							</div>  
                        </form>   



                    </div>                     
            </div>  
        </div>
<?php
break;
case 'termofuse':
?>

        <div id="loginbox" style="margin-top:20px;" class="mainbox col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">                      
            <div class="panel panel-default" >
                    <div class="panel-heading">
					<a href="?login=register"><i class="glyphicon glyphicon-chevron-left"></i> Petunjuk penggunaan</a>
					</div>
                    <div class="panel-body" >
<fieldset>
    <legend>Aturan Umum dari portal</legend>
<ol>
<li>Portal kami dibuka untuk mengunjungi oleh semua orang tertarik. Untuk menggunakan semua ukuran jasa sebuah situs, perlu bagi Anda untuk mendaftar.</li>
<li>Pengguna portal bisa menjadi setiap orang, setuju untuk mematuhi aturan yang diberikan.</li>
<li>Setiap peserta dialog memiliki hak untuk kerahasiaan informasi. Oleh karena itu tidak membahas keuangan, keluarga dan kepentingan peserta lainnya tanpa izin di atasnya peserta.</li>
<li>Panggilan di situs terjadi pada &quot;Anda&quot;. Ini bukan tanda sopan atau ramah dalam kaitannya dengan teman bicara.</li>
<li>Portal kami - postmoderated. Informasi yang ditempatkan di situs, awal tidak dilihat dan tidak diedit, tetapi administrasi dan moderator berhak untuk dirinya sendiri agar nanti.</li>
<li>Semua pesan mencerminkan hanya pendapat penulisnya.</li>
<li>Urutan di portal ini diawasi oleh moderator. Mereka memiliki hak untuk mengedit, menghapus pesan dan untuk menutup mata pelajaran di bagian diperiksa oleh mereka.</li>
<li>Sebelum penciptaan subjek baru di forum, disarankan untuk mengambil keuntungan dari pencarian. Mungkin pertanyaan yang Anda ingin mengatur, sudah dibahas. Jika Anda memiliki troubleshot oleh kekuatan sendiri, silahkan, menulis tentang hal ini, dengan instruksi tentang bagaimana Anda membuatnya. Jika ingin menutup atau subject pesan, menginformasikan di atasnya untuk moderator.</li>
<li>Buat pelajaran baru hanya dalam bagian yang tepat. Jika subjek tidak mendekati di bawah salah satu bagian atau Anda meragukan kebenaran dari pilihan - menciptakannya dalam bagian dari sebuah forum &quot;papan Buletin&quot;.</li>
<li>Sebelum mengirim pesan atau menggunakan jasa portal, Anda diwajibkan untuk membiasakan dengan aturan umum, dan juga aturan departemen yang erat.</li>
<li>Dalam kasus pelanggaran kasar aturan, manajer berhak untuk dirinya sendiri untuk menghilangkan pengguna dari sebuah situs tanpa peringatan. Pendaftaran ulang dari pengguna dalam kasus menghapus dihilangkan.</li>
<li>Manajer berhak untuk dirinya sendiri untuk mengubah aturan yang diberikan tanpa pemberitahuan sebelumnya. Semua perubahan diberlakukan dari saat publikasi mereka.</li>
<li>Informasi dan link yang disajikan secara eksklusif dalam tujuan pendidikan dan ditujukan hanya untuk kepuasan rasa ingin tahu pengunjung.</li>
<li>Anda berjanji untuk tidak menerapkan informasi yang diterima dengan pemandangan, dilarang FC Federasi dan norma-norma hukum internasional Rusia.</li>
<li>Penulis situs yang diberikan tidak membawa tanggung jawab untuk konsekuensi dari penggunaan informasi dan link.</li>
<li>Jika Anda tidak setuju dengan persyaratan yang disebutkan di atas, dalam hal bahwa Anda harus meninggalkan situs kami segera.</li>
</ol><br>
<legend>Di situs itu dilarang</legend>
<ul>
<li>Untuk memecahkan subyek forum dan bagian.</li>
<li>Untuk membuat mata pelajaran yang baru-baru sudah dibahas dalam forum yang sama.</li>
<li>Untuk membuat subjek yang sama dalam beberapa bagian.</li>
<li>Untuk membuat subyek dengan nama kosong.</li>
<li>Untuk menggunakan tidak normatif leksikon, ekspresi kasar dalam kaitannya dengan teman bicara, menyinggung perasaan nasional atau keagamaan lawan bicara, dan juga untuk menulis huruf besar pesan.</li>
<li>Untuk menempatkan iklan. Iklan link ke situs dipromosikan, dengan alamat atau tanpa juga dianggap, atau homepage di tanda tangan.</li>
<li>Untuk mengekspos retak, nomor serial untuk program atau program yang telah retak. Juga dilarang untuk meninggalkan link ke mereka.</li>
<li>Untuk menulis pesan, yang tidak membawa informasi yang berguna (banjir, offtop) di bagian subjek.</li>
<li>Untuk mendiskusikan dan mengutuk operasi moderator dan administrasi, mungkin hanya dalam korespondensi pribadi atau keluhan, administrasi diarahkan dari portal.</li>
</ul>
</fieldset>

                    </div>                     
            </div>  
        </div>
		 

<?php
break;
case 'profile':
?>
 
        <div id="loginbox" style="margin-top:20px;" class="mainbox col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-default" >
                    <div class="panel-heading">
					<a href="?login"><i class="glyphicon glyphicon-chevron-left"></i> Profile</a>
					<div class="pull-right"> 
						<a href="?admin" class="pull-right"><i class="glyphicon glyphicon-th-list"></i> Manage Dashboard</a> 
					</div>
					</div>
                    <div class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" action="" method="post">
						
						<div class="col-md-5">
									<div class="btn-group btn-group-justified">
									  <a href="#" class="btn btn-default" onClick="$('#img-gravatar').hide(); $('#img-local').show()">Local</a>
									  <a href="#" class="btn btn-default" onClick="$('#img-local').hide(); $('#img-gravatar').show()">Gravatar</a>
									</div>
							<div id="img-local">
								<center>								
									<img src="libs/img/cinqueterre.jpg" class="img-circle" alt="Cinque Terre" height="100" width="100" style="margin:20px 0;" >
									<h4>Eko Azza</h4>								
								</center>
							
								<div class="form-group">
									<div class="col-md-12">
										<input name="thumb" class="form-control" type="file">
									</div>
								</div>
							</div>
							<div id="img-gravatar" style="display:none">
								<center>
								<a href="http://www.gravatar.com/" title="Clik for Change Gravatar" target="_blank">
									<img class="img-rounded"  height="100" width="100" style="margin:20px 0;" src="http://0.gravatar.com/avatar/8e72e2c28090a7490d2042890c7459e2?s=180&amp;d=http%3A%2F%2F0.gravatar.com%2Favatar%2Fad516503a11cd5ca435acc9bb6523536%3Fs%3D180">
								</a>
								</center>
							</div>
							
                            <div class="form-group">
                                <!-- Button -->                                        
                                <div class="col-md-12">
                                    <button id="btn-login" class="btn btn-primary btn-info btn-lg btn-block" type="submit">Update</button>
                                </div>                                           
                                        
                            </div>
						</div>
						<div class="col-md-7" style="border-left:1px solid #f2f2f2;">
                            <div class="form-group">
                                <label for="username" class="col-md-4 control-label">Username</label>
                                <div class="col-md-8">
                                    <input type="username" class="form-control" name="username" placeholder="Username" disabled="" value="ekoazza">
                                </div>
                            </div>
							<div class="form-group">
							  <label for="email" class="col-md-4 control-label">Email</label>
							  <div class="col-md-8">
								<input class="form-control" id="email" placeholder="Email" type="text" value="admin@cmsid.org">
							  </div>
							</div>
							<div class="form-group">
							  <label for="author" class="col-md-4 control-label">Author</label>
							  <div class="col-md-8">
								<input class="form-control" id="author" placeholder="Author" type="text" value="Eko Azza">
							  </div>
							</div>
							<div class="form-group">
								<label for="sex" class="col-md-4 control-label">Saya seorang</label>
								<div class="col-md-8">
									<select class="form-control" id="sex">
									  <option>Laki-laki</option>
									  <option>Perempuan</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="country" class="col-md-4 control-label">Saya di</label>
								<div class="col-md-8">
									<select class="form-control" id="country">
									  <option>Indonesia</option>
									  <option>Luar negeri</option>
									</select>
								</div>
							</div>  
							<div class="form-group">
							  <label for="province" class="col-md-4 control-label">Provinsi</label>
							  <div class="col-md-8">
								<input class="form-control" id="province" placeholder="Provinsi" type="text" value="Kalianda">
							  </div>
							</div>
							<div class="form-group">
							  <label for="website" class="col-md-4 control-label">Website</label>
							  <div class="col-md-8">
								<textarea class="form-control" rows="3" id="website">http://cmsid.org</textarea>
							  </div>
							</div>
							</div>
                        </form>   



                    </div>                     
            </div>  
        </div>
		 

<?php
break;
}
?>

</div>
    
</body>
</html>
