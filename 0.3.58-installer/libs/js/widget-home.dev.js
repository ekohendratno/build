/* <![CDATA[ */
$(document).ready(function(){
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