<?php
global $db;
?>
<div id="slider">
<div id="featured">
<?php 
$i = 0;
$sqlFrontArtikel 		= $db->select( 'post',array('type'=>'post','status'=>1,'approved'=>1),'ORDER BY date_post DESC LIMIT 0,4' );
while ($wFrontArtikel 	= $db->fetch_obj($sqlFrontArtikel)) {

if( $i != 0 ) $style = 'ui-tabs-hide';
?>
<div id="post-<?php echo $wFrontArtikel->id?>" class="ui-tabs-panel<?php echo $style;?>" style="">
<a href="#" rel="bookmark"><img src="<?php get_template_directory_uri(true); ?>/includes/timthumb.php?src=<?php echo content_url('/uploads/post/'.$wFrontArtikel->thumb);?>&amp;h=236&amp;w=373&amp;zc=1" alt=""></a>
<div class="info">
<h2><a href="<?php echo do_links('post', array('view'=>'item','id'=>$wFrontArtikel->id,'title'=>$wFrontArtikel->title) );?>" rel="bookmark"><?php echo $wFrontArtikel->title?></a></h2>
</div>
</div>
<?php
$i++;
}
?>
<ul class="ui-tabs-nav">
<?php 
$sqlFrontArtikel 		= $db->select( 'post',array('type'=>'post','status'=>1,'approved'=>1),'ORDER BY date_post DESC LIMIT 0,4' );
while ($wFrontArtikel 	= $db->fetch_obj($sqlFrontArtikel)) {
?>
<li class="ui-tabs-nav-item" id="nav-post-<?php echo $wFrontArtikel->id?>">
<a href="#post-<?php echo $wFrontArtikel->id?>"><img src="<?php get_template_directory_uri(true); ?>/includes/timthumb.php?src=<?php echo content_url('/uploads/post/'.$wFrontArtikel->thumb);?>&amp;h=44&amp;w=80&amp;zc=1" alt=""></a>
</li>
<?php
}
?>
</ul>
</div>
</div>