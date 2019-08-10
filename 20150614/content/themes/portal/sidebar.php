<div id="sidebar">	
<?php $p = get_query_var('p'); if ( in_array($p,array('postdetail','page','archive','category')) ) {?>
	<?php if( theme_option('ads160x600') ):?>
    <div class="ad160x600">
    <a href="#" target="_blank"><img src="<?php echo theme_option('ads160x600');?>"></a>
    </div>
    <div class="clear"></div>
    <?php endif;?>
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Right') ) : ?>
    <?php endif; ?>	
    <div class="clear"></div>	
<?php }else{ ?>
<?php if( theme_option('ads300x250') ):?>
<div class="ad300x250">
<a href="#" target="_blank"><img src="<?php echo theme_option('ads300x250');?>"></a>
</div>
<?php endif;?>
<div class="clear"></div>
	<?php if( theme_option('tabber') ): include('tabber.php'); endif;?>
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
<?php }?>
</div> <!--end: sidebar-->


