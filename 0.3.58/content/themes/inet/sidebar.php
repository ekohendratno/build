<?php $get_query = get_query_var('com'); if ( $get_query == 'post' || $get_query == 'page' || $get_query == '404' ) {?>
    <div class="ad160x600">
    <a href="#" target="_blank">
    <img src="<?php get_template_directory_uri(true); ?>/includes/timthumb.php?src=<?php get_template_directory_uri(true); ?>/images/ads/160X600.jpg&h=600&w=160&zc=1">
    </a>
    </div>
    <div class="clear"></div>
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Page Right') ) : ?>
    <?php endif; ?>	
<?php }else{ ?>
    <div id="rightbar">
    <!--start-right-->
    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Right #Full Width') ) : ?>
    <?php endif;?>
    <!--end-right-->
    </div>
<?php } ?>