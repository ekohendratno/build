<?php
/**
 * @file init.mypost.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;
global $iw,$db,$access;
set_layout('left');

$go		= filter_txt($_GET['go']);
$act	= filter_txt($_GET['act']);
$pub	= filter_txt($_GET['pub']);
$id		= filter_int($_GET['id']);

switch($go){
	default:
if($act == 'pub'){
	if ($pub == 'no') $stat =0;	
	if ($pub == 'yes') $stat =1;
	user_update_post(array('status'=>$stat),$id);
}

if($act == 'del' && !empty($act)){
	user_del_post($id); 
}
	
$limit			= 10;
$a				= new paging();
$query_post		= $a->query( "SELECT * FROM `".$iw->pre."post` WHERE type='post' AND user_login='".the_login_name()."' ORDER BY `date_post` DESC",$limit );

if( !$db->num($query_post) ): echo 'no data';
else:
?>
<table id=table cellpadding="0" cellspacing="0" width="100%">
<tr class="head">
<td class="depan"><strong>Title</strong></td>
<td class="depan"><div align="center"><strong>Aproved</strong></div></td>
<td class="depan"><div align="center"><strong>Image</strong></div></td>
<td class="depan"><div align="center"><strong>Status</strong></div></td>
<td class="depan" colspan="2"><div align="center"><strong>Action</strong></div></td>
</tr>
<?php
$warna 	= '';
while( $data_post = $db->fetch_array($query_post) ) {

$warna 		= empty ($warna) ? ' bgcolor="#f1f6fe"' : '';
$imgx 		= (empty($data_post['thumb'])) ? 'not avalable' : 'available';
$approved 	= ($data_post['approved'] == 1) ? 'yes' : 'no';
$status 	= ($data_post['status'] == 1) ? '<a href="index.php?com=post&view=mypost&amp;act=pub&amp;pub=no&amp;id='.$data_post['id'].'"><img src="'.apps_url_post('images/ya.png').'" border="0" alt="no" /></a>' : '<a href="index.php?com=post&view=mypost&amp;act=pub&amp;pub=yes&amp;id='.$data_post['id'].'"><img src="'.apps_url_post('images/tidak.png').'" border="0" alt="no" /></a>';


?>
<tr <?php echo $warna;?> class="isi">
	<td><?php echo $data_post['title'];?></td>
	<td><div align="center"><?php echo $approved;?></div></td>
	<td><div align="center"><?php echo $imgx;?></div></td>
	<td><div align="center"><?php echo $status;?></div></td>
    <td>
	<div align="center">
	<a href="index.php?com=post&view=mypost&go=edit&id=<?php echo $data_post['id'];?>" title="Edit"><img src="<?php echo apps_url_post('images/edit.gif');?>"></a>
	</div>
	</td>
    <td width="8%" style="border-left:0;">
	<div align="center">
	<a href="index.php?com=post&view=mypost&act=del&id=<?php echo $data_post['id'];?>&file=<?php echo $data_post['thumb'];?>" title="Delete" onclick="return confirm('Are You sure delete?')"><img src="<?php echo apps_url_post('images/delete.gif');?>"></a>
	</div>
	</td>
</tr>
<?php
}
?>
</table>
<?php
//halaman navigasi
echo $a->pg( 'post', array('view' => 'my') );
endif;
	break;
	case'add':
if(isset($_POST['submit'])){
	$title 		= filter_txt($_POST['title']);
	$cat 		= filter_int($_POST['cat']);	
	
	if(get_option('text_editor')=='classic'){
	$isi	 	= nl2br2($_POST['isi']);
	}else{
	$isi	 	= $_POST['isi'];
	}
	
	$tags 		= filter_txt($_POST['tags']);
	$thumb	 	= $_FILES['thumb'];
	
	$data = compact('title','cat','isi','thumb','tags');
	user_add_post($data);
}

?>
<form action="" method="post" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td width="6%" align="left" valign="top">Title</td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="93%" align="left" valign="top">
      <input type="text" name="title" size="80" value="<?php echo stripslashes(htmlspecialchars(@$_POST['title']));?>"></td>
    </tr>
    <tr>
      <td align="left" valign="top">Desc</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">
      <textarea name="isi" id="editor" style="width:600px; height:250px;"><?php echo htmlspecialchars(@$_POST['isi']);?></textarea></td>
    </tr>
    <tr>
      <td align="left" valign="top">Topic</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">
      <select name="cat">
      <option value="">--Select Topic--</option>
<?php
$where = null;
if(!is_admin()) $where = array('public'=>1,'status'=>1);

$query_album_category = list_post_category( $where );
while($data_album_category = $db->fetch_array($query_album_category)){
	echo '<option value="'.$data_album_category['id'].'">'.$data_album_category['topic'].'</option>';
}
?>
      </select>
      </td>
    </tr>
    <tr>
      <td align="left" valign="top">Thumb</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input class=input type="file" name="thumb" /></td>
    </tr>
    <tr>
      <td align="left" valign="top">Tag</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input class=input type="text" name="tags" size="50" value="<?php echo stripslashes(htmlspecialchars(@$_POST['tags']));?>" /><span class="req">*exc: google,facebook</span></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input type="submit" name="submit" value="Kirim" /> <input type="reset" name="button" value="Reset" /><input name="MAX_FILE_SIZE" type="hidden" id="MAX_FILE_SIZE" size="30000" /></td>
    </tr>
  </table>
</form>
<?php
	break;
	case'edit':
if(isset($_POST['submit'])){
	$title 		= filter_txt($_POST['title']);
	$cat 		= filter_int($_POST['cat']);	
	
	if(get_option('text_editor')=='classic'){
	$isi	 	= nl2br2($_POST['isi']);
	}else{
	$isi	 	= $_POST['isi'];
	}
	
	$tags 		= filter_txt($_POST['tags']);
	$thumb	 	= $_FILES['thumb'];
	
	$data = compact('title','cat','isi','thumb','tags');
	user_edit_post($data, $id);
}
$data_post = view_post( $id );
?>
<form action="" method="post" enctype="multipart/form-data">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
    <tr>
      <td width="6%" align="left" valign="top">Title</td>
      <td width="1%" align="left" valign="top">&nbsp;</td>
      <td width="93%" align="left" valign="top">
      <input type="text" name="title" size="80" value="<?php echo stripslashes(htmlspecialchars($data_post['title']));?>"></td>
    </tr>
    <tr>
      <td align="left" valign="top">Desc</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">
      <textarea name="isi" id="editor" style="width:600px; height:250px;"><?php echo htmlspecialchars($data_post['content']);?></textarea></td>
    </tr>
    <tr>
      <td align="left" valign="top">Topic</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">
      <select name="cat">
      <option value="">--Select Topic--</option>
<?php
$where = null;
if(!is_admin()) $where = array('public'=>1,'status'=>1);

$query_post_category = list_post_category( $where );
while($data_post_category = $db->fetch_obj($query_post_category)){
	$selected =  '';
	if($data_post_category->id == $data_post['post_topic']) $selected = 'selected="selected"';	
	echo '<option value="'.$data_post_category->id.'" '.$selected.'>'.$data_post_category->topic.'</option>';
}
?>
      </select>
      </td>
    </tr>
    <tr>
      <td align="left" valign="top">Image</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input class=input type="file" name="thumb" /></td>
    </tr>
    <tr>
      <td align="left" valign="top">Thumb</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><div style="text-align:left;"><img style="border:1px solid #ddd; padding:5px; min-height:120px; min-width:120px" src="<?php echo $iw->base_url;?>?request&load=thumb.php&apps=post&src=<?php echo $data_post['thumb'];?>&x=120&y=120&c=1"></div></td>
    </tr>
    <tr>
      <td align="left" valign="top">Tags</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input class=input type="text" name="tags" size="50" value="<?php echo stripslashes(htmlspecialchars($data_post['tags']));?>" /><span class="req">*exc: google,facebook</span></td>
    </tr>
    <tr>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top">&nbsp;</td>
      <td align="left" valign="top"><input type="submit" name="submit" value="Kirim &amp; Update" /> <input type="reset" name="button" value="Reset" /><input name="MAX_FILE_SIZE" type="hidden" id="MAX_FILE_SIZE" size="30000" /></td>
    </tr>
  </table>
</form>
<?php
	break;


}
