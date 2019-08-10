<?php
/**
 * The Index for our theme.
 *
 * @package ID
 * @subpackage Ares plus
 * @since Classic 1.2
 */
if(!defined('_iEXEC')) exit;?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<title><?php iw_title( true );?></title>
<meta charset="<?php get_info( 'charset', true ); ?>">
<meta name="Description" content="<?php get_info( 'description', true ); ?>">
<meta name="Keywords" content="<?php get_info( 'keywords', true ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php get_info( 'stylesheet_url', true ); ?>" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php get_stylesheet_directory_uri(true); ?>/css/style.css" />
<?php iw_head();?>
</head>
<body>

<div id="wrapper">

<!-- header-wrapper -->
<div class="header_wrapper"></div>
<br class="clear">
<div class="standard_wrapper header">
<div class="logo"><a id="custom_logo" href=""><img src="<?php get_stylesheet_directory_uri(true); ?>/images/logo.png" alt=""></a></div>
<div class="header_ads"><div class="ads468"><div class="text">468x60</div></div></div>
<br class="clear">
</div>
<!-- end header-wrapper -->

<!-- standard_wrapper -->
<br class="clear">
<div class="standard_wrapper">			
<div class="main_nav">
<ul>
	<li class="page_item page-item-2"><a href="<?php _e(do_links('contact'));?>">Home</a></li>
	<li class="page_item page-item-2"><a href="<?php _e(do_links('page',array('id'=>2,'title'=>'page')));?>">Page</a></li>
	<li class="page_item page-item-2"><a href="<?php _e(do_links('page',array('id'=>3,'title'=>'simple-page')));?>">Sample Page</a></li>
	<li><a>&nbsp;</a></li>
</ul>
</div>
</div>
<!-- end standard_wrapper -->

<!-- content_wrapper -->
<br class="clear">
<div id="content_wrapper">
<div class="sidebar_content">

<?php
$query_post = mysql_query("SELECT * FROM iw_post WHERE type='post' ORDER BY date_post DESC LIMIT 10");
while($data_post = mysql_fetch_object($query_post)){
?>
<div class="post_wrapper">
<div class="post_inner_wrapper" style="margin-top:10px">
<div class="post_header_wrapper">
<div class="post_header">
<h3><a href="#" title="<?php echo $data_post->title?>"><?php echo $data_post->title?></a></h3>
</div>
<br class="clear">
<div class="post_detail">Posted by admin on <?php echo dateformat($data_post->date_post)?> /<a href="">1 Comment</a></div>
</div>    	
<div class="post_social">#social</div>
<br class="clear"><br><hr>
<p><?php echo limittxt( strip_tags( $data_post->content , '<a>') ,250)?></p>
<a href="">Read more →</a>
</div>
</div>
<?php
}
?>

</div>
<!------------------------------->
<div class="sidebar_wrapper">
<div class="sidebar">
<div class="content">
<ul class="sidebar_widget">

<li id="search-2" class="widget widget_search">
<form role="search" method="get" id="searchform" action="">
<div>
<label class="screen-reader-text" for="s">Search for:</label>
<input type="text" value="" name="s" id="s" title="to search type and hit enter" class="blur" placeholder="to search type and hit enter">
<input type="submit" id="searchsubmit" value="Search">
</div>
</form>
</li>

<li id="recent-posts-2" class="widget widget_recent_entries">		
<h2 class="widgettitle">Recent Posts</h2>
<ul>
<li><a href="" title="">Microsoft bakes giant Surface cake for Windows 8 party</a></li>
<li><a href="" title="">Hello world!</a></li>
</ul>
</li>

<li id="recent-posts-2" class="widget widget_recent_entries">		
<h2 class="widgettitle">Recent Posts</h2>
<ul>
<li><a href="" title="">Microsoft bakes giant Surface cake for Windows 8 party</a></li>
<li><a href="" title="">Hello world!</a></li>
</ul>
</li>

<li id="recent-posts-2" class="widget widget_recent_entries">		
<h2 class="widgettitle">Recent Posts</h2>
<ul>
<li><a href="" title="">Microsoft bakes giant Surface cake for Windows 8 party</a></li>
<li><a href="" title="">Hello world!</a></li>
</ul>
</li>

</ul>
</div>
</div>
<br class="clear">
</div>
<br class="clear">
</div>
<!-- end content_wrapper -->

<!-- footer_wrapper -->
<br class="clear">
<div class="footer_wrapper">
<div id="footer"></div>
<div id="copyright">
<div id="copyright_left">Copyright &copy; 2011. Remove this via Theme admin | Footer</div>
<div class="social_wrapper">
<ul>
    <li><a href=""><img src="<?php get_stylesheet_directory_uri(true); ?>/images/social_black/youtube.png" alt=""></a></li>
    <li><a href=""><img src="<?php get_stylesheet_directory_uri(true); ?>/images/social_black/tumblr.png" alt=""></a></li>
    <li><a href=""><img src="<?php get_stylesheet_directory_uri(true); ?>/images/social_black/facebook.png" alt=""></a></li>
    <li><a href=""><img src="<?php get_stylesheet_directory_uri(true); ?>/images/social_black/rss.png" alt=""></a></li>
</ul>
</div>
</div>
</div>
<!-- end footer_wrapper -->

</div>


</body>
</html>