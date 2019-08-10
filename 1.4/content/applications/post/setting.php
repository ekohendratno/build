<?php
/**
 * @file setting.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $login;

if( 'post/setting.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') 
):

if( isset($_POST['post_comment_filter']) ){
	
	$post_comment = (string)$_POST['post_comment'];
	if( checked_option( 'post_comment' ) ) set_option( 'post_comment', $post_comment );
	else add_option( 'post_comment', $post_comment );
	
	
	$post_comment_filter = (int)$_POST['post_comment_filter'];
	if( checked_option( 'post_comment_filter' ) ) set_option( 'post_comment_filter', $post_comment_filter );
	else add_option( 'post_comment_filter', $post_comment_filter );
	
	add_activity('post',"Merubah setting post", 'post');	
	
	$response['status'] = 1;
	$response['msg'] = 'Berhasil merubah pengaturan post';
	header('Content-type: application/json');	
	echo json_encode($response);
	
}else{
?>
<form>
<div class="padding">
  <table width="100%" cellpadding="4">
    <tbody>
    <tr>
      <td>Post Comment Filter</td>
      <td><strong>:</strong></td>
      <td>
      <select name="post_comment_filter">
<?php
if(get_option('post_comment_filter')==1){
	echo '	
      <option value="0">Unaproved</option>
      <option value="1" selected="selected">Approved</option>
	';
}else{	
	echo '	
      <option value="0" selected="selected">Unapproved</option>
      <option value="1">Approved</option>
	';
}
?>
      </select>
      </td>
    </tr>
    
    <tr>
      <td>Post Comment Form</td>
      <td><strong>:</strong></td>
      <td>
      <select name="post_comment">
<?php
if(get_option('post_comment')==1){
	echo '	
      <option value="0">Hide</option>
      <option value="1" selected="selected">Show</option>
	';
}else{	
	echo '	
      <option value="0" selected="selected">Hide</option>
      <option value="1">Show</option>
	';
}
?>
      </select>
      </td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td>
      </td>
    </tr>
    <tbody>
</table>
</div>
</form>
<?php
}
endif;
?>