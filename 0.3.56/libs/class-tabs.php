<?php
/*
<ul class="recent_reg">
	<li class="active"><a href="#reg-date">Terbaru</a></li>
	<li><a href="#reg-country">Negara</a></li>
</ul>
<div style="clear:both"></div>
<div class="tabs-content">
	<div id="reg-date" class="tab_recent_reg" style="display: block; "></div>
	<div id="reg-country" class="tab_recent_reg" style="display: block; "></div>
</div>

<style>
.tab_recent_reg {
	padding:2px 0;
}
.tab_recent_reg ul.ul-box {
	
}
ul.recent_reg {
	margin: 0;
	padding: 0;
	float: left;
	list-style: none;
	height: 25px;
	margin-left:3px;
	margin-right:0;
	margin-top:-5px;
}
ul.recent_reg li {
	float: left;
	margin: 0;
	padding: 0;
	height: 24px;
	line-height: 24px;
	border: 1px solid #ddd;
	margin-right:2px;
	overflow: hidden;
	font-weight:normal;
    border-top-left-radius: 2px;
    border-top-right-radius: 2px;
    -moz-border-radius-topleft: 2px;
    -moz-border-radius-topright: 2px;
}
ul.recent_reg li a {
	text-decoration: none;
	display: block;
	padding: 0 5px 0 5px;
	outline: none;
}
ul.recent_reg li a:hover {
	background: #f2f2f2;
    border-top-left-radius: 2px;
    border-top-right-radius: 2px;
    -moz-border-radius-topleft: 2px;
    -moz-border-radius-topright: 2px;
}
html ul.recent_reg li.active, 

html ul.recent_reg li.active a:hover   {
	background: #f2f2f2;
	border-bottom: 1px solid #ccc;
	border-bottom-style:dotted;
}
</style>

<![CDATA[
$(document).ready(function(){
	
$(".tab_recent_reg").hide();
$(".tab_recent_reg:first").show();
$("ul.recent_reg li:first").addClass("active").show();
$("ul.recent_reg li").click(function() {
	$("ul.recent_reg li").removeClass("active");
	$(this).addClass("active");
	$(".tab_recent_reg").hide();
	var activeTab = $(this).find("a").attr("href");
	$(activeTab).fadeIn();
	return false;
});

});
	
*/
class tabs_boxes{

	private static $tab_id = '';
	private static $tab_ref = '';
	
	public function __construct($tab_id,$tab_ref){
		self::$tab_id = $tab_id;
		self::$tab_ref = $tab_ref;
	}
	
	public function add_tab($name){
		echo '<ul class="recent_reg">';
		echo '<li class="active"><a href="#reg-date">Terbaru</a></li>';
		echo '</ul>';
	}
	
	public function tab_content(){
		echo '<div style="clear:both"></div>';
		echo '<div class="tabs-content">';
		echo '<div id="reg-date" class="tab_recent_reg" style="display: block; "></div>';
		echo '</div>';
	}
		
}