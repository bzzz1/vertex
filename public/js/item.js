(function ($) {
	setTimeout(function() { 
		$('.item-img, .to-item-page-btn').on('click', function(evt) {
			evt.stopPropagation();

			var id = $(this).closest('.item').data('id');

			$('.item-page-ctnt')
				.hide()
					.filter(function(index) {
						return $(this).data('id') == id;
					}).show();

			saveScroll();
			
			$('html, body').stop(true, false).animate({
				scrollTop: 0
			}, 600);

			$('.item-page').fadeIn(400);

			// MUST be declared here
			$('.to-cart-btn').off().on('click', function(evt2) {
				saveScroll();
				evt2.preventDefault();
				var id = $(this).closest('.item-page-ctnt').data('id');
				Cart.push(id);
				writeCartToCookie(Cart);
				enableCartBtn();
				runCart();
			});

			runCloseIconForItem();
		});	
	}, 1000);
})(jQuery);