jQuery(document).ready(function($) {
	$('body').on('click', 'input.select_link', function(e){
		let checked = e.target.checked;

		$(this).parents('.shared_link').toggleClass('selected');
		let prevText = $('#copy_text').html();
		let link = $(this).parents('.shared_link').find('a').attr('href');

		if(checked){
			var copy_text = prevText + link + '<br>';
		}else{
			var copy_text = prevText.replace(link+'<br>', '');
		}
		

		$('#copy_text').html(copy_text);
	});

	$(".copy_icon").click(function(){
		$(".copiedConfirm").show();
	});

	setInterval(function(){
		$(".copiedConfirm").hide();
	},4000);

	new Clipboard('.copy_icon');

});