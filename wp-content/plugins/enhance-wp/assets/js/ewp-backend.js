jQuery(document).ready(function()
{
	jQuery("#ewp_css_mobile_disabled").click(function(){
		if( jQuery("#ewp_css_mobile_disabled").attr("value") == "yes" )
		{ jQuery("#ewp_css_mobile_disabled").attr("value","no"); }
		else
		{ jQuery("#ewp_css_mobile_disabled").attr("value","yes"); }
	});

	jQuery("#ewp_js_mobile_disabled").click(function(){
		if( jQuery("#ewp_js_mobile_disabled").attr("value") == "yes" )
		{ jQuery("#ewp_js_mobile_disabled").attr("value","no"); }
		else
		{ jQuery("#ewp_js_mobile_disabled").attr("value","yes"); }
	});
	
	jQuery("#ewp_wp_rocket_support").click(function(){
		if( jQuery("#ewp_wp_rocket_support").attr("value") == "yes" )
		{ jQuery("#ewp_wp_rocket_support").attr("value","no"); }
		else
		{ jQuery("#ewp_wp_rocket_support").attr("value","yes"); }
	});
	
	jQuery("#ewp_white_label").click(function(){
		if( jQuery("#ewp_white_label").attr("value") == "yes" )
		{ jQuery("#ewp_white_label").attr("value","no"); }
		else
		{ jQuery("#ewp_white_label").attr("value","yes"); }
	});
	
	jQuery("#ewp_cartflows").click(function(){
		if( jQuery("#ewp_cartflows").attr("value") == "yes" )
		{ jQuery("#ewp_cartflows").attr("value","no"); }
		else
		{ jQuery("#ewp_cartflows").attr("value","yes"); }
	});
	
	jQuery("#ewp_video_mobile_disabled").click(function(){
		if( jQuery("#ewp_video_mobile_disabled").attr("value") == "yes" )
		{ jQuery("#ewp_video_mobile_disabled").attr("value","no"); }
		else
		{ jQuery("#ewp_video_mobile_disabled").attr("value","yes"); }
	});
	
});