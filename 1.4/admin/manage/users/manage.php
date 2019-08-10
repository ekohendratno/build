<?php 
/**
 * @fileName: manage.php
 * @dir: admin/manage/users
 */
if(!defined('_iEXEC')) exit;
global $db, $class_country, $widget;
$go 	= filter_txt($_GET['go']);
$act	= filter_txt($_GET['act']);
$to		= filter_txt($_GET['to']);
$offset	= filter_int($_GET['offset']);
$level	= filter_txt($_GET['level']);
$id  	= filter_txt($_GET['id']);
$user_country = filter_txt($_GET['user_country']);

?>
<link href="admin/manage/users/style.css" rel="stylesheet" media="screen" type="text/css" />
<?php
echo js_redirec_list();

ob_start();

$header_title = 'Users Manager';

switch($go){
default:

if($act == 'del' && !empty($act)){
	del_users($id); 
	add_activity('manager_users',"menghapus user",'user');
}



if( !empty($offset) ) $bt = $offset;
else $bt	= 20;

$pg = (int) get_query_var('pg');
if(empty($pg)){
	$ps = 0;
	$pg = 1;
}
else{
	$ps = ($pg-1) * $bt;
}

if($level=='admin'){
	$add_query	= 'user_level="admin"';
}elseif($level=='user'){
	$add_query	= ' user_level="user"';
}elseif($level=='all'){
	$add_query	= ' user_level="user" OR  user_level="admin"';
}else $add_query = '';


$add_query1 = $add_query2 = '';
if( !empty($add_query) ){
	if( !empty($user_country) ){
		$add_query0 = " AND user_country='$user_country'";
		$add_query2 = "$add_query$add_query0";
		$add_query1 = "WHERE $add_query2";
	}else{
		$add_query1 = "WHERE $add_query";
	}
}else{
	if( !empty($user_country) ){
		$add_query0 = "user_country='$user_country'";
		$add_query1 = "WHERE $add_query0";
		$add_query2 = " AND $add_query0";
	}
}

$sql_query = $db->query("SELECT * FROM $db->users $add_query1 ORDER BY user_registered DESC LIMIT $ps,$bt");
$total = $db->num_query("SELECT * FROM $db->users $add_query1");
?>
<div id="list-comment">
<?php
$warna = 'white';
while($row = $db->fetch_array($sql_query)){
$warna 	= ( $warna == 'white' ) ? 'gray' : 'white';

$avatar_img_profile = avatar_url($row['user_login']);
?>
<div class="comment <?php echo $warna?>">
<img alt="" src="<?php echo $avatar_img_profile?>" class="avatar" height="50" width="50">
<div class="dashboard-comment-wrap">
<span class="name"><?php echo $row['user_author']?></span><br />
Negara: <span class="country"><em><?php if(empty($row['user_country'])) echo 'unknow'; else echo $class_country->country_name($row['user_country']);?></em></span>
,Provinsi: <span class="prov"><em><?php if(empty($row['user_province'])) echo 'unknow'; else echo $row['user_province'];?></em></span><br /> 
Tanggal: <span class="date"><em><?php echo datetimes($row['user_registered'])?></em></span>	
			
<p class="row-actions">
<a id="popup" data-type="show" title="Detail User" href="?request&load=libs/ajax/user.php&amp;aksi=detail&user_id=<?php echo $row['ID'];?>" class="button button2 l">Detail</a>
<a id="popup" data-type="edit" title="Edit User" href="?request&load=libs/ajax/user.php&amp;aksi=edit&to=data&user_id=<?php echo $row['ID'];?>" class="button button2 m green">Edit Data</a>
<a id="popup" data-type="edit" title="Edit Password" href="?request&load=libs/ajax/user.php&amp;aksi=edit&to=password&user_id=<?php echo $row['ID'];?>" class="button button2 m green">Edit Password</a>
<a href="?admin&sys=users&act=del&id=<?php echo  $row['ID']?>"  onclick="return confirm('Are You sure delete this users?')" class="button button2 r red">Trash</a>
</p>
<div style="clear:both"></div>
</div>
</div>
<?php
}
?>
</div>
<?php

ob_start()
?>
<div class="header_menu_top">
<select onchange="redir(this)" name="show">
<option value="">-- Show --</option>
<option value="?admin&sys=users&offset=20"<?php if( $offset == 20 ) echo ' selected';?>>20</option>
<option value="?admin&sys=users&offset=30"<?php if( $offset == 30 ) echo ' selected';?>>30</option>
<option value="?admin&sys=users&offset=50"<?php if( $offset == 50 ) echo ' selected';?>>50</option>
<option value="?admin&sys=users&offset=100"<?php if( $offset == 100 ) echo ' selected';?>>100</option>
</select>
<select onchange="redir(this)" name="show">
<option value="">-- Level --</option>
<option value="?admin&sys=users&level=all"<?php if( $level == 'all' || empty($level) ) echo 'selected';?>>All Level</option>
<option value="?admin&sys=users&level=admin"<?php if( $level == 'admin' ) echo 'selected';?>>Admin</option>
<option value="?admin&sys=users&level=user"<?php if( $level == 'user' ) echo 'selected';?>>User</option>
</select></div>
<a id="popup" data-type="add" title="Add New User" href="?request&load=libs/ajax/user.php&amp;aksi=add" class="button button3">+ New</a><?php
$header_menu = ob_get_contents();
ob_end_clean();

$sql_query_admin = $db->query("SELECT * FROM $db->users WHERE user_level='admin' $add_query2");
$sql_query_user = $db->query("SELECT * FROM $db->users WHERE user_level='user' $add_query2");

$paging = new Pagination();
$paging->set('urlscheme','?admin&sys=users&pg=%page%');
$paging->set('perpage',$bt);
$paging->set('page',$pg);
$paging->set('total',$total);
$paging->set('nexttext','Next');
$paging->set('prevtext','Previous');
$paging->set('focusedclass','selected');

$total_footer = 'Total Member : '.$db->num( $sql_query ).' Dari '.$db->num( $sql_query_admin ).' Administrator dan : '.$db->num( $sql_query_user ) .' User';

$footer = '<div class="left">'.$paging->display(true).'</div>';
$footer.= '<div class="right">'.$total_footer.'</div>';

break;
}

$content = ob_get_contents();
ob_end_clean();

$form = 'name="form1" method="post" action=""';
add_templates_manage( $content, $header_title, $header_menu, null, $form, $footer ); 

?>