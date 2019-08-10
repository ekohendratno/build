<div id="sidebar">
<?php $get_query = get_query_var('com'); if ( $get_query == 'post' || $get_query == 'page' || $get_query == '404' ) {?>
    <div class="ad160x600">
    <a href="#" target="_blank">
    <img src="<?php get_template_directory_uri(true); ?>/includes/timthumb.php?src=<?php get_template_directory_uri(true); ?>/images/ads/160X600.jpg&h=600&w=160&zc=1">
    </a>
    </div>
    <div class="clear"></div>
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Right') ) : ?>
    <?php endif; ?>	
    <div class="clear"></div>	
<?php }else{ ?>
<div class="ad300x250">
<a href="#" target="_blank">
<img src="<?php get_template_directory_uri(true); ?>/includes/timthumb.php?src=<?php get_template_directory_uri(true); ?>/images/ads/ads300x250.jpg&h=250&w=300&zc=1">
</a>
</div>
<div class="clear"></div>
	<?php include('tabber.php') ;?>
	<div class="fullwidget">
    	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Right #Full Width') ) : ?>
    	<?php endif; ?>
  	</div> <!--end: fullwidget-->
  	<div class="leftwidget">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Right #Left') ) : ?>
    	<?php endif; ?>
  	</div> <!--end: leftwidget-->
  	<div class="rightwidget">
    	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Right #Right') ) : ?>
    	<?php endif; ?>
  	</div> <!--end: rightwidget-->
    <div class="clear"></div>
<?php } ?>
</div> <!--end: sidebar-->


