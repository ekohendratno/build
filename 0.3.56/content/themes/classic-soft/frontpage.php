<?php 
defined('_iEXEC') or die();

global $db;
set_layout('front');

?>
<h1  class="border"><?php _e( page('title',1) );?></h1>
<div class="border"><?php _e( page('content',1) );?></div>
<?php
$sql = get_post( array( 'type' => 'post' ), 'ORDER BY date_post DESC LIMIT 10' );
$post = $db->fetch_free( $sql );
foreach($post as $r ) {
	
$post_img='';
if(file_exists( upload_path . 'post/' . $r['thumb'] ) && !empty( $r['thumb'] ) )
$post_img='<img src="?request&load=thumb.php&apps=post&src='.$r['thumb'].'&x=70&y=70&c=1" class="post-img">';
?>

<h1 class="bg" title="<?php echo $r['title'];?>"><?php _e( limittxt($r['title'],50) );?></h1>

<div class="post" id="post-1">
<?php _e($post_img);?>
<p style="text-align:justify;">
<?php _e(limittxt(strip_tags($r['content']),350));?></p>
</div>

<p class="post-footer">
<?php $data = array('view' => 'item','id' => $r['id'],'title' => $r['title']);?>
<a href="<?php _e(do_links('post',$data));?>" rel="bookmark" title="<?php echo $r['title'];?>" class="readmore">Baca Selengkapnya</a>	
<span class="comments">Klik (<?php _e($r['hits']);?>)</span>
<span class="waktu_posting"><?php _e(datetimes($r['date_post'],false));?></span>	
</p>

<?php
}
?>
<div style="clear: both;"></div>