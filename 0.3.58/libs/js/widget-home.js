/* <![CDATA[ */
$(document).ready(function(){
	
$(".tab_activity_records").hide();
$(".tab_activity_records:first").show();
$("ul.activity_records li:first").addClass("active").show();
$("ul.activity_records li").click(function() {
	$("ul.activity_records li").removeClass("active");
	$(this).addClass("active");
	$(".tab_activity_records").hide();
	var activeTab = $(this).find("a").attr("href");
	$(activeTab).fadeIn();
	return false;
});

$(".tab_view_post").hide();
$(".tab_view_post:first").show();
$("ul.view_post li:first").addClass("active").show();
$("ul.view_post li").click(function() {
	$("ul.view_post li").removeClass("active");
	$(this).addClass("active");
	$(".tab_view_post").hide();
	var activeTab = $(this).find("a").attr("href");
	$(activeTab).fadeIn();
	return false;
});

$(".tab_referr_urls").hide();
$(".tab_referr_urls:first").show();
$("ul.referr_urls li:first").addClass("active").show();
$("ul.referr_urls li").click(function() {
	$("ul.referr_urls li").removeClass("active");
	$(this).addClass("active");
	$(".tab_referr_urls").hide();
	var activeTab = $(this).find("a").attr("href");
	$(activeTab).fadeIn();
	return false;
});

$(".tab_feednews").hide();
$(".tab_feednews:first").show();
$("ul.feednews li:first").addClass("active").show();
$("ul.feednews li").click(function() {
	$("ul.feednews li").removeClass("active");
	$(this).addClass("active");
	$(".tab_feednews").hide();
	var activeTab = $(this).find("a").attr("href");
	$(activeTab).fadeIn();
	return false;
});

$(".tab_stat").hide();
$(".tab_stat:first").show();
$("ul.stat li:first").addClass("active").show();
$("ul.stat li").click(function() {
	$("ul.stat li").removeClass("active");
	$(this).addClass("active");
	$(".tab_stat").hide();
	var activeTab = $(this).find("a").attr("href");
	$(activeTab).fadeIn();
	return false;
});

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

/*
drag and drob
*/

	$(".widget").each(function(){
		$(".widget-title-action a.widget-action").click(
			function(){
				$(this).siblings(".widget-inside").toggle();
			}
		);
	});
	
	$(".dragbox").each(function(){
		show_empty_container();
		$(this).hover(
		function(){
			$(this).find("span.colspace").addClass("collapse");
		}, 		
		function(){
			$(this).find("span.colspace").removeClass("collapse");
		})
		
		.find("div.gd-header").hover(
		function(){
			$(this).find(".configure").css("visibility", "visible");
		}, 		
		function(){
			$(this).find(".configure").css("visibility", "hidden");
		})
		.click(function(){
			//$(this).siblings(".gd-content").toggle();
			//updateWidgetData();
		})
		.end()
		
		.find(".configure").css("visibility", "hidden");
	});
	
	$(".column .meta-box-sortables").sortable({
		connectWith: ".column .meta-box-sortables",
		handle: "span.colspace",
		cursor: "move",
		opacity: 0.8,
		placeholder: "placeholder",
		forcePlaceholderSize: true,
		stop: function(event, ui){
			//$(ui.item).find("span.colspace").click();
			updateWidgetData();
			show_empty_container();
		}
		
	})
	.enableSelection();
	
});
/* ]]> */