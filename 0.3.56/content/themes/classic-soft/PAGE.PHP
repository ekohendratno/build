<?php 
if(!defined('_iEXEC')) exit;
/* set posisi kontent */
set_layout('left');

/* menyaring id permintaan */
$id 			= post_item_id('page',$_GET['id']);
$judul_halaman 	= page('title',$id); 
$isi_halaman 	= page('content',$id);

if( $judul_halaman == false ) $judul_halaman = 'Page Not Found';
else $judul_halaman = $judul_halaman;

if( $isi_halaman == false ) $isi_halaman = 'Apologies, but the Page you requested could not be found';
else $isi_halaman = $isi_halaman;

set_meta( $judul_halaman, $isi_halaman, $judul_halaman );
?>
<h1  class="border"><?php _e($judul_halaman);?></h1>
<div class="border"><?php _e($isi_halaman);?></div>






