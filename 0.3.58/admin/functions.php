<?php 
/**
 * @fileName: functions.php
 * @dir: admin/templates/
 */
if(!defined('_iEXEC')) exit;

$aside_default = array(
			"post" => array(
				'title'		=>'Posts',
				'link'		=>'?admin&apps=post'
			),
			"page" => array(
				'title'		=>'Pages',
				'link'		=>'?admin&apps=post&type=page'
			),
			"comments" => array(
				'title'		=>'Comments',
				'link'		=>'?admin&apps=post&go=comment'
			),
			"media" => array(
				'title'		=>'Files',
				'link'		=>'?admin&sys=files'
			),
			"appearance" => array(
				'title'		=>'Appearance',
				'link'		=>'?admin&sys=appearance'
			),
			"backup" => array(
				'title'		=>'Backup',
				'link'		=>'?admin&sys=backup'
			),
			"menus" => array(
				'title'		=>'Menus',
				'link'		=>'?admin&sys=menus'
			),
			"sidebar" => array(
				'title'		=>'Sidebar',
				'link'		=>'?admin&sys=sidebar'
			),
			"users" => array(
				'title'		=>'Users',
				'link'		=>'?admin&sys=users'
			),
			"stats" => array(
				'title'		=>'Stats',
				'link'		=>'?admin&apps=stats'
			),
			"options" => array(
				'title'		=>'Options',
				'link'		=>'?admin&sys=options'
			)
	);

if( !function_exists('add_activity') ){
	function add_activity(){}
}
/**
 * membuat menu action pada admin
 *
 * @return array, html
 */
function add_manager_top(){
	global $login, $aside_default;
	


$style_width_top_left = ' style="width:650px"';
$style_width_menu_left = ' style="width:800px"';
if( $_SESSION['lw'] == 'full' ) $style_width_menu_left = $style_width_top_left = '';
?>

<link href="libs/css/nav.css" rel="stylesheet" />
<link href="libs/css/nav-menu.css" rel="stylesheet" />
<div class="nav-bg">
<div class="nav nav-fix">
<div class="nav-top">
<div class="left"<?php echo $style_width_top_left;?>>
<ul class="mainMenu tiptip">
<?php 
$top_menu_home = $top_menu_app = $top_menu_plugin = $top_menu_install = '';

if( is_sys_values() == 'applications' || is_apps() )
	$top_menu_app = ' current';
elseif( is_sys_values() == 'plugins' )
	$top_menu_plugin = ' current';
elseif( is_sys_values() == 'installer' )
	$top_menu_install = ' current';
elseif( is_sys_values() == 'help' )
	$top_menu_install = ' current';
else 
	$top_menu_home = ' current';

?>
    <li class="topNavLink<?php echo $top_menu_home;?>"><a href="?admin" class="tip" title="Home"><div class="icon menuHome"></div></a></li>
    <li class="topNavLink<?php echo $top_menu_app;?>"><a href="?admin&sys=applications"><div class="icon menuApps"></div><div class="icon menuAppsName">Applications</div></a><span class="jTips animating"><?php echo get_counted( 'app' );?></span></li>
    <li class="topNavLink<?php echo $top_menu_plugin;?>"><a href="?admin&sys=plugins"><div class="icon menuPlugins"></div><div class="icon menuPluginsName">Plugins</div></a><span class="jTips animating"><?php echo get_counted( 'plg' );?></span></li> 
    <li class="topNavLink<?php echo $top_menu_install;?>"><a href="?admin&sys=installer"><div class="icon menuInstall"></div><div class="icon menuInstallName">Installer</div></a></li>
    <li class="topNavLink<?php echo $top_menu_help;?>"><a href="?admin&sys=options&go=help"><div class="icon menuHelp"></div><div class="icon menuHelpName">Help</div></a></li>
</ul>
</div>

<div class="right">
<?php

$data_user 	= array('user_login' => $login->exist_value('username'));
$field 		= $login->username_cek( $data_user );
?>
<ul class="mainMenu tiptip">
    <li class="topNavLink">
    <a href="?login&go=profile" class="tip" title="Lihat Data Profile">
    <?php $avatar_img_profile = avatar_url($login->exist_value('username'));?>
    <img class="img" src="<?php echo $avatar_img_profile;?>" alt="">
    <span class="headerTinymanName"><?php echo $field->user_author;?></span>
    </a>
    </li>
    <li class="topNavLink"><a href="./" class="tip" title="Pratinjau Situs" target="_blank"><div class="icon menuViewsearch"></div></a></li>
    <li class="topNavLink">
    <dl class="staticMenu"><dt><a href="#" onclick="return false"><div class="icon menuPulldown"></div></a></dt>
    <dd>
    <ul class="mainMenuSub" style="right:0;left:auto">
        <li><a href="?admin&sys=options&go=setting">Pengaturan</a></li>
        <li class="logout"><a href="?login&go=logout" onclick="return confirm('Yakin ingin keluar?')">Keluar</a></li>
        <div style="clear:both"></div>
        <li class="seperator"><div></div></li>
        <li class="help"><a href="?admin&sys=options&go=help">Bantuan</a></li>
    </ul>
    </dd>
    </dl>
</li>
</ul>
</div>
</div>
</div>
<?php if(is_admin() && get_option('jump_app') == 1 ):?>
<div class="nav nav-fix-sub" style="display:none;">
<div class="nav-top-sub">
<div class="left"<?php echo $style_width_menu_left;?>>
<ul class="mainMenu showMenuSub">
    <li class="topNavLink navSub nav_jump">
    <a>
    <form action="" method="get" class="nav_jump_form">
        <input type="hidden" name="admin" value="single"/>  
        <input type="text" class="text_jump" name="apps" placeholder="Jump App to" /> 
        <input type="submit" class="submit_jump" value=""/> 
    </form>
    </a>
    </li>
<?php
$i = 1;
$limit_show = 5;

$i = 1;
foreach($aside_default as $k => $v){
	
	if( $i <= $limit_show && get_sys_cheked( $k ) || get_apps_cheked( $k, true ) ):	
		
		$current = '';
		if( $k == $_GET['apps'] or $k == $_GET['sys'] ) $current = ' current';		
		
		echo '<li class="topNavLink navSub'.$current.'"><a href="'.$v['link'].'">'.$v['title'].'</a></li>';
		$i++;
	endif;
}

?>
</ul>
</div>
<div class="right" style="width:100px">
<ul class="mainMenu right">
	<?php
	if( 'full' == $_SESSION['lw'] ){
		$lw_title = 'Change to Wrap';
		$lw = ' goFull';
	}
	elseif( 'single' == $_SESSION['lw'] ){
		$lw_title = 'Change to Full';
		$lw = ' goSingle';
	}
	else{
		$lw_title = 'Change to Single';
		$lw = ' goWrap';
	}
	?>
	<li class="topNavLink navSub currentRight"><a title="<?php echo $lw_title;?>"><div class="icon menuOverStyle<?php echo $lw;?>"></div></a></li>
</ul>
</div>
</div>
</div>
</div>
<?php endif;?>
<div class="shadow-inside-top"></div>

<?php
}

add_action('manager_top','add_manager_top');

/**
 * Gets the copunt apps and plugins.
 *
 * @return number
 */
function get_counted( $get_ = 'app' ){
	
	if( $get_ == 'app' ) return count( get_mu_apps() );
	elseif( $get_ == 'plg' ) return count( get_noactive_and_valid_plugins() );
	else return false;	
}
function add_manager_header_notif(){
	
if( get_query_var('x') == 'header-notif' ){
	if( !checked_option( 'header-notif-x' ) ) add_option( 'header-notif-x', 1 );
	else set_option( 'header-notif-x', 1 );
	
	redirect('?admin');
}
?>
<style type="text/css">
.codrops-top-notif-bg{
	width:100%;
	height:100%;
	z-index: 9999;
	position: fixed;
	
	background-color: #dddddd;
	background-color: rgba(221, 221, 221, .7);
	border-bottom: 1px solid #818285;
	color: #ECECEC;
	line-height: 45px;
	font-family:"LG";
	text-shadow:0 1px 0.3px #000;
}
.codrops-top-notif-content{
	top:0;
	width:100%;
	height:100%;
	z-index: 9999;
	position: fixed;
	
	background-color: black;
	background-color: rgba(129, 130, 133, .8);
	border-bottom: 1px solid #818285;
	color: #ECECEC;
	line-height: 45px;
	font-family:"LG";
	text-shadow:0 1px 0.3px #000;
}

.codrops-top-notif-content .wrap-width{
	width:950px;
	margin:0 auto;
}

.codrops-top-notif -content.wrap-width span, .codrops-top-notif-content .wrap-width a{
	color: #fff;
	font-family:"LGB";
	text-decoration:none;
}


.codrops-top-notif-content a span.img_close{
	display: block;
	float:left;
	background:url(libs/img/close_header_top_notif.png) no-repeat center top;
	background-position:0 0;
	width:21px;
	height:19px;
	margin-top:12px;
	margin-right:5px;
}
.codrops-top-notif-content a:hover span.img_close:hover{
	background-position:0 -19px;
}

</style>

<div class="codrops-top-notif-bg">
<div class="codrops-top-notif-content">
<div class="wrap-width"><a href="?admin&x=header-notif"><span class="img_close"></span></a><span>Selamat datang</span>, terimakasih sudah menggunakan karya dan produk anak negeri, untuk berpartisipasi dalam pengembangan cms ini <a href="http://cmsid.org/page-support-us.html" target="_blank">lihat tautan ini</a></div>
<div style="clear:both"></div>
</div></div>
<?php
}

if( 1 != get_option('header-notif-x') )
add_action('manager_header','add_manager_header_notif');

function add_manager_content(){
	
	if(!isset($_SESSION) )
		session_start();
	
	if( 'oops' == is_admin_values() ) the_main_oops();
	elseif( 'full' == $_SESSION['lw'] || 'full' == is_admin_values() ){
	?>
		<link href="libs/css/full.css" rel="stylesheet" />  
		<div style="padding:10px;"><?php echo the_main_manager()?></div>
		<?php
	}elseif( 'wrap' == $_SESSION['lw'] or is_admin_values() == 'single' ){		
	?>		
	<link href="libs/css/wrap.css" rel="stylesheet" />  
	<div id="body">
        <div class="body-content">
        <?php the_actions_menu()?>
        <?php the_main_manager()?>
        </div>
	</div>
		<?php
	}else{		
	?>
	<div id="body">
        <div class="aside left">
            <div class="section">
            <?php the_actions_menu()?>
            </div>
        </div>
        <div class="body-content right">
        <?php the_main_manager()?>
        </div>
	</div>
	<?php
	}
}

add_action('manager_content','add_manager_content');


function the_main_oops(){
	if ( file_exists( content_path . '/oops.php' ) ) {
		require_once( content_path . '/oops.php' );
		die();
	}
	?>
    <div id="oops_body" class="drop-shadow lifted">
    <div class="oops_logo">Ups maaf!</div>
    <div class="oops_content">
    <div style="clear:both"></div>
    <div class="oops_logo_atentions">!</div>
    <p style="margin-left:60px;">
    <h1>Halaman tidak ditemukan!</h1><br />
    Ups halaman '<?php echo esc_sql( $_SERVER['HTTP_REFERER'] )?>' yang Anda cari telah dipindahkan atau tidak ada lagi..<br />
    Silakan coba halaman lain tetapi jika Anda tidak dapat menemukan apa yang Anda butuhkan, beritahukan kepada kami.<br /><br />
    <a href="?admin" class="button">&laquo;&laquo; Kembali ke halaman utama</a><br /><br />
    </p>
    <div style="clear:both"></div>
    </div>
    </div>
    <?php
}

function list_category_op( $id = false ){
	global $db;
		
	$q = $db->select("post_topic");
		
	$op = '';
	while($row 	= $db->fetch_array($q)){
		if(!empty($id) && $row['id'] == $id)
			$op.= '<option value="'.$row['id'].'" selected="selected">'.$row['topic'].'</option>'."\n";
		else
			$op.= '<option value="'.$row['id'].'">'.$row['topic'].'</option>'."\n";
	}
		
	return $op;
}
/**
 * mengubah spasi
 *
 * @return string lower
 */
function add_space($string){
	if( empty($string) ) 
		return false;
	
	$string = html_entity_decode($string);
	$string = strtolower(preg_replace("/[^A-Za-z0-9-]/","-",$string));
	return $string;
}
/**
 * membaca xml 
 *
 * @return array
 */
function ul_feed( $feed ){
	$feed_content = '';		
	$feed_content.= '<ul class="ul-box">';
	if (is_array($feed)) {
	foreach($feed as $item)	{
		$feed_content .= '<li>
		<a href="'.$item->link.'" title="'.$item->title.'" target="_blank">'.$item->title.'</a>';
		if( !empty($item->author) || !empty($item->date) ):
			$feed_content .= '<div style="color:#333;">';
			if( !empty($item->author) ) $feed_content.= $item->author.' - ';
			if( !empty($item->date) ) $feed_content.= datetimes($item->date, false);
			$feed_content.= '</div>';
		endif;
		
		if( !empty($item->desc) ) 
			$feed_content.= '<div style="color:#333">'.initialized_text($item->desc).'</div>';
		
		$feed_content.= '</li>';	
	}}
	$feed_content.= '</ul>';
	return $feed_content;
}

/**
 * membuat menu action pada admin
 *
 * @return array, html
 */
function the_actions_menu(){
	global $widget, $aside_default;
	
	if( get_sys_cheked( get_query_var('sys') ) 
	&& $values = is_sys_values() )
	{
		get_sys_included( $values, 'init' );
	}
	elseif( get_apps_cheked( get_query_var('apps'), true )
	&&  $values = is_apps_values() )
	{
		get_apps_included( $values, true, 'init' );
	}
	
	do_action('the_actions_menu');
	
	
	if('full' == $_SESSION['lw'] 
	or 'wrap' == $_SESSION['lw'] 
	or is_admin_values() == 'single' 
	or is_sys_values() == 'installer' )
		return false;
		
	echo '<ul class="menu-box"><li><a href="./?admin">Dashboard</a></li></ul>';
	echo '<div class="p head">Actions</div><div class="plr"><ul class="menu-box">';	
	
	if( isset($widget['menu']) && count($widget['menu']) > 0 && !empty($widget['menu']) ) {
		
		foreach($widget['menu'] as $k => $v){
			echo '<li><a href="'.$v['link'].'">'.$v['title'].'</a></li>';
		}
		
	}
	
	else{
		foreach($aside_default as $k => $v){
			
			if( get_sys_cheked( $k ) || get_apps_cheked( $k, true ) ):
				echo '<li><a href="'.$v['link'].'">'.$v['title'].'</a></li>';
			endif;
		}
	}
	
	echo '</ul></div>';
	
	if( isset($widget['help_desk']) && !empty($widget['help_desk']) )
	echo '<div class="p head">Tip</div><div class="p">'.$widget['help_desk'].'</div>';
	
	echo '<div class="p head">Copyright <a href="http://cmsid.org/page-abouts.html" target="_blank">';
	echo '<span>i</span></a></div><div class="p">'.cleanname( get_option('site_copyright') ).'</div>';
	
	
}


function add_templates_manage( 
	$templates_content, 
	$templates_title = null, 
	$templates_header_menu = null, 
	$widget_manual = null, 
	$form = null, 
	$gd = 'content-fix' ){
	
	do_action('add_templates_manage');	
	
	return add_templates_content_position( 
	$templates_content, 
	$templates_title, 
	$templates_header_menu, 
	$widget_manual, 
	$form, 
	$gd );
}

function add_templates_content_position( 
	$templates_content, 
	$templates_title = null, 
	$templates_header_menu = null, 
	$widget_manual = null, 
	$form = null, 
	$gd = 'content-fix' ){
		
	global $widget;
	
	do_action('add_templates_content_position');	
	
	if( !empty($widget_manual) ) $widgetx = $widget_manual;
	else $widgetx = $widget;	
		
	$widget_avalable = false;
	if( count($widgetx['gadget']) > 0 && !empty($widgetx['gadget'][0]) )
		$widget_avalable = true;	
		
	if( $gd == 'full-single' ){
		?>
        <style type="text/css">
		.gd-menu {margin-top: 0;}
		</style>
        <?php
	}
	
	$add_templates_content_widget = _add_templates_content_widget( $widgetx );
	$add_templates_content = _add_templates_content( 
		$templates_content, 
		$templates_title, 
		$templates_header_menu, 
		$gd );
	
	$content = '';
	if( $widget_avalable ) :
	
	$content.= '<div id="post-left">';
	$content.= $add_templates_content;
	$content.= '</div>';
	$content.= '<div id="post-right">';
	$content.= $add_templates_content_widget;
	$content.= '</div>';	
	
	else:
	
	$content.= $add_templates_content;
	
	endif;
	
	if( !empty($form) )
		echo sprintf('<form %s>%s</form>', $form, $content);
	else
		echo $content;
		
	return;
}

function _add_templates_content( 
	$templates_content, 
	$templates_title = null, 
	$templates_header_menu = null, 
	$gd = 'content-fix' ){
	global $widget;
	
	do_action('add_templates_content');
	
	$content = '<div class="gd '.$gd.'">';
	$content.= '<div class="gd-header-single">'.$templates_title;
	
	if( !empty($templates_header_menu) )
	$content.= '<div class="gd-menu right">'.$templates_header_menu.'</div>';
		
	$content.= '</div>';
	$content.= '<div class="gd-content">';
	$content.= $templates_content;
	$content.= '</div>';	
	$content.= '</div>';
	
	return $content;
}

function _add_templates_content_widget( $current_widget = null){
	
	if( !is_array($current_widget['gadget']) )
		return false;
		
	$content = '';
	foreach($current_widget['gadget'] as $box){
		$content.= '<div class="gd">';
		$content.= '<div class="gd-header-single">'.$box['title'].'</div>';
		$content.= '<div class="gd-content">';
		$content.= $box['desc'];
		$content.= '</div>';
		$content.= '</div>';
	}
	
	return $content;
}

function save_quick_post($data){
		global $db,$login; 
		extract($data, EXTR_SKIP);
		
		$title 		= esc_sql($title);
		$type 		= esc_sql($type);
		$post_topic	= esc_sql($category);
		$tags 		= esc_sql($tags);
		$content	= esc_sql($isi);
		$date_post	= esc_sql($date);
		$status		= esc_sql($status);
		$approved	= esc_sql($approved);
		
		$meta_keys 	= esc_sql($meta_keys);
		$meta_desc 	= esc_sql($meta_desc);
		
		if( $thumb ):
		$thumb		= hash_image( $thumb );
		$thumb 		= esc_sql($thumb['name']);
		else: $thumb = '';
		endif;
		
		$seo 		= new engine;
		$sefttitle	= esc_sql($seo->judul($title));
		$user_login	= esc_sql($login->exist_value('user_name'));		
		$row 		= $login->username_cek( compact('user_login') );
		$mail		= esc_sql($row->user_email);
		
		$data = compact('user_login','title','sefttitle','post_topic','mail','type','content','thumb','tags','date_post','status','approved','meta_keys','meta_desc');
		return $db->insert('post',$data);
}


function add_quick_post( $data ){
		extract($data, EXTR_SKIP);
		
		$msg = array();
		if( empty($title) ) $msg[] ='<strong>ERROR</strong>: The title is empty.';
		if( empty($category) ) $msg[] ='<strong>ERROR</strong>: The category is empty.';
		
		if( $msg ) foreach($msg as $error) echo '<div id="error">'.$error.'</div>';
		else
		{
			if( save_quick_post($data) ) 
			echo '<div id="success"><strong>SUCCESS</strong>: Posting berhasil di tambahkan</div>';
		}
}