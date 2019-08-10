<?php
/**
 * @file func.php
 * 
 */
 
//not direct login
if(!defined('_iEXEC')) exit;

if(!function_exists('save_comment')){
	function save_comment($data){	
	global $db;	
		extract($data, EXTR_SKIP);
		
		$waiting_comment = '';
		if($approved    != 1) $waiting_comment ='<em>Your comment is awaiting moderation.</em><br>';
		
		$user = get_user_post();
		if($user->user_level != 'admin')
		posted('contact');
		
		if($db->insert('post_comment',$data)) 
		echo '<div class="div_info">Komentar berhasil. '.$waiting_comment.' </div>';
	}
}

if(!function_exists('filter_comment')){
	function filter_comment($data){
		global $login;
		extract($data, EXTR_SKIP);
		
		$author 		= esc_sql($author);
		$user_id		= esc_sql($user);
		$email 			= esc_sql($email);
		$comment 		= esc_sql($comment);
		$date 			= date('Y-m-d H:i:s');
		$date 			= esc_sql($date);
		$approved		= esc_sql($approved);
		$comment_parent	= esc_sql($reply);
		$post_id		= esc_sql($post_id);
		$time			= time();
		
		if( $login->cek_login() && $login->login_level('admin') ) $approved = 1;
		
		$data 		= compact('user_id','author','email','comment','date','time','approved','comment_parent','post_id');
		save_comment($data);
	}
}

if(!function_exists('get_user_post')){
	function get_user_post(){	
	global $login;
	
		$user_login = $login->exist_value('user_name');
		$field 		= $login->username_cek( compact('user_login') );

		return $field;
	}
}

if(!function_exists('set_comment')){
	function set_comment($data){
		
		extract($data, EXTR_SKIP);
		
		if(!$author)  			 $error .= "Nama kosong<br />";
		if(!$email)  			 $error .= "Mail kosong<br />";
		if(!valid_mail($email))  $error .= "Format Mail salah<br />";		
		if(empty($comment))   	 $error .= "Isi Komentar kosong<br />"; 
		
		if($gfx_check != $_SESSION['Var_session'] or !isset($_SESSION['Var_session'])) $error .= "Code failed<br>";
		
		if(cek_post('comment')==1)
		$error .= 'Maaf anda sudah berkomentar, silahkan tunggu beberapa menit untuk berkomentar lagi.<br>';
		
		if($error){
			echo'<div class="div_alert">'.$error.'</div>';
		}else{						
			filter_comment($data);
		}
	}
}

if(!function_exists('post_user_login')){
	function post_user_login(){
		global $login;
		return $login->cek_login();
	}
}

if(!function_exists('count_comment')){
	function count_comment($id){
		global $db;
		
		$qry_comment			= $db->select("post_comment",array('post_id'=>$id,'approved'=>1,'comment_parent'=>0)); 
		$num1					= $db->num($qry_comment);
		$num2					= 0;
		while ($data			= $db->fetch_array($qry_comment)) {
			$no_comment 		= filter_int( $data['comment_id'] );
						
			$qry_comment2		= $db->select("post_comment",array('approved'=>1,'comment_parent'=>$no_comment)); 
			$num2				= $num2+$db->num($qry_comment2);
		}
		return $num1+$num2;	
		
	}
}

/*
 * Function for user Album Manager
 */
 
if(!function_exists('apps_url_post')){
	function apps_url_post($file){
	if( file_exists( application_path . 'post/'.$file ) && !empty($file) )
		return content_url( 'applications/post/'.$file );
	}
}

if(!function_exists('is_admin')){
	function is_admin(){
		global $login;
		$user_level	= esc_sql($login->exist_value('user_level'));
		if($user_level == 'admin') return true;
	}
}

if(!function_exists('the_login_name')){
	function the_login_name(){
		global $login;
		return esc_sql($login->exist_value('user_name'));
	}
}

if(!function_exists('view_post')){
	function view_post($id){
		global $db;
		
		$where = compact('id') + array('type'=>'post');
		$user_login = the_login_name();
		if(!is_admin()) $where = compact('id') + array('type'=>'post','user_login' => $user_login);
		
		$q	 = $db->select("post", $where);
		return $db->fetch_array($q);
	}
}

if(!function_exists('user_update_post')){
	function user_update_post($data,$id){
		global $db; 			
		
		$where = compact('id') + array('type'=>'post');
		if(!is_admin()) $where = compact('id') + array('type'=>'post','user_login'=> the_login_name());	
		return $db->update('post', $data, $where);
	}
}

if(!function_exists('user_del_post')){
	function user_del_post($id){
		global $db;
		
		$where = compact('id') + array('type'=>'post');
		if(!is_admin()) $where = compact('id') + array('type'=>'post','user_login'=> the_login_name());
		
		$r = $db->fetch_obj( $db->select("post", $where) );
		
		if(file_exists(upload_path.'post/'.$r->thumb)){
			@unlink(upload_path.'post/'.$r->thumb);  
		}   
		
		$db->delete("post",$where);
	}
}

if(!function_exists('list_post_category')){
	function list_post_category($data = false){
		global $db;		
		return $db->select("post_topic",$data);
	}
}

if(!function_exists('user_add_post')){
	function user_add_post($data){
		global $iw;
		extract($data, EXTR_SKIP);
		
		$msg = array();
		if( empty($title) ) $msg[] ='<strong>ERROR</strong>: The title is empty.';		
		if( empty($isi) )   $msg[] ='<strong>ERROR</strong>: The content is empty.';		
		if( empty($cat) )   $msg[] ='<strong>ERROR</strong>: The category is empty.';		
		if(!empty($thumb['name']) && !in_array($thumb['type'],array_keys($iw->image_allaw)) ):
		$msg[] ='<strong>ERROR</strong>: The file type thumb image not valid.';	
		endif;	
		
		if( $msg ){
			foreach($msg as $error) _e('<div class="error">'.$error.'</div>');
		}
		else
		{
			if($thumb){	
			$thumb	= hash_image( $thumb );
			//$thumb= the_name_image( $thumb );
			//upload image		
			upload_img_post($thumb,'post/',650,120);
			}
			$image 	= filter_txt( $thumb['name'] );
			$data 	= compact('title','isi','cat','image','tags');
			//saving data to database
			if(user_save_post($data)) 
			_e('<div class="sukses"><strong>SUCCESS</strong>: Foto berhasil di tambahkan</div>');
		}
			
	}
}

if(!function_exists('user_save_post')){
	function user_save_post($data){
		global $login;
		extract($data, EXTR_SKIP);
		
		$title 		= esc_sql($title);
		$content	= esc_sql($isi);
		$post_topic	= esc_sql($cat);
		$thumb 		= esc_sql($image);	
		$tags 		= esc_sql($tags);	
		
		$date_post	= date('Y-m-d H:i:s');	
		$type		= 'post';	
		$status		= 0;		
		
		$seo 		= new engine;
		$sefttitle	= esc_sql( $seo->judul($title) );
		$user_login	= esc_sql( the_login_name() );		
		$row 		= $login->username_cek( compact('user_login') );
		$mail		= esc_sql( $row->user_email );
		
		$data 		= compact('user_login','title','sefttitle','post_topic','mail','type','content','thumb','tags','date_post','status');
		return user_insert_post($data);
	}
}

if(!function_exists('user_insert_post')){
	function user_insert_post($data){
		global $db; 
		//approved comfirm
		if(!is_admin()) $data = $data + array('approved'=>0);
		else $data = $data + array('approved'=>1);
		
		return $db->insert('post', $data);
	}
}

if(!function_exists('user_edit_post')){
	function user_edit_post($data,$id){
		global $iw; 
		extract($data, EXTR_SKIP);
		
		$msg = array();
		if( empty($title) ) $msg[] ='<strong>ERROR</strong>: The title is empty.';		
		if( empty($isi) )   $msg[] ='<strong>ERROR</strong>: The content is empty.';		
		if( empty($cat) )   $msg[] ='<strong>ERROR</strong>: The category is empty.';				
		if(!empty($thumb['name']) && !in_array($thumb['type'],array_keys($iw->image_allaw)) ):
		$msg[] ='<strong>ERROR</strong>: The file type thumb image not valid.';	
		endif;		
		
		if( $msg ) foreach($msg as $error) _e('<div class="error">'.$error.'</div>'); 
		else user_save_edit_post($data, $id); 
	}
}

if(!function_exists('user_save_edit_post')){
	function user_save_edit_post($data, $id){
		extract($data, EXTR_SKIP);
		
		$title 		= esc_sql($title);
		$content	= esc_sql($isi);
		$post_topic	= esc_sql($cat);
		$thumb		= esc_sql($thumb);
		$tags		= esc_sql($tags);
			
		$thumb	 	= hash_image( $thumb );
		//$thumb	= the_name_image( $thumb );
		
		$row 		= view_post( $id );
		if(!empty($thumb['name'])):
		upload_img_post($thumb,'post/',650,120);
			
		del_img_post($row['thumb'],'post/');
		$thumb 		= esc_sql($thumb['name']);
		else:
		$thumb		= esc_sql($row['thumb']);
		endif;
			
		$approved = $row['approved'];
		if(!is_admin()) $approved = 0;	
			
		$seo 		= new engine;
		$sefttitle	= esc_sql( $seo->judul($title) );	
			
		$data 		= compact('title','sefttitle','post_topic','content','thumb','tags','approved');
		
		//saving data to database
		if(user_update_post($data, $id)) 
		_e('<div class="sukses"><strong>SUCCESS</strong>: Data berhasil di perbaharui</div>');
	}
}

if(!function_exists('tags')){
	function tags($id=false){
		global $db;
		
		if(!empty($id)) $where = array('type'=>'post','id'=>$id);
		else $where = array('type'=>'post','status'=>1);
		
		$qry 	= $db->select('post',$where);
		$jum 	= $db->num($qry);
		if($jum <1 ){
		_e('tidak ada tags');
		}else{
		$TampungData = array();
		while ($data_tags = $db->fetch_array($qry)) {
			$tags = explode(',',strtolower(trim($data_tags['tags'])));
			foreach($tags as $val) {
						$TampungData[] = $val;
						
				}
		}
	
		$totalTags = count($TampungData);
		$jumlah_tag = array_count_values($TampungData);
		ksort($jumlah_tag);
		if ($totalTags > 0) {
		$output = array();
		$tag_mod = array();
		$tag_mod['fontsize']['max'] = 20;
		$tag_mod['fontsize']['min'] = 9;
	
		$min_count = min($jumlah_tag);
		$spread = max($jumlah_tag) - $min_count;
		if ( $spread <= 0 )
			$spread = 1;
		$font_spread = $tag_mod['fontsize']['max'] - $tag_mod['fontsize']['min'];
		if ( $font_spread <= 0 )
			$font_spread = 1;
		$font_step = $font_spread / $spread;
		
		foreach($jumlah_tag as $key=>$val) {
			$font_size = ( $tag_mod['fontsize']['min'] + ( ( $val - $min_count ) * $font_step ) );
			$datas = array('view'=>'tags','id'=>urlencode($key));
			$output[] = "<a href='".do_links("post",$datas)."' style='font-size:".$font_size."px'>".$key ."</a>";
		}
		return $output;
		}
		}
	}
}
function set_image_thumb( $thumb, $display = false, array $size, $class = 'post-img-item' ){
	
	if( file_exists( upload_path . 'post/'.$thumb) && !empty($thumb))
	$retval = "<img src=\"?request&load=thumb.php&apps=post&src=$thumb&x=$size[0]&y=$size[1]&c=1\" class=\"$class\">";
	
	if( $display ) echo $retval;
	else return $retval;
}
?>