<?php 
/* set posisi kontent */
set_layout('full');

/* kirim judul dan isi ke GLOBALS */ 
$title = 'Page Not Found';
$desc  = 'Apologies, but the Page you requested could not be found';

set_meta( $title, $desc, $title );
?>
<h1 class=border><?php _e($title);?></h1>
<div class="border"><?php _e($desc);?></div>