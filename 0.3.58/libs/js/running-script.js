
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
			
			$(".staticMenu dd ul").css({
				'position':'abolsute',
				'z-index':'4'
			});

			$(".staticMenu dd ul").not($(this).parents(".staticMenu").find("ul")).hide();
			$(".staticMenu dt a").not($(this)).removeClass("selected");
			$(this).parents(".staticMenu").find("ul").slideToggle('slow', function() {
				if($(".staticMenu dt a").parents(".staticMenu").find("ul.mainMenuSub").css("display") == "none"){
					$(".staticMenu dt a").removeClass("selected");	
				}else{
					$(".staticMenu dt a").addClass("selected");
				}
			});

			if($(this).parents(".staticMenu").find("ul.mainMenuSub").css("display") == "none"){
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
	
	window.setTimeout("$('#success,#message,#error,.ani_fade_out').fadeOut('fast')",7000);
	window.setTimeout("$('.ani_fade_out').fadeOut('fast')",1000);
	
	
	var counterValue = parseInt($('.bubble').html()); // Get the current bubble value

	function removeAnimation(){
		setTimeout(function() {
			$('.bubble').removeClass('animating')
		}, 1000);			
	}
	
	$(".nav-fix-sub").hide();
	$(".shadow-inside-top").css({
		'top':'39px',
		'position':'absolute'
	});
	
	$(".nav").mouseover(function() {				
		$(".nav-fix-sub").show();
		$(".shadow-inside-top").css({
			'top':'78px',
			'position':'absolute'
		});
	});
	$(".nav-fix-sub").mouseout(function() {
		$(".nav-fix-sub").hide();
		$(".shadow-inside-top").css({
			'top':'39px',
			'position':'absolute'
		});
	});
	/*
	$("li.topNavLink > dl.staticMenu > dt > a").click( function(){
		if ($("div:first").is(":hidden")) {
			$("li.topNavLink > dl.staticMenu > dt > a").addClass('selected');
			$("li.topNavLink > dl.staticMenu > dd > ul.mainMenuSub").css({
				'top':'-1px',
				'right':'0px',
				'left':'auto',
				'position':'absolute',
				'display':'block',
				'z-index':'1'
			});
		}else{
			$("li.topNavLink > dl.staticMenu > dt > a").removeClass('selected');
			$("li.topNavLink > dl.staticMenu > dd > ul.mainMenuSub").css({
				'top':'-1px',
				'right':'0px',
				'left':'auto',
				'position':'absolute',
				'display':'none'
			});
		}
	});*/
	
	
	$(".goSingle").click( function(){
		var src = "full";
		$.post("?request&load=libs/ajax/lw.php", {"v": src});
		
		$(this).removeClass("goSingle");
		$(this).addClass("goFull");			
			
		location.reload(); 
	});
	
	$(".goFull").click( function(){
		var src = "wrap";
		$.post("?request&load=libs/ajax/lw.php", {"v": src});	
		
		$(this).removeClass("goFull");
		$(this).addClass("goWrap");			
			
		location.reload();
	});
	
	$(".goWrap").click( function(){
		var src = "single";
		$.post("?request&load=libs/ajax/lw.php", {"v": src});
		
		$(this).removeClass("goWrap");
		$(this).addClass("goSingle");			
			
		location.reload();
	});
	
	if($.browser.mozilla == true){
		$(".submit_jump").css({
			'margin-left':'-29px',
		});
	}
	if($.browser.opera == true || $.browser.msie == true){
		if($.browser.opera == true){
			$("ul.mainMenuSub li.logout a").css({ 
				'display': 'block',
				'height': '12px',
				'line-height': '12px',
				'overflow-x': 'hidden',
				'overflow-y': 'hidden',
				'padding-bottom': '7px',
				'padding-left': '22px',
				'padding-right': '4px',
				'padding-top': '6px'
			});
		}
		$(".submit_jump").css({
			'margin-left':'-34px',
		});
	}
		
	});