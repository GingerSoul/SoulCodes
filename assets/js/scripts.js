// Soulcodes Scripts

jQuery(window).load(function(){
	
	jQuery('.button-copy-to-clipboard').click(function(){
		thisShortCodeValue = '['+(jQuery(this).prev('input').attr('value'))+']';
		navigator.clipboard.writeText(thisShortCodeValue);
	});
	
});


