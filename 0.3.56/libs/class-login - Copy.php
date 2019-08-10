<?php 
/**
 * @fileName: class-login.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;

class login{
	protected $referal_login = '?login';
	protected $referal_admin = '?admin';
	
	function __construct(){
		//cons
	}
	/*
	 * timer execution
	 * 
	 * return boolean true|false
	 */
	function timer(){			
		$_SESSION['iexec'] = time() + get_option('timeout');
	}
	/*
	 * logout rediirect url
	 * return string
	 */
	function log_url(){
		$this->referal_login = do_links('login');
	}
	/*
	 * log out
	 * 
	 * return string
	 */
	function login_out(){	
		//referal url log
		$this->log_url();
		//unset / delete session
		unset( $_SESSION["user_name"] );
		unset( $_SESSION["user_level"] );
		//menghapus session
		//menghapus isi cookie
		//meredirek ke url user
		delete_directory( 'cache' );
		
		_e('<p class="message">Anda telah keluar dari website</p>');
		redirect( $this->referal_login );
	}
	/*
	 * username cek 
	 * @param $data array
	 * return array
	 */
	function username_cek($data){
		global $db;
		$query	= $db->select('users',$data);
		if($query){
			$row 	= $db->fetch_array($query);
			$obj 	= $db->fetch_obj($query);
			$cek   	= $db->num($query);
			return array('obj'=>$obj,'row'=>$row,'num'=>$cek);
		}
	}
	/*
	 * sign in 
	 * @param $data array
	 * return true|false
	 */
	function sign_in( $data ){
		extract($data, EXTR_SKIP);
		
		$user_login = esc_sql( $username );
		$user_pass  = esc_sql( $password );
		$rememberme = esc_sql( $remember );
		
		if( $rememberme == 1 ) $rememberme = 'on'; 
		else $rememberme = 'off';
		
		$data = compact('user_login', 'user_pass','rememberme');		
		$this->_in($data);
	}
	/*
	 * sign up 
	 * @param $data array
	 * return true|false
	 */
	function sign_up( $data ){
		extract($data, EXTR_SKIP);
		
		$user_login 	= esc_sql( $username );		
		$user_email 	= esc_sql( $email );		
		$password 		= esc_sql( $password );	
		$repassword 	= esc_sql( $repassword );		
		$user_sex 		= esc_sql( $sex );		
		$user_country 	= esc_sql( $country );
		$chekterm 		= esc_sql( $chekterm );
		
		$userdata = compact('user_login', 'user_email','password','repassword','user_sex','user_country','chekterm');
		$this->_up($userdata);
	}
	/*
	 * lost password
	 * @param $email string
	 * return echo message
	 */
	function lost_password($email){
		$user_email = esc_sql( $email );			
		if( $this->filter_lost_password( $user_email ) )
			_e('<p class="message">Link aktivasi telah dikirim ke email anda, silahkan melakukan aktivasi</p>');
		else 
			_e('<div id="error"><strong>ERROR</strong>: Gagal mengirim aktivasi ke email</div>');
	}
	/*
	 * activation key 
	 * @param $codeaktivasi string
	 * return echo message
	 */
	function activation($codeaktivasi){
		$key = esc_sql( $codeaktivasi );
		if( $this->filter_activation($key) )
			_e('<p class="message">Data telah dikirim ke email anda</p>');
		else 
			_e('<div id="error"><strong>ERROR</strong>: Gagal mengirim data ke email</div>');
	}	
	/*
	 * insert user data
	 * @param $userdata array
	 * return echo message
	 */
	function _in($userdata){
		global $db;
		
		extract($userdata, EXTR_SKIP);		
		$msg = $data = '';
		$redirect = false;
		
		if( empty( $user_login ) ) 	
			$msg = 'Kolom username kosong.';
		elseif( empty( $user_pass ) ) 	
			$msg = 'Kolom sandi kosong.';
		elseif( $user_pass = md5($user_pass) ){
			$data = $this->get_data_user( compact('user_login','user_pass') );
		}
		
		if( empty($msg) && $data == null ){
			$msg = 'Nama pengguna atau sandi tidak valid. Klik di sini jika <a href="'.do_links('login',array('go'=>'lost')).'">Kehilangan kata sandi Anda?</a>';
		}
		
		if( !empty($msg) )
			printf('<div id="error"><strong>Kesalahan</strong>: %s </div>',$msg);
		
		if( empty($msg) && $data ){
			$data = array_merge_simple( $data, array('rememberme' => $rememberme) );
			$save_log = $this->_save_log( $data );
			
			if( $save_log && $this->cek_login() ) 
				$redirect = true;
		}
		
		$redirect_url = $this->referal_login;
		if( $this->login_level('admin') )
			$redirect_url = $this->referal_admin;
		
		if( $redirect ){
			echo '<div id="success">Redirect...</div>';
			redirect( site_url($redirect) );	
		}
		
	}		
	/*
	 * update data user
	 * @param $userdata array
	 * return echo message
	 */
	function _up($userdata){
		global $db;
		
		extract($userdata, EXTR_SKIP);				
		$msg = array();
		
		if( empty( $user_login ) ){
			$msg[] = 'The username field is empty.';
		}else{
			$field = $this->username_cek( compact('user_login') );
			if($field['num'] > 0) $msg[] = 'Username "'.$user_login.'" sudah terpakai, silahkan ganti yg lain</a>';
		}
		
		
		if( empty( $user_email ) ) $msg[] = 'Kolom email kosong.';
		else{
			
			if( !valid_mail( $user_email ) ){	
				$msg[] = 'Email tidak valid.';
			}else{
				$field = $this->username_cek( compact('user_email') );
				if( $field['num'] > 0) $msg[] = 'Email ini sudah pernah melakukkan registrasi</a>';
			}
		
		}
		
		if( empty( $password ) ){
			$msg[] = 'The password field is empty.';
		}elseif( $password != $repassword ){
			$msg[] = 'The password not match.';			
		}
				
		if( $user_sex == 1 ) $user_sex = 0;
		elseif( $user_sex == 2 ) $user_sex = 1;	
		else $msg[] = 'Kolom jenis kelamin belum dipilih.';	
		
		if( empty( $chekterm ) ) $msg[] = 'Peraturan belum dicentang.';
		
		if( $msg != null && is_array($msg))	{
			foreach($msg as $val){
				echo "<div id=\"error\"><strong>Salah</strong>: $val </div>";
			}
		}else{			
			$user_level 			= 'user'; // default
			$user_activation_key 	= random_password(20, false);
			$user_registered 		= date('Y-m-d H:i:s');
			$user_last_update 		= $user_registered;
			$user_pass 				= md5($repassword);
			$user_author 			= $user_login;
			$user_status			= 0;
			
			$data 		= compact('user_login','user_author','user_email','user_pass','user_sex','user_registered','user_last_update','user_status','user_country','user_activation_key');
			
			if( $db->insert( 'users', $data) ){
				
				$user_data = compact('user_email','user_activation_key');
				
				if( $this->message_activation($user_data) )
				echo '<div id="success">Anda berhasil menambahkan akun, cek email kamu untuk verifikasi</div>';
			}
		}
	}
	/*
	 * get data user
	 * @param $param_data array
	 * return array
	 */
	function get_data_user($param_data){
		extract($param_data, EXTR_SKIP);
		
		if( valid_mail($user_login) && $user_email = $user_login ){
			$where 	= compact('user_email','user_pass');
				
		}
		else
		{			
			$where 	= compact('user_login','user_pass');
		}
		
		
		$row 	= $this->username_cek( array_merge_simple( $where, array('user_status'=>1) ) );
		$data 	= array('user_login'=>$row['row']['user_login'],'user_level'=>$row['row']['user_level']);
		
		if( $row['num'] > 0 && is_array( $data ) ) 
			return $data;	
	}	
	/*
	 * convert array to base 64
	 * @param $data array
	 * return base 64
	 */
	function __convert_to_encode($data){		
		$json = new JSON();
		return base64_encode( $json->jencode( $data ) );
	}	
	/*
	 * conver array to base 64
	 * @param $data array
	 * return json
	 */
	function __convert_to_decode($data){	
	
		if( empty( $data ) )
			return false;
			
		$json = new JSON();
		return $json->decode( base64_decode( $data ) );
	}
	/*
	 * save log
	 * @param $data array
	 * return true|false
	 */
	function _save_log($data){				
		extract($data, EXTR_SKIP);
		add_activity('sign_in','mengakses site', 'log', $user_login);
			/*
			* $session->set($param,$value)
			* mulai mengeset session
			*/
			$_SESSION['user_name'] = esc_sql( $user_login );
			$_SESSION['user_level'] = esc_sql( $user_level );	
			$_SESSION['iexec'] = 1;	
			/*
			 * $this->session->timer()
			 * mulai mengeset timer time out log out
			 */			
			//$this->timer();	
		
			//memperbaharui data log
			$this->_save_log_update($data);
		
	}	
	/*
	 * save log update data
	 * @param $data array
	 * return redirect url
	 */
	function _save_log_update($data){
		global $db;
		extract($data, EXTR_SKIP);
		
		//referal url log
		$this->log_url();
			
		$user_last_update = date('Y-m-d H:i:s');
			
		$db->update( 'users', compact( 'user_last_update' ), compact( 'user_login','user_level' ) );
			
		if($user_level == 'admin') redirect( $this->referal_admin );
		else redirect( $this->referal_login );
	}
	
	/*
	 * chekking lever user
	 * @param $param string
	 * return true|false
	 */
	function login_level($param){
		if( is_string($param) && !empty($param) ){
			
		 	if( $this->exist_value('user_level') == $param ) 
			return true;
		}
		
		return false;
	}	
	
	/*
	 * chekking log $_SESSION or $_COOKIE 
	 * @param $param string
	 * return true|false
	 */
	function exist($param){
		//memanggil session
		$sess	= esc_sql( $_SESSION[$param] );
		
		if( isset( $sess ) ){
			if( isset($sess) && !empty($sess) ):
				
				if( time() < $_SESSION['iexec'] ) $this->timer();
				else $this->login_out();
				
				return true;
			endif;
		}
		
		return false;
	}
	
	/*
	 * chekking value log $_SESSION atau $_COOKIE
	 * @param $param string
	 * return true|false
	 */
	function exist_value($param){
		//memanggil session
		$sess	= esc_sql( $_SESSION[$param] );
		
		if( isset( $sess ) ){
			
			if( isset($sess) && !empty($sess) )
				return $sess;	
		}
		
		return false;
	}
	/*
	 * chekking username
	 * return true|false
	 */
	function cek_login(){						
		return $this->exist("user_name");
	}
	/*
	 * update user data
	 * @param $usredata
	 * return filter data for update
	 */
	function update_user($userdata){
		extract($userdata, EXTR_SKIP);
		
		$user_id 		= esc_sql( $user_id );
		$user_login 	= esc_sql( $username );
		$user_email 	= esc_sql( $email );
		$user_sex		= esc_sql( $sex );
		$user_author	= esc_sql( $author );
		$thumb			= esc_sql( $thumb );
		$user_country	= esc_sql( $country );
		$user_province	= esc_sql( $province );
		$user_url		= esc_sql( $website );
		
		$userdata = compact('user_login', 'user_email', 'user_sex','user_author', 'user_id','thumb','user_country','user_province','user_url');
		$this->filter_user_update($userdata);
	}
	/*
	 * validation username using pattern
	 * return true|false
	 */
	function valid_username($input,$pattern = '[^A-Za-z0-9]'){

	  return !ereg($pattern,$input);
	//return preg_match('!^[a-z0-9_~]{1,30}$!i', $param);
	}
	/*
	 * change password
	 * @param $data array
	 * @param $where array
	 * return true|false
	 */
	function change_password($data,$where){	
		global $db;	
		$user_last_update	= date('Y-m-d H:i:s');	
		return $db->update( 'users', $data + compact('user_last_update'),$where );	
	}
	/*
	 * validation username using name or mail
	 * @param $user_login  string
	 * @param $user_mail string
	 * return array
	 */
	function valid_username2($user_login, $user_mail){
		$field = false;
		
		if( !empty($user_mail) && valid_mail( $user_mail ) ){	
			$compact = compact( 'user_email' );
		}elseif( !empty($user_login) && $this->valid_username($user_login) ){			
			$compact = compact( 'user_login' );
		}
		
		$field = $this->username_cek( $compact );
		
		return $field['obj'];
	}
	/*
	 * user filter dan update data
	 * @param $userdata array
	 * return echo message and redirect url
	 */
	function filter_user_update( $userdata ){
		global $db;
		extract($userdata, EXTR_SKIP);
		
		$ID = (int) $user_id;
		$user_last_update = date('Y-m-d H:i:s');
		
		$msg = array();
		if( empty($user_author) ) $msg[] = '<strong>Salah</strong>: Kolom nama kosong';
		if( empty( $user_email ) ) $msg[] = '<strong>Salah</strong>: Kolom email kosong.';
		elseif( !valid_mail( $user_email ) ) $msg[] = '<strong>Salah</strong>: Email tidak valid.';		
		
		if( $user_sex == 1 ) $user_sex = 0;
		elseif( $user_sex == 2 ) $user_sex = 1;
		else $msg[] = '<strong>Salah</strong>: Kolom jenis kelamin belum dipilih';
		if( empty($user_country) ) $msg[] = '<strong>Salah</strong>: Kolom negara belum dipilih';
		
		if( is_array($msg) ){
			foreach($msg as $val) echo '<div id="error">'.$val.' </div>';
		}
		
		$field = $this->username_cek( compact( 'ID' ) );
		
		if(!empty($thumb['name'])):
			$thumb	= hash_image( $thumb );
			$user_avatar = esc_sql($thumb['name']);
			//thumb extract		
			$thumb[name] = 'avatar_' . $thumb[name];
			$thumb[type] = $thumb[type];
			$thumb[tmp_name] = $thumb[tmp_name];
			$thumb[error] = $thumb[error];
			$thumb[size] = $thumb[size];
			
			upload_img_post($thumb,'',650,120);
			
			del_img_post('avatar_'.$field['row']['user_avatar']);
		else:
			$user_avatar = esc_sql($field['row']['user_avatar']);
		endif;
		
		$data = compact('user_login','user_email','user_author','user_sex','user_last_update','user_country','user_province','user_url','user_avatar');
			
		if( $msg == null && $db->update( 'users', $data, compact( 'ID' ) ) ):
			echo '<div id="success">Berhasil memperbaharui akun</div>';
			redirect( site_url('?' . $_SERVER['QUERY_STRING']) );
		endif;
	}
	/*
	 * send message activation
	 * @param $data array
	 * return echo message
	 */
	function message_activation($data){	
		global $iw;
		extract($data, EXTR_SKIP);	
				
		$head  = 'Activation Registration<br><br>';
		$send .= '<b>'.$head.'</b><br>';
		$send .= "Seseorang telah mendaftarkan akun email anda di <a href=\"$iw->base_url\">$iw->base_url</a><br><br>";
		$send .= sprintf('Your Email: %s', $user_email) . "<br>";
		$send .= sprintf('Activation Code: %s', $user_activation_key) . "<br>";
		$send .= 'Tautan aktivasi : <a target="_blank" href="'.$iw->base_url.'index.php?login&go=activation&keys='.$user_activation_key.'">'.$iw->base_url.'index.php?login&go=activation&keys='.$user_activation_key.'"</a><br><br>';
		$send .= 'Ini adalah email otomatis, diharapkan tidak membalas email ini<br>';
		
		if( mail_send($user_email, $head, $send) )
			_e('<p class="message">Link aktivasi telah dikirim ke email anda, silahkan melakukan aktivasi</p>');
		else 
			_e('<div id="error"><strong>ERROR</strong>: Gagal mengirim aktivasi ke email</div>');
	}	
	/*
	 * send message registration member
	 * @param $data array
	 * return echo message
	 */
	function message_reg($data){	
		global $iw;
		extract($data, EXTR_SKIP);	
		
		$head  = 'Login Data Registration<br><br>';
		$send .= '<b>'.$head.'</b><br>';
		$send .= 'Akun anda sudah diaktifkan berikut data datanya<br><br>';
		$send .= sprintf('Email: %s', $email) . "<br>";
		$send .= sprintf('User Name: %s', $login) . "<br>";
		$send .= sprintf('Password: %s', $new_pass) . "<br>";
		$send .= sprintf('Jenis Kelamin: %s', $user_sex) . "<br>";
		$send .= 'Country: Unknow (please change)<br>';
		$send .= 'Province: Unknow (please change)<br><br>';
		$send .= 'Silahkan kunjungi website : <a target="_blank" href="'.$iw->base_url.'">'.$iw->base_url.'"</a> dan ubah profile kamu<br><br>' ;
		$send .= 'Ini adalah email otomatis, diharapkan tidak membalas email ini<br>';
		
		if( mail_send($email, $head, $send) )
			_e('<p class="message">Akun dan Sandi telah dikirim ke email anda, silahkan login</p>');
		else 
			_e('<div id="error"><strong>ERROR</strong>: Gagal mengirim aktivasi ke email.</div>');
	}	
	/*
	 * send message lost password
	 * @param $data array
	 * return echo message
	 */
	function message_lost($data){	
		global $iw;
		extract($data, EXTR_SKIP);	
				
		$head  = 'Your Login Data<br><br>';
				
		$send .= '<b>'.$head.'</b><br>';
		$send .= 'Ini data akun anda<br><br>';
		$send .= sprintf('Email: %s', $email) . "<br>";
		$send .= sprintf('User Name: %s', $login) . "<br>";
		$send .= sprintf('Password: %s', $new_pass) . "<br>";
		$send .= 'Silahkan kunjungi website : <a target="_blank" href="'.$iw->base_url.'">'.$iw->base_url.'"</a> dan ubah profile kamu<br><br>' ;
		$send .= 'Ini adalah email otomatis, diharapkan tidak membalas email ini<br>';
		
		if(mail_send($email, $head, $send))
		_e('<p class="message">Akun dan Sandi telah dikirim ke email anda, silahkan login</p>');
		else _e('<div id="error"><strong>ERROR</strong>: There are some glitches in the process of sending a message.</div>');
	}	
	/*
	 * filtering activation
	 * @param $key string
	 * return echo message and log in
	 */
	function filter_activation($key){
		global $db;
		
		$msg = array();
		
		if( empty( $key ) ) 	
			$msg[] = '<strong>ERROR</strong>: The code activation field is empty.';
			
		$field = $this->username_cek( array('user_activation_key' => $key) );
		
		if( $field['num'] == 0 ){ 	
			$msg[] = '<strong>ERROR</strong>: The code activation not valid.';
		}else{
			if( empty($msg) ){
			$new_pass			= random_password();
			$user_pass			= has_password($new_pass);
			$user_last_update 	= date('Y-m-d H:i:s');
			$user_status	 	= 1;
			
			$data = compact('user_pass','user_last_update','user_status');			
			$userupdate = $db->update( 'users', $data + array('user_activation_key' => ''), array('user_activation_key' => $key) );
			if($userupdate){
				$login = $field['row']['user_login'];
				$email = $field['row']['user_email'];
				$sex   = $field['row']['user_sex'];
				
				if($sex == 0) $user_sex = 'Perempuan';
				elseif($sex == 1) $user_sex = 'Laki - laki';
				else $user_sex = 'Unknow';
				
				$user_data = compact('login','email','user_sex','new_pass');
				
				if( $this->message_reg($user_data) )
				$this->sign_in( array('username' => $login, 'password' => $new_pass, 'remember' => 1) );
				
			}}
		}
		if( is_array($msg))	{
			foreach($msg as $val){
			_e('<div id="error">'.$val.' </div>');
			}
		}
	}	
	/*
	 * filtering data lost password
	 * @param $user_mail string
	 * return echo message
	 */
	function filter_lost_password($user_email){
		global $db;
	
		if( empty( $user_email ) )
			$msg[] = '<strong>ERROR</strong>: The email field is empty.';
		else
		if( !valid_mail( $user_email ) ) 	
			$msg[] = '<strong>ERROR</strong>: The email not valid.';
			
		$field = $this->username_cek( compact('user_email') );
		
		if( $field['num'] == 0 ):	
			$msg[] = '<strong>ERROR</strong>: The email not registration.';
		else:
			if(empty($msg)):
			$user_activation_key 	= random_password(20, false);
			$user_last_update 		= date('Y-m-d H:i:s');
			
			$data = compact('user_last_update','user_activation_key');			
			$userupdate = $db->update( 'users', $data, compact('user_email') );
			if( $userupdate ):
				
				$user_data = compact('user_email','user_activation_key');
				$this->message_activation($user_data);
				
			endif;
			endif;
		endif;
		
		if( is_array($msg))	{
			foreach($msg as $val){
			_e('<div id="error">'.$val.' </div>');
			}
		}
	}
}