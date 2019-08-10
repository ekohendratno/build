<?php if( the_sidebar_active('sidebar-1') ):?>
<div id="sidebar">
<div class="mlmenu vertical blindv delay inaccesible">
<ul>
	<li><a class="home" href="<?php echo site_url('/'); ?>">Home</a></li>
	<?php list_categories('title_li='); ?>
</ul>
<?php //echo dynamic_menus(1, 'class="vertical white"'); ?>
</div>
<!--start-right-->
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home/Page Left') ) : ?>
<?php endif; ?>	
<!--end-right-->
</div>
<?php endif;?>

