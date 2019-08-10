<?php 
/**
 * @fileName: functions.php
 * @dir: admin/templates/
 */
if(!defined('_iEXEC')) exit;

/**
 * membuat menu action pada admin
 *
 * @return array, html
 */
function the_actions_menu(){
	global $widget;
	
	do_action('the_actions_menu');
	
	if( esc_sql( $_GET['admin'] ) == 'single' or esc_sql( $_GET['sys'] ) == 'installer' )
		return false;
	
	$array_default = array(
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
	echo '<ul class="menu-box"><li><a href="./?admin">Dashboard</a></li></ul>';
	echo '<div class="p head">Actions</div><div class="plr"><ul class="menu-box">';	
	
	if( isset($widget['menu']) && count($widget['menu']) > 0 && !empty($widget['menu']) ) {
		
		foreach($widget['menu'] as $k => $v){
			echo '<li><a href="'.$v['link'].'">'.$v['title'].'</a></li>';
		}
		
	}
	
	else{
		foreach($array_default as $k => $v){
			
			if( get_sys_cheked( $k ) || get_apps_cheked( $k, true ) ):
				echo '<li><a href="'.$v['link'].'">'.$v['title'].'</a></li>';
			endif;
		}
	}
	
	echo '</ul></div>';
	
	if( isset($widget['help_desk']) && !empty($widget['help_desk']) )
	echo '<div class="p head">Tip</div><div class="p">'.$widget['help_desk'].'</div>';
	
	echo '<div class="p head">Copyright <a href="http://cmsid.org/page-abouts.html" target="_blank"><span>?</span></a></div><div class="p">'.get_option('site_copyright').'</div>';
	
	
}
/**
 * memperbaharui widget
 */
function set_dashboard_admin($string){	
	/*
	$sorted = array();
	$sorted['normal'] = 'box1,box2';
	$sorted['side'] = 'box1,box2';
	*/	
	$string = esc_sql($string);
	
	if( !checked_option( 'dashboard_widget' ) ) add_option('dashboard_widget',$string);
	else set_option('dashboard_widget',$string);
}

/**
 * membaca xml 
 *
 * @return array
 */
function fetch_feed_new( $feed_url, $display ){
	$Rss = new Rss;
	$feed_content = '';
	/*
		XML way
	*/
	try {
	$feed = $Rss->getFeed($feed_url, Rss::XML);
	
	if( !is_array($feed) && empty($feed) ):
		echo '<div id="error_no_ani"><strong>ERROR</strong>: The Feed not connect to server</div>';
		return false;
	endif;
	
	$feed_content .= '<ul class="ul-box">';
	$i = 1;
	foreach($feed as $item)	{
		
	if($i <= $display->{'limit'}){
	$feed_content .= '<li>
    <a href="'.$item['link'].'" title="'.$item['title'].'" target="_blank">'.$item['title'].'</a>';
    if($display->{'author'} == 1 || $display->{'date'} == 1 ):
    	$feed_content .= '<div style="color:#333;">';
		if($display->{'author'} == 1) $feed_content .= $item['author'].' - ';
    	if($display->{'date'} == 1) $feed_content .= datetimes($item['date'], false);
		$feed_content .= '</div>';
    endif;
	
    if($display->{'desc'} == 1) 
		$feed_content .= '<div style="color:#333">'.limittxt(strip_tags($item['description'] , '<a>'),120).'</div>';
	
	$feed_content .= '</li>';	
    }
    $i++;
    }
    $feed_content .= '</ul>';
	}catch (Exception $e) {
		$feed_content .= $e->getMessage();
	}
	
	return $feed_content;
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
 * membuat class statistik
 */
class statistik {
	/**
	 * membuat progress bar dari hit
	 *
	 * @return persentase
	 */
	function progress($option){
		global $iw,$db;
		$query		= $db->select('stat_browse',array('title'=>$option));
		$show		= $db->fetch_array($query);
		
		$option 	= explode("#", $show["option"]);
		$hits	 	= explode("#", $show["hits"]);
		$totopt 	= count($option)-1;
	
		$tothits 	= 0;
		foreach($hits as $vhit) $tothits = $tothits + $vhit;
		
		if($tothits == 0) $tothits = 1;
			$progress = array(
			'opt'		=>$option,
			'hit'		=>$hits,
			'totopt'	=>$totopt,
			'tothit'	=>$tothits,
			'percent'	=>$persentase,
			'option'	=>$option
			);
		return $progress;
	}		
	/**
	 * mengubah persentase menjadi warna
	 *
	 * @return color
	 */
	function select_color($persentase,$color=''){	
		if($persentase < 45) $color='orange';
		elseif($persentase < 70) $color='green';
		else $color='blue';
		
		return $color;
	}
}

if(!function_exists('reset_statistic')){
	function reset_statistic(){
		global $db;
		
		$sql= $db->select('stat_browse');	
		
		$run='';	
		while( $row = $db->fetch_obj($sql) ){		
		$v1 	= explode("#", $row->option);
		$totv1 	= count($v1)-1;
		
		$option = $hits = '';
		for($i=0;$i<$totv1;$i++){
			$option	.= $v1[$i].'#';
			$hits	.= '0#';
		}
		
		if($row->title == 'country') $option = $hits = '';
		
		$data = compact('option','hits');
		
		$run .= $db->truncate('stat_count');
		$run .= $db->update('stat_browse', $data, array('title'=>$row->title) );
		}
	}
}

if(!function_exists('list_category_op')){
	function list_category_op( $id = false ){
		global $db;
		
		$q		    = $db->select("post_topic");
		
		$op = '';
		while($row 	= $db->fetch_array($q)){
			if(!empty($id) && $row['id'] == $id)
				$op.= '<option value="'.$row['id'].'" selected="selected">'.$row['topic'].'</option>'."\n";
			else
				$op.= '<option value="'.$row['id'].'">'.$row['topic'].'</option>'."\n";
		}
		
		return $op;
	}
}

if(!function_exists('save_quick_post')){
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

function _add_templates_content( $templates_content, $templates_title = null, $templates_header_menu = null, $gd = 'content-fix' ){
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

function add_templates_content_position( $templates_content, $templates_title = null, $templates_header_menu = null, $widget_manual = null, $form = null, $gd = 'content-fix' ){
	global $widget;
	
	do_action('add_templates_content_position');	
	
	if( !empty($widget_manual) ) $widgetx = $widget_manual;
	else $widgetx = $widget;	
		
	$widget_avalable = false;
	if( is_array($widgetx['gadget']) && !empty($widgetx['gadget'][0]) )
		$widget_avalable = true;	
	
	$add_templates_content = _add_templates_content( $templates_content, $templates_title, $templates_header_menu, $gd );
	$add_templates_content_widget = _add_templates_content_widget( $widgetx );
	
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

function add_manager_content(){
	$run = esc_sql( $_GET['admin'] );
	if( $run == 'oops' ){
		the_main_oops();
	}elseif( $run == 'full' ){
		the_main_manager();
	}elseif( $run == 'single' ){
	?>
	<link href="admin/templates/css/single.css" rel="stylesheet" />    
	<div id="body">
	<?php 
	the_actions_menu();	
	the_main_manager();
	?>
	</div>
	<?php
	}else{
	?>
	<div id="body">
	<div class="aside left">
	<div class="section"><?php the_actions_menu()?></div>
	</div>
	<div class="body-content right">
	<?php the_main_manager()?>
	</div>
	</div>
	<?php
	}
}

add_action('manager_content','add_manager_content');

function add_manager_top(){
	global $login;
?>

<link href="admin/templates/css/nav.css" rel="stylesheet" />
<link href="admin/templates/css/nav-menu.css" rel="stylesheet" />

<div class="nav nav-fix">
<div class="nav-top">
<div class="left" style="width:650px">
<ul class="mainMenu tiptip">
<?php 
$top_menu_home = $top_menu_app = $top_menu_plugin = $top_menu_install = '';

if( isset($_GET['sys']) && $_GET['sys'] == 'applications' || isset($_GET['apps']) )
	$top_menu_app = ' current';
elseif( isset($_GET['sys']) && $_GET['sys'] == 'plugins' )
	$top_menu_plugin = ' current';
elseif( isset($_GET['sys']) && $_GET['sys'] == 'installer' )
	$top_menu_install = ' current';
else 
	$top_menu_home = ' current';

?>
    <li class="topNavLink<?php echo $top_menu_home;?>"><a href="?admin" class="tip" title="Home"><div class="icon menuHome"></div></a></li>
    <li class="topNavLink<?php echo $top_menu_app;?>"><a href="?admin=single&sys=applications" class="tip" title="Applications"><div class="icon menuApps"></div><div class="icon menuAppsName">Applications</div></a><span class="jTips animating"><?php echo get_counted( 'app' );?></span></li>
    <li class="topNavLink<?php echo $top_menu_plugin;?>"><a href="?admin=single&sys=plugins" class="tip" title="Plugins"><div class="icon menuPlugins"></div><div class="icon menuPluginsName">Plugins</div></a><span class="jTips animating"><?php echo get_counted( 'plg' );?></span></li> 
    <li class="topNavLink<?php echo $top_menu_install;?>"><a href="?admin=single&sys=installer" class="tip" title="Installer"><div class="icon menuInstall"></div><div class="icon menuInstallName">Installer</div></a></li>
</ul>
</div>

<div class="right">
<?php

$data_user 	= array('user_login' => $login->exist_value('user_name'));
$field 		= $login->username_cek( $data_user );
?>
<ul class="mainMenu tiptip">
    <li class="topNavLink">
    <a href="?login&go=profile" class="tip" title="Lihat Data Profile">
    <?php $avatar_img_profile = avatar_url($login->exist_value('user_name'));?>
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
        <li><a href="?login&go=logout">Keluar</a></li>
        <li class="seperator"><div></div></li>
        <li><a href="?admin&sys=options&go=help">Bantuan</a></li>
    </ul>
    </dd>
    </dl>
</li>
</ul>
</div>
</div>
</div>
<div class="shadow-inside-top"></div>

<?php
}

add_action('manager_top','add_manager_top');

function add_manager_header_notif(){
	
if( $_GET['x'] == 'header-notif' ){
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
	background-color: rgba(221, 221, 221, .2);
	border-bottom: 1px solid #818285;
	color: #ECECEC;
	line-height: 45px;
	font-family:"LG";
	text-shadow:0 1px 0.3px #000;
}
.codrops-top-notif-content{
	top:0;
	width:100%;
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