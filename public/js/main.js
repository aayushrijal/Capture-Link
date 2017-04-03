jQuery(document).ready(function($) {
	$('body').on('click', 'input.select_link', function(){
		$(this).parents('.shared_link').toggleClass('selected');
	})
});