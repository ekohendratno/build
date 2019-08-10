<?php 
/**
 * @fileName: class-login.php
 * @dir: ilibs/
 */
if(!defined('_iEXEC')) exit;

class login{
	protected $referal_login = '?login';
	protected $referal_admin = '?admin';
	
	/*
	 * timer execution
	 * 
	 * return boolean true|false
	 */
	function timer(){
		$time = time() + get_option('timeout');			
		$_SESSION['iexec'] = $_SESSION['iexec'] + $time;
		return;
	}	
	/*
	 * chekking username
	 * return true|false
	 */
	function cek_login(){						
		return $this->exist( "user_name" );
	}
	/*
	 * chekking log $_SESSION or $_COOKIE 
	 * @param $param string
	 * return true|false
	 */
	function exist( $param ){
		//memanggil session
		
		if( isset( $_SESSION[$param] ) ){
			$sess = esc_sql( $_SESSION[$param] );
			
			if( !empty( $sess ) )
				return $sess;	
		}
		
		return false;
	}
	
	/*
	 * chekking value log $_SESSION atau $_COOKIE
	 * @param $param string
	 * return true|false
	 */
	function exist_value( $param ){
		//memanggil session
		
		if( isset( $_SESSION[$param] ) ){
			$sess = esc_sql( $_SESSION[$param] );
			
			if( !empty( $sess ) )
				return $sess;	
		}
		
		return false;
	}
	/*
	 * log out
	 * 
	 * return string
	 */
	function login_out(){	
		//unset / delete session
		unset( $_SESSION["user_name"] );
		unset( $_SESSION["user_level"] );
		//menghapus session
		//menghapus isi cookie
		//meredirek ke url user
		delete_directory( 'cache' );
		
		echo '<p class="message">Anda telah keluar dari website</p>';
		redirect( $this->referal_login );
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
	 * insert user data
	 * @param $userdata array
	 * return echo message
	 */
	function _in($data){
		global $db;
		
		extract($data, EXTR_SKIP);		
		$msg = $get_data_user = null;
		
		if( empty( $user_login ) ) 	
			$msg = 'Kolom username kosong.';
		elseif( empty( $user_pass ) ) 	
			$msg = 'Kolom sandi kosong.';
		elseif( $user_pass = md5($user_pass) ){
			$get_data_user = $this->get_data_user( compact('user_login','user_pass') );
		}
		
		if( empty($msg) && $get_data_user == null ){
			$msg = 'Nama pengguna atau sandi tidak valid. Klik di sini jika <a href="'.do_links('login',array('go'=>'lost')).'">Kehilangan kata sandi Anda?</a>';
		}
		
		if( !empty( $msg ) )
			printf('<div id="error"><strong>Kesalahan</strong>: %s </div>',$msg);
			
		if( empty($msg) && $get_data_user ){
			
			$data_compile = array_merge_simple( $get_data_user, array('rememberme' => $rememberme) );
			$save_log = $this->_log( $data_compile );
			if( $save_log ): 
			
				$redirect = true;
			
				$redirect_url = $this->referal_login;
				if( $this->exist_value('user_level') == 'admin' )
					$redirect_url = $this->referal_admin;
				
			endif;
		}
		
		if( $redirect ){
			echo '<div id="success">Redirect...</div>';
			redirect( site_url($redirect_url) );	
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
		
		$data_merge = array_merge_simple( $where, array('user_status'=>1) );
		$rows 		= $this->username_cek( $data_merge );
		$data 		= array( 'user_login' => $rows->user_login, 'user_level' => $rows->user_level);
		
		if( $rows->total > 0 && is_array( $data ) ) 
			return $data;	
	}	
	/*
	 * username cek 
	 * @param $data array
	 * return array
	 */
	function username_cek( $data ){
		global $db;
		
		$retval = false;
		if( $query	= $db->select('users',$data) ):
			$retval = object_merge_simple( 
				$db->fetch_obj($query), 
				array(
					'total' => $db->num($query) 
				) 
			);
		endif;
		
		return $retval;
	}
	/*
	 * function save_log()
	 * untuk menyimpan data user kedalam log baik cookie, session atau database
	 * using: $this->save_log($data)
	 */
	function _log( $data ){				
		extract($data, EXTR_SKIP);
		/*
		 * $session->set($param,$value)
		 * mulai mengeset session
		 */
		$_SESSION['user_name'] = esc_sql( $user_login );
		$_SESSION['user_level'] = esc_sql( $user_level );
		//$_SESSION['iexec'] = 1;				
		/*
		 * $this->session->timer()
		 * mulai mengeset timer time out log out
		 */			
		//$this->timer();	
		
		//memperbaharui data log
		$this->_log_update($data);
		return true;
	}
	/*
	 * save log update data
	 * @param $data array
	 * return redirect url
	 */
	function _log_update($data){
		global $db;
		
		extract($data, EXTR_SKIP);
		$user_last_update = date('Y-m-d H:i:s');
			
		$db->update( 'users', compact( 'user_last_update' ), compact( 'user_login','user_level' ) );
	}
	/*
	 * chekking lever user
	 * @param $param string
	 * return true|false
	 */
	function login_level( $param ){
		if( is_string($param) && !empty($param) ){
			
		 	if( $this->exist_value('user_level') == $param ) 
				return true;
		}
		
		return false;
	}
}