jQuery(document).ready(function($){
	check_width();
	var TO = false;

	$(window).resize(function(){
		if(TO !== false){clearTimeout(TO);}
		TO = setTimeout('check_width()', 200);
	});
});

function check_width(){

	// check nav level two
	jQuery(".main-nav>ul>li>ul").each(function() {
		if(jQuery(this).parent().offset().left + jQuery(this).innerWidth() > (jQuery(window).width() - 50)){
			jQuery(this).addClass('nav-shift');
		}else{
			jQuery(this).removeClass('nav-shift');
		}
	});

	// check nav level three
	jQuery(".main-nav>ul>li>ul>li>ul").each(function() {
		if(jQuery(this).parent().parent().parent().offset().left + jQuery(this).width() + jQuery(this).width() > (jQuery(window).width() - 50)){
			jQuery(this).addClass('nav-shift');
		}else{
			jQuery(this).removeClass('nav-shift');
		}
	});
}