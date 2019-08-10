<?php
/**
 * @file init.php
 * @dir: admin/manage/appearance
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $get_group_title, $get_group_id, $get_menu_groups;

$get_group_id = 1;
if (isset($_GET['group_id'])) {
	$get_group_id = (int)$_GET['group_id'];
}

$get_group_title = get_menu_group_title($get_group_id);
$get_menu_groups = get_menu_groups();

function loading_ajax(){
 	echo '<div id="loading_ajax">
	<img src="'.site_url('libs/img/ajax-loader.gif').'" alt="Loading">
	Processing...
	</div>'."\n";
}


function get_widget(){
	global $widget, $get_group_title, $get_group_id;
	
	$actions = $gadget = array();
	$actions[] = array(
		'title' => 'Themes',
		'link'  => '?admin&amp;sys=appearance'
	);
	$actions[] = array(
		'title' => 'Widgets',
		'link'  => '?admin&amp;sys=appearance&amp;go=widgets'
	);
	$actions[] = array(
		'title' => 'Menus',
		'link'  => '?admin&amp;sys=appearance&amp;go=menus'
	);
	$actions[] = array(
		'title' => 'Header',
		'link'  => '?admin&amp;sys=appearance&amp;go=custom-header'
	);
	$actions[] = array(
		'title' => 'Background',
		'link'  => '?admin&amp;sys=appearance&amp;go=custom-background'
	);
	$actions[] = array(
		'title' => 'Theme Editor',
		'link'  => '?admin=single&amp;sys=appearance&amp;go=theme-editor'
	);
	
	if( $_GET['go'] == 'theme-editor' )
		$gadget[] = array('title' => 'More Files','desc' => list_files());	
	
	if( $_GET['go'] == 'menus' ){
		$gadget[] = array('title' => 'Current Menu Group','desc' => current_menu_group($get_group_title,$get_group_id));	
		$gadget[] = array('title' => 'Add Menu','desc' => add_menu_on_group($get_group_id));	
		add_action('manager_footer','loading_ajax');
	}
	
	$widget = array(
		'menu'		=> $actions,
		'gadget'	=> $gadget,
		'help_desk' => 'Pilih dan Perbaharui tampilan website dengan mudah'
	);
	return;
}
add_action('the_actions_menu', 'get_widget');

function load_style_info( $dir, $current = false ){
	
		if (file_exists(theme_path . $dir . '/styleInfo.xml')) {
			$index_theme 	= @implode( '', file( theme_path . $dir.'/styleInfo.xml' ) );
			$info_themes 	= str_replace ( '\r', '\n', $index_theme );
			
			preg_match( '|<themes>(.*)<\/themes>|ims'				, $info_themes, $themes 			);
			preg_match( '|<name>(.*)<\/name>|ims'					, $themes[1], $theme_name 			);
			preg_match( '|<version>(.*)<\/version>|ims'				, $themes[1], $theme_version		);
			preg_match( '|<creationDate>(.*)<\/creationDate>|ims'	, $themes[1], $theme_date 			);
			preg_match( '|<author>(.*)<\/author>|ims'				, $themes[1], $theme_author 		);
			preg_match( '|<authorEmail>(.*)<\/authorEmail>|ims'		, $themes[1], $theme_authorEmail 	);
			preg_match( '|<authorUrl>(.*)<\/authorUrl>|ims'			, $themes[1], $theme_authorUrl 		);
			preg_match( '|<copyright>(.*)<\/copyright>|ims'			, $themes[1], $theme_copyright 		);
			preg_match( '|<license>(.*)<\/license>|ims'				, $themes[1], $theme_license 		);
			preg_match( '|<description>(.*)<\/description>|ims'		, $themes[1], $theme_description 	);
			
			$screenhoot = 'content/themes/' . $dir . '/screenshot.gif';
			if( !file_exists($screenhoot) ) $screenhoot = '';
			
			echo '<br style="clear:both">';
			echo '<div style="float:left; height:100%;"><img src="'.$screenhoot.'" width="183" height="124" align="left" style="border:3px solid #ccc;background:#f8f8f8 url(libs/img/icon-no-image.png) no-repeat center" /></div>';
			echo '<div style="height:100%; margin-left:200px;">';
			echo '<strong>'.$theme_name[1].'</strong><br>';
			echo 'By <a target="_blank" href="'.$theme_authorUrl[1].'">'.$theme_author[1].'</a> | Version '.$theme_version[1].'<br /><br>';
			echo $theme_description[1]."<br /><br>";
			echo 'semua file themes ada di lokasi<br>
			      <span style="font: 500 1em/1.5em Lucida Console,courier new,monospace;">themes/'.$dir.'</span><br><br>';
				  
			if( $current ){
			echo '<a href="?admin=single&sys=appearance&go=theme-editor&theme=' . str_replace('/','',$dir) . '" class="button button2 blue">Customize to Theme Editor</a>';
			}else{
			echo '<a class="button button2 left orange" href="?admin&sys=appearance&act=active&theme=' . str_replace('/','',$dir) .'" onclick="return confirm(\'Are You sure active this theme?\')">Activate</a>';
			echo '<a class="button button2 middle green" href="?admin=full&sys=appearance&theme=' . str_replace('/','',$dir) .'&themepreview">Live Preview</a>';
			echo '<a class="button button2 right red" href="?admin&sys=appearance&act=delete&theme=' . str_replace('/','',$dir) . '" onclick="return confirm(\'Are You sure delete this theme?\')">Delete</a><br />';	
			}	
			echo '<br style="clear:both"></div>';
		}else{
			echo '<br style="clear:both">';
			echo 'Theme Corupt';
		}
}

function themes_current(){
	load_style_info(get_option('template').'/', true);
}

function themes_available(){

	$count=0;$i=0;
	unset($theme_arr);
	if ($handle = opendir(theme_path)) {
		while (false !== ($file = readdir($handle))) {
		$i++;
		if ($file != "." && $file != ".." 
		&& is_dir(theme_path . $file) 
		&& $file . "/" != get_option('template')
		&& file_exists( theme_path . $file . '/styleInfo.xml' ) ) 
		$theme_arr[] = $file;
		
		}
		closedir($handle);
	}
	
	echo '<div id="list-comment" style="max-height:300px">';
	
	if ( @count($theme_arr) > 1 ){
		foreach($theme_arr as $file){
		$count++;
		if( $file != get_option('template') ) {
		load_style_info($file);
		}}
	}else{
	?>
		<p>Theme not available</p>
	<?php 
	} 
	
	echo '</div>';
}

if(!function_exists('get_file_name')){
	function get_file_name($string){
		return end( explode('/',$string) );
	}
}

function editing_file_themes(){
	$count = $i = 0;
	
	unset($theme);
	$rep = opendir(theme_path . get_option('template'));
	while ($file = readdir($rep)) {
		if($file != '..' && $file !='.' && $file !=''
		&& $file !='favicon.ico' && $file !='screenshot.gif' && $file !='images'
		&& !is_dir($file))
		$theme[] = $file;
		
	}
	
	closedir($rep);
	clearstatcache();
	
	return $theme;
}

function list_files(){
	$file_allow = array('.php','.css','.xml','.html','.htm','.js','.txt');
	$path_dir 	= theme_path . get_option('template');
	$filed		= '<ul class="list-file">';	
	if( file_exists( $path_dir.'/index.php' ) ){		
	foreach(rec_listFiles($path_dir) as $k) {
		if ( in_array(substr($k, -4), $file_allow)){
			$k = str_replace( $path_dir , '' , $k );
			$filed .= '<li><a href="?admin=single&sys=appearance&go=theme-editor&file='.$k.'">'.$k.'</a></li>';
		}
	}}else $filed.='Empty File';
	$filed .= '</ul>';
	return $filed;
}

function rec_listFiles( $from = '.'){
    if(! is_dir($from))
        return false;
    
    $files = array();
    if( $dh = opendir($from))
    {
        while( false !== ($file = readdir($dh)))
        {
            // Skip '.' and '..'
            if( $file == '.' || $file == '..')
                continue;
            $path = $from . '/' . $file;
            if( is_dir($path) )
                $files += rec_listFiles($path);
            else
                $files[] = $path;
        }
        closedir($dh);
    }
    return $files;
}

if(!function_exists('del_folder_themes')){
	function del_folder_themes($path){	
		
		$path_dir = theme_path . $path;
		deleteDirectory($path_dir);
		
	}
}

if(!function_exists('deleteDirectory')){
	function deleteDirectory($dir) { 
		if (!file_exists($dir)) return true; 
		if (!is_dir($dir) || is_link($dir)) return unlink($dir); 
			foreach (scandir($dir) as $item) { 
				if ($item == '.' || $item == '..') continue; 
				if (!deleteDirectory($dir . "/" . $item)) { 
					chmod($dir . "/" . $item, 0777); 
					if (!deleteDirectory($dir . "/" . $item)) return false; 
				}; 
			} 
		return rmdir($dir); 
	} 
}

if(!function_exists('current_menu_group')){
	function current_menu_group($group_title,$group_id) { 
	
	$content = '<div class="padding"><span id="edit-group-input">'.$group_title.'</span>
	(ID: <b>'.$group_id.'</b>)
	<div>
	<a id="edit-group" href="#">Edit</a>';
	if ($group_id > 1) : 
	$content .= '&middot; <a id="delete-group" href="#">Delete</a>';
	endif;
	$content .= '</div></div>';
	return $content;
	} 
}

if(!function_exists('add_menu_on_group')){
	function add_menu_on_group($group_id) { 
	$content ='<div class="padding">
    <form id="form-add-menu" method="post" action="?request&load=libs/ajax/menu.php&aksi=add">
	<label for="menu-title">Title</label>
	<input type="text" name="title" id="menu-title" style="width:95%">
	<label for="menu-url">URL</label>
	<input type="text" name="url" id="menu-url" style="width:95%">
	<label for="menu-class">Class</label>
	<input type="text" name="class" id="menu-class" style="width:95%">
	<p class="buttons">
	<input type="hidden" name="group_id" value="'.$group_id.'">
	<input id="add-menu" type="submit" class="button" value="Add Menu">
	</p>
	</form></div>';
	return $content;
	} 
}