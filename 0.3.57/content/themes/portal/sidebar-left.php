<?php if( the_sidebar_active('sidebar-1') ):?>
<div id="column1">
<div class="mlmenu vertical blindv delay inaccesible">
<ul>
	<li><a class="home" href="<?php echo site_url('/'); ?>">Home</a></li>
	<?php list_categories('title_li='); ?>
</ul>
<?php //echo dynamic_menus(1, 'class="vertical white"'); ?>
</div>
<div class="leftsidebar">
<h3><a href="#">Top News</a></h3>
		<div class="box">
<?php $sqlFrontArtikel = $db->select( 'post',array('type'=>'post','status'=>1,'approved'=>1),'ORDER BY hits DESC LIMIT 5' );
while ($wFrontArtikel  = $db->fetch_obj($sqlFrontArtikel)):?>
			<div class="leftnews">
				<div class="thumb">
					<a href="<?php echo do_links('post', array('view'=>'item','id'=>$wFrontArtikel->id,'title'=>$wFrontArtikel->title) );?>" rel="bookmark"><img src="<?php get_template_directory_uri(true); ?>/includes/timthumb.php?src=<?php echo content_url('/uploads/post/'.$wFrontArtikel->thumb);?>&amp;h=36&amp;w=36&amp;zc=1" alt="<?php echo $wFrontArtikel->title; ?>" /></a>
				</div> <!--end: thumb-->
				<span><a href="<?php echo do_links('post', array('view'=>'item','id'=>$wFrontArtikel->id,'title'=>$wFrontArtikel->title) );?>" rel="bookmark"><?php echo $wFrontArtikel->title; ?></a></span>
				<div class="clear"></div>
			</div> <!--leftnews-->				
			<?php endwhile; ?>
		</div>
</div>
<div class="leftsidebar">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home/Page Left') ) : ?>
<?php endif; ?>
</div>
</div>
<?php endif;?>

