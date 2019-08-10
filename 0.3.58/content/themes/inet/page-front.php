<?php 
if(!defined('_iEXEC')) exit;

global $db;

/* 
 * fungsi page() bertujuan untuk mengextrax content halaman misal title dengan id 1(satu)
 * title disini mengacu pada field nama table di id 1 (satu) pada database
 * maka akan didapatkan judul yang akan ditampilkan pada halaman web
 * fungsi ini bisa anda cari di file function.php dengan nama function page(){}
 * untuk menampilkan anda bisa menggunakan fungsi _e() atau echo
 */

$sqlFrontArtikel = $db->query( "SELECT * FROM `$db->post` WHERE status=1 AND type='post' ORDER BY `id` DESC LIMIT 10" );
while ($wFrontArtikel = $db->fetch_obj($sqlFrontArtikel)) {
$dFrontArtikel	= array('view'=>'item','id'=>$wFrontArtikel->id,'title'=>$wFrontArtikel->title);
?>

<h4 class="bg"><?php echo $wFrontArtikel->title?></h4>
<div class="news">
<div class="thumb">
<a href="#" rel="bookmark" class="img-url">
<img src="<?php get_template_directory_uri(true); ?>/includes/timthumb.php?src=<?php echo content_url('/uploads/post/'.$wFrontArtikel->thumb);?>&h=100&w=100&zc=1" alt="">
</a>
</div>
<span class="align-justify"> <?php echo limittxt( strip_tags($wFrontArtikel->content), 300 )?></span>
<div style="clear:both"></div>
</div>		
			
<p class="post-footer">					
<a href="<?php echo do_links('post',$dFrontArtikel);?>" title="'.$data[1].'" class="readmore">Read more</a>
<span class="comments">Hits (<?php echo $wFrontArtikel->hits?>)</span>
<span class="date"><?php echo datetimes( $wFrontArtikel->date_post, false )?></span>	
</p>
<?php
}

?>
