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

$class_postbox 	= 'right';
$clear_div = 0;
$sqlFrontArtikel 		= $db->select( 'post',array('type'=>'post','status'=>1),'ORDER BY date_post DESC LIMIT 10' );
while ($wFrontArtikel 	= $db->fetch_obj($sqlFrontArtikel)) {

$sqlFrontTopic 	= $db->select( 'post_topic', array('status'=>1,'id'=>$wFrontArtikel->post_topic) );
$wFrontTopic 	= $db->fetch_obj($sqlFrontTopic);

$dFrontArtikel	= array('view'=>'item','id'=>$wFrontArtikel->id,'title'=>$wFrontArtikel->title);
$dFrontTopic 	= array('view'=>'category','id'=>$wFrontTopic->id,'title'=>$wFrontTopic->topic);
	
$class_postbox 	= ( $class_postbox === 'right' ) ? 'left' : 'right';
?>
<div class="postbox <?php echo $class_postbox?>">

<h1><a href="<?php echo do_links('post',$dFrontTopic);?>"><?php echo $wFrontTopic->topic;?></a></h1>
<div class="boxcontent">
<div class="thumb">
<a href="#" rel="bookmark" class="img-url">
<img src="<?php get_stylesheet_directory_uri(true); ?>/includes/timthumb.php?src=<?php echo content_url('/uploads/post/'.$wFrontArtikel->thumb);?>&h=100&w=209&zc=1" alt="">
</a>
</div>
<h5><a href="#" title="Posts by <?php echo $wFront->user_login?>"><?php echo $wFrontArtikel->user_login?></a> // <?php echo datetimes( $wFrontArtikel->date_post, false )?></h5>
<h2><a href="<?php echo do_links('post',$dFrontArtikel);?>" rel="bookmark"><?php _e( $wFrontArtikel->title )?></a></h2>
<div class="more"><div class="more">More &raquo;</div></div>   
<ul>
<?php
$sqlFrontArtikelMore 		= $db->select('post',array('type'=>'post','status'=>1),'ORDER BY date_post DESC LIMIT 3');
while($wFrontArtikelMore 	= $db->fetch_obj($sqlFrontArtikelMore)){	
if($wFrontArtikelMore->id != $wFrontArtikel->id){
	
$dFrontArtikelMore = array('view'=>'item','id'=>$wFrontArtikelMore->id,'title'=>$wFrontArtikelMore->title);
?>
<li><a href="<?php echo do_links('post',$dFrontArtikelMore);?>" rel="bookmark"><?php _e( limittxt($wFrontArtikelMore->title,60) )?></a></li>
<?php }}?>
</ul>
</div>
</div><!--.postbox-->

<?php
if( $clear_div == 1 ) echo '<div style="clear:both;"></div>'; 
if( $clear_div > 1 ) $clear_div = 0;
 
$clear_div++;


}

?>
