<?php
/*
App Name: Post
App URI: http://cmsid.org/#
Description: App post
Author: Eko Azza
Version: 1.1.0
Author URI: http://cmsid.org/#
*/ 

//dilarang mengakses
if(!defined('_iEXEC')) exit;

set_layout('center');

$view = get_query_var('view');

global $iw, $db, $login;

echo'<h1 class=border>Posting</h1>';
if( $login->cek_login() ):
echo'<div class="border"><a href="index.php?com=post">Halaman Utama Posting</a> | <a href="index.php?com=post&view=mypost">My Post</a> | <a href="index.php?com=post&view=mypost&go=add">';
if(!is_admin()) echo 'Kirim '; else echo 'Tambah ';
echo 'Article</a></div>';
endif;

switch( $view ){
default:

$limit		= 10;
$a			= new paging();
$q			= $a->query( "SELECT * FROM `".$iw->pre."post` WHERE type='post' AND approved=1 AND status=1 ORDER BY date_post DESC", $limit);
$jml_baris 	= $db->num($q);
for($i = 0; $i < $jml_baris; $i++){ 
$data 		= $db->fetch_array($q);
$topic 		= $data['post_topic'];
$id			= $data['id'];

$q1			= $db->query("SELECT * FROM ".$iw->pre."post_comment WHERE post_id='$id' and approved=1");
$totalres	= $db->num($q1); 

?>
<h1 class="bg"><?php _e($data['title']);?></h1>
<div class="post" id="post-1">
<?php set_image_thumb($data['thumb'], true, array('260','260'), 'post-img');?>
<p style="text-align:justify;"><?php _e(limittxt(strip_tags($data['content']),450));?></p></div>

<?php $datas = array('view'=>'item','id'=>$data['id'],'title'=>$data['title']);?>
<p class="post-footer">
<a href="<?php _e(do_links('post',$datas));?>" rel="bookmark" title="<?php echo $data['title'];?>" class="readmore">Baca Selengkapnya</a>	
<span class="comments">Klik (<?php _e($data['hits']);?>)</span>
<span class="comments">Komentar (<?php _e($totalres);?>)</span>
<span class="waktu_posting"><?php _e(datetimes($data['date_post'],false));?></span>	
</p>
<?php
$no++;
}
//halaman navigasi
echo $a->pg( 'post' );
break;
case'item':
set_layout('right');
$id		= post_item_id('item',$_GET['id']);

$query_status = 'AND approved=1 AND status=1';
//if( $login->cek_login() &&  $login->login_level('admin') )
//$query_status = '';

$q		= $db->query("SELECT * FROM `".$iw->pre."post` WHERE id=$id AND type='post' $query_status");
$hits   = 0;
$data   = $db->fetch_array($q);
if(empty($data['id'])){
	redirect();
}else{
$hits	= $data['hits'];
$db->query("UPDATE ".$iw->pre."post SET hits=$hits+1 WHERE type='post' $query_status AND id=$id");

set_meta(	$data['title'], $data['content'], $data['tags'] );

?>
<h1  class="border"><?php _e($data['title']);?></h1>
<?php 
$q2			= $db->query("SELECT * FROM ".$iw->pre."post_topic WHERE id=".$data['post_topic']);
$row		= $db->fetch_array($q2);

$datas = array('view'=>'category','id'=>$data['post_topic'],'title'=>$row['topic']);
?>
<div class="border">Topik : <a href="<?php _e(do_links('post',$datas));?>"><?php _e($row['topic']);?></a></div>
<div class="border">
<div style="width:60%; float:left;">
<?php _e(datetimes($data['date_post']));?> - by : <?php _e($data['user_login']);?></div>
<div style="width:15%; float:right;" align="right">
<a href="javascript:void(window.open('<?php _e($iw->base_url);?>?request&load=print.php&apps=post&id=<?php _e($data['id']);?>','Print','scrollbars=yes,width=650,height=530'))">
<img src="<?php _e($iw->base_url);?>content/applications/post/images/printButton.png" alt="print" height="16"/>
</a> 
<a href="#">
<img src="<?php _e($iw->base_url);?>content/applications/post/images/emailButton.png" alt="send" height="16"/></a> 
<a href="#">
<img src="<?php _e($iw->base_url);?>content/applications/post/images/pdf_button.png" alt="pdf"  height="16"/>
</a>
</div>
<br />
</div>
<?php
set_image_thumb($data['thumb'], true, array('260','260'));

$titlenya	= $data['title'];
$content	= $data['content'];
$id			= $data['id'];
$topic 		= $data['post_topic'];

$id_link	= do_links( 'post', array('view'=>'item','id'=>$id,'title'=>$titlenya) );
?>
<div class="post-item">
<?php _e($content);?>
<div style="clear:both"></div>
</div>
<?php
//plugins
?>
<div class=border><strong>Label : </strong><?php echo implode( ', ', tags($id) )?>
</div>
<h1 class=border>Postingan Lainnya :</h1><div class=border>
<?php
/*
 *show post more where != id post and status = 1 and id topic  order by date asc limit 10
 */
$q		= $db->query("SELECT * FROM ".$iw->pre."post WHERE type='post' AND status=1 AND id!='$id' and post_topic='$topic' ORDER BY date_post ASC LIMIT 10" );
?>
<table cellspacing="1" cellpadding="1" width="100%">
<?php
$respon		= 0;
while ($data= $db->fetch_array($q)) {
$respon		= 1;
$id2    	= $data[0];
$titlemore  = $data['title'];
$datas		= array('view'=>'item','id'=>$id2,'title'=>$titlemore);
?>
<tr><td>
<img src="<?php echo $iw->base_url;?>content/applications/post/images/1.gif" border="0" alt="ul" />
<a href="<?php echo do_links('post',$datas);?>"><?php echo limittxt($titlemore,123);?></a>
</td></tr>
<?php
}
if(!$respon){
?>
<tr><td>Kosong</td></tr>
<?php
}
?>
</table></div>
<?php
include('init.comment.php');
}

break;
case'category':

$id			= post_item_id('category',$_GET['id']);
$qry		= $db->select("post_topic",array('id'=>$id));
$data_topic	= $db->fetch_array($qry);
echo'<h1 class=border>Topik : '.$data_topic['topic'].'</h1>';

$limit		= 10;
$a			= new paging();
$qry_post	= $a->query("SELECT * FROM `".$iw->pre."post` WHERE type='post' AND post_topic='".$id."' AND approved=1 AND status=1 ORDER BY date_post DESC", $limit);

if($db->num($qry_post) < 1) redirect();

while($data_post = $db->fetch_array($qry_post)){
$post_id		 = $data_post['id'];
$qry_comment	 = $db->select("post_comment",array('post_id'=>$post_id,'approved'=>1)); 
?>
<h1 class="bg"><?php echo limittxt($data_post['title'],55);?></h1>
<div class="post" id="post-1">
           <?php set_image_thumb($data_post['thumb'], true, array('70','70'), 'post-img');?>
           <p style="text-align:justify;"><?php echo limittxt(strip_tags($data_post['content']),450);?></p>
        </div>
<p class="post-footer">	
	
<?php $datas = array('view'=>'item','id'=>$post_id,'title'=>$data_post['title']);?>			
<a href="<?php echo do_links('post',$datas);?>" rel="bookmark" title="<?php echo $data_post['title'];?>" class="readmore">Baca Selengkapnya</a>
<span class="comments">Klik (<?php echo $data_post['hits'];?>)</span>
<span class="comments">Komentar (<?php _e($db->num($qry_comment));?>)</span>
<span class="waktu_posting"><?php echo datetimes($data_post['date_post'],false);?></span>	
</p>
<?php
$no++;
}
//halaman navigasi
echo $a->pg('post',array('view'=>'category','id'=>$_GET['id']));

break;
case'tags':

$tags 		= filter_txt($_GET['id']);
$limit		= 10;
$a			= new paging();
if (!empty($tags)){
$tag = mysql_escape_string($tags);?>
<h1 class="border">Tags : <?php echo str_replace('+',' ',stripslashes(strip_tags($tags)));?></h1>
<?php			
if (strlen($tag) == 3) {
	$finder = "`tags` LIKE '%$tag%'";
}else {
	$finder = "MATCH (tags) AGAINST ('$tag' IN BOOLEAN MODE)";
}
}
$q			= $a->query( "SELECT * FROM `".$iw->pre."post` WHERE  $finder AND type='post' AND approved=1 AND status=1 ORDER BY date_post DESC", $limit);
$jml_baris  = $db->num($q);
if($jml_baris<=0){			
	redirect();
}
for($i = 0; $i < $jml_baris; $i++){ 
$data 	= $db->fetch_array($q);
$post_id= $data['id'];
$topic 	= $data['post_topic'];

$q2			= $db->query("select * from ".$iw->pre."post_comment where 	post_id='$post_id' and approved=1"); 
$totalres 	= $db->num($q2);

?>
<h1 class="bg"><?php echo limittxt($data['title'],55);?></h1>
<div class="post" id="post-1">
           <?php set_image_thumb($data['thumb'], true, array('70','70'), 'post-img');?>
           <p style="text-align:justify;"><?php echo limittxt(strip_tags($data['content']),450);?></p>
        </div>
<p class="post-footer">	

<?php $datas = array('id'=>$data['id'],'view'=>'item','title'=>$data['title']);?>				
<a href="<?php echo do_links('post',$datas);?>" rel="bookmark" title="<?php echo $data['title'];?>" class="readmore">Baca Selengkapnya</a>
<span class="comments">Klik (<?php echo $data['hits'];?>)</span>
<span class="comments">Komentar (<?php _e($totalres);?>)</span>
<span class="waktu_posting"><?php _e(datetimes($data['date_post'],false));?></span>	

</p>
<?php
$no++;
}
//halaman navigasi
echo $a->pg( 'post',array('view'=>'tags','id'=>$tags) );
break;
case'arsip':
$limit		= 10;
$a			= new paging();
$date 		= filter_txt($_GET['id']);
if (preg_match('/\d{4}\:\d{2}/',$date) or preg_match('/\d{4}\.\d{2}/',$date)) {
	if (preg_match('/\d{4}\:\d{2}/',$date)){
	list($tahun,$bulan) = explode(':',$date);
	}
	if (preg_match('/\d{4}\.\d{2}/',$date)){
	list($tahun,$bulan) = explode('.',$date);
	}
	
	$bulan = filter_txt($bulan);
	$tahun = filter_int($tahun);
?>
<h1 class="border">Arsip : <?php echo convert_bln($bulan).' '.$tahun;?></h1>
<?php
if (checkdate($bulan,1,$tahun)) {
	$q	= $a->query("SELECT * FROM `".$iw->pre."post` WHERE month(`date_post`) = '$bulan' AND year(`date_post`) = '$tahun' AND approved=1 AND status = 1 ORDER BY `date_post` DESC", $limit);
	$jml_baris  = $db->num($q);
	if($jml_baris<=0){			
		redirect();
	}
	for($i = 0; $i < $jml_baris; $i++){ 
	$data 	= $db->fetch_array($q);
	?>
	<h1 class="bg"><?php echo limittxt($data['title'],55);?></h1>
	<div class="post" id="post-1">
			   <?php set_image_thumb($data['thumb'], true, array('70','70'), 'post-img');?>
			   <p style="text-align:justify;"><?php echo limittxt(strip_tags($data['content']),450);?></p>
			</div>
	<p class="post-footer">		
	<?php $datas = array('id'=>$data['id'],'view'=>'item','title'=>$data['title']);?>				
	<a href="<?php echo do_links('post',$datas);?>" rel="bookmark" title="<?php echo $data['title'];?>" class="readmore">Baca Selengkapnya</a>
	<span class="comments">Klik (<?php echo $data['hits'];?>)</span>
	<span class="comments">Komentar (<?php _e($totalres);?>)</span>
	<span class="waktu_posting"><?php _e(datetimes($data['date_post'],false));?></span>	
	
	</p>
	<?php
	}
	//halaman navigasi
	echo $a->pg( 'post',array('view'=>'arsip','id'=>$date) );
}}
break;
case'mypost':

if(!$login->cek_login() ) redirect();
else include_once('init.mypost.php');

break;
}
?>