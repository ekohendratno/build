<?php
/**
 * @file init.comment.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;
global $iw, $db;

$id_reply	= filter_int($_GET['reply']);
$id			= post_item_id('item',$_GET['id']);
?>
<link rel="stylesheet" href="<?php apps_url('post/style.css');?>" type="text/css">
<?php
if( get_option('post_comment') == 1 ):
/*
 *show comment where id post and status = 1 order by id desc limit where data limit table id_comment_set
 */

$color			= '';
$comment_no		= 0;
$qry_comment	= $db->select("post_comment",array('post_id'=>$id,'approved'=>1,'comment_parent'=>0)); 

echo '<h1 class=border>'.count_comment($id).' Respon dari "'.$titlenya.'"</h1>';

if(count_comment($id) == 0)
echo '<div class=border>Belum ada komentar</div>';

while ($data	= $db->fetch_array($qry_comment)) {
	
$no_comment 	= filter_int( $data['comment_id'] );
$no_respon  	= filter_int( $comment_no++ );
//?com=post&view=item&id=1&reply=10
$data_reply		= array('view'=>'item','reply'=>$no_comment,'id'=>$id,'title'=>$titlenya);
$reply_link		= do_links('post',$data_reply);
?>
<div class="comment-wrap" id="respon-<?php echo $no_respon;?>">
<div class="comment-img"><img src="<?php _e(get_gravatar($data['email']));?>" /></div>
<div class="comment-text">
<b><?php echo $data['author'];?></b> <?php echo set_link($data['comment']);?>
<div class="comment-time"><?php echo time_stamp($data['time']); if($id_reply != $no_comment):?> | <a href='<?php echo $reply_link?>#respon-comment'>Balas </a><?php endif;?></div> 
<!--comment reply-->
<?php
$comment_no_reply	= 0;
$q2					= $db->select("post_comment",array('post_id'=>$id,'approved'=>1,'comment_parent'=>$no_comment)); 
while ($data2		= $db->fetch_array($q2)) {
$no_respon_reply	= filter_int( $comment_no_reply++ );
?>
<div class="comment-reply-bg" id="respon-<?php echo $no_respon;?>-<?php echo $no_respon_reply;?>">
<div class="comment-img comment-reply-img"><img src="<?php _e(get_gravatar($data2['email']));?>" /></div>
<div class="comment-text comment-reply-text">
<b><?php echo $data2['author'];?></b> <?php echo set_link($data2['comment']);?>
<div class="comment-time comment-reply-time"><?php echo time_stamp($data2['time']);?></div> 
</div>
</div>
<?php
}
?>
</div>
</div>
<?php
}
?>
<h1 class=border>Tinggalkan Komentar <?php if(isset($id_reply)) _e('Balasan')?></h1>

<?php 
if($id_reply): ?>
<div align="right"><a href="<?php echo $id_link?>#respon-comment" class="post_reply">New Comment</a></div>
<?php
endif;

if(isset($_POST['addcomment'])){

if(!post_user_login())
{
	$author		= filter_txt($_POST['name']);
	$email 		= filter_txt($_POST['email']);
}
else
{
	$field 		= get_user_post();
		
	$user 		= $field->user_login;
	$email 		= $field->user_email;
	$author		= $field->user_author;
}

	$comment 	= filter_txt($_POST['comment']);
	$comment 	= nl2br($comment);
	
	$approved	= get_option('post_comment_filter');
	
	$gfx_check  = filter_txt($_POST['gfx_check']);
	$reply	    = $id_reply;
	$post_id    = filter_int($id);
	
	$data 		= compact('user','author','email','comment','date','approved','gfx_check','reply','post_id');
	set_comment($data);

}
?>
<div class="border" id="respon-comment">
<form method="post" action="#respon" id=respon>
  <table width="100%" border="0" cellspacing="2" cellpadding="0">
  <?php
  if(!post_user_login())
  {
  ?>
    <tr>
      <td width="15%" valign="top">Nama*</td>
      <td width="1%" valign="top"><strong>:</strong></td>
      <td width="74%" valign="top"><input class=input type="text" name="name"></td>
    </tr>
    <tr>
      <td valign="top">Mail*</td>
      <td valign="top"><strong>:</strong></td>
      <td valign="top"><input class=input type="text" name="email"></td>
    </tr>
    <?php
  }
  else
  {
	$field 	= get_user_post();
	?>   
    <tr>
      <td colspan="3" valign="top">Logged in as <a href="<?php echo do_links('login',array('go'=>'profile'))?>"><?php echo $field->user_login?></a>. <a href="?logout"  onclick="return confirm('Are You sure logout?')">Log out?</a></td>
      </tr>
    <tr>
      <td colspan="3" valign="top">&nbsp;</td>
      </tr>
    <?php
  }
	?>
    <tr>
      <td valign="top">Komentar*</td>
      <td valign="top"><strong>:</strong></td>
      <td valign="top"><textarea  cols="50" rows="5" name="comment" style="height:50px; width:80%"></textarea></td>
    </tr>
    <tr>
      <td valign="top">Kode Keamanan*</td>
      <td valign="top"><strong>:</strong></td>
      <td valign="top"><img src="<?php echo $iw->base_url?>?request&load=libs/captcha/image-random.php"  style="border:1px solid #ddd; margin-bottom:2px"></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top"><input  name="gfx_check" type="text" size=10/></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td valign="top">&nbsp;</td>
      <td valign="top"><input class=button type="submit" name="addcomment" value="Kirim"></td>
    </tr>
  </table>
</form>
</div>
<?php
endif;
?>