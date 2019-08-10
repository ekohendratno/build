<?php
/**
 * The Index for our theme.
 *
 * @package ID
 * @subpackage Classic
 * @since Classic 1.3
 */
global $login;

if(!defined('_iEXEC')) exit;?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<title><?php iw_title( true );?></title>
<meta charset="<?php get_info( 'charset', true ); ?>">
<meta name="Description" content="<?php get_info( 'description', true ); ?>">
<meta name="Keywords" content="<?php get_info( 'keywords', true ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php get_info( 'stylesheet_url', true ); ?>" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php get_stylesheet_directory_uri(true); ?>/css/default.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php get_stylesheet_directory_uri(true); ?>/css/forms.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php get_stylesheet_directory_uri(true); ?>/css/message.css" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php get_stylesheet_directory_uri(true); ?>/css/table.css" />
<link rel="stylesheet" type="text/css" href="<?php get_stylesheet_directory_uri(true); ?>/css/style-menu.css">
<script>
$(function() {
	$('.vertical li:has(ul)').addClass('parent');
	$('.horizontal li:has(ul)').addClass('parent');
});
</script>
<?php iw_head();?>
</head>
<body>
<div id="wrap">

<div class="wrap-top"></div>
<!--start-head-->
<div id="header"> 
<?php
	/*
	 * function get_themes_url()
	 * menampilkan url file ke direktori themes
	 */
?>
<img src="<?php get_stylesheet_directory_uri(true); ?>/rotator.php" class="header-image">
<div id="header-wrap">
<div id="text">
<?php
	/*
	 * function index()
	 * menampilkan title, slogan dll tergantung dari pengaturan option
	 */
?>
<div class="logo-ID" title="<?php iw_title( true );?>"></div>
</div>
<?php
	/*
	 * class function $access->cek_login()
	 * mengecek status log
	 */
?>
<ul id="menu-user">
<?php if( $login->cek_login() ){?>
<li><a href="<?php _e(do_links('logout'));?>">Logout</a></li>
<?php }else{?>
<li><a href="<?php _e(do_links('login'));?>">Login</a></li>
<li><a href="<?php _e(do_links('login',array('go'=>'register')));?>">Register</a></li>
<?php }?>
<li><a href="<?php _e(do_links('login',array('go'=>'lost')));?>">Lost Password</a></li>
</ul>
<?php
	/*
	 * function do_links()
	 * mengubah menjadi link supaya user frendly dan akan digenerat secara
	 * otomatis oleh system
	 *
	 * contoh dengan menggunakan seo default
	 * do_links('applikasimu') akan jadi link "/?com=applikasimu"
	 *
	 * contoh lagi
	 * do_links('applikasimu',array('view'=>'lihat',id'=>1,'title'=>'judul mu') 
	 * akan jadi link "/?com=applikasimu&view=lihat&id=1"
	 *
	 * lebih lanjut baca 
	 * http://cmsid.org/item/gimana-sie-cara-buat-link-generator-di-cmsid-versi-2-1-terbaru.html
	 */
?>
<ul id="menu-header">
<li><a href="./"><span>Home</span></a></li>
<li><a href="<?php _e(do_links('post'));?>"><span>Article</span></a></li>
<li><a href="<?php _e(do_links('album'));?>"><span>Photo Gallery</span></a></li>
<li><a href="<?php _e(do_links('download'));?>"><span>Download</span></a></li>
<li><a href="<?php _e(do_links('links'));?>"><span>Links</span></a></li>
<li><a href="<?php _e(do_links('contact'));?>"><span>Contact Us</span></a></li> 
<li><a href="<?php _e(do_links('page',array('id'=>2,'title'=>'abouts')));?>"><span style="border-right:0;">About's</span></a></li> 
</ul> 
<form id="searching" action="<?php _e(do_links('search'));?>" method="post"><input type="text" value="" placeholder="Searching here..." class="searching-text" name="q"><button class="searching-button">Go</button></form>
</div> 
</div>
<!--start-content-->
<div id="wrap-content">
<!--content-wrap-->
<div id="content-wrap">

<?php if( the_sidebar_active('sidebar-1') ):?>
<div id="sidebar">
<?php echo dynamic_menus(1, 'class="vertical white"'); ?>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home/Page Left') ) : ?>
<?php endif; ?>
</div>
<?php endif; ?>
<div id="main">
<?php the_main_page();?>
</div>
<?php if( the_sidebar_active('sidebar-2') ):?>
<div id="rightbar">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Right') ) : ?>
<?php endif; ?>
</div>
<?php endif; ?>

</div>
<!--start-footer-->
<div id="footer"> 
<div id="footer_text">
<div class="footer-left">
<p>
<a href="./">Home</a>&nbsp;&bull;&nbsp;
<a href="<?php _e('http://cmsid.org/page-support-us.html');?>">Support Us</a>&nbsp;&bull;&nbsp;
<a href="<?php _e('http://cmsid.org/page-about.html');?>">About</a>
<!--
<a href="<?php _e(do_links('contact'));?>">Contact Us</a>&nbsp;&bull;&nbsp;
<a href="<?php _e(do_links('page',array('id'=>3,'title'=>'privacy')));?>">Privacy</a>&nbsp;&bull;&nbsp;
<a href="<?php _e(do_links('page',array('id'=>4,'title'=>'term of use')));?>">Term of Use</a>&nbsp;&bull;&nbsp;
<a href="<?php _e(do_links('page',array('id'=>5,'title'=>'site credit')));?>">Site Credit</a>
-->
</p>
</div> 
<div class="footer-right">
<p class="align-right"><?php _e(get_option('site_copyright'));?></p>
</div>
</div>
</div>

</div>
</body>
</html>