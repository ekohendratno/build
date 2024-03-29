<?php
/**
 * The Index for our theme.
 *
 * @package ID
 * @subpackage Portal
 * @since Portal 1.3
 */
if(!defined('_iEXEC')) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
<meta charset="utf-8"> 
<title><?php the_title( true );?></title>
<meta charset="<?php get_info( 'charset', true ); ?>">
<meta name="Description" content="<?php get_info( 'description', true ); ?>">
<meta name="Keywords" content="<?php get_info( 'keywords', true ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link href="<?php get_template_directory_uri(true); ?>/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php get_template_directory_uri(true); ?>/js/ajaxtabs.js"></script>
<script type="text/javascript" src="<?php get_template_directory_uri(true); ?>/js/menu.js"></script>
<script type="text/javascript" src="<?php get_template_directory_uri(true); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php get_template_directory_uri(true); ?>/js/jquery-ui.min.js"></script>
<script>
$(function() {
	$('.vertical li:has(ul)').addClass('parent');
	$('.horizontal li:has(ul)').addClass('parent');
});
$(document).ready(function(){
	$("#featured > ul").tabs({fx:{opacity: "toggle"}}).tabs("rotate", 7000, true);
});
</script>
<?php the_head();?>
</head>
<body>
<div id="header">
<div class="left"><a class="imagelogo" href="<?php echo site_url('/')?>"></a></div>
<div class="right">
<div class="ad468x60"><a href="#" target="_blank"><img src="<?php get_template_directory_uri(true); ?>/includes/timthumb.php?src=<?php get_template_directory_uri(true); ?>/images/ads/ads468x60.jpg&h=60&w=468&zc=1"></a></div>
</div>
</div>
<div id="headline">

<div class="left">
Subscribe:<span class="rss"><a href="#" title="Subscribe to RSS feed">Posts</a></span>
<span class="rss"><a href="#" title="Subscribe to Comments feed">Comments</a></span>
</div>
<div class="right">
<div class="mlmenu horizontal fade inaccesible">
<ul>
<?php echo dynamic_menus(8, 'class="horizontal fade"', false); ?>
				<li>
				<form method="get" id="searchform" action="/">
				  <div id="search">
				    <input class="searchinput" type="text" value="Search this site..." onclick="this.value='';" name="s" id="s" />
				    <input class="searchsubmit" type="submit" value="GO"/>
				  </div>
				</form>
				</li>
			</ul>	
</div>
</div>
<div class="clear"></div>

</div>
<div id="wrapper">

<div id="leftwrapper">
<?php include 'sidebar-left.php';?>
<div id="column2">
<?php the_content();?>
</div>
</div>
<?php if( the_sidebar_active('sidebar-2') ):
include 'sidebar.php';
endif; ?>
<div class="clear"></div>
</div>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer') ) : ?>
<div id="footer">
    <div class="footerwidget left">
    <h3>
      Footer Widget #1    </h3>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin semper ultrices tortor quis sodales. Proin scelerisque porttitor tellus, vel dignissim tortor varius quis. Proin diam eros, lobortis sit amet viverra id, eleifend ut tellus. Vivamus sed lacus augue.  </div>
  <div class="footerwidget left">
    <h3>
      Footer Widget #2    </h3>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin semper ultrices tortor quis sodales. Proin scelerisque porttitor tellus, vel dignissim tortor varius quis. Proin diam eros, lobortis sit amet viverra id, eleifend ut tellus. Vivamus sed lacus augue.  </div>
  <div class="footerwidget left">
    <h3>
      Footer Widget #3    </h3>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin semper ultrices tortor quis sodales. Proin scelerisque porttitor tellus, vel dignissim tortor varius quis. Proin diam eros, lobortis sit amet viverra id, eleifend ut tellus. Vivamus sed lacus augue.  </div>
  <div class="footerwidget left">
    <h3>
      Footer Widget #4    </h3>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin semper ultrices tortor quis sodales. Proin scelerisque porttitor tellus, vel dignissim tortor varius quis. Proin diam eros, lobortis sit amet viverra id, eleifend ut tellus. Vivamus sed lacus augue.  </div>
<?php endif; ?>
  <!--end: footerwidget-->
    <div class="clear"></div>
</div>
<div id="bottom">
&copy; 2010 <a href="#">Portal</a> &bull; Subscribe:<span class="rss"><a href="#">Posts</a></span><span class="rss"><a href="#">Comments</a></span> &bull; Designed by <a href="#">Theme Junkie</a> &bull; Powered by <a href="#">WordPress</a>
<div class="clear"></div>
</div>
</body>
</html>