<?php
/**
 * @file recent.php
 *
 */
//dilarang mengakses
if(!defined('_iEXEC')) exit;

if( 'libs/ajax/recent.php' == is_load_values() 
&& $login->check() 
&& $login->level('admin') 
):

@set_time_limit(0);

global $login, $db, $class_country;

if( checked_option( 'recent_reg_limit' )  ) $recent_reg_limit = get_option('recent_reg_limit');
else $recent_reg_limit = 10;
?>
<script>
/* <![CDATA[ */
$(document).ready(function(){

$(".tab_recent_reg").hide();
$(".tab_recent_reg:first").show();
$("ul.recent_reg li:first").addClass("active").show();
$("ul.recent_reg li").click(function() {
	$("ul.recent_reg li").removeClass("active");
	$(this).addClass("active");
	$(".tab_recent_reg").hide();
	var activeTab = $(this).find("a").attr("href");
	$(activeTab).slideDown('slow');
	return false;
});

});
/* ]]> */
</script>
<div style="clear:both"></div>
<ul class="recent_reg">
<li class="active"><a href="#reg-date">Terbaru</a></li>
<li><a href="#reg-country">Negara</a></li>
</ul>
<div style="clear:both"></div>
<div class="tabs-content">
<div id="reg-date" class="tab_recent_reg" style="display: block; ">
<div style="overflow:auto; max-height:200px;">
<ul class="ul-box">
<?php
$query	= $db->select('users',null,"ORDER BY user_registered DESC LIMIT $recent_reg_limit");
while($data	= $db->fetch_obj($query)){
?>
<li><a href="?admin&sys=users&user_id=<?php echo $data->ID;?>"><?php echo $data->user_author;?></a><span>
<?php 
if( $data->user_sex == 'l' ) echo 'Pria';
else echo 'Wanita';
?>
</span><span>
<?php 
if(!empty($data->user_country)) echo $class_country->country_name($data->user_country);
else echo 'unknow';

echo ' - ';

if(!empty($data->user_province)) echo $data->user_province;
else echo 'unknow';
?>
</span><span><?php echo dateformat($data->user_registered);?></span></li>
<?php
}
?>
</ul>
</div>
</div>
<div id="reg-country" class="tab_recent_reg" style="display: none; ">
<div style="overflow:auto; max-height:200px;">
<ul class="ul-box">
<?php
$q		= $db->query("
SELECT user_registered, user_country, COUNT(user_login) AS user_total
FROM $db->users
GROUP BY user_country
ORDER BY user_registered DESC
LIMIT $recent_reg_limit
");
while($data	= $db->fetch_obj($q)){
?>
<li><a href="?admin&sys=users&user_country=<?php echo $data->user_country;?>"><?php echo $class_country->country_name($data->user_country);?></a><span><?php echo $data->user_total;?> Terdaftar</span><span><?php echo dateformat($data->user_registered);?></span></li>
<?php
}
?>
</ul>
</div>
</div>
</div>
<?php endif;?>