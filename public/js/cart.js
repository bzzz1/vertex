(function ($) {
	$('.cart .cancel-btn').on('click', function() {
		$('.cart .checkout').slideUp(600);
		$('html, body').animate({
			scrollTop: 0
		}, 600);
	});

	$('.buy-btn').on('click', function() {
		var data = {};
		data['cart'] = JSON.stringify(Cart);
		data['name'] = $('#name_id').val();
		data['surname'] = $('#surname_id').val();
		data['phone'] = $('#phone_id').val();
		data['email'] = $('#email_id').val();
		data['city'] = $('#city_id  :selected').val();
		data['np'] = $('#office_id  :selected').val();
		data['address'] = $('p.office-address').text();
		data['manual_address'] = $('#address_id').val();

		postPurchase(data);
		clearCart();
		disableCartBtn();

		$('.buy').fadeIn(600);
		$('html, body').animate({
			scrollTop: 0
		}, 600);

		// Sliding up Animations
		setTimeout(function() {
			$('.buy').fadeOut(600);

			setTimeout(function() { 
				$('.checkout').slideUp(600);
			}, 800);

			setTimeout(function() { 
				$('.cart').fadeOut(600);
			}, 1400)

			setTimeout(function() { 
				$('.item-page').fadeOut(600);
			}, 2000);
		}, 4000);
	});
})(jQuery);