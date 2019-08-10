<?php 
/**
 * @fileName: manage.php
 * @dir: admin/manage/appearance
 */
if(!defined('_iEXEC')) exit;
global $db, $widget, $registered_widgets, $registered_sidebars, $sidebars_widgets, $registered_widget_controls;

$go 		= filter_txt($_GET['go']);
$act		= filter_txt($_GET['act']);
$id			= filter_int($_GET['id']);
$parent_id	= filter_int($_GET['parent_id']);
$file   	= filter_txt($_GET['file']);
$theme   	= filter_txt($_GET['theme']);
$sidebar_id = filter_txt($_GET['sidebar_id']);
$widget_id  = filter_txt($_GET['widget_id']);
$widget_key = filter_int($_GET['widget_key']);
switch($go){
default:

if( isset($_GET['theme']) && isset($_GET['preview']) ){
$_SESSION['theme'] = esc_sql($theme);
ob_start();
?>
<style>
@media only screen and (-webkit-min-device-pixel-ratio: 0) and (min-device-width: 1025px) {
div.nav > div.nav-top {
	min-width:1024px;
	width: 100%;
	margin:0 auto;
}
.gd.full-single {
	min-width:1024px;
	width: 100%;
	margin:0 auto;
}
}
@media only screen and (-webkit-min-device-pixel-ratio: 0) and (max-device-width: 1025px) {
div.nav > div.nav-top {
	min-width:980px;
	width: 90%;
	margin:0 auto;
}
.gd.full-single {
	min-width:980px;
	width: 90%;
	margin:0 auto;
}
}

.gd-menu{
	margin-top:5px;
}
</style>
<iframe class="shadow-inside" src='<?php echo site_url('/')."?theme=$theme";?>' style="width:100%; min-height:500px;" frameborder="0" scrolling="auto"></iframe>
<?php
$content = ob_get_contents();
ob_end_clean();

$header_menu = '
<a href="?admin&sys=appearance&act=active&theme='.$theme.'" class="button button2 left orange" onclick="return confirm(\'Are You sure current this theme?\')">Activate</a>';
$header_menu.= '<a class="button button2 middle red" href="?admin&sys=appearance&act=delete&theme=' . $theme . '" onclick="return confirm(\'Are You sure delete this theme?\')">Delete</a>';
$header_menu.= '<a href="?admin&sys=appearance" class="button button2 right">Cencel</a>'; 
	
add_templates_manage( $content, 'Theme Live Preview : <span style="color:green">'.$theme.'</span>', $header_menu, null, null, 'full-single' );

}else{
	
if( $_SESSION['theme'] ){
	$_SESSION['theme'] = '';
unset(
	$_SESSION['theme']
	);
}

ob_start();
?>
<div class="padding">
<?php
if(isset($act) && !empty($act)){
if($act == 'active' && !empty($theme) ){
	set_option('template',$theme);
	set_option('stylesheet',$theme);
	echo "<div id='success'>Memasang Theme berhasil.</div>";
	add_activity('theme',"Menerapkan themes $theme", 'appearance');
}
if( $act == 'delete' && !empty($theme) ){
	del_folder_themes($theme); 
	add_activity('theme',"menghapus themes $theme", 'appearance');
}}

?>
<strong>Curent Theme</strong>
<div style="border-top:1px solid #eeeeee; margin-bottom:10px;">
<?php themes_current();?>
</div>
<div style="clear:bolth"></div>
<strong>Available theme</strong>
<div style="border-bottom:1px solid #eeeeee"></div>
<?php themes_available()?>

</div>
<?php 
$content = ob_get_contents();
ob_end_clean();

add_templates_manage($content,'Appearance Manager');
}

break;
case'widgets':
?>
<link href="<?php echo site_url('admin/manage/appearance/css/style.css');?>" rel="stylesheet" media="screen" type="text/css" />
<?php
ob_start();

if( $act == 'del' ){

$sidebars = array();
$data_sidebars_widgets_x = get_option('sidebar_widgets');
$data_sidebars_widgets_x = json_decode($data_sidebars_widgets_x);
foreach($data_sidebars_widgets_x as $data_sidebar_id => $data_widgets){
	
	if( $data_sidebar_id == $sidebar_id ){
		$widgets = array();
		foreach($data_widgets as $_widget_key => $_widget_value){
			if( $_widget_value == $widget_id  ){
				if( $_widget_key != $widget_key ){
					$widgets[] = $_widget_value;
				}
			}else{
				$widgets[] = $_widget_value;
			}
		}
		$sidebars[$data_sidebar_id] = $widgets;
	}else{
		$widgets = array();
		foreach($data_widgets as $_widget_value){
			$widgets[] = $_widget_value;
		}
		$sidebars[$data_sidebar_id] = $widgets;
	}
}



$sidebars = json_encode($sidebars);

set_option('sidebar_widgets', $sidebars);
add_activity('theme',"Menghapus widget '$witgets_available' dari sidebar '$sidebar_available'", 'appearance');
redirect('?admin&sys=appearance&go=widgets');

}

$widget_availabe = array();
$data_sidebars_widgets = get_sidebars_widgets();
	
if ( empty( $data_sidebars_widgets ) )
	return false;
	
foreach ( (array) $data_sidebars_widgets as $sidebar_id_x => $widgets ) {
		
	foreach( $widgets as $widget_key => $widget_id_x ){
		$widget_availabe[] = array(
			'widget_key' => $widget_key,
			'widget_nums' => count( $widgets ) - 1,
			'widgets' => $registered_widgets[$widget_id_x],
			'sidebar_id' => $sidebar_id_x,
			'sidebar_name' => $registered_sidebars[$sidebar_id_x]['name']
		);
	}
}

?>
<table id="table" cellpadding="0" cellspacing="0">
<tr class="head">
    <td width="43%" class="depan"><strong>Widget</strong></td>
    <td class="depan"><strong>Sidebar</strong></td>
    <td class="depan"><div align="center"><strong>Action</strong></div></td>
    <td class="depan"><div align="center"><strong>Order</strong></div></td>
  </tr>
<?php
$warna = '';
foreach ( (array) $widget_availabe as $widgets ) {	
$warna 	= empty ($warna) ? ' bgcolor="#f1f6fe"' : '';

$widget_id = $widgets['widgets']['id'];	

$ordering_down = '<a href="?admin&sys=appearance&go=widgets&act=down&sidebar_id='.$widgets['sidebar_id'].'&widget_id='.$widget_id.'&widget_key='.$widgets['widget_key'].'" class="down" title="down">down</a>';    
$ordering_up = '<a href="?admin&sys=appearance&go=widgets&act=up&sidebar_id='.$widgets['sidebar_id'].'&widget_id='.$widget_id.'&widget_key='.$widgets['widget_key'].'" class="up" title="up">up</a>'; 		       
					
if( $widgets['widget_key'] == 0 ) $ordering_up = '';
if( $widgets['widget_key'] == $widgets['widget_nums'] ) $ordering_down = '';

?>
<tr <?php echo $warna?> class="isi">
	<td valign="top"><span title="<?php echo $widgets['widgets']['name']?>"><?php echo $widgets['widgets']['name']?></span></td>
	<td valign="top"><?php echo $widgets['sidebar_name']?></td>
    <td valign="top">
    <div class="action">
<a href="?admin&sys=appearance&go=widgets&act=del&sidebar_id=<?php echo $widgets['sidebar_id']?>&widget_id=<?php echo $widget_id?>&widget_key=<?php echo $widgets['widget_key']?>" class="delete" title="delete" onclick="return confirm('Are You sure delete widget <?php echo $widgets['widgets']['name']?>?')">delete</a>
    </div></td>
    <td valign="top">
    <div class="action"><?php echo $ordering_up.'  '.$ordering_down?></div></td>
</tr>
<?php
}
?>
</table>
<?php

$content = ob_get_contents();
ob_end_clean();

ob_start();
?>
<div class="padding">
<?php
$widget_manual_title = 'Add New Widgets';

if( isset($_POST['submit']) ){
	
$sidebar_available = esc_sql( $_POST['sidebar_available'] );
$witgets_available = esc_sql( $_POST['witgets_available'] );

$sidebars = array();
$data_sidebars_widgets_x = get_option('sidebar_widgets');
$data_sidebars_widgets_x = json_decode($data_sidebars_widgets_x);
foreach($data_sidebars_widgets_x as $data_sidebar_id => $data_widgets){
	
	if( $data_sidebar_id == $sidebar_available ){
		$widgets = array();
		foreach($data_widgets as $_widget_value){
			$widgets[] = $_widget_value;
		}
		$widgets[] = $witgets_available;			
		$sidebars[$data_sidebar_id] = $widgets;
	}else{
		$widgets = array();
		foreach($data_widgets as $_widget_value){
			$widgets[] = $_widget_value;
		}		
		$sidebars[$data_sidebar_id] = $widgets;
	}
}

$sidebars = json_encode($sidebars);

set_option('sidebar_widgets', $sidebars);
echo "<div id='success'>Memasang Widget berhasil.</div>";
add_activity('theme',"Menambahkan widget '$witgets_available' pada sidebar '$sidebar_available'", 'appearance');
redirect('?admin&sys=appearance&go=widgets');

}
?>
<form action="" method="post">
<label for="sidebar_available">Sidebar Available :</label><br />
  <select name="sidebar_available">
<?php
foreach ( $registered_sidebars as $sidebar => $registered_sidebar ) {
	if ( false !== strpos( $registered_sidebar['class'], 'inactive-sidebar' ) || 'orphaned_widgets' == substr( $sidebar, 0, 16 ) )
		continue;
?>    
	<option value="<?php echo $registered_sidebar['id']?>"><?php echo $registered_sidebar['name']?></option>
<?php 
}
?>
  </select><br />

<label for="witgets_available">Widgets Available :</label><br />
  <select name="witgets_available">
<?php
$sort = $registered_widgets;
usort( $sort, '_sort_name_callback' );
$done = array();

foreach ( $sort as $widget ) {
	if ( in_array( $widget['callback'], $done, true ) ) // We already showed this multi-widget
		continue;

	$done[] = $widget['callback'];
		
	if ( ! isset( $widget['params'][0] ) )
		$widget['params'][0] = array();	
		
	$widget_id_replace = explode('-',$widget['id']);
	$widget_id_replace = $widget_id_replace[0];			
?>
    <option value="<?php echo $widget_id_replace?>"><?php echo $widget['name']?></option>
<?php
}
?>
  </select><br />
  <input name="submit" type="submit" value="Add" />
</form>
</div>
<?php
$content_widget = ob_get_contents();
ob_end_clean();

$header_menu = '';
$widget_manual = array();
$widget_manual['gadget'][] = array('title' => $widget_manual_title, 'desc' => $content_widget);

add_templates_manage($content, 'Widgets Manager', $header_menu, $widget_manual);

break;
case'theme-editor':

ob_start();

$path_dir = theme_path .'/'. get_option('template');

if( file_exists( $path_dir . $file ) && isset($file))
	$edit_file = $path_dir . $file;	
else
	$edit_file = $path_dir.'/index.php';

if (isset($_POST['submit'])) {
	$file = $_POST['file'];
	echo '<div class="padding">';
	save_to_file($file);
	echo '</div>';
	add_activity('theme','editing theme using theme editor','write');
}
?>
<div class=num style="text-align:left; height:30px; line-height:30px; border-bottom:1px solid #ddd;">
File : <?php echo get_file_name($edit_file)?>
</div>
<input type="hidden" name="file" value="<?php echo $edit_file?>">
<textarea id="textcode" name="content" style="width:98.5%; height:350px">
<?php echo htmlspecialchars(file_get_contents( $edit_file ))?>
</textarea>

<?php
$content = ob_get_contents();
ob_end_clean();

$form = 'action="" method="post" enctype="multipart/form-data" name="form1"';
$header_menu = '<div class="header_menu_top">';
$header_menu.= '<input type="submit" name="submit" class="button on l green" value="Save & Update">';
$header_menu.= '<input name="Reset" type="reset" value="Reset" class="button r black">';
$header_menu.= '</div>';
$header_menu.= '<a href="?admin&sys=appearance" class="button"><span class="icon_head back">&laquo; Back</span></a>';
add_templates_manage( $content, 'Themes Editor', $header_menu, null, $form );

break;
case'menus':

global $get_group_title, $get_group_id, $get_menu_groups;

ob_start();
$group_id = esc_sql( $get_group_id );
$parent_id = esc_sql( $parent_id );

if( $act == 'up'){

$select = $db->query ("SELECT MAX(position) as sc FROM $db->menu WHERE group_id='".$group_id."' AND parent_id = '".$parent_id."'");
$data = $db->fetch_array ($select);

if ($data['sc'] <= 0){
	$qquery = mysql_query ("SELECT `id` FROM `$db->menu` WHERE parent_id='$parent_id' AND group_id='".$group_id."'");
	$integer = 1;
	while ($getsql = mysql_fetch_assoc($qquery)){
		mysql_query ("UPDATE `$db->menu` SET `position` = $integer WHERE `id` = '".$getsql['id']."'");
		$integer++;	
	}		
}

$total = $data['sc'] + 1;
$a = $db->query ("UPDATE $db->menu SET position='".$total."' WHERE position='".($id-1)."' AND group_id='".$group_id."' AND parent_id = '".$parent_id."'"); 
$a.= $db->query ("UPDATE $db->menu SET position=position-1 WHERE position='".$id."' AND group_id='".$group_id."' AND parent_id = '".$parent_id."'");
$a.= $db->query ("UPDATE $db->menu SET position='".$id."' WHERE position='".$total."' AND group_id='".$group_id."' AND parent_id = '".$parent_id."'");
}

if( $act == 'down'){
$select = $db->query ("SELECT MAX(position) as sc FROM $db->menu WHERE group_id='".$group_id."' AND parent_id = '".$parent_id."'");
$data = $db->fetch_array ($select);

if ($data['sc'] <= 0){
	$qquery = mysql_query ("SELECT `id` FROM `$db->menu` WHERE parent_id='$parent_id' AND group_id='".$group_id."'");
	$integer = 1;
	while ($getsql = mysql_fetch_assoc($qquery)){
		mysql_query ("UPDATE `$db->menu` SET `position` = $integer WHERE `id` = '".$getsql['id']."'");
		$integer++;	
	}		
}

$total = $data['sc'] + 1;
$a = $db->query ("UPDATE $db->menu SET position='".$total."' WHERE position='".($id+1)."' AND group_id='".$group_id."' AND parent_id = '".$parent_id."'"); 
$a.= $db->query ("UPDATE $db->menu SET position=position+1 WHERE position='".$id."' AND group_id='".$group_id."' AND parent_id = '".$parent_id."'");
$a.= $db->query ("UPDATE $db->menu SET position='".$id."' WHERE position='".$total."' AND group_id='".$group_id."' AND parent_id = '".$parent_id."'");  
}
?>
<link rel="stylesheet" href="<?php echo site_url('admin/manage/appearance/css/style-menu-popup.css');?>">
<link rel="stylesheet" href="<?php echo site_url('admin/manage/appearance/css/style-menu.css');?>">
<script>
var BASE_URL = '<?php echo site_url('');?>/';
var current_group_id = <?php echo $get_group_id; ?>;
</script>
<script src="<?php echo site_url('admin/manage/appearance/js/interface-1.2.js');?>"></script>
<script src="<?php echo site_url('admin/manage/appearance/js/menu.js');?>"></script>
<div style="clear:both"></div>
<ul id="menu-group">
<?php 
$get_menu_groups_sort = array_multi_sort($get_menu_groups, array('id' => SORT_ASC));
foreach ((array)$get_menu_groups_sort as $data_get_menu) : 
?>
<li id="group-<?php echo $data_get_menu['id']; ?>"><a href="?admin&sys=appearance&go=menus&group_id=<?php echo $data_get_menu['id']; ?>"><?php echo $data_get_menu['title']; ?></a></li>
<?php endforeach; ?>
<li id="add-group"><a href="?request&load=libs/ajax/menu-group.php&aksi=add" title="Add Menu Group">+</a></li>
</ul>
<div class="clear" style="border-top:2px solid #ccc;"></div>

<div class="ns-row" id="ns-header">
<div class="ns-orders">Orders</div>
<div class="ns-actions">Actions</div>
<div class="ns-class">Class</div>
<div class="ns-url">URL</div>
<div class="ns-title">Title</div>
</div>
<div class="padding">
<?php 
$get_menu = dynamic_menus_data($get_group_id);

$group_menu_ul = '<ul id="dragbox_easymn"></ul>';
if ( $get_menu ) {

	include libs_path . '/class-tree.php';
	$tree = new Tree;
	
	foreach($get_menu as $row) {
	
		$querymax	= $db->query ("SELECT MAX(`position`) FROM `$db->menu` WHERE parent_id = '".$row['parent_id']."' AND group_id = '$get_group_id'");
		$alhasil 	= $db->fetch_array($querymax);	
		$numbers	= $alhasil[0];
	
		$tree->add_row(
			$row['id'],
			$row['parent_id'],
			' id="menu-'.$row['id'].'" class="sortable_easymn"',
			dynamic_menus_label($row, $numbers)
		);
	}	
	$group_menu_ul = $tree->generate_list('id="dragbox_easymn"');
}

echo $group_menu_ul;
?>
</div>
<?php
$content = ob_get_contents();
ob_end_clean();

add_templates_manage( $content, 'Menus Manager');
break;
}
?>
