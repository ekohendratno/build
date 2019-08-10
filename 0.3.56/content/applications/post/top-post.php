<?php
/**
 * @file top-post.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $iw,$db;
/*
$query_add='';
if($access->cek_login()){
if($_GET['com']=='post' && $_GET['view']=='item'){
	$query_add='WHERE user_login='.$access->exist_value('user_name');
}}
*/

$qry	= $db->query("SELECT * FROM ".$iw->pre."post WHERE type='post' ORDER BY hits DESC LIMIT 10");
$jum 	= $db->num($qry);
if($jum < 1){
echo'no data';
}else{
echo'<ul class="sidemenu">';
while ($data = $db->fetch_array($qry)) {
$datas = array('view'=>'item','id'=>$data['id'],'title'=>$data['title']);
echo'<li><a title="'.$data['title'].'"  class="main-menu-act" href="'.do_links('post',$datas).'">
'.limittxt($data['title'],60).'
</a></li>';
}
?>
<ul>
<?php
}
?>

