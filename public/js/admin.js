(function ($) {
	$('.control-btns').on('click', 'button', function() {
		$('.control-btns button').removeClass('active');
		$(this).addClass('active');
		var block = $(this).data('block');
		$('.block').hide();
		$('.'+block).show();
	});
})(jQuery);