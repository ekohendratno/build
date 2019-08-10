
	document.createElement("article");
	document.createElement("footer");  
	document.createElement("header");
	document.createElement("hgroup");
	document.createElement("nav");
	document.createElement("menu");

	var SubMenutimer;
	var last_o;

	$(".mainMenu").ready(function() {
		$(".staticMenu dt a").click(function() {

			$(".staticMenu dd ul").not($(this).parents(".staticMenu").find("ul")).hide();
			$(".staticMenu dt a").not($(this)).removeClass("selected");
			$(this).parents(".staticMenu").find("ul").toggle();

			if($(this).parents(".staticMenu").find("ul").css("display") == "none"){
				$(this).removeClass("selected");
			}else{
				$(this).addClass("selected");
			}

		});
/*
		$(".staticMenu dd ul li a").click(function() {
			var text = $(this).html();
			$(".staticMenu dt a div").html(text);
			$(".staticMenu dd ul").hide();
		});
*/
		$(document).bind('click', function(e) {
			var $clicked = $(e.target);
			if (! $clicked.parents().hasClass("staticMenu")){
				$(".staticMenu dd ul").hide();
				$(".staticMenu dt a").removeClass("selected");
			}

		});
	});

	function openSubMenu(o){
		cancelSubMenuClose();

		if(last_o) $(last_o).parent().find("div").hide();

		last_o = o;
		$(o).parent().find("div").show();
	}

	function closeSubMenu(){
		SubMenutimer = setTimeout("close()",500);
	}

	function cancelSubMenuClose(){
		clearTimeout(SubMenutimer);
	}

	function close(){
		$(last_o).parent().find("div").hide();
	}
		
	

	$(document).ready(function() {
		
	var wrapper = $('<div/>').css({height:0,width:0,'overflow':'hidden'});
	var fileInput = $(':file').wrap(wrapper);

	fileInput.change(function(){
    	$this = $(this);
    	$('#file').text($this.val());
	})

	$('#file').click(function(){
    	fileInput.click();
	}).show();
		
	$("#post-right .widget .widget-top").toggler({method: "fadeToggle"});
	
	$("textarea.grow").ata();
	
	//$(this).find("img").fadeIn(6000);
	/*	
	var nav_div = $("nav.nav-fix");
	var nav_div_start = $(nav_div).offset().top;
	$.event.add(window, "scroll", function(){
		var nav_p = $(window).scrollTop();
		$(nav_div).css('position',((nav_p)>nav_div_start) ? 'fixed' : 'static');
		$(nav_div).css('top',((nav_p)>nav_div_start) ? '0px' : '');
		}
	);
	*/
	
	
	$(".progress_anim").each(function() {
		$(this)
		.data("origWidth", $(this).width())
		.width(0)
		.animate({
		width: $(this).data("origWidth")
		}, 3000);
	});
	
	$('#date-picker').datepicker({
		format: 'yyyy-mm-dd'
	});
	
	// Launch TipTip tooltip
	$('.tiptip a.button, .tiptip button, ul.tiptip li .tip').tipTip();
	
	window.setTimeout("$('#success,#message,#error, .ani_fade_out').fadeOut('fast')",5000);
	window.setTimeout("$('.ani_fade_out').fadeOut('fast')",1000);
	
	
	var counterValue = parseInt($('.bubble').html()); // Get the current bubble value

	function removeAnimation(){
		setTimeout(function() {
			$('.bubble').removeClass('animating')
		}, 1000);			
	}
		
	});