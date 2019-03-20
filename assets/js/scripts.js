// Soulcodes Scripts

jQuery(window).load(function(){
	
	jQuery('.copy-shortcode').click(function(){
		thisShortCodeValue = '['+(jQuery(this).prev('input').attr('value'))+']';
		navigator.clipboard.writeText(thisShortCodeValue);
	});
	
});


