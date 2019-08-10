<?php 
/**
 * @fileName: manage.php
 * @dir: admin/manage/appearance
 */
if(!defined('_iEXEC')) exit;
global $db, $widget, $registered_sidebars;

$go 		= filter_txt($_GET['go']);
$act		= filter_txt($_GET['act']);
$id			= filter_int($_GET['id']);
$file   	= filter_txt($_GET['file']);
$theme   	= filter_txt($_GET['theme']);
switch($go){
default:


if( isset($_GET['themepreview']) ){
$_SESSION['themepreview'] = esc_sql($theme);
ob_start();
?>
<style>
@media only screen and (-webkit-min-device-pixel-ratio: 0) and (min-device-width: 1025px) {
div.nav > div.nav-top {
	min-width:1024px;
	width: 90%;
	margin:0 auto;
}
.gd.full-single {
	min-width:1024px;
	width: 90%;
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
</style>
<iframe class="shadow-inside" src='<?php echo site_url('/')."?themepreview=".$theme;?>' style="width:100%; min-height:500px;" frameborder="0" scrolling="auto"></iframe>
<?php
$content = ob_get_contents();
ob_end_clean();

$header_menu = '
<a href="?admin&sys=appearance&act=active&theme='.$theme.'" class="button button2 left orange" onclick="return confirm(\'Are You sure current this theme?\')">Activate</a>';
$header_menu.= '<a class="button button2 middle red" href="?admin&sys=appearance&act=delete&theme=' . $theme . '" onclick="return confirm(\'Are You sure delete this theme?\')">Delete</a>';
$header_menu.= '<a href="?admin&sys=appearance" class="button button2 right">Cencel</a>'; 
	
add_templates_content_position( $content, 'Theme Live Preview : <span style="color:green">'.$theme.'</span>', $header_menu, null, null, 'full-single' );

}else{

if( $_SESSION['themepreview'] ){
	$_SESSION['themepreview'] = '';
unset(
	$_SESSION['themepreview']
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

add_templates_content_position($content,'Appearance Manager');
}

break;
case'widgets':
?>
<link href="admin/manage/appearance/style.css" rel="stylesheet" media="screen" type="text/css" />
<style type="text/css">
#post-left {
	width: 470px;
}
#post-right {
	width: 330px;
}
</style>
<?php
ob_start();
?>
<div style="overflow: auto;max-height: 500px;">
<div id="available-widgets" class="widgets-holder-wrap ui-droppable">
		<div class="sidebar-name" style="margin-bottom:0px;">
		<div class="sidebar-name-arrow"><br></div>
		<h3>Available Widgets <span id="removing-widget">Deactivate <span></span></span></h3></div>
		<div class="widget-holder shadow-inside" style="overflow:auto; max-height:500px;">
		<div id="widget-list">
        <?php list_widgets(); ?>
		</div>
        <div style="clear:both"></div>
        </div>
</div>
</div>
<?php
$content = ob_get_contents();
ob_end_clean();


ob_start();
?>
<div style="overflow: auto;max-height: 400px;">
<?php
$i = 0;
foreach ( $registered_sidebars as $sidebar => $registered_sidebar ) {
	if ( false !== strpos( $registered_sidebar['class'], 'inactive-sidebar' ) || 'orphaned_widgets' == substr( $sidebar, 0, 16 ) )
		continue;

	$wrap_class = 'widgets-holder-wrap';
	if ( !empty( $registered_sidebar['class'] ) )
		$wrap_class .= ' sidebar-' . $registered_sidebar['class'];

	if ( $i )
		$wrap_class .= ' closed'; ?>

	<div class="<?php echo $wrap_class; ?>">
	<div class="sidebar-name" style="margin-bottom:0px;">
	<div class="sidebar-name-arrow"><br /></div>
	<h3><?php echo $registered_sidebar['name']; ?></h3></div>
	<?php list_widget_controls( $sidebar );?>
	</div>
    <div style="clear:both"></div>
<?php
	$i++;
} 
?>
</div>
<?php
$content_widget = ob_get_contents();
ob_end_clean();

$form = '';
$header_menu = '';
$widget_manual = array();
$widget_manual['gadget'][] = array('title' => 'Current Widgets', 'desc' => $content_widget);

add_templates_content_position($content, 'Widgets Manager', $header_menu, $widget_manual, $form);

break;
case'theme-editor':

ob_start();

$path_dir = theme_path . get_option('template');

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
File : <?php _e( get_file_name($edit_file) )?>
</div>
<div class="padding">
<input type="hidden" name="file" value="<?php _e($edit_file)?>">
<textarea id="textcode" name="content" style="width:98.5%; height:350px">
<?php _e(htmlspecialchars(file_get_contents( $edit_file )))?>
</textarea>
</div>
<div class=num style="text-align:left;">
<input type="submit" name="submit" class="button on l green" value="Save & Update"><input name="Reset" type="reset" value="Reset" class="button r black">
</div>

<?php
$content = ob_get_contents();
ob_end_clean();

$form = 'action="" method="post" enctype="multipart/form-data" name="form1"';
$header_menu = '<a href="?admin&sys=appearance" class="button"><span class="icon_head back">&laquo; Back</span></a>';
add_templates_content_position( $content, 'Themes Editor', $header_menu, null, $form );

break;
case'menus':

global $get_group_title, $get_group_id, $get_menu_groups;

ob_start();
?>
<link rel="stylesheet" href="<?php echo site_url('libs/css/g-box-popup.css');?>">
<link rel="stylesheet" href="<?php echo site_url('libs/css/style-menu.css');?>">
<script>
var BASE_URL = '<?php echo site_url('');?>/';
var current_group_id = <?php echo $get_group_id; ?>;
</script>
<script src="<?php echo site_url('libs/js/interface-1.2.js');?>"></script>
<script src="<?php echo site_url('libs/js/inestedsortable.js');?>"></script>
<script src="<?php echo site_url('libs/js/menu.js');?>"></script>

<div class="padding">

<ul id="menu-group">
<?php 
$get_menu_groups_sort = array_multi_sort($get_menu_groups, array('id' => SORT_ASC));
foreach ((array)$get_menu_groups_sort as $data_get_menu) : 
?>
<li id="group-<?php echo $data_get_menu['id']; ?>"><a href="?admin&sys=appearance&go=menus&group_id=<?php echo $data_get_menu['id']; ?>"><?php echo $data_get_menu['title']; ?></a></li>
<?php endforeach; ?>
<li id="add-group"><a href="?request&load=libs/ajax/menu_group.php&aksi=add" title="Add Menu Group">+</a></li>
</ul>
<div class="clear" style="border-top:1px solid #ccc;"></div>

<form method="post" id="form-menu" action="?request&load=libs/ajax/menu.php&aksi=save_position">
<div class="ns-row" id="ns-header">
<div class="ns-actions">Actions</div>
<div class="ns-class">Class</div>
<div class="ns-url">URL</div>
<div class="ns-title">Title</div>
</div>
<?php 
$get_menu = get_menu($get_group_id);

$group_menu_ul = '<ul id="dragbox_easymn"></ul>';
if ( $get_menu ) {

	include libs_path . 'tree.php';
	$tree = new Tree;
	
	foreach ($get_menu as $row) {
		$tree->add_row($row['id'],$row['parent_id'],' id="menu-'.$row['id'].'" class="sortable_easymn"',get_label($row));
	}
	
	$group_menu_ul = $tree->generate_list('id="dragbox_easymn"');
}

echo $group_menu_ul;
?>
<div id="ns-footer">
<input type="submit" id="btn-save-menu" class="button" value="Update Menu">
</div>
</form>

</div>
<?php
$content = ob_get_contents();
ob_end_clean();

add_templates_content_position( $content, 'Menus Manager');

break;
}
?>
