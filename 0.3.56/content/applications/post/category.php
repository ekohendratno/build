<?php
/**
 * @file category.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

global $iw,$db;
/*
$query_add	='ORDER BY id DESC LIMIT 10';
if($access->cek()){
$r=$access->profile_user();
if($_GET['com']=='news' && $_GET['view']=='article'){
	$d			=$db->result($db->query("SELECT * FROM ".$config->dbprefix."com_news WHERE UserId=".$r['UserId']));
	$query_add	='WHERE id='.$d['topic'].'';
}}
*/

$qry	= $db->select('post_topic');
$jum 	= $db->num($qry);
if($jum < 1){
echo'no data';
}else{
echo'<ul class="sidemenu">';
while ($data = $db->fetch_array($qry)) {
$datas = array('view'=>'category','id'=>$data['id'],'title'=>$data['topic']);
echo'<li><a title="'.$data['title'].'"  class="main-menu-act" href="'.do_links('post',$datas).'">
'.limittxt($data['topic'],36).'<br><span>'.$data['desc'].'</span></a>
</li>';
}
?>
<ul>
<?php
}
?>
