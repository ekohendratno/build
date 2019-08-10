<?php 
if(!defined('_iEXEC')) exit;
/* set posisi kontent */
set_layout('left');
?>
<h1  class="border">
<?php
/* menyaring id permintaan */
$id 			= post_item_id('page',$_GET['id']);

$judul_halaman 	= page('title',$id); 
$isi_halaman 	= page('content',$id);

/* kirim judul dan isi ke GLOBALS */
$GLOBALS['title'] 	= $judul_halaman;
$GLOBALS['desc']  	= limittxt(htmlentities(strip_tags($isi_halaman)),200);

if($judul_halaman==false) _e('Page Not Found');
else _e($judul_halaman);
?>
</h1>
<div class="border">
<?php 
if($isi_halaman==false) _e('Apologies, but the Page you requested could not be found');
else _e($isi_halaman);
?>
</div>






