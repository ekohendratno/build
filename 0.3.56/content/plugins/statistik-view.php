<?php
/**
 * @file: statistik-view.php
 * @dir: content/plugins
 */
 
/*
Plugin Name: Statistik Website
Plugin URI: http://cmsid.org/#
Description: Plugin bla bla bla
Author: Eko Azza
Version: 1.2.0
Author URI: http://cmsid.org/
*/ 

if(!defined('_iEXEC')) exit;

function web_statistik_view(){
global $iw,$db,$class_country;
?>
<br>
<!--Show Dialog-->
<div id="dialog_web_statistik_view"  class="redactor_modal" style="width: 300px; height: auto;display: none; ">
<div id="redactor_modal_close">&times;</div>
<div id="redactor_modal_header">Pengaturan Statistik</div>
<div id="redactor_modal_inner">
<form method="post" action="" enctype="multipart/form-data">
<center>
Hapus dan kembalikan data menjadi kosong.<br style="clear:both"/><br style="clear:both"/>
<input onclick="return confirm('Are You sure delete all records?')" type="submit" name="submitReset" value="Reset to default" />
</center>
</form>
</div>
</div>
<!--Show End Dialog-->
<div style="clear:both"></div>
<!--start-tabs-->
<!--start-->
<ul class="stat">
<li class="active"><a href="#stat-os">OS</a></li>
<li><a href="#stat-day">Hari</a></li>
<li><a href="#stat-month">Bulan</a></li>
<li><a href="#stat-clock">Jam</a></li>
<li><a href="#stat-browser">Browser</a></li>
<li><a href="#stat-country">Negara</a></li>
</ul>
<div style="clear:both"></div>
<div class="tabs-content">
<?php 
$stat = new statistik;
if( isset($_POST['submitReset']) ){
	reset_statistic();
	redirect('?admin');	
}
?>
<div id="stat-os" class="tab_stat" style="display: block; ">
<div class="progress">
<?php
$progress 	= $stat->progress('os');
for($i=0;$i<$progress['totopt'];$i++){
$persentase = round($progress['hit'][$i] / $progress['tothit'] * 100, 2);
?>
<div class="jpaginate1">
<div class="progress-container">
<span class="no"><?php echo $i+1;?></span>
<span class="name"><?php echo $progress['opt'][$i];?></span>
<span class="persent"><?php echo $progress['hit'][$i];?></span>
<div style="width: <?php echo $persentase;?>%" class="<?php echo $stat->select_color($persentase);?> progress_anim"></div>
</div>
</div>
<?php
}
?>
<div class="total">
<span>Total : <?php echo $progress['tothit'];?> Visitor</span>
<span class="orange fw">low</span>
<span class="green fw">medium</span>
<span class="blue fw">height</span>
</div>
</div>
<!--end-->

</div>
<div id="stat-day" class="tab_stat" style="display: none; ">
<div class="progress">
<?php
$progress 	= $stat->progress('day');
for($i=0;$i<$progress['totopt'];$i++){
?>
<div class="jpaginate1">
<?php $persentase = round($progress['hit'][$i] / $progress['tothit'] * 100, 2);?>
<div class="progress-container">
<span class="no"><?php echo $i+1;?></span>
<span class="name"><?php echo $progress['opt'][$i];?></span>
<span class="persent"><?php echo $progress['hit'][$i];?></span>
<div style="width: <?php echo $persentase;?>%" class="<?php echo $stat->select_color($persentase);?> progress_anim"></div>
</div>
</div>
<?php
}
?>
<div class="total">
<span>Total : <?php echo $progress['tothit'];?> Visitor</span>
<span class="orange fw">low</span>
<span class="green fw">medium</span>
<span class="blue fw">height</span>
</div>
</div>
<!--end-->
</div>
<div id="stat-month" class="tab_stat" style="display: none; ">
<div class="progress">
<?php
$progress 	= $stat->progress('month');
for($i=0;$i<$progress['totopt'];$i++){
?>
<div class="jpaginate1">
<?php $persentase = round($progress['hit'][$i] / $progress['tothit'] * 100, 2);?>
<div class="progress-container">
<span class="no"><?php echo $i+1;?></span>
<span class="name"><?php echo $progress['opt'][$i];?></span>
<span class="persent"><?php echo $progress['hit'][$i];?></span>
<div style="width: <?php echo $persentase;?>%" class="<?php echo $stat->select_color($persentase);?> progress_anim"></div>
</div>
</div>
<?php
}
?>
<div class="total">
<span>Total : <?php echo $progress['tothit'];?> Visitor</span>
<span class="orange fw">low</span>
<span class="green fw">medium</span>
<span class="blue fw">height</span>
</div>
</div>
<!--end-->
</div>
<div id="stat-clock" class="tab_stat" style="display: none; ">
<div class="progress">
<?php
$progress 	= $stat->progress('clock');
for($i=0;$i<$progress['totopt'];$i++){
?>
<div class="jpaginate1">
<?php $persentase = round($progress['hit'][$i] / $progress['tothit'] * 100, 2);?>
<div class="progress-container">
<span class="no"><?php echo $i+1;?></span>
<span class="name"><?php echo $progress['opt'][$i];?></span>
<span class="persent"><?php echo $progress['hit'][$i];?></span>
<div style="width: <?php echo $persentase;?>%" class="<?php echo $stat->select_color($persentase);?> progress_anim"></div>
</div>
</div>
<?php
}
?>
<div class="total">
<span>Total : <?php echo $progress['tothit'];?> Visitor</span>
<span class="orange fw">low</span>
<span class="green fw">medium</span>
<span class="blue fw">height</span>
</div>
</div>
<!--end-->
</div>
<div id="stat-browser" class="tab_stat" style="display: none; ">
<div class="progress">
<?php
$progress 	= $stat->progress('browser');
for($i=0;$i<$progress['totopt'];$i++){
?>
<div class="jpaginate1">
<?php $persentase = round($progress['hit'][$i] / $progress['tothit'] * 100, 2);?>
<div class="progress-container">
<span class="no"><?php echo $i+1;?></span>
<span class="name"><?php echo $progress['opt'][$i];?></span>
<span class="persent"><?php echo $progress['hit'][$i];?></span>
<div style="width: <?php echo $persentase;?>%" class="<?php echo $stat->select_color($persentase);?> progress_anim"></div>
</div>
</div>
<?php
}
?>
<div class="total">
<span>Total : <?php echo $progress['tothit'];?> Visitor</span>
<span class="orange fw">low</span>
<span class="green fw">medium</span>
<span class="blue fw">height</span>
</div>
</div>
<!--end-->
</div>
<div id="stat-country" class="tab_stat" style="display: none; ">
<div class="progress">
<?php
$progress 	= $stat->progress('country');
for($i=0;$i<$progress['totopt'];$i++){
?>
<div class="jpaginate1">
<?php $persentase = round($progress['hit'][$i] / $progress['tothit'] * 100, 2);?>
<div class="progress-container">
<span class="no"><?php echo $i+1;?></span>
<span class="name"><?php echo $class_country->country_name($progress['opt'][$i]);?></span>
<span class="persent"><?php echo $progress['hit'][$i];?></span>
<div style="width: <?php echo $persentase;?>%" class="<?php echo $stat->select_color($persentase);?> progress_anim"></div>
</div>
</div>
<?php
}
?>
<div class="total">
<span>Total : <?php echo $progress['tothit'];?> Visitor</span>
<span class="orange fw">low</span>
<span class="green fw">medium</span>
<span class="blue fw">height</span>
</div>
</div>
<!--end-->
</div>
</div>
<!--end-tabs-->


<br />
<?php
}

add_dashboard_widget( 'web_statistik_view', 'Statistik', 'web_statistik_view', true );