<?php
/**
 * @file arsip.php
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

$qry	= $db->query("SELECT date_format( `date_post` , '%Y:%m' ) AS `date` FROM `".$iw->pre."post` WHERE status = 1 GROUP BY `date` DESC LIMIT 12");
$jum 	= $db->num($qry);
if($jum < 1){
echo'no data';
}else{
echo'<ul class="sidemenu">';
while ($data = $db->fetch_assoc($qry)) {
	list($tahun,$bulan) = explode(':',$data['date']);
	
	$quer 	= $db->query("SELECT count(`id`) AS `total` FROM `".$iw->pre."post` WHERE month(`date_post`) = '$bulan' AND year(`date_post`) = '$tahun' AND status = 1");
	$tot 	= $db->fetch_assoc($quer);
	$total 	= $tot['total'];
	$datas 	= array('view'=>'arsip','id'=>$data['date']);
	echo '<li><a href="'.do_links('post',$datas).'">'.convert_bln($bulan).' '.$tahun.' ('.$total.') </a></li>';
}
?>
<ul>
<?php
}
?>
