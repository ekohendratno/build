<?php 
/* set posisi kontent */
set_layout('full');

/* kirim judul dan isi ke GLOBALS */ 
$GLOBALS['title'] ='Page Not Found';
$GLOBALS['desc']  ='Apologies, but the Page you requested could not be found';
?>
<h1 class=border><?php _e($GLOBALS['title']);?></h1>
<div class="border"><?php _e($GLOBALS['desc']);?></div>