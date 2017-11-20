$(document).ready(function(){
	$('.form-wrap').on('click', function(){
		if($(this).hasClass('error'))
			$(this).removeClass('error');
	});
	$('.check-vars').on('click', function(){
		$('.popap-vars').addClass('open');
	});
	$('.close').on('click', function(){
		$(this).parent().removeClass('open');
	});
});