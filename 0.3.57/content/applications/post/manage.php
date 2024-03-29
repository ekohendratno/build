<?php 
/**
 * @fileName: manage.php
 * @dir: admin/manage/post
 */
if(!defined('_iEXEC')) exit;
global $db, $login, $class_country, $widget;
$go 	= filter_txt($_GET['go']);
$act	= filter_txt($_GET['act']);
$type	= filter_txt($_GET['type']);
$pub	= filter_txt($_GET['pub']);
$from	= filter_txt($_GET['from']);
$sfl	= filter_txt($_GET['showforlevel']);
$id 	= filter_int($_GET['id']);
$reply 	= filter_int($_GET['reply']);
$offset	= filter_int($_GET['offset']);

echo js_redirec_list();

switch($go){
default:

ob_start();

if(!empty($act))
if($act == 'pub'){
	if ($pub == 'no') $stat =0;	
	if ($pub == 'yes') $stat =1;
	update_pub_post(array('status'=>$stat),$id);
	add_activity('post',"mengubah status post $id menjadi $stat", 'post');
}

if($act == 'approv'){
	if ($pub == 'no') $approv =0;	
	if ($pub == 'yes') $approv =1;
	update_pub_post(array('approved'=>$approv),$id);
	add_activity('post',"menyetujui status post $id menjadi $approv", 'post');
}

if($act == 'del'){    
	del_post(compact('id'));  
	add_activity('post',"menghapus post $id", 'post');
}

$limit		= 20;
if($type=='page'){
	$add_query	='WHERE `type`="page"';
	$type		='&type=page';
}else{
	$add_query	='WHERE `type`="post"';
	$type		= '';
}

$sql = $db->query( "SELECT * FROM `$db->post` $add_query ORDER BY id DESC LIMIT $limit");
?>

<table id="table" cellpadding="0" cellspacing="0">
<tr class="head">
    <td width="63%" class="depan"><strong>Title</strong></td>
    <td class="depan"><div align="center"><strong>Approved</strong></div></td>
    <td class="depan"><div align="center"><strong>Status</strong></div></td>
    <td class="depan"><div align="center"><strong>Action</strong></div></td>
  </tr>
<?php
$warna = '';
while ($data = $db->fetch_array($sql)) {
$id 	= $data['id'];
$warna 	= empty ($warna) ? ' bgcolor="#f1f6fe"' : '';

$data_user 	= array( 'user_login' => $data['user_login'] );
$field 		= $login->username_cek( $data_user );

$showthis = false;

$from = '';
if( !empty($sfl) ){

	if( esc_sql($field->user_level) == $sfl && $sfl == 'user' ){
		$showthis = true;	
		$from = '&from=user';
	}elseif( esc_sql($field->user_level) == $sfl && $sfl == 'admin' ){
		$showthis = true;	
		$from = '&from=admin';
	}

}else{

	if( esc_sql($field->user_level) == 'admin' ){
		$showthis = true;	
	}
	
}

if( $showthis ):

$approved 	= ($data['approved'] == 1) ? '<a  class="enable" title="Disable Now" href="?admin&apps=post'.$type.'&act=approv&pub=no&id='.$id.'">Enable</a>' : '<a  class="disable" title="Enable Now" href="?admin&apps=post'.$type.'&act=approv&pub=yes&id='.$id.'">Disable</a>';
$status 	= ($data['status'] == 1) ? '<a  class="enable" title="Disable Now" href="?admin&apps=post'.$type.'&act=pub&pub=no&id='.$id.'">Enable</a>' : '<a  class="disable" title="Enable Now" href="?admin&apps=post'.$type.'&act=pub&pub=yes&id='.$id.'">Disable</a>';

?>
<tr <?php echo $warna?> class="isi">
	<td valign="top"><span title="<?php echo $data['title']?>"><?php echo $data['title']?></span></td>
	<td valign="top"><div align="center"><?php echo $approved?></div></td>
	<td valign="top"><div align="center"><?php echo $status?></div></td>
    <td valign="top">
    <div class="action">
<a href="?com=post&view=item&id=<?php echo $id?>" class="view" title="view" target="_blank">view</a>
<a href="?admin=single&apps=post&go=edit<?php echo $type?>&id=<?php echo $id . $from;?>" class="edit" title="edit">edit</a>
<?php if( $id != 1 ):?>
<a href="?admin&apps=post&act=del&id=<?php echo $id?>" class="delete" title="delete" onclick="return confirm('Are You sure delete this post?')">delete</a>
<?php endif;?>
    </div></td>
</tr>
<?php
endif;

}
?>
</table>

<?php
$content = ob_get_contents();
ob_end_clean();

$header_menu = '';
$header_menu.= '<div class="header_menu_top">
<label>Show for :</label><select onchange="redir(this)" name="show">';
if( $sfl == 'user' ){
$header_menu.= '<option value="?admin&apps=post&showforlevel=admin">Admin</option>
<option value="?admin&apps=post&showforlevel=user" selected="selected">User</option>';
}else{
$header_menu.= '<option value="?admin&apps=post&showforlevel=admin" selected="selected">Admin</option>
<option value="?admin&apps=post&showforlevel=user">User</option>';
}
$header_menu.= '</select></div>';
$header_menu.= '<a href="?admin=single&apps=post&go=add" class="button button3 left">+ Post</a><a href="?admin&apps=post&go=addcat" class="button button3 right">+ Topik</a>';

add_templates_content_position( $content, 'Posting Manager', $header_menu );

break;
case'add':

ob_start();
?>
<div class="padding">
<?php
if(isset($_POST['draf']) || isset($_POST['publish'])){
	$title 		= filter_txt($_POST['title']);
	
	$title 		= sanitize( $title );
	
	$category 	= filter_int($_POST['category']);
	$type 		= filter_txt($_POST['type']);
	
	if( get_option('text_editor') == 'classic' ):
	$isi	 	= nl2br2($_POST['isi']);
	else:
	$isi	 	= $_POST['isi'];
	endif;
	
	$isi 		= sanitize( $isi );
	
	$tags 		= filter_txt($_POST['tags']);
	$date 		= filter_txt($_POST['date']);
	$date		= $date .' '.date('H:i:s');
	
	$meta_keys 	= filter_txt($_POST['meta_keys']);
	$meta_desc 	= filter_txt($_POST['meta_desc']);
	$thumb	 	= $_FILES['thumb'];
	
	if(isset($_POST['draf'])) $status = 0;
	else $status = 1;
	
	$data = compact('title','category','type','isi','thumb','tags','date','status','meta_keys','meta_desc');	
	add_post($data);
}
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="width:70%"><label for="title">Judul: <span class="required">*</span></label><br /><input type="text" id="title" name="title" value="" placeholder="Judul Posting" required="required" style="width:99%;" /></td>
      <td align="right"><label for="category">Kategori: <span class="required">*</span> </label><br />
        <select id="category" name="category">
           <option value="">-- Pilih --</option> 
           <?php list_category()?>
        </select></td>
    </tr>
    <tr>
      <td colspan="2"><label for="isi">Isi:</label><?php the_editor('','idEditor', array('editor_name' => 'isi','editor_style' => 'width:550px; height:250px;') );?></td>
    </tr>
    <tr>
      <td colspan="2"><label for="tags">Tags *(:</label><br /><input id="tags" type="text" name="tags" value="" style="width:98%;"/></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><label for="thumb">Gambar *(:</label><br /><div id="file">Chose file</div><input id="thumb" type="file" name="thumb"></td>
      <td align="right"><label for="thumb_desc">Keterangan Gambar *(:</label><br /><input id="thumb_desc" type="text" name="thumb_desc" value="" style="width:90%;"/></td>
    </tr>
    <tr>
      <td colspan="2">*( : Jika type posting {page} option ini diabaikan<br /><span class="required">*</span> : Harus disini</td>
    </tr>
  </table>
</div>
<?php
$content = ob_get_contents();
ob_end_clean();

$widget_manual = array();
$widget_manual['gadget'][] = array('title' => 'Meta Desc', 'desc' => '
<div class="padding">
<label for="meta_keys">Kata kunci:</label><input type="text" id="meta_keys" name="meta_keys" value="" placeholder="Keyboard" style="width:95%;" />
<label for="meta_desc">Keterangan:</label><textarea id="meta_desc" name="meta_desc" style="width:95%; height:100px"></textarea>
</div>');
$header_menu = '<div class="header_menu_top">Date : <input id="date-picker" type="text" name="date" value="'.date('Y-m-d').'">';
$header_menu.= '<select name="type" style="margin-left:2px;"><option value="">-- Pilih Type --</option><option value="post">Post</option><option value="page">Page</option></select>';
$header_menu.= '<input type="submit" name="publish" value="Terbitkan" class="l button on green" style="margin-left:2px;"/>';
$header_menu.= '<input type="submit" name="draf" value="Simpan di Draf" class="m button black"/>';
$header_menu.= '<input type="Reset" value="Bersihkan" class="r button"/></div>';
$header_menu.= '<a href="?admin&apps=post" class="button button3 left"><span class="icon_head back">&laquo; Back</span></a>';
$header_menu.= '<a href="?admin&apps=post&go=addcat" class="button button3 right">+ Topik</a>';

$form = 'method="post" action="" enctype="multipart/form-data"';
add_templates_content_position( $content, 'Add Post', $header_menu, $widget_manual, $form );

break;
case'edit':

ob_start();
?>
<div class="padding">
<?php

$row = view_post( $id );	
if( empty($type) ) $type = 'post';

if(isset($_POST['update'])){
	$title 		= filter_txt($_POST['title']);
	$title 		= sanitize( $title );
	$category 	= filter_int($_POST['category']);
	
	if(get_option('text_editor')=='classic')
	$isi	 	= nl2br2($_POST['isi']);
	else
	$isi	 	= $_POST['isi'];
	
	$isi 		= sanitize( $isi );
	
	$tags 		= filter_txt($_POST['tags']);
	$date 		= filter_txt($_POST['date']);
	$meta_keys 	= filter_txt($_POST['meta_keys']);
	$meta_desc 	= filter_txt($_POST['meta_desc']);
	$thumb_desc = filter_txt($_POST['thumb_desc']);
	$date		= $date .' '.date('H:i:s');
	$thumb	 	= $_FILES['thumb'];	
	
	$approved 	= filter_int($_POST['approved']);
	
	$data = compact('title','type','category','isi','thumb','thumb_desc','tags','date','meta_keys','meta_desc','approved');
	update_post($data,$id); 
}

?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="width:70%"><label for="title">Judul: <span class="required">*</span></label><br /><input type="text" id="title" name="title" value="<?php echo sanitize($row['title'])?>" placeholder="Judul Posting" required="required" style="width:99%;" /></td>
      <td align="right">
      <?php if( $type != 'page' ):?>
      <label for="category">Kategori: <span class="required">*</span> </label><br />
        <select id="category" name="category">
           <option value="">-- Pilih --</option> 
           <?php list_category( $row['post_topic'] )?>
        </select>
        <?php endif;?>
        </td>
    </tr>
    <tr>
      <td colspan="2"><label for="isi">Isi:</label><?php the_editor( sanitize($row['content']) ,'idEditor', array('editor_name' => 'isi','editor_style' => 'width:550px; height:420px;') );?></td>
    </tr>
<?php if( $type != 'page' ):?>
    <tr>
      <td colspan="2"><label for="tags">Tags: *(</label><br /><input id="tags" type="text" name="tags" style="width:98%;" value="<?php echo $row['tags']?>"/></td>
    </tr>
    <tr>
      <td><label for="thumb">Ganti Thumbnail:</label><br /><div id="file">Chose file</div><input id="thumb" type="file" name="thumb"></td>
      <td align="right"><label for="thumb_desc">Keterangan Gambar *(:</label><input id="thumb_desc" type="text" name="thumb_desc" value="<?php echo $row['thumb_desc']?>" style="width:90%;"/></td>
      </tr>
<?php endif;?>
    <tr>
      <td></td>
      <td></td>
    </tr>
<?php if( $type != 'page' ):?>
    <tr>
      <td colspan="2">*( : Jika type posting {page} option ini diabaikan<br /><span class="required">*</span> : Harus disini</td>
    </tr>
<?php endif;?>
  </table>

</div>

<?php
$content = ob_get_contents();
ob_end_clean();

$widget_manual = array();
$widget_meta = ' 
<div class="padding">
<label for="meta_keys">Kata kunci:</label><input type="text" id="meta_keys" name="meta_keys" value="'.$row['meta_keys'].'" placeholder="Keyboard" style="width:95%;" />
<label for="meta_desc">Keterangan:</label><textarea id="meta_desc" name="meta_desc" style="width:95%; height:100px">'.$row['meta_desc'].'</textarea>
</div>';

if( $type != 'page' ) $widget_metax = $widget_meta;
else $widget_metax = '<div class="padding"><p id="message_no_ani">No meta needed</p></div>';

$widget_manual['gadget'][] = array('title' => 'Meta Desc', 'desc' => $widget_metax);

if( $type != 'page' ):
$widget_manual['gadget'][] = array('title' => 'Thumbnail', 'desc' => ' 
<div class="padding" align="center">
<img style="border:1px solid #ddd; max-height:160px; max-width:160px" src="?request&load=libs/timthumb.php&src='.content_url('/uploads/post/'.$row['thumb']).'&w=385&h=250&zc=1">
</div>');
endif;

$header_menu = '<div class="header_menu_top">';
if( $type != 'page' ):
$tanggal = strtotime($row['date_post']);
$header_menu.= 'Date : <input id="date-picker" type="text" name="date" value="'.date('Y-m-d',$tanggal).'">';
endif;

if( !empty($from) ):
$header_menu.= '<select name="approved" style="margin-left:2px;">';
if( $row['approved'] > 0 ){
$header_menu.= '<option value="0">Panding</option>';
$header_menu.= '<option value="1" selected="selected">Approved</option>';
}else{
$header_menu.= '<option value="0" selected="selected">Panding</option>';
$header_menu.= '<option value="1">Approved</option>';
}
$header_menu.= '</select>';
else:
$header_menu.= '<input type="hidden" name="approved" value="'.$row['approved'].'">';
endif;

$header_menu.= '<input type="submit" name="update" value="Simpan" class="l button on orange" style="margin-left:2px;"/>';
$header_menu.= '<input type="Reset" value="Bersihkan" class="m button"/></div>';
$header_menu.= '<a href="?admin&apps=post&act=del&id='.$id.'" class="button button3 right red" style="margin-left:-2px; margin-right:2px;" onclick="return confirm(\'Are You sure delete this post?\')">Hapus</a>';
$header_menu.= '<a href="?admin&apps=post" class="button button3 left"><span class="icon_head back">&laquo; Back</span></a>';
$header_menu.= '<a href="?admin=single&apps=post&go=add" class="button button3 middle">+ Post</a><a href="?admin&apps=post&go=addcat" class="button button3 right">+ Topik</a>';

$form = 'method="post" action="" enctype="multipart/form-data"';
add_templates_content_position( $content, 'Editing '.uc_first($type), $header_menu, $widget_manual, $form );

?>
<br /><br /><br /><br /><br /><br />
<?php

break;
case'category':
ob_start();

if(!empty($act))
if($act == 'pub'){
	if ($pub == 'no') $stat =0;	
	if ($pub == 'yes') $stat =1;
	update_category_post(array('status'=>$stat),$id);
	add_activity('post',"mengubah status ketegory post $id", 'post');
}
if($act == 'del'){    
	del_category_post(compact('id'));  
	add_activity('post',"menghapus kategory post $id", 'post');
}
?>
<table id=table cellpadding="0" cellspacing="0">
<tr class="head">
    <td width="65%" class="depan"><strong>Title</strong></td>
    <td class="depan"><div align="center"><strong>Total Post</strong></div></td>
    <td class="depan"><div align="center"><strong>Status</strong></div></td>
    <td colspan="2"><div align="center"><strong>Action</strong></div></td>
</tr>
<?php
$limit		= 10;
$sql		= $db->query( "SELECT * FROM `$db->post_topic` ORDER BY id DESC LIMIT $limit");
$warna 		= '';
while($data = $db->fetch_array($sql)) {
$id 		= $data['id'];
$title 		= sanitize( $data['topic'] );
$q2			= $db->query("SELECT COUNT(*) AS jumNews FROM `$db->post` WHERE post_topic='$id'");
$data2     	= $db->fetch_array($q2);
$jumNews 	= $data2['jumNews'];
$warna 		= empty ($warna) ? ' bgcolor="#f1f6fe"' : '';
$status = ($data['status'] == 1) ? '<a  class="enable" title="Disable Now" href="?admin&apps=post&go=category&act=pub&pub=no&id='.$id.'">Enable</a>' : '<a  class="disable" title="Enable Now" href="?admin&apps=post&go=category&act=pub&pub=yes&id='.$id.'">Disable</a>';

?>
<tr <?php echo $warna?> class="isi">
	<td><?php echo $title?></td>
	<td><div align="center">( <?php echo $jumNews?> )</div></td>
	<td><div align="center"><?php echo $status?></div></td>
    <td>
    <div class="action">
<a href="?admin&apps=post&go=editcat<?php echo $type?>&id=<?php echo $id?>" class="edit" title="edit">edit</a>
<a href="?admin&apps=post&go=category&act=del&id=<?php echo $id?>" class="delete" title="delete" onclick="return confirm('Are You sure delete this category post?')">delete</a>
    </div></td>
</tr>
<?php
}
?>
</table>
<?php
$content = ob_get_contents();
ob_end_clean();

$header_title = 'Category Post Manager';
$header_menu = '<a href="?admin&apps=post&go=addcat" class="button button3">+ Topik</a>';

add_templates_content_position( $content, $header_title, $header_menu );


break;
case'addcat':

ob_start();
?>
<div class="padding">
<?php
if(isset($_POST['submit'])){
	$title	= filter_txt($_POST['title']);	
	$desc	= filter_txt($_POST['desc']);
	
	$title	= sanitize($title);
	$desc	= sanitize($desc);
	
	$data = compact('title','desc');
	add_category_post($data);
	add_activity('post',"menambah kategory post dengan judul ' $title ' ", 'post');
}
?>
  <table width="100%" border="0" cellpadding="0" cellspacing="2">
    <tr>
      <td>Title</td>
    </tr>
	<tr>
      <td width="84%"><input type="text" name="title" style="width:400px;"></td>
    </tr>
    <tr>
      <td>Description</td>
    </tr>
    <tr>
      <td><textarea type="text" name="desc" style="width:90%; height:60px;"></textarea></td>
    </tr>
</table>

</div>
<?php
$content = ob_get_contents();
ob_end_clean();


$header_title = 'Add Category Post';
$form = 'action="" method="post" enctype="multipart/form-data" name="form1"';
$header_menu = '<div class="header_menu_top"><input type="submit" name="submit" value="Tambahkan" class="l button on"/>';
$header_menu.= '<input type="Reset" value="Bersihkan" class="r button"/></div>';
$header_menu.= '<a href="?admin&apps=post&go=category" class="button button3"><span class="icon_head back">&laquo; Back</span></a>';
add_templates_content_position( $content, $header_title, $header_menu, null, $form );

break;
case'editcat':
 
ob_start();
?>
<div class="padding">
<?php
$row = view_category_post( $id );
if(isset($_POST['update'])){
	$title	= filter_txt($_POST['title']);
	$desc	= filter_txt($_POST['desc']);	
	
	$title	= sanitize($title);
	$desc	= sanitize($desc);
		
	if(empty($title)) 	$msg ='<strong>ERROR</strong>: The title is empty.';
		
	if($msg){
		echo '<div id="error">'.$msg.'</div>';
	}else{				
		$topic 		= esc_sql($title);
		$desc 		= esc_sql($desc);
		
		$data = compact('topic','desc');
		update_category_post($data,$id);
		add_activity('post',"mengubah kategory post dengan judul ' $row[topic] ' menjadi ' $title ' ", 'post');
	}
}
?>
  <table width="100%" border="0" cellpadding="0" cellspacing="2">
    <tr>
      <td>Title</td>
    </tr>
	<tr>
      <td width="84%"><input type="text" name="title" style="width:400px;" value="<?php echo sanitize( $row['topic'] )?>"></td>
    </tr>
    <tr>
      <td>Description</td>
    </tr>
    <tr>
      <td><textarea type="text" name="desc" style="width:90%; height:60px;"><?php echo sanitize( $row['desc'] )?></textarea></td>
    </tr>
    
</table>

</div>
<?php
$content = ob_get_contents();
ob_end_clean();

$header_title = 'Editing Category Post';
$form = 'action="" method="post" enctype="multipart/form-data" name="form1"';
$header_menu = '<div class="header_menu_top"><input type="submit" name="update" value="Perbaharui" class="l button on"/>';
$header_menu.= '<input type="Reset" value="Bersihkan" class="r button"/></div>';
$header_menu.= '<a href="?admin&apps=post&go=category" class="button button3"><span class="icon_head back">&laquo; Back</span></a>';
add_templates_content_position( $content, 'Editing Category Post', $header_menu, null, $form );

break;
case'comment':
?>
<link href="content/applications/post/style.css" rel="stylesheet" media="screen" type="text/css" />
<?php

ob_start();

if( $act == 'del' && !empty($id) ){
	delete_commentar($id); 
	add_activity('post_comment',"menghapus commentar $id", 'comment');
}

if( isset($_POST['submitDelete']) ) {
	$commentar_id = (array) $_POST['commentar_id'];
		
	foreach($commentar_id as $key){
		delete_commentar($key); 
		add_activity('post_comment',"menghapus commentar $key", 'comment');
	}
}

if( $act == 'view' ){

$color			= '';
$comment_no		= 0;
$qry_comment	= $db->select("post_comment",array('comment_id'=>$id,'comment_parent'=>0)); 
$data			= $db->fetch_array($qry_comment);
	
$no_comment 	= filter_int( $data['comment_id'] );
$no_respon  	= filter_int( $comment_no++ );
$reply_link		= '';

$sql_post = $db->select( 'post' , array('id' => $data['post_id']) );
$row_post = $db->fetch_obj( $sql_post );

?>
<div class="comment_post_title">
<strong>Title : <?php echo sanitize( $row_post->title )?></strong>
</div>
<?php
if( isset($_POST['submit']) ){
	$comment = nl2br2($_POST['comment']);
	$comment = sanitize( $comment );
	
	$user_login = $login->exist_value('username');
	$field 		= $login->username_cek( compact('user_login') );
		
	$user_id	= $field->user_login;
	$email 		= $field->user_email;
	$author		= $field->user_author;
	
	$approved	= 1;
	
	$comment_parent = $data['comment_id'];
	$post_id    = $data['post_id'];
	$date    	= date('Y-m-d H:i:s');	
	$time		= time();
	
	$reply_data = compact('user_id','author','email','comment','date','time','approved','comment_parent','post_id');
	set_comment_manager($reply_data);
	add_activity('post_comment',"menambah commentar pada $row_post->title", 'comment');
}
?>
<div id="list-comment">
<div class="comment-wrap" id="respon-<?php echo $no_respon;?>">
<div class="comment-img" style="margin-left:5px; margin-top:5px; margin-right:10px"><img src="<?php echo get_gravatar($data['email']);?>" /></div>
<div class="comment-text">
<strong><?php echo $data['author'];?></strong> <?php echo $data['comment'];?>
<div class="comment-time"><?php echo time_stamp($data['time']);?></div> 
<br style="clear:both" />
<!--comment reply admin -->
<?php if( $reply == 1 ):?>
<div class="comment-reply-bg" id="respon">
<div class="comment-img comment-reply-img" style="margin-left:15px;"><img src="<?php echo get_gravatar( get_option('admin_email') );?>" /></div>
<div class="comment-text comment-reply-text">
<textarea cols="50" rows="5" name="comment" class="grow" style="height:15px; width:95%"></textarea>
<input type="submit" name="submit" value="Balas" class="l button blue" /><input type="reset" name="Reset" value="Bersihkan" class="r button white" />
</div>
</div>
<?php endif;?>

<!--comment reply-->
<?php

$color = '';
$checkbox_id = 0;
$q2					= $db->select("post_comment",array('comment_parent'=>$id),'ORDER BY date DESC LIMIT 30'); 
while ($data2		= $db->fetch_array($q2)) {
$color 	= empty ($color) ? ' style="background:#fff"' : '';
?>
<div class="comment-reply-bg" id="respon-<?php echo $checkbox_id;?>"<?php echo $color;?>>
<input type="checkbox" name="commentar_id[]" value="<?php echo $data2['comment_id']?>" id="checkbox_id_<?php echo $checkbox_id;?>" />
<div class="comment-img comment-reply-img"><img src="<?php echo get_gravatar($data2['email']);?>" /></div>
<div class="comment-text comment-reply-text">
<strong><?php echo $data2['author'];?></strong> <?php echo $data2['comment'];?>
<div class="comment-time comment-reply-time"><?php echo time_stamp($data2['time']);?></div> 
</div>
</div>
<?php
$checkbox_id++;
}
?>
<input type="hidden" id="checkbox_total" value="<?php echo $checkbox_id?>" name="checkbox_total">
</div>
</div>
</div>
<?php

$header_title = 'Reply Comment Manager';
$header_menu = '';

$header_menu.= '<div class="header_menu_top">';
$header_menu.= '<label for="set_checkbox_all">Check All</label> ';
$header_menu.= '<input type="checkbox" onClick="checkbox_all()" id="set_checkbox_all" style="margin-top:13px;">';
$header_menu.= '<input type="submit" name="submitDelete" class="primary button on" value="Delete the selected" id="checkbox_go">';
$header_menu.= '</div>';

if( $reply == 1 )
$header_menu.= '<a href="?admin&apps=post&go=comment&act=view&id='.$id.'" class="button button3">Cencel</a>';
else
$header_menu.= '<a href="?admin&apps=post&go=comment&act=view&reply=1&id='.$id.'" class="button button3 blue">Reply</a>';

$header_menu.= '<a href="?admin&apps=post&go=comment" class="button button3" style="margin-left:2px;"><span class="icon_head back">&laquo; Back</span></a>';

}else{

$warna = '';
$checkbox_id 	= 0;
$sql_comment = $db->select( 'post_comment' , array('comment_parent' => 0), 'ORDER BY date DESC LIMIT 30' );
?>
<div id="list-comment">
<table id=table cellpadding="0" cellspacing="0" widtd="100%">
    <tr class="head" style="border-bottom:0;">
		<td style="text-align:left; width:1%; vertical-align:middle; padding-left:5px"><input type="checkbox" onClick="checkbox_all()" id="set_checkbox_all"></td>
		<td style="text-align:left; width:25%">By</td>
		<td style="text-align:left">Comment</td>
	</tr>
<?php
while( $row_comment = $db->fetch_obj( $sql_comment ) ){
$warna 	= empty ($warna) ? ' style="background:#f9f9f9"' : '';

$sql_post = $db->select( 'post' , array('id' => $row_comment->post_id) );
$row_post = $db->fetch_obj( $sql_post );
?>
	<tr class="isi" <?php echo $warna;?>>
	  <td style="text-align:left; vertical-align:middle; padding-left:5px"><input type="checkbox" name="commentar_id[]" value="<?php echo $row_comment->comment_id?>" id="checkbox_id_<?php echo $checkbox_id;?>" /></td>
	  <td>
      <div style="float:left; width:42px; height:100%; margin:2px; margin-right:5px; padding:2px; padding-top:10px;">
      <img src="<?php echo get_gravatar($row_comment->email);?>" style="width:40px; height:40px; border:1px solid #ddd;">
      </div>
      <div style="margin:0; margin-top:3px; margin-left:50px;">
      <?php echo $row_comment->author?><br />
      <a href="?admin&apps=post&go=comment&act=view&id=<?php echo $row_comment->comment_id?>" class="button button4 green" style="margin-top:3px;">Lihat</a><a href="?admin&apps=post&go=comment&act=view&reply=1&id=<?php echo $row_comment->comment_id?>" class="button button4 blue" style="margin-top:3px;">Balas</a>
	  </div>
      <div style="clear:both"></div>
      </td>
	  <td>
      <strong><?php echo $row_post->title?></strong>
      <p><?php echo $row_comment->comment?></p>
      <div style="clear:both"></div>
      <a href="mailto:<?php echo $row_comment->email?>" title="Visit autdor homepage">Send a Mail</a> &bull; <?php echo  time_stamp($row_comment->time)?> 
      <div style="clear:both"></div>
      </td>
    </tr>
<?php
$checkbox_id++;
}
?>
</table>
<input type="hidden" id="checkbox_total" value="<?php echo $checkbox_id?>" name="checkbox_total">
</div>

<?php

$header_title= 'Comment Manager';

$header_menu.= '<div class="header_menu_top">';
$header_menu.= '<input type="submit" name="submitDelete" class="primary button on" value="Delete the selected" id="checkbox_go">';
$header_menu.= '</div>';

}

$content = ob_get_contents();
ob_end_clean();

$form = 'action="" method="post" enctype="multipart/form-data"';
add_templates_content_position( $content, $header_title, $header_menu, null, $form );

break;
}
?>
