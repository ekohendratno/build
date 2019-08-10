<?php 
if(!defined('_iEXEC')) exit;

set_layout("front");
global $db;

/* 
 * fungsi page() bertujuan untuk mengextrax content halaman misal title dengan id 1(satu)
 * title disini mengacu pada field nama table di id 1 (satu) pada database
 * maka akan didapatkan judul yang akan ditampilkan pada halaman web
 * fungsi ini bisa anda cari di file function.php dengan nama function page(){}
 * untuk menampilkan anda bisa menggunakan fungsi _e() atau echo
 */
?>
<h1  class="border"><?php _e(page('title',1));?></h1>
<div class="border"><?php _e(page('content',1));?></div>

<?php 
$class_postbox = 'right';

$sql = $db->select( 'post_topic', array('status'=>1), 'ORDER BY id DESC LIMIT 10' );
while ($w = $db->fetch_obj($sql)) {
	
$sql_artikel 	= $db->select('post',array('type'=>'post','post_topic'=>$w->id,'status'=>1),'ORDER BY date_post DESC LIMIT 1');
$w_artikel 		= $db->fetch_obj($sql_artikel);

$datas_artikel	= array('view'=>'item','id'=>$w_artikel->id,'title'=>$w_artikel->title);
$datas_topic 	= array('view'=>'category','id'=>$w->id,'title'=>$w->topic);
	
$class_postbox 	= ( $class_postbox === 'right' ) ? 'left' : 'right';
?>
<div class="postbox <?php echo $class_postbox?>">
<h1><a href="<?php echo do_links('post',$datas_topic);?>"><?php echo limittxt($w->topic,30);?></a></h1>
<div class="boxcontent">
<div class="thumb">
<?php if(file_exists(Upload.'post/'.$w_artikel->thumb)&&!empty($w_artikel->thumb)):?>
<a href="#" rel="bookmark" class="img-url">
<img src="<?php _e( $iw->base_url. 'irequest.php?load=thumb&app=post&src='.$w_artikel->thumb.'&x=240&y=130&c=1')?>" alt="">
</a>
<?php endif;?>
</div>
<h5><a href="#" title="Posts by <?php echo $w_artikel->user_login?>"><?php echo $w_artikel->user_login?></a> // <?php echo datetimes( $w_artikel->date_post, false )?></h5>
<h2><a href="<?php echo do_links('post',$datas_artikel);?>" rel="bookmark"><?php _e( limittxt($w_artikel->title,70) )?></a></h2>
<div class="more"><div class="more">More &raquo;</div></div>   
<ul>
<?php
$sql_am 	= $db->select('post',array('type'=>'post','post_topic'=>$w->id,'status'=>1),'ORDER BY date_post DESC LIMIT 3');
while($w_am = $db->fetch_obj($sql_am)){
if($w_am->id != $w_artikel->id){
$datas_am = array('view'=>'item','id'=>$w_am->id,'title'=>$w_am->title);
?>
<li><a href="<?php echo do_links('post',$datas_am);?>" rel="bookmark"><?php _e( limittxt($w_am->title,60) )?></a></li>
<?php }}?>
</ul>
</div>
</div>

<?php }?>
